
<?php
$password = $_GET['password'];
$imageId = $_GET['imageId'];
if($password=="123456"){

$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb = substr($cleardb_url["path"], 1);
$servername = $cleardb_server;
$username = $cleardb_username;
$password = $cleardb_password;
$dbname = $cleardb;

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