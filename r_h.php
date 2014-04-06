#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>
The Unlucky (hitting most woodwork)
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
if($_POST["year"])
{
$year1="01-JUL-".$_POST["year"];
$year2="01-AUG-".($_POST["year"]-1);
}

$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$query = "select teamname ,hit_woodwork
from (Select teamname , sum(hit_woodwork) as hit_woodwork
From ((Select hometeam as teamname, sum(HHW)as hit_woodwork
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by hometeam) union
(Select awayteam as teamname ,sum(AHW)as hit_woodwork
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by awayteam)) 
Group by teamname )
where hit_woodwork=(select max(hit_woodwork)
from (Select teamname , sum(hit_woodwork) as hit_woodwork
From ((Select hometeam as teamname, sum(HHW)as hit_woodwork
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by hometeam) union
(Select awayteam as teamname ,sum(AHW)as hit_woodwork
From match
Where div='".$league."' and (day>'".$year2."' and day<'".$year1."')
Group by awayteam)) 
Group by teamname ))";
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
              <td align="center"><b>Hit Woodwork</b></td> 
		</tr>
<?php
while ($row = oci_fetch_array($statement)) {
?>
                <?php 
if ($row['HIT_WOODWORK']==null)
continue;
?>
<tr>
    			<td><?php echo $row['TEAMNAME'];?></td>     
                     <td><?php echo $row['HIT_WOODWORK'];?></td> 
</tr>

<?php
}
oci_free_statement($statement);
oci_close($connection);
?>
<form action="r_h.php" method="post">
Name of league: <select name="league">
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
Year of league: <select name="year">
<option value="2013">12-13</option>
<option value="2012">11-12</option>
<option value="2011">10-11</option>
<option value="2010">09-10</option>
<option value="2009">08-09</option>
<option value="2008">07-08</option>
<option value="2007">06-07</option>
<option value="2006">05-06</option>
<option value="2005">04-05</option>
<option value="2004">03-04</option>
<option value="2003">02-03</option>
<option value="2002">01-02</option>
<option value="2001">00-01</option>
<option value="2000">99-00</option>
<option value="1999">98-99</option>
<option value="1998">97-98</option>
<option value="1997">96-97</option>
<option value="1996">95-96</option>
<option value="1995">94-95</option>
<option value="1994">93-94</option>
</select>

<input type="submit" />
</form>
<br>
<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="league.php">Return to League</a><br>

</html>