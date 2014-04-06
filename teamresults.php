#!/usr/local/bin/php

<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="playersteam.php">Return to teamplayers search page</a><br>

<?php

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$club = ucfirst(strtolower($_GET['club']));

$q = "SELECT * FROM PLAYERS WHERE CLUBID LIKE '%$club%' ";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);


echo "Are you looking for...<br><br>";
?>

    <table align="center" border="1px">
            <thead>
                <tr>
                    <th colspan="5">Results</th>
                </tr>  
            </thead>
            <tbody>
              <tr bgcolor="#dcdcdc"> 
                    <td align="center"><b>Firstname</b></td>  
			        <td align="center"><b>Lastname</b></td> 
                    <td align="center"><b>Position</b></td> 
			        <td align="center"><b>Teamname</b></td>  
			        <td align="center"><b>Playerlink</b></td> 

               </tr>
<?php
while ( $row = oci_fetch_array($query_stmt) ) {
?>
    
	<tr>
	         <td><?php	echo $row['FIRSTNAME']?></td>
		 <td><?php	echo $row['LASTNAME']?></td>
		 <td><?php	echo $row['POSITION']?></td>
		 <td><?php	echo $row['CLUBID']?></td>
	<td><a href="player.php?playerid=<?php echo $row['BASEID'];?>" id="link">Click here</a></td>
      </tr>


	<?php
	
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