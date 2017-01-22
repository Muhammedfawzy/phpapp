<!DOCTYPE html>
<html>
<head>
	    <link rel="stylesheet" type="text/css" href="css/main.css">

	<title>all projects</title>
	<style type="text/css">
		.gridContainer{
   width:95%;
   margin: 0 auto;
   max-width: 1200px;
}
.projects ul {
   text-align: center;
   padding-top: 20px;

}
.projects ul li{
   width: 300px;
   padding: 10px;
   background-color: #eee;
   display: inline-block;
   position: relative;
   height: 300px;
   overflow: hidden;
   margin: 10px ;

}
.projects ul li img{
   display: block;
   width:100%;
   height: auto;

}
.projects ul li span{
   display: block;
   padding: 5px;
   color: #000;
   font-size: 18px;
   font-family: sans-serif;
}
.removeIcon{
  position: absolute;
  top: 15px;
  right: 15px;
  z-index: 999

}
.removeIcon i , .zoomIn i{
  font-size: 30px;
  color: #b2a4a4;
  cursor: pointer;
}
.zoomIn i{
  font-size: 40px;
}
.zoomIn{
  position: absolute;
  top: 50%;
  right: 50%;
  z-index: 999;
  margin-top: -20px;
  margin-right: -18px;

}
@media screen and (min-width: 480px) {
	.projects ul{
		text-align: left
	}
	.projects ul li{
		width: 45%;
		display: inline-block;
	}
}


	</style>

</head>
<body>
<div class="gridContainer">
	<div class="projects">
		<ul>
		<?php
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

$sql = "SELECT id, name, image_name FROM project";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<li>";
        echo "<a href='project.php?id=".$row["id"]."'>";
        echo "<img src='uploads/".$row["image_name"]."'>";
        echo "<span>".$row["name"]."</span>";
        echo "</a>";
        echo "</li>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>			
		</ul>
	</div><!-- projects -->
</div><!-- gridCOntainer -->
<form action="php/newProject.php" method="post" enctype="multipart/form-data">
  <input type="text" name="project_name">
  <input type="password" name="password">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Add" name="submit">
</form>
</body>
</html>