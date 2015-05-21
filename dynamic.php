<?php 
//ini_set('display_errors', true);
//error_reporting(E_ALL ^ E_NOTICE);
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
//echo "connected";
if(isset($_REQUEST['start'])){
	$start_date = $_REQUEST['start'];
$end_date = $_REQUEST['end'];
$sql = "SELECT FLOOR((TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , 
   	@@session.time_zone ,'+05:30' ))-1)/5)+1 as Category,COUNT(1) as Cont

FROM order_details od,grider_requests g,order_log ol where (date(g.pickup_time) 
	between '$start_date' and '$end_date') and g.request_id=od.request_id and od.order_id=ol.order_id and ol.status='4' 
and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))<=120 and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))>0


GROUP BY Category";
}else{

	$date = date('Y-m-d');
	$date = explode("-", $date);

	$start_date =  implode("-", array($date[0],$date[1],"01") );;

	$end_date =  implode("-", array($date[0],$date[1],"31") );

$sql = "SELECT FLOOR((TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , 
   	@@session.time_zone ,'+05:30' ))-1)/5)+1 as Category,COUNT(1) as Cont

FROM order_details od,grider_requests g,order_log ol where (date(g.pickup_time) 
	between '$start_date' and '$end_date') and g.request_id=od.request_id and od.order_id=ol.order_id and ol.status='4' 
and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))<=120 and TIMESTAMPDIFF(MINUTE,g.timestamp,CONVERT_TZ( ol.timestamp , @@session.time_zone ,'+05:30' ))>0


GROUP BY Category";	
}

$nil_arr = array();

for ($i=1; $i <=21 ; $i++) { 
	$nil_arr[$i] = 0;
}

//echo $sql;
$my_arr = array();
$sum = 0;
if($result = mysql_query($sql,$conn)){
	while($row = mysql_fetch_array($result)){
		//echo "<pre>";
		$my_arr[$row['Category']] = $row['Cont'];
		if(array_key_exists($row['Category'], $nil_arr)){
			//$random = rand(0, 25);
			$random = rand(0, 0);
			$nil_arr[$row['Category']] = $row['Cont'] + $random ;
		}
		$sum += ($row['Cont'] + $random);
		//echo "</pre>";
	}
}else{
	 echo "Error updating record: " . mysql_error($conn);
}


$new_arr = array();
foreach ($nil_arr as $key => $value) {
	$nil_arr[$key] = ($value/$sum)*100;
}
$my_arr = array();

foreach ($nil_arr as $key => $value) {
	$new_key = ($key*5);//."-".($key*5+4);
	$my_arr[$new_key] = $value;
}
//echo json_encode($new_arr);
echo json_encode($my_arr);
?>