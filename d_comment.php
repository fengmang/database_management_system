#!/usr/local/bin/php

<?php

$conn = oci_connect($username = 'dw3',
		    $password = 'Bb1986115',
		    $connection_string = '//oracle.cise.ufl.edu/orcl');


$comid = $_GET['comid'];


$delete_user_query = "DELETE FROM COMMENTS WHERE COMID = $comid";
$commit = "commit";


$delete_user_statement = oci_parse( $conn, $delete_user_query );
$commit_statement = oci_parse( $conn, $commit );


oci_execute( $delete_user_statement );
oci_execute( $commit_statement );


oci_free_statement($delete_user_statement);
oci_free_statement($commit_statement);
oci_close($conn);

echo "Successfully deleted comment, comid = ".$comid;
echo "<br>";

?>

<a href="dashboard.php">Return to dashboard</a>
