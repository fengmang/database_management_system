#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<a href="index.php">Return to home </a><br>
<a href="players.php">Return to players </a>
<h1>
The Average height and rating of players:
</h1>
<?php
$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$query = "Select avg(height) as avg_height, avg(rating) as avg_rating
From players";
$statement = oci_parse($connection, $query);
oci_execute($statement);
?>
<table align="center" border="1px">
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
              <td align="center"><b>Average Height</b></td> 
              <td align="center"><b>Average Rating</b></td> 
		</tr>
<?php
while ($row = oci_fetch_array($statement)) {
?>
<tr>
    			<td><?php echo $row['AVG_HEIGHT'];?></td>     
                     <td><?php echo $row['AVG_RATING'];?></td> 
</tr>

<?php
}
oci_free_statement($statement);
oci_close($connection);
?>

</html>
