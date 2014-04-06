#!/usr/local/bin/php

<?php

if(!isset($_POST['submit'])){
    exit('Illegal Access!');
}

$usrname = $_POST['usrname'];
$pw_unencrypted = $_POST['pw'];
$repass = $_POST['repass'];
$pw = MD5($pw_unencrypted);
$regdate_unix = time();
$regdate = date('d-M-Y',$regdate_unix);

// echo $usrname."<br>";
// echo $pw."<br>";
// echo $regdate."<br>";


// Check the registration information
if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $usrname)){
    exit('Illegal username, username must be at least 3 characters long.<a href="javascript:history.back(-1);">Return</a>');
}
if(strlen($pw_unencrypted) < 6){
    exit('Illegal password, Password should be more than 6 characters.<a href="javascript:history.back(-1);">Return</a>');
}
if($pw_unencrypted !== $repass){
    exit('Password does not match, please try again.<a href="javascript:history.back(-1);">Return</a>');
}

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	if (!$conn) {
		$m = oci_error();
    		trigger_error(htmlentities($m['message']), E_USER_ERROR);
}



// Check if the username already exists
$q = "SELECT USERID FROM USERS WHERE USERNAME = '$usrname'";
$query_stmt = oci_parse($conn, $q);


oci_execute($query_stmt);

if(oci_fetch_array($query_stmt)){
    echo 'Error: username ',$usrname,' is already taken.<a href="javascript:history.back(-1);">Return</a>';
    exit;
 }

$query = "INSERT INTO USERS (USERID, USERNAME, PASSWD, REGDATE) VALUES(UID_SEQ.nextval, '$usrname', '$pw', '$regdate')";

$ins_stmt = oci_parse($conn, $query);
$commit = oci_parse($conn, 'commit');

oci_execute($ins_stmt);
oci_execute($commit);

if(oci_parse($conn, $query)){
    exit('Registration succeed! Click <a href="login.html">here to login</a>');
} else {
    echo 'Sorry, registration failed','<br />';
    echo 'Click <a href="javascript:history.back(-1);">return</a> to try again';
}

oci_free_statement($query_stmt);
oci_free_statement($ins_stmt);
oci_free_statement($commit);
oci_close($conn);

?>