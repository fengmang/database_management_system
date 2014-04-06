#!/usr/local/bin/php

<!DOCTYPE html>
<html>
     <head>
          <title>Players</title>
            <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	    <link rel="shortcut icon" href="favicon.ico">
              <style type="text/css">
            form{
                margin: 50px;
                font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
                font-size :2em;             
            }

            img{
                height:30em;
                weight:30em;
                margin: 0px 0px 0px 400px;
 
             }
                </style>
     </head>
             
     <body>

<a href="league.php">return to league</a>
<form align="center" action="whowinswhoresult.php" method="get">
  The history match results between the two teams: <input type="text" name="club1" />VS<input type="text" name="club2" /><input type="submit" value="Submit" />
</form>
<img src="vs.jpg" />
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
//$page = $_GET['page']?$_GET['page']:1;

// Calculate the offset
//$offset = $pagesize*($page - 1);


$q = 	"select tb.* from(
		select rownum rn,ta.* from(
			SELECT * FROM PLAYERS ORDER BY RATING DESC
		) ta where rownum <= $offset+$pagesize
	)tb where rn >= $offset";

$query_stmt = oci_parse($conn, $q);
oci_execute($query_stmt);

?>



<?php
while ($row = oci_fetch_array($query_stmt)) {
?>
            
         
               

<?php
}



oci_free_statement($query_stmt);
oci_free_statement($count_stmt);
oci_close($conn);

?>


<div id="pfooter">
               <p><?php



//echo "<div align='center'>Total of ".$pages." Pages(".$page."/".$pages.")";

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