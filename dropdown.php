#!/usr/local/bin/php

<!DOCTYPE html>
<html>
	<head>
		<title>PHP Test</title>
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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="/~jlv/project/highcharts.js"></script>
		
		<!-- 1a) Optional: add a theme file -->
		<!--
			<script type="text/javascript" src="../js/themes/gray.js"></script>
		-->
		
		<!-- 1b) Optional: the exporting module -->
		<script type="text/javascript" src="../js/modules/exporting.js"></script>
		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Browser market shares at a specific website, 2010'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
							['<1.6',   1.1],
							['<1.7',   2.5],
							{
								name: '<1.7',    
								y: 2.5,
								sliced: true,
								selected: true
							},
							['<1.8',    32.45],
							['<1.9',     52.78],
							['<2.0',   12.07],
							['>2.0',   1.70]
						]
					}]
				});
			});
				
		</script>
		
	</head>

<body>

<img src = "http://bit.ly/128TNkY" alt="England">

<?php
 $connection = oci_connect($username = 'dw3',
                           $password = 'Bb1986115',
                           $connection_string = '//oracle.cise.ufl.edu/orcl');
// $statement = oci_parse($connection, 'SELECT LASTNAME, FIRSTNAME FROM PLAYERS WHERE HEIGHT > 190');

// $statement = oci_parse($connection, 'SELECT DISTINCT CLUBID FROM PLAYERS');

$statement1 = oci_parse($connection, 'SELECT FIRSTNAME AS FLG FROM PLAYERS');
$statement2 = oci_parse($connection, 'SELECT MAX(HEIGHT) AS HT FROM PLAYERS');
$statement3 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT < 160');
$statement4 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT >= 160 AND HEIGHT < 170');
$statement5 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT >= 170 AND HEIGHT < 180');
$statement6 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT >= 180 AND HEIGHT < 190');
$statement7 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT >= 190 AND HEIGHT < 200');
$statement8 = oci_parse($connection, 'SELECT COUNT(*) AS HT FROM PLAYERS WHERE HEIGHT >= 200');

oci_execute($statement1);
oci_execute($statement2);
oci_execute($statement3);
oci_execute($statement4);
oci_execute($statement5);
oci_execute($statement6);
oci_execute($statement7);
oci_execute($statement8);

//$i = 0;
?>

<select name="xingming">

<?php

while (($row = oci_fetch_array($statement1))) {
//var_dump($row);
?>

<img src = "http://bit.ly/128TNkY" alt="England">
<option value="<?php echo $row['FLG'];?>" ><?php echo $row['FLG'];?></option>


<?php
//echo $row['DIV']." ";
//echo $row[$i]."<br>";
echo "<br>";
}
?>
</select>



<?php
$row1 = oci_fetch_array($statement1);
$row2 = oci_fetch_array($statement2);
$row3 = oci_fetch_array($statement3);
$row4 = oci_fetch_array($statement4);
$row5 = oci_fetch_array($statement5);
$row6 = oci_fetch_array($statement6);
$row7 = oci_fetch_array($statement7);
$row8 = oci_fetch_array($statement8);

echo "<br>";
echo "The number of players less than 1.6m:".$row3['HT']."<br>";
echo "The number of players less than 1.7m:".$row4['HT']."<br>";
echo "The number of players less than 1.8m:".$row5['HT']."<br>";
echo "The number of players less than 1.9m:".$row6['HT']."<br>";
echo "The number of players less than 2m:".$row7['HT']."<br>";
echo "The number of players higher than 2m:".$row8['HT']."<br>";

oci_free_statement($statement1);
oci_free_statement($statement2);
oci_free_statement($statement3);
oci_free_statement($statement4);
oci_free_statement($statement5);
oci_free_statement($statement6);
oci_free_statement($statement7);
oci_free_statement($statement8);
oci_close($connection);
?>




<br>
<br>

a)	Show the basic information of a player (height, weight, position, etc.)<br>

b)	List all the players in a certain team<br>

c)	List all the players playing the same position<br>

d)	List all the players who are born before/after a certain date or the same date<br>

e)	List all the players in a certain league<br>

f)	Show the ranking of a league in a certain season<br>


<br>
<br>
a)	¡°Who owns who¡±, get the historical overall win/lose relation between two teams (which is always referenced when people want to make decisions on betting) <br>
b)	¡°Offend or defend¡±, show the ¡°most offensive¡±/¡°least offensive¡± ranking of a league, which is a ranking of teams by goals scored in descending/ascending order<br>
c)	¡°Clash of the titans¡±, compare the number of championship titles of different teams, this can be done by calculating the number of seasons in which a team has a rank of 1 in the table<br>
d)	 ¡°League power¡±, list the total amount of goals scored/conceded in a league in a certain season, and compare them, so we could know which league has the strongest offensive power<br>
e)	¡°How many¡±, show the total number of players in a league/in all the leagues.<br>
f)	¡°The averages¡±, show the average of some specific data like: height, weight, goals scored, etc.<br>
g)	¡°King of half time¡±, compare the number of half-time goals of different teams.<br>
h)	¡°The unlucky¡±, list the most unlucky teams in each league(hitting woodwork the most)<br>
i)	¡°Home dragon¡±, compare teams with their home goals<br>
j)	¡°Beware the yellow/red card!¡±, compare the number of yellow/red cards between teams/leagues<br>
k)	¡°What a pity¡±, list the number of offside of different teams<br>
l)	¡°Hi corner flag¡±, compare the total number of corners ny each team<br>


<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
		

</body>
</html>