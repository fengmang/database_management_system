#!/usr/local/bin/php

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Player Profile</title>

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


$playerid =  $_GET['playerid'];

$q = "SELECT * FROM PLAYERS WHERE BASEID = $playerid";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);

$row = oci_fetch_array($query_stmt);
?>


var rat = <?php echo $row['RATING'];?>;
var pac = <?php echo $row['PAC'];?>;
var sho = <?php echo $row['SHO'];?>;
var pas = <?php echo $row['PAS'];?>;
var dri = <?php echo $row['DRI'];?>;
var def = <?php echo $row['DEF'];?>;
var hea = <?php echo $row['HEA'];?>;
var name = "<?php echo $row['FIRSTNAME']." ".$row['LASTNAME']?>";


var pos = "<?php echo $row['POSITION']; ?>";
var dob = "<?php echo $row['DOB']; ?>";
var foot = "<?php echo $row['FOOT']; ?>";
var club = "<?php echo $row['CLUBID']; ?>";
var nat = "<?php echo $row['NATIONALID'];?>";

var title = name + "'s profile";
var sub = name + ", playing for: " + club + ", Nationality: "+ nat + ",  " + foot + " foot " + pos + " Born on: " + dob;

<?php oci_free_statement($query_stmt); ?>

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
                name: name,
                data: [rat, pac, sho, pas, dri, def, hea]
            }, {
                name: 'Average',
                data: [66.7, 67.9, 56.1, 59.3, 62, 59.1, 63.9]
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

// echo $userid;

 
echo "<br>Hi, ".$usrname;

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

echo "Comments:<br><br>";

$c = "SELECT * FROM COMMENTS WHERE PLAYERID = $playerid";

$com_stmt = oci_parse($conn, $c);

oci_execute($com_stmt);

// if (!$c = oci_fetch_array($com_stmt)) {
// echo "There's no comment about this player yet.<br><br>";
// }
while ($c = oci_fetch_array($com_stmt)) {
//$c = oci_fetch_array($com_stmt);

echo $c['USERNAME']." says: ";
echo $c['CONTENT'];
echo "<br><br>";

} 
?>



Post a comment about this player:<br>


<FORM action="comment.php" method="post">
   <P>
   <TEXTAREA name="comment" rows="10" cols="40">
   Input your comment here.
   </TEXTAREA>
   <INPUT type="submit" value="Send"><INPUT type="reset">
   </P>
</FORM>



<?php

$_SESSION['playerid'] = $playerid;

oci_free_statement($com_stmt);
oci_free_statement($query_stmt);
oci_close($conn);

?>


<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>



	</body>
</html>