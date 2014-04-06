#!/usr/local/bin/php

<?php

session_start();

$userid = $_SESSION['USERID'];
$usrname =  $_SESSION['username'];
$comdate_unix = time();
$comdate = date('d-M-Y',$comdate_unix);
$playerid =  $_SESSION['playerid'];
$content = $_POST['comment'];


if ($usrname == "") {$usrname = "Anonymous";}


echo "User ".$usrname." posted a comment on player ".$playerid."'s profile: ".$content." on ".$comdate;


$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$i = "INSERT INTO COMMENTS VALUES(COMID_SEQ.nextval, $playerid, '$usrname', '$comdate', '$content')";
$cmt_stmt = oci_parse($conn, $i);
oci_execute($cmt_stmt);

$commit = "commit";
$commit_stmt = oci_parse($conn, $commit);
oci_execute($commit_stmt);

oci_free_statement($commit_stmt);
oci_free_statement($cmt_stmt);
oci_close($conn);


?>


<br>
<a href="players.php">Return to players</a>


