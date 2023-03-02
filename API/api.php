<?php

include_once("./config.php");
// Set content type to JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM `task` WHERE complete = 0 AND delett = 0;";
    $prepare = mysqli_query($conn, $query);
    if ($prepare) {
        $data = mysqli_fetch_all($prepare, true);
        $response = array("code" => 200, 'message' => 'This is a GET request', "data" => $data);
        echo json_encode($response, true);
    } else {
        $response = array('message' => 'Server Error...');
        echo json_encode($response);
    }

}

// Handle POST request
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $task = $data['task'];
    $query = "INSERT INTO `task`(`task`) VALUES ('${task}');";
    $prepare = mysqli_query($conn, $query);
    if ($prepare) {
        $response = array("code" => 200, 'message' => 'Task Added Successfully.....', 'data' => $data);
        echo json_encode($response);
    } else {
        $response = array("code" => 401, 'message' => 'Server Error.....', 'data' => $data);
        echo json_encode($response);
    }

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $data = json_decode(file_get_contents("php://input"), true);
    $did = $data['did'];
    $query = "DELETE FROM `task` WHERE  id = ${did};";
    $prepare = mysqli_query($conn, $query);
    if ($prepare) {
        $response = array("code" => 200, 'message' => 'Task Deleted Successfully.....', 'data' => $data);
        echo json_encode($response);
    } else {
        $response = array("code" => 401, 'message' => 'Server Error.....', 'data' => $data);
        echo json_encode($response);
    }
}
 else {
    http_response_code(405);
    $response = array('message' => 'This method is not allowed');
    echo json_encode($response);
}

?>