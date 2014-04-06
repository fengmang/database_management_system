#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>
Hi corner flag in recent 20 years
<style>
body{background-image:url("bg2.jpg");}

</style>

</h1>
<?php
$league="E0";
$year1="01-JUL-13";
$year2="01-AUG-93";
if($_POST["league"])
{
$league=$_POST["league"];
}
$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$query = "select teamname ,sum (corners) as corners
From ((Select hometeam as teamname,sum(HC)as corners
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by hometeam) union
(Select awayteam as teamname ,sum(HC)as corners
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by awayteam))
Group by teamname
order by corners desc";
$statement = oci_parse($connection, $query);
oci_execute($statement);
?>
<table align="center" border="1px">
            <thead>
                <tr>
                    <th colspan="10">Ranking</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
		<td align="center"><b>Teamname</b></td> 
              <td align="center"><b>Corners</b></td> 
		</tr>
<?php
while ($row = oci_fetch_array($statement)) {
?>
                <?php 
if ($row['CORNERS']==null)
continue;
?>
<tr>
    			<td><?php echo $row['TEAMNAME'];?></td>     
                     <td><?php echo $row['CORNERS'];?></td> 
</tr>

<?php
}
oci_free_statement($statement);
oci_close($connection);
?>
<form align = "center" action="r_l.php" method="post">
Name of league: <select align="center" name="league">
<option value="E0">Premier League</option>
<option value="E1">Championship</option>
<option value="E2">League 1</option>
<option value="E3">League 2</option>
<option value="EC">Conference</option>
<option value="D1">Bundesliga 1</option>
<option value="D2">Bundesliga 2</option>
<option value="I1">Serie A</option>
<option value="I2">Serie B</option>
<option value="SC0">Scotland Div1</option>
<option value="SC1">Scotland Div2</option>
<option value="SC2">Scotland Div3</option>
<option value="SC3">Scotland Div4</option>
<option value="SP1">La Liga Primera</option>
<option value="SP2">La Liga Segunda</option>
<option value="F1">Le Championnat</option>
<option value="F2">France Div2</option>
<option value="N1">Eredivisie</option>
<option value="B1">Jupiler League</option>
<option value="P1">Liga I</option>
<option value="T1">Futbol Ligi 1</option>
<option value="G1">Ethniki Katigoria</option>
</select>
<input type="submit" />
</form>
<br>
<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="league.php">Return to League</a><br>


</html>