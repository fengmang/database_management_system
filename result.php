#!/usr/local/bin/php

<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="players.php">Return to players</a><br>

<?php

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$name = ucfirst(strtolower($_GET['name']));

$q = "SELECT * FROM PLAYERS WHERE LASTNAME LIKE '%$name%' OR FIRSTNAME LIKE '%$name' ";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);


echo "Are you looking for...<br><br>";
while ( $row = oci_fetch_array($query_stmt) ) {
	echo $row['FIRSTNAME']." ".$row['LASTNAME']." , ";
	echo $row['POSITION']." , ".$row['CLUBID']."   ";
	?>

	<a href="player.php?playerid=<?php echo $row['BASEID'];?>" id="link">Click here</a>

	<?php
	echo "<br>";
}





$c = "SELECT * FROM COMMENTS WHERE PLAYERID = 191251";

$com_stmt = oci_parse($conn, $c);

oci_execute($com_stmt);

$c = oci_fetch_array($com_stmt);

echo $c['CONTENT'];

oci_free_statement($query_stmt);
oci_free_statement($com_stmt);
oci_close($conn);



?>