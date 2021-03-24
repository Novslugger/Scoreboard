<?php

/*
 * Database Constants
 */
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'scoreboard');

//Connecting to the database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

//checking the successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//making an array to store the response
$response = array();

//if there is a post request move ahead
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //getting the data from request
   
	
	if(isset($_POST['game_name'])){
		$game_name = $_POST['game_name'];
	}
	
	if(isset($_POST['game_type'])){
		$game_type = $_POST['game_type'];
	}
	
	
$sql = "select * from ".$game_type." order by id desc"; //where game_name like '%$game_name%'
$res = mysqli_query($conn,$sql);
$result = array();
while($row = mysqli_fetch_array($res)){
array_push($result,array('game_name'=>$row['game_name'],
'period'=>$row['period'],
'id'=>$row['id']
));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($conn);
 

} else {
    $response['error'] = true;
    $response['message'] = "Invalid request";
    $response['type'] = $_SERVER['REQUEST_METHOD'];
}

//displaying the data in json format
echo json_encode($response);