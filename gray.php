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

echo "connected";

$sql = "SELECT * FROM category";
if($result = mysql_query($sql,$conn)){
	while($row = mysql_fetch_array($result)){
		echo $row['category_id']." ".$row['range']."<br />";
		$id = $row['id'];
		$value1 = ($row['category_id'] - 1)*5;
		$value2 = $value1+4;
		$range = $value1."-".$value2;
		
		$sql = "UPDATE `category` SET `range`='{$range}' WHERE `id`='{$id}'";
		if (mysql_query($sql,$conn)) 
		{
		    echo "Record updated successfully";
		
		} else {
		    echo "Error updating record: " . mysql_error($conn);
		}
		

	}
}
	

	$sql = "SELECT * FROM data";
	if($result = mysql_query($sql,$conn)){
		while($row = mysql_fetch_array($result)){
			$category_id = ($row['data']-1) /5 +1;

		$sql = "UPDATE `category` SET `count`=(`count`+1) WHERE `category_id`= '{$category_id}'";
			if (mysql_query($sql,$conn)) 
			{
			    //echo "Record updated successfully";
			}else
			{
			    echo "Error updating record: " . mysql_error($conn);
			}


		} 

		}else{
			echo "Error updating record: " . mysql_error($conn);
		}
		echo "updated";
	
	





?>