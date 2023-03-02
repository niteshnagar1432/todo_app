<?php

include_once("./config.php");
// Set content type to JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
} else {
    $response = array("code" => 401, 'message' => 'Server Error.....', 'data' => $data);
    echo json_encode($response);
}

?>