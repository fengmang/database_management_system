#!/usr/local/bin/php

<!DOCTYPE html>
<html>
    <head>
        <title>Player Comparison</title>
        <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	    <link rel="shortcut icon" href="favicon.ico">
     </head>

    <body>
		<form align="center" action="compare.php" method="get">
  		Enter the first player: 
		<input type = "text" name= "player1" />
		Enter the second player:
		<input type = "text" name= "player2" />
		<input type = "submit" value= "Submit" />
</form>

<?php

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$name1 = ucfirst(strtolower($_GET['player1']));
$name2 = ucfirst(strtolower($_GET['player2']));

if ($name1 == "")
$name1 = "null";

if ($name2 == "")
$name2 = "null";

$q1 = "SELECT * FROM PLAYERS WHERE LASTNAME LIKE '%$name1%' OR FIRSTNAME LIKE '%$name1' ";
$q2 = "SELECT * FROM PLAYERS WHERE LASTNAME LIKE '%$name2%' OR FIRSTNAME LIKE '%$name2' ";

$s1 = oci_parse($conn, $q1);
$s2 = oci_parse($conn, $q2);

oci_execute($s1);
oci_execute($s2);

?>


<form action="cp_result.php" method="get">

<?php

echo "For the 1st player, are you looking for...<br><br>";
while ( $row = oci_fetch_array($s1) ) {
	echo $row['FIRSTNAME']." ".$row['LASTNAME']." , ";
	echo $row['POSITION']." , ".$row['CLUBID']."   ";
	?>

	<input type="checkbox" name="player1" value="<?php echo $row['BASEID']; ?>" /> Player 1
	

	<?php
	echo "<br>";
}
?>


<?php

echo "<br><br>For the 2nd player, are you looking for...<br><br>";
while ( $row = oci_fetch_array($s2) ) {
	echo $row['FIRSTNAME']." ".$row['LASTNAME']." , ";
	echo $row['POSITION']." , ".$row['CLUBID']."   ";
	?>
	
	<input type="checkbox" name="player2" value="<?php echo $row['BASEID']; ?>" /> Player 2
	
	<?php
	echo "<br>";
}

?>

<input type="submit" value="Submit">
</form>
<?php

oci_free_statement($query_stmt);
oci_free_statement($count_stmt);
oci_close($conn);

?>

</body>
</html>