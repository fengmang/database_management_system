#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="players.php">Return to players</a><br>

<?php

$conn = oci_connect($username = 'dw3',
               $password = 'Bb1986115',
               $connection_string = '//oracle.cise.ufl.edu/orcl');
    
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


$q = "Select div as leaguename, sum(goals) as goals
From ((Select div ,sum(FTHG) as goals
From match
Group by div) union
(Select div ,sum(FTAG) as goals
From match
Group by div))
Group by div 
Order by goals desc";

$query_stmt = oci_parse($conn, $q);

oci_execute($query_stmt);
?>

<table align="left" border="1px">
            <thead>
                <tr>
                    <th colspan="10">Scoreboard</th>
                </tr>  
            </thead>
            <tbody>
                 <tr bgcolor="#dcdcdc"> 
                                   <td align="center"><b>RANK</b></td> 
                         <td align="center"><b>leaguename</b></td>
                                      <td align="center"><b>goals</b></td> 
                                
              </tr>  

<?php
while ( $row = oci_fetch_array($query_stmt) ) {
    
       var_dump($row);
?>
          <tr>
                    <td><?php $i++; echo  $i;?></td>
                     <td><?php echo $row['LEAGUENAME'];?></td>     
                     <td><?php echo $row['GOALS'];?></td> 
                     
                </tr>

       

<?php
    
}

oci_free_statement($query_stmt);
oci_free_statement($com_stmt);
oci_close($conn);

?>
</html>