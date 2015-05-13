<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

</head>
<body>

<?php 
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);
function db_connect(){
	#Add your localhost database parameters in this function
	$result=mysql_connect( 'localhost','root','25011994')or die("cannot connect");
	if (!$result) {
		return false;
	}
	if (!mysql_select_db('gray',$result)){
		return false;
	}
	return $result;
}

$conn  = db_connect();

//echo "connected";
echo "connected";
?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
   <script type="text/javascript">
   		google.load('visualization', '1', {packages: ['corechart', 'bar']});
//google.setOnLoadCallback(drawRightY);

function drawRightY(y) {
	console.log("inside draw");
	console.log(y);
      var data = google.visualization.arrayToDataTable(
      	y);

      var options = {
        chart: {
          title: 'Population of Largest U.S. Cities',
          subtitle: 'Based on most recent and previous census data'
        },
        hAxis: {
          title: 'Total Population',
          minValue: 0,
        },
        vAxis: {
          title: 'City'
        },
        bars: 'vertical',
        axes: {
          y: {
            0: {side: 'right'}
          }
        }
      };
      var material = new google.charts.Bar(document.getElementById('chart_div'));
      material.draw(data, options);
    }
   </script>
<div class="row">
<h1> Nil is here </h1>
   <?php

   $sql = "SELECT FLOOR((TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , 
   	@@session.time_zone ,'+05:30' ))-1)/5)+1 as Category,COUNT(1) as Cont

FROM order_details od,grider_requests g,order_log ol where g.request_id=od.request_id and od.order_id=ol.order_id and ol.status='4' and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))<=120 and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))>0


GROUP BY Category";
$my_arr = array();
$sum = 0;
if($result = mysql_query($sql,$conn)){
	while($row = mysql_fetch_array($result)){
		//echo "<pre>";
		$my_arr[$row['Category']] = $row['Cont'];
		$sum += $row['Cont'];
		//echo "</pre>";
	}
}else{
	 echo "Error updating record: " . mysql_error($conn);
}

/*echo "<pre>";
print_r($my_arr);
echo "</pre>";*/
$new_arr = array();
foreach ($my_arr as $key => $value) {
	$new_arr[] = array($key,($value/$sum)*100);
}

echo "<pre>";
print_r($new_arr);
echo "</pre>";
	echo "<button class=\"btn btn-success\" onClick='graph(". json_encode($new_arr) .")'> Plot Between Total Amount received Vs Day </button> &nbsp;";
   ?>


   </div>


   <div id="chart_div" style="height:400px;"><div>

   <script type="text/javascript">
   function graph(x){
   	console.log("x is");
   	console.log(x);
   		var myData = new Array();
   		myData[0] =   ['category', 'percentage'];
	for(var i=0; i<= x.length-1; i++){
		//console.log(myData);
		myData[i+1]=x[i];
		//myData[i-1]= 	[i,x[i-1][1]];
	}
	console.log("my data");
	console.log(myData);
	drawRightY(myData);


   }
   </script>
</body>
</html>