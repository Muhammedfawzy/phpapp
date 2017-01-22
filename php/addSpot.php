<?php 
$pitch = $_POST['pitch'];
$yaw = $_POST['yaw'];
$sceneId = $_POST['sceneId'];
$title = $_POST['title'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "3d";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind

if ($stmt = $conn->prepare("INSERT INTO hotspots (hs_id, pitch,yaw,stype,title,sceneId,image_id) VALUES (?,?, ?, ?, ?, ?, ?)")) {
    $stmt->bind_param("isssssi",$id2, $pitch1, $yaw1, $type, $title1, $sceneId,$id1);
}
else {
    printf("Errormessage: %s\n", $conn->error);
}
// set parameters and execute
$id2 = "null";
$pitch1 = $pitch;
$yaw1 = $yaw;
$title1 = $title;
$type = "scene";
$sceneId = $sceneId;
$id1 = 15;  
$stmt->execute();


echo "New records created successfully";

$stmt->close();
$conn->close();


header("Location: ../image.php?projectId=1");

?>