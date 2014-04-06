#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>
<style>
body{background-image:url("bg2.jpg");}
table{display:inline;}
li{display:inline;}
</style>
League:
</h1>
<body>

<?php
$league="E0";
$year1="01-JUL-13";
$year2="01-AUG-12";
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
$query = "select teamname ,Games_playeds ,Wins,Draws,LOSSES,points,Goals_for,Goals_Against
from (select teamname,sum(ht_total_score) as points,sum(Games_playeds) as Games_playeds,sum(Wins) as Wins,sum(Draws)as Draws,SUM(LOSSES) AS LOSSES, sum(Goals_for)as Goals_for,
       sum(Goals_Against)as Goals_Against 
from((Select hometeam as teamname ,count(*) *3 as ht_total_score,count(*)as Games_playeds, count(*) as Wins,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,
      Null as Draws,NULL AS LOSSES
From match 
Where FTR='H' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by hometeam)union
(Select hometeam as teamname ,count(*) *1 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,count(*)as Draws,NULL AS LOSSES
From match 
Where FTR='D' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by hometeam)union
(Select hometeam as teamname ,count(*) *0 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,NULL as Draws,COUNT (*)AS LOSSES
From match 
Where FTR='A' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by hometeam)union
(Select awayteam as teamname ,count(*) *1 as ht_total_score,count(*)as Games_playeds,NULL,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,count(*)as Draws,NULL AS LOSSES
From match 
Where FTR='D' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by awayteam)union
(Select awayteam as teamname ,count(*) *3 as ht_total_score,count(*)as Games_playeds,count(*) as Wins,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,Null as Draws,NULL AS LOSSES
From match 
Where FTR='A' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by awayteam)union
(Select awayteam as teamname ,count(*) *0 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,NULL as Draws,COUNT (*)AS LOSSES
From match 
Where FTR='H' and (day <'".$year1."' and day>'".$year2."') and div='".$league."'
Group by awayteam))
group by teamname
order by points desc)";
$statement  = oci_parse($connection, $query);
oci_execute($statement);
?>
            <table align="left" border="1px">
            <thead>
                <tr>
                    <th colspan="10">Scoreboard</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#cdcdcd"> 
                    <td align="center"><b>Rank</b></td>  
			        <td align="center"><b>Teamname</b></td> 
                    <td align="center"><b>Games</b></td> 
			        <td align="center"><b>Wins</b></td>  
			        <td align="center"><b>Draws</b></td> 
                               <td align="center"><b>losses</b></td> 
			        <td align="center"><b>Goals/F</b></td>  
			        <td align="center"><b>Goals/A</b></td> 
			        <td align="center"><b>Goals+/-</b></td> 
			        <td align="center"><b>Points</b></td> 
                </tr> 
 <?php
while ($row = oci_fetch_array($statement) ) {
?>          
     <tr>
                    <td><?php $i++; echo  $i;?></td>
                    <td><?php echo $row['TEAMNAME'];?></td>     
                       <td><?php echo $row['GAMES_PLAYEDS'];?></td> 
                    <td><?php echo $row['WINS'];?></td>   
                    <td><?php echo $row['DRAWS'];?></td>  
                    <td><?php echo $row['LOSSES'];?></td>  
                    <td><?php echo $row['GOALS_FOR'];?></td>  
                    <td><?php echo $row['GOALS_AGAINST'];?></td>  
                    <td><?php echo $row['GOALS_FOR']-$row['GOALS_AGAINST'];?></td>     
                    <td><?php echo $row['POINTS'];?></td>  
                </tr>
<?php
}
oci_free_statement($statement);
oci_close($connection);
?>
<li>
<a href="championnumber.php">Championship numbers</a>
</li><li>
<a href="whowinswho.php">Winner of two</a>
</li><li>
<a href="b.php">Team Goals</a>
</li><li>
<a href="d.php">League Goals</a>
</li><li>
<a href="r_l.php">Hi corner flag</a>
</li><li>
<a href="r_k.php">What a pity</a>
</li><li>
<a href="r_j.php">Beware the yellow cards!</a>
</li><li>
<a href="r_i.php">Home Dragon</a>
</li><li>
<a href="r_h.php">The unlucky</a>
</li><li>
<a href="r_g.php">King of half time</a>
</li>
<br>

<form action="league.php" method="post">
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


</body>
</html>