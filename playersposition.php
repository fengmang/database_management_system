#!/usr/local/bin/php

<!DOCTYPE html>
<html>
     <head>
          <title>Players</title>
            <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	    <link rel="shortcut icon" href="favicon.ico">
     </head>

     <body>

<a href="players.php">Go back to players page</a>
<form align="center" action="positionresults.php" method="get">
  Search for players in the same position by entering the position: <input type="text" name="position" /><input type="submit" value="Submit" />
</form>

<?php

$conn = oci_connect($username = 'dw3',
		       $password = 'Bb1986115',
		       $connection_string = '//oracle.cise.ufl.edu/orcl');
	
if (!$conn) {
	$m = oci_error();
	trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


$c = "SELECT COUNT(*) FROM PLAYERS";
$count_stmt = oci_parse($conn, $c);
oci_execute($count_stmt);

$pagesize = 20;
$myrow = oci_fetch_array($count_stmt);
$numrows=$myrow[0];

$pages= $numrows / $pagesize;

// Calculate the current page
$page = $_GET['page']?$_GET['page']:1;

// Calculate the offset
$offset = $pagesize*($page - 1);


$q = 	"select tb.* from(
		select rownum rn,ta.* from(
			SELECT * FROM PLAYERS ORDER BY RATING DESC
		) ta where rownum <= $offset+$pagesize
	)tb where rn >= $offset";

$query_stmt = oci_parse($conn, $q);
oci_execute($query_stmt);

?>

<table align="center" border="1px">
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
oci_free_statement($count_stmt);
oci_close($conn);

?>


<div id="pfooter">
               <p><?php



echo "<div align='center'>Total of ".$pages." Pages(".$page."/".$pages.")";

//if ($pages > 1) {
//    for($i=1; $i<=$pages; $i++) {
//        if($i == $page) {
//            echo ' [',$i,']';
//        } else {
//            echo ' <a href="players.php?page=',$i,'">',$i,'</a>';
//        }
//    }
//}
?>
</p>



          </div>




</body>
</html>