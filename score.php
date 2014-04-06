#!/usr/local/bin/php

<!DOCTYPE html>
<html>
	<head>
		<title>score table</title>
      <style type="text/css">
        body {
          color: #005;
          background: #fff;
          margin: 500;
          padding: 500;
          font-family: Courier, Palatino, serif;
          }
          p {color:blue}
      </style>
	</head>

<body>

<?php
$connection = oci_connect($username = 'dw3',
                          $password = 'Bb1986115',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

$query = "select teamname as TEAMNAME, Games_playeds as GP, Wins as W, Draws as D, LOSSES as L
from (select teamname,sum(ht_total_score) as points,sum(Games_playeds) as Games_playeds,sum(Wins) as Wins,sum(Draws)as Draws,SUM(LOSSES) AS LOSSES, sum(Goals_for)as Goals_for,
       sum(Goals_Against)as Goals_Against 
from((Select hometeam as teamname ,count(*) *3 as ht_total_score,count(*)as Games_playeds, count(*) as Wins,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,
      Null as Draws,NULL AS LOSSES
From match 
Where FTR='H' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by hometeam)union
(Select hometeam as teamname ,count(*) *1 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,count(*)as Draws,NULL AS LOSSES
From match 
Where FTR='D' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by hometeam)union
(Select hometeam as teamname ,count(*) *0 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTHG)as Goals_for,sum(FTAG)as Goals_Against,NULL as Draws,COUNT (*)AS LOSSES
From match 
Where FTR='A' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by hometeam)union
(Select awayteam as teamname ,count(*) *1 as ht_total_score,count(*)as Games_playeds,NULL,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,count(*)as Draws,NULL AS LOSSES
From match 
Where FTR='D' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by awayteam)union
(Select awayteam as teamname ,count(*) *3 as ht_total_score,count(*)as Games_playeds,count(*) as Wins,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,Null as Draws,NULL AS LOSSES
From match 
Where FTR='A' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by awayteam)union
(Select awayteam as teamname ,count(*) *0 as ht_total_score,count(*)as Games_playeds,NULL ,sum(FTAG)as Goals_for,sum(FTHG)as Goals_Against,NULL as Draws,COUNT (*)AS LOSSES
From match 
Where FTR='H' and (day <'01-JUL-13' and day>'01-AUG-12') and div='D2'
Group by awayteam))
group by teamname
order by points desc)";

$statement  = oci_parse($connection, $query);
oci_execute($statement);

?>


<table align="center" border="1px">
            <thead>
                <tr>
                    <th colspan="9">Scoreboard</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
                    <td align="center"><b>Rank</b></td>  
			        <td align="center"><b>Teamname</b></td> 
                    <td align="center"><b>Games Played</b></td> 
			        <td align="center"><b>Wins</b></td>  
			        <td align="center"><b>Draws</b></td> 
                    <td align="center"><b>losses</b></td> 
			        <td align="center"><b>Points</b></td> 
			        <td align="center"><b>Goals for</b></td>  
			        <td align="center"><b>Goals against</b></td> 
                </tr> 
<?php


$i = 1;
while ($row = oci_fetch_array($statement)) {
//var_dump($row);
?>

            
                <tr>
                    <td><?php echo $i; $i++?></td>
                    <td><?php echo $row['TEAMNAME'];?></td>  
			<td><?php echo $row['GP'];?></td>
<td><?php echo $row['W'];?></td> 
<td><?php echo $row['D'];?></td> 
<td><?php echo $row['L'];?></td> 
                </tr>
               

<?php
}



oci_free_statement($statement);
oci_close($connection);


?>
</body>
</html>