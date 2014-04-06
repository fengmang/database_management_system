#!/usr/local/bin/php

<!DOCTYPE html>
<html>
<h1>
Players:
</h1>
<body>
<a href="http://cise.ufl.edu/~dw3/r_f.php">Calculate averages</a>
<br>
<a href="http://cise.ufl.edu/~dw3/r_e.php">Total of players in each league</a>
<br>

<?php
$sort="RATING";
if($_POST["sort"])
$sort=$_POST["sort"];

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
$q = "SELECT * FROM PLAYERS ORDER BY ".$sort." DESC";
$query_stmt = oci_parse($conn, $q);
oci_execute($query_stmt);

?>

<table align="right" border="1px">
            <thead>
                <tr>
                    <th colspan="15">Players</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
                    <td align="center"><b>Position</b></td>  
		       <td align="center"><b>Fisrtname</b></td> 
                    <td align="center"><b>Lastname</b></td> 
		       <td align="center"><b>Rating</b></td>  
		       <td align="center"><b>Pacing</b></td> 
                    <td align="center"><b>Shooting</b></td> 
		       <td align="center"><b>Passing</b></td> 
		       <td align="center"><b>Dribbling</b></td>  
			<td align="center"><b>Defend</b></td> 
			<td align="center"><b>Head Shot</b></td>
			<td align="center"><b>Height</b></td>
			<td align="center"><b>Birthday</b></td>
			<td align="center"><b>Foot</b></td>
			<td align="center"><b>Club</b></td>
			<td align="center"><b>Nation</b></td>
                </tr> 

<?php
while ($row = oci_fetch_array($query_stmt)) {
?>
            
                <tr>
                     <td align="center"><?php echo $row['POSITION'];?></td>  
			<td align="center"><?php echo $row['FIRSTNAME'];?></td>
			<td align="center"><?php echo $row['LASTNAME'];?></td> 
			<td align="center"><?php echo $row['RATING'];?></td> 
			<td align="center"><?php echo $row['PAC'];?></td> 
			<td align="center"><?php echo $row['SHO'];?></td>
			<td align="center"><?php echo $row['PAS'];?></td>
			<td align="center"><?php echo $row['DRI'];?></td>
			<td align="center"><?php echo $row['DEF'];?></td>
			<td align="center"><?php echo $row['HEA'];?></td>
			<td align="center"><?php echo $row['HEIGHT'];?></td>
			<td align="center"><?php echo $row['DOB'];?></td>
			<td align="center"><?php echo $row['FOOT'];?></td>
			<td align="center"><?php echo $row['CLUBID'];?></td>
			<td align="center"><?php echo $row['NATIONALID'];?></td>
                </tr>
               

<?php
}

oci_free_statement($query_stmt);
oci_close($conn);

?>
<form align="left" action="result.php" method="get">
  Search for a player: <input type="text" name="name" /><input type="submit" value="Submit" />
</form>
<br>
<form action="p.php" method="post">
Sort players by: <select name="sort">
<option value="POSITION">Position</option>
<option value="FIRSTNAME">Firstname</option>
<option value="LASTNAME">Lastname</option>
<option value="RATING">Rating</option>
<option value="PAC">Pacing</option>
<option value="SHO">Shooting</option>
<option value="PAS">Passing</option>
<option value="DRI">Dribbling</option>
<option value="DEF">Defend</option>
<option value="DRI">Heading</option>
<option value="HEIGHT">Height</option>
<option value="DOB">Birthday</option>
<option value="FOOT">Foot</option>
<option value="CLUBID">Club</option>
<option value="NATIONID">Nation</option>



</select>
<input type="submit" />
</form>

</body>
</html>