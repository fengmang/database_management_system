#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>
Total of players in each league:
<style>
body{background-image:url("bg2.jpg");}

</style>


</h1>
<?php
$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$query = "Select leagueid ,count(firstname)as number_of_players
From players
Group by leagueid
order by number_of_players desc";
$statement = oci_parse($connection, $query);
oci_execute($statement);
?>
<table align="center" border="1px">
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
              <td align="center"><b>League</b></td> 
              <td align="center"><b>Number of Players</b></td> 
		</tr>
<?php
while ($row = oci_fetch_array($statement)) {
?>
<tr>
    			<td><?php echo $row['LEAGUEID'];?></td>     
                     <td><?php echo $row['NUMBER_OF_PLAYERS'];?></td> 
</tr>

<?php
}
oci_free_statement($statement);
oci_close($connection);
?>
<br>
<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="players.php">Return to Players</a><br>

</html>
