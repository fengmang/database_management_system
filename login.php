#!/usr/local/bin/php

<?php

session_start();

// Log-off
if($_GET['action'] == "logout"){
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo 'Log-off succeed! Click <a href="login.html">here to login</a>';
    exit;
}

// Log in
if(!isset($_POST['submit'])){
    exit('Illigal Access!');
}

$usrname = $_POST['usrname'];
$opw = $_POST['pw'];
$pw = MD5($_POST['pw']);


$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	if (!$conn) {
		$m = oci_error();
    		trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


//check the username and password
$q = "select USERID from users where username='$usrname' and passwd='$pw'";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);

if($result = oci_fetch_array($query_stmt)){
    //login succeed
    $_SESSION['username'] = $usrname;
    $_SESSION['USERID'] = $result['USERID'];

	// echo $_SESSION['USERID'];

    echo $_SESSION['username'],' , Welcome!  <a href="my.php">User center</a><br />';

    echo 'Click <a href="login.php?action=logout"> here </a>to log off.<br />';
    exit;
} else {
echo "<br />";
// echo "The password you typed is:"."$opw"."<br />";
    exit('Log in failed! Click <a href="javascript:history.back(-1);">Return</a> to try again');
}

oci_free_statement($query_stmt);
oci_close($conn);
?>