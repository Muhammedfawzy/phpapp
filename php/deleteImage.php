
<?php
$password = $_GET['password'];
$imageId = $_GET['imageId'];
if($password=="123456"){

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

// sql to delete a record
$sql = "DELETE FROM images WHERE id=$imageId";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

}else{
	echo "password is not correct";
}
?>