<html>
<head></head>
<body>
	
	<h1> we are here </h1>


	<?php 
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);


	$date = date('Y-m-d');
	$date = explode("-", $date);

	$start =  implode("-", array($date[0],$date[1],"01") );;

	$end =  implode("-", array($date[0],$date[1],"31") );

	echo $start."   ".$end;




	?>

</body>
</html>
