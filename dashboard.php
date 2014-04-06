#!/usr/local/bin/php

<?php

session_start();

// Check if the user is logged in, if not, navigate to the login page.
 if($_SESSION['username'] !== "admin"){
     header("Location:login.html");
   exit();
}

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');

$userid = $_SESSION['USERID'];
$usrname =  $_SESSION['username'];

$q = "SELECT * FROM COMMENTS";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);

echo "Comment list:<br>";

while ($row = oci_fetch_array($query_stmt)) {

echo $row['USERNAME']." on ".$row['PLAYERID']." 's profile: ".$row['CONTENT'];
?>
<a href="d_comment.php?comid= <?php echo $row['COMID']; ?>">Delete</a>
<?php
echo "<br>";

}


$u = "SELECT * FROM USERS";
$user_stmt = oci_parse($conn, $u);
oci_execute($user_stmt);
echo "<br>Users list:<br>";
while ($row = oci_fetch_array($user_stmt)) {

echo "User ID: ".$row['USERID'].", Username: ".$row['USERNAME'].", Registration date:  ".$row['REGDATE'];
?>
<a href="d_user.php?userid=<?php echo $row['USERID']; ?>">Delete</a>
<?php
echo "<br>";

}
?>

<?php

oci_free_statement($user_stmt);
oci_free_statement($query_stmt);
oci_close($conn);

?>