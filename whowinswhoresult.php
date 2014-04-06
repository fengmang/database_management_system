#!/usr/local/bin/php

<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="whowinswho.php">Return to teamplayers search page</a><br>

<?php

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$club1 = ucfirst(strtolower($_GET['club1']));
$club2 = ucfirst(strtolower($_GET['club2']));

$q = "SELECT TEAMNAME,SUM(WIN)AS WIN,SUM(DRAW)AS
DRAW,SUM(LOSE)AS LOSE
FROM ((SELECT A.TEAMNAME ,A.WIN ,B.DRAW,C.LOSE
FROM (SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS
WIN
FROM MATCH
WHERE (HOMETEAM LIKE '%$club1%' AND AWAYTEAM LIKE '%$club2%')
AND FTR='H'
GROUP BY HOMETEAM) A
,
(SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS DRAW
FROM MATCH
WHERE (HOMETEAM LIKE '%$club1%' AND AWAYTEAM LIKE '%$club2%')
AND FTR='D'
GROUP BY HOMETEAM) B
,
(SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS LOSE
FROM MATCH
WHERE (HOMETEAM LIKE '%$club1%' AND AWAYTEAM LIKE '%$club2%')
AND FTR='A'
GROUP BY HOMETEAM) C
WHERE A.TEAMNAME=C.TEAMNAME AND
B.TEAMNAME=C.TEAMNAME )
UNION
(SELECT A.TEAMNAME ,A.WIN ,B.DRAW,C.LOSE
FROM (SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS
WIN
FROM MATCH
WHERE (HOMETEAM LIKE '%$club2%' AND AWAYTEAM LIKE '%$club1%')
AND FTR='H'
GROUP BY HOMETEAM) A
,
(SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS DRAW
FROM MATCH
WHERE (HOMETEAM LIKE '%$club2%' AND AWAYTEAM LIKE '%$club1%')
AND FTR='D'
GROUP BY HOMETEAM) B
,
(SELECT HOMETEAM AS TEAMNAME, COUNT(*) AS LOSE
FROM MATCH
WHERE (HOMETEAM LIKE '%$club2%' AND AWAYTEAM LIKE '%$club1%')
AND FTR='A'
GROUP BY HOMETEAM) C
WHERE A.TEAMNAME=C.TEAMNAME AND
B.TEAMNAME=C.TEAMNAME )
UNION
(SELECT A.TEAMNAME ,A.WIN ,B.DRAW,C.LOSE
FROM (SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS WIN
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club1%' AND HOMETEAM LIKE '%$club2%')
AND FTR='A'
GROUP BY AWAYTEAM) A
,
(SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS DRAW
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club1%' AND HOMETEAM LIKE '%$club2%')
AND FTR='D'
GROUP BY AWAYTEAM) B
,
(SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS LOSE
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club1%' AND HOMETEAM LIKE '%$club2%')
AND FTR='H'
GROUP BY AWAYTEAM) C
WHERE A.TEAMNAME=C.TEAMNAME AND
B.TEAMNAME=C.TEAMNAME )
UNION
(SELECT A.TEAMNAME ,A.WIN ,B.DRAW,C.LOSE
FROM (SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS WIN
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club2%' AND HOMETEAM LIKE '%$club1%')
AND FTR='A'
GROUP BY AWAYTEAM) A
,
(SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS DRAW
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club2%' AND HOMETEAM LIKE '%$club1%')
AND FTR='D'
GROUP BY AWAYTEAM) B
,
(SELECT AWAYTEAM AS TEAMNAME, COUNT(*) AS LOSE
FROM MATCH
WHERE (AWAYTEAM LIKE '%$club2%' AND HOMETEAM LIKE '%$club1%')
AND FTR='H'
GROUP BY AWAYTEAM) C
WHERE A.TEAMNAME=C.TEAMNAME AND
B.TEAMNAME=C.TEAMNAME ))
GROUP BY TEAMNAME";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);


echo "Are you looking for...<br><br>";
?>

    <table align="center" border="1px">
            <thead>
                <tr>
                    <th colspan="4">Results</th>
                </tr>  
            </thead>
            <tbody>
              <tr bgcolor="#dcdcdc"> 
                    <td align="center"><b>TEAMNAME</b></td>  
			        <td align="center"><b>WIN</b></td> 
                    <td align="center"><b>DRAW</b></td> 
			        <td align="center"><b>LOSE</b></td>  


               </tr>
<?php
while ( $row = oci_fetch_array($query_stmt) ) {
?>
    
	<tr>
	         <td><?php	echo $row['TEAMNAME']?></td>
		 <td><?php	echo $row['WIN']?></td>
		 <td><?php	echo $row['DRAW']?></td>
		 <td><?php	echo $row['LOSE']?></td>

      </tr>


	<?php
	
}





$c = "SELECT * FROM COMMENTS WHERE PLAYERID = 191251";

$com_stmt = oci_parse($conn, $c);

oci_execute($com_stmt);

$c = oci_fetch_array($com_stmt);

echo $c['CONTENT'];

oci_free_statement($query_stmt);
oci_free_statement($com_stmt);
oci_close($conn);



?>