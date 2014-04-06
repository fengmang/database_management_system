#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>
King of half time:
<style>
body{background-image:url("bg2.jpg");}

</style>
</h1>
<body>
<?php
$year1="01-JUL-13";
$year2="01-AUG-12";
if($_POST["year"])
{
$year1="01-JUL-".$_POST["year"];
$year2="01-AUG-".($_POST["year"]-1);
}

$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$query = "Select teamname , sum(half_time_goals) as half_time_goals
           From ((Select hometeam as teamname, sum(HTHG)as half_time_goals
           From match
           Where (day>'".$year2."' and day<'".$year1."')
           Group by hometeam) 
           union
           (Select awayteam as teamname ,sum(HTAG)as half_time_goals
           From match
           Where (day>'".$year2."' and day<'".$year1."')
           Group by awayteam))
           Group by teamname 
           order by half_time_goals desc";
$statement = oci_parse($connection, $query);
oci_execute($statement);
?>
<table align="left" border="1px">
            <thead>
                <tr>
                    <th colspan="10">Ranking</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
		<td align="center"><b>Teamname</b></td> 
              <td align="center"><b>Half time goals</b></td> 
		</tr>
<?php
while ($row = oci_fetch_array($statement)) {
?>
                <?php 
if ($row['HALF_TIME_GOALS']==null)
continue;
?>
<tr>
    			<td><?php echo $row['TEAMNAME'];?></td>     
                     <td><?php echo $row['HALF_TIME_GOALS'];?></td> 
</tr>

<?php
}
oci_free_statement($statement);
oci_close($connection);
?>
<form style="text-align:center"; action="r_g.php" method="post" >
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


</body>
</html>