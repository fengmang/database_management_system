#!/usr/local/bin/php

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Player Comparison</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
				<script type="text/javascript">

<?php 

session_start();

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


$player1 =  $_GET['player1'];
$player2 =  $_GET['player2'];

$q1 = "SELECT * FROM PLAYERS WHERE BASEID = $player1";
$q2 = "SELECT * FROM PLAYERS WHERE BASEID = $player2";

$query_stmt1 = oci_parse($conn, $q1);
$query_stmt2 = oci_parse($conn, $q2);

oci_execute($query_stmt1);
oci_execute($query_stmt2);

$row1 = oci_fetch_array($query_stmt1);
$row2 = oci_fetch_array($query_stmt2);

?>


var rat1 = <?php echo $row1['RATING'];?>;
var pac1 = <?php echo $row1['PAC'];?>;
var sho1 = <?php echo $row1['SHO'];?>;
var pas1 = <?php echo $row1['PAS'];?>;
var dri1 = <?php echo $row1['DRI'];?>;
var def1 = <?php echo $row1['DEF'];?>;
var hea1 = <?php echo $row1['HEA'];?>;
var name1 = "<?php echo $row1['FIRSTNAME']." ".$row1['LASTNAME']?>";


var pos1 = "<?php echo $row1['POSITION']; ?>";
var dob1 = "<?php echo $row1['DOB']; ?>";
var foot1 = "<?php echo $row1['FOOT']; ?>";
var club1 = "<?php echo $row1['CLUBID']; ?>";
var nat1 = "<?php echo $row1['NATIONALID'];?>";

var rat2 = <?php echo $row2['RATING'];?>;
var pac2 = <?php echo $row2['PAC'];?>;
var sho2 = <?php echo $row2['SHO'];?>;
var pas2 = <?php echo $row2['PAS'];?>;
var dri2 = <?php echo $row2['DRI'];?>;
var def2 = <?php echo $row2['DEF'];?>;
var hea2 = <?php echo $row2['HEA'];?>;
var name2 = "<?php echo $row2['FIRSTNAME']." ".$row2['LASTNAME']?>";

var pos2 = "<?php echo $row2['POSITION']; ?>";
var dob2 = "<?php echo $row2['DOB']; ?>";
var foot2 = "<?php echo $row2['FOOT']; ?>";
var club2 = "<?php echo $row2['CLUBID']; ?>";
var nat2 = "<?php echo $row2['NATIONALID'];?>";

var title = "Player Comparison: " + name1 + " vs. " + name2;
var sub = name1 + ", playing for: " + club1 + ",  " + name2 + ", playing for: " + club2;



<?php oci_free_statement($query_stmt1);
oci_free_statement($query_stmt2); ?>

$(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: title
            },
            subtitle: {
                text: sub
            },
            xAxis: {
                categories: ['Rating', 'Pacing', 'Shooting', 'Passing', 'Dribbling', 'Defence', 'Head Shot'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Out of 100',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: '/100'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 0,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: name1,
                data: [rat1, pac1, sho1, pas1, dri1, def1, hea1]
            }, {
               name: name2,
                data: [rat2, pac2, sho2, pas2, dri2, def2, hea2]
            }]
        });
    });
    

		</script>

	</head>
	<body>



<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="players.php">Return to players</a><br>

<?php



// Check if the user is logged in, if not, navigate to the login page.
//	if(!isset($_SESSION['userid'])){
//	header("Location:login.html");
//	exit();
//}


$userid = $_SESSION['USERID'];
$usrname =  $_SESSION['username'];

echo "Hi, ";
echo $usrname;

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


$playerid =  $_GET['playerid'];

$q = "SELECT * FROM PLAYERS WHERE BASEID = $playerid";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);

$row = oci_fetch_array($query_stmt);

// echo "Player profile<br><br>";


// echo "Name: ".$row['FIRSTNAME']." ".$row['LASTNAME']."<br>";

?>


<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>


<?php

// echo "Position: ".$row['POSITION']."<br>";
// echo "Rating: ".$row['RATING']."<br>";
// echo "Pacing: ".$row['PAC']."<br>"; 
// echo "Shooting: ".$row['SHO']."<br>";
// echo "Passing: ".$row['PAS']."<br>";
// echo "Dribbling: ".$row['DRI']."<br>";
// echo "Defence: ".$row['DEF']."<br>";
// echo "Head shot: ".$row['HEA']."<br>";
// echo "Birthday: ".$row['DOB']."<br>";
// echo "Foot: ".$row['FOOT']."<br>";
// echo "Club: ".$row['CLUBID']."<br>";
//echo "Nationality: ".$row['NATIONALID']."<br><br>";

$c = "SELECT * FROM COMMENTS WHERE PLAYERID = $playerid";

$com_stmt = oci_parse($conn, $c);

oci_execute($com_stmt);

// if (!$c = oci_fetch_array($com_stmt)) {
//echo "There's no comment about this player yet.<br><br>";

//}
while ($c = oci_fetch_array($com_stmt)) {
//$c = oci_fetch_array($com_stmt);

echo $c['USERNAME']." says: ";
echo $c['CONTENT'];
echo "<br><br>";

} 

$_SESSION['playerid'] = $playerid;

oci_free_statement($com_stmt);
oci_free_statement($query_stmt);
oci_close($conn);

?>


<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>



	</body>
</html>