#!/usr/local/bin/php
<!DOCTYPE html>

<html>
<h1>League Goals
</h1>
<style>
body{background-image:url("bg2.jpg");}

</style>

<a  align="center" href="index.php">Home</a><br>
<a  align="center" href="league.php">Return to League</a><br>

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

<table align="center" border="1px">
            <thead>
                <tr>
                    <th colspan="10">Scoreboard</th>
                </tr>  
            </thead>
            <tbody>
			     <tr bgcolor="#dcdcdc"> 
                         <td align="center"><b>rank</b></td> 
			             <td align="center"><b>leaguename</b></td>
                         <td align="center"><b>goals</b></td> 
                                
              </tr>  

<?php
while ( $row = oci_fetch_array($query_stmt) ) {     
?>
          <tr align = "center">
                 
                          <td><?php $i++; echo  $i;?></td>
                      
                       <td><?php
                        switch ($row['LEAGUENAME']){
                          case "E0":
                            echo "Premier League";
                            break;
          
                          case "E1":
                            echo "Championship";   
                            break;
                    
                          case "E2":
                            echo "League 1";     
                            break;
                       
                          case "E3":
                            echo "League 2";   
                            break;

                        case "EC":
                        echo "Conference";   
                      
                        break;
  
                        case "D1":
                       echo "Bundesliga 1";    
                       
                        break;

                        case "D2":
                       echo "Bundesliga 2";     
                        
                        break;

 case "I1":
                         echo "Serie A";    
                      
                        break;

 case "I2":
                         echo "Serie B";  
                       
                        break;


 case "SC0":
                        echo "Scotland Div1";    
                       
                        break;


 case "SC1":
                         echo "Scotland Div2";   
                   
                        break;


 case "SC2":
                        echo "Scotland Div3";    
                      
                        break;

 case "SC3":
                        echo "Scotland Div4";    
                   
                        break;


 case "SP1":
                         echo "La Liga Primera";     
                      
                        break;



 case "SP2":
                        echo "La Liga Segunda";    
                    
                        break;



 case "F1":
                        echo "Le Championnat";     
                     
                        break;


 case "F2":
                        echo "France Div2";    
               
                        break;




 case "N1":
                       echo "Eredivisie";    
               
                        break;



 case "B1":
                         echo "Jupiler League";    
                       
                        break;



 case "P1":
                         echo "Liga I";    
                       
                        break;


 case "T1":
                        echo "Futbol Ligi 1";    
                       
                        break;


 case "G1":
                       echo "Ethniki Katigoria";    
                      
                        break;
 
}
?></td>
    
<td><?php echo $row['GOALS'];?></td>
           </tr>
<?php
 }      


oci_free_statement($query_stmt);
oci_free_statement($com_stmt);
oci_close($conn);

?>
</html>