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
    $game_name = $_POST['game_name'];
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];
    $away_team_score = $_POST['away_team_score'];
    $home_team_score = $_POST['home_team_score'];
    $period = $_POST['period'];
    $home_team_foul = $_POST['home_team_foul'];
    $away_team_foul = $_POST['away_team_foul'];
    $game_type = $_POST['game_type'];
	$serve = $_POST['serve'];

    if ($game_type == "basketball_scores") {

        $sql = "select * from basketball_scores where game_name = '" . $game_name . "' and period = '" . $period . "'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);

        if ($count > 0) {

            mysqli_query($conn, "update basketball_scores set game_name = '" . $game_name . "', home_team = '" . $home_team . "'
                ,away_team = '" . $away_team . "' ,away_team_score = '" . $away_team_score . "' ,home_team_score = '" . $home_team_score . "'
                ,period = '" . $period . "' ,home_team_foul = '" . $home_team_foul . "', away_team_foul = '" . $away_team_foul . "'
                where game_name = '" . $game_name . "' and period = '" . $period . "'"
            );
            $response['message'] = "Data successfully saved.";

        } else {

            mysqli_query($conn, "INSERT INTO basketball_scores (game_name, home_team ,away_team, away_team_score, home_team_score, period, home_team_foul, away_team_foul)
        VALUES ('" . $game_name . "','" . $home_team . "', '" . $away_team . "', $away_team_score, $home_team_score, $period, $home_team_foul, $away_team_foul)");

            $response['message'] = "Data successfully saved.";
        }
    } else if ($game_type == "common_scores") {

        $sql = "select * from " . $game_type . " where game_name = '" . $game_name . "' and period = '" . $period . "'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);

        if ($count > 0) {

            mysqli_query($conn, "update " . $game_type . " set game_name = '" . $game_name . "', home_team = '" . $home_team . "'
                ,away_team = '" . $away_team . "' ,away_team_score = '" . $away_team_score . "' ,home_team_score = '" . $home_team_score . "'
                ,period = '" . $period . "' where game_name = '" . $game_name . "' and period = '" . $period . "'"
            );
            $response['message'] = "Data successfully saved.";

        } else {

            mysqli_query($conn, "INSERT INTO " . $game_type . " (game_name, home_team ,away_team, away_team_score, home_team_score, period)
        VALUES ('" . $game_name . "','" . $home_team . "', '" . $away_team . "', $away_team_score, $home_team_score, $period)");

            $response['message'] = "Data successfully saved.";
        }

    } else {
		
		  $sql = "select * from " . $game_type . " where game_name = '" . $game_name . "' and period = '" . $period . "'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);

        if ($count > 0) {

            mysqli_query($conn, "update " . $game_type . " set game_name = '" . $game_name . "', home_team = '" . $home_team . "'
                ,away_team = '" . $away_team . "' ,away_team_score = '" . $away_team_score . "' ,home_team_score = '" . $home_team_score . "' ,serve = '" . $serve . "',period = '" . $period . "' where game_name = '" . $game_name . "' and period = '" . $period . "'"
            );
            $response['message'] = "Data successfully saved.";

        } else {

            mysqli_query($conn, "INSERT INTO " . $game_type . " (game_name, home_team ,away_team, away_team_score, home_team_score, period,serve)
        VALUES ('" . $game_name . "','" . $home_team . "', '" . $away_team . "', $away_team_score, $home_team_score, $period, $serve)");

            $response['message'] = "Data successfully saved.";
        }
		
		
	}

} else {
    $response['error'] = true;
    $response['message'] = "Invalid request";
}

//displaying the data in json format
echo json_encode($response);



