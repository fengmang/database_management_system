#!/usr/local/bin/php

<?php

session_start();

// Check if the user is logged in, if not, navigate to the login page.
// if(!isset($_SESSION['userid'])){
//    header("Location:login.html");
//    exit();
//}


// Include the database connection

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');

$userid = $_SESSION['USERID'];
$usrname =  $_SESSION['username'];

$q = "SELECT * FROM USERS WHERE USERID = $userid";
$query_stmt = oci_parse($conn, $q);
oci_execute($query_stmt);
$row = oci_fetch_array($query_stmt);

?>


<li><a  href="index.php">Home</a></li>
<?php
if ( $usrname == "admin" ) {
echo "<a href = 'dashboard.php'>admin's dashboard</a><br>";
echo "<a href = 'Queries.pdf'>All queries</a><br>";
}
echo "User ID: ".$row['USERID'];
echo "<br>";
echo "Username: ".$row['USERNAME'];
echo "<br>";
echo "Registration Date: ".$row['REGDATE'];
echo "<br>";
echo "<br>";
echo '<a href="login.php?action=logout">Log off</a><br>';
echo "My comments: <br>";

$un = $row['USERNAME'];

$c = "SELECT DISTINCT PLAYERS.FIRSTNAME, PLAYERS.LASTNAME, COMMENTS.CONTENT FROM COMMENTS, USERS, PLAYERS WHERE COMMENTS.USERNAME = '$un' AND PLAYERS.BASEID = COMMENTS.PLAYERID";

//$c = "SELECT * FROM COMMENTS WHERE USERNAME = '$un'";
$com_stmt = oci_parse($conn, $c);
oci_execute($com_stmt);

while ($row = oci_fetch_array($com_stmt)) {

echo "On ".$row['FIRSTNAME']." ".$row['LASTNAME']." 's profile: ";
// echo "On ".$row['PLAYERID'];
echo "<i><b>".$row['CONTENT']."</b></i>";
echo "<br>";

}

oci_free_statement($query_stmt);
oci_free_statement($com_stmt);
oci_close($conn);


?>

<br>
<a href="players.php">Players</a>
<a href="league.php">League</a>

