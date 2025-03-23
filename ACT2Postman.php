<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["type"]) && !empty($data["name"])) {
 $Name = $conn->real_escape_string($data["name"]);
 $Type = $conn->real_escape_string($data["type"]);
 $Status = $conn->real_escape_string( $data["status"]);


 $sql = "INSERT INTO t (name, type, status) VALUES ('$Name', '$Type', '$Status')";

if ($conn->query($sql) === TRUE) {
echo json_encode(["status" => "success", "message" => "sensor data added successfully"]);
} else {
 echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
 }
} else {
 echo json_encode(["status" => "error", "message" => "Invalid input"]);
}

$conn->close();

?>