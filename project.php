<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<script type="text/javascript" src='js/jquery.js'></script>
	<title></title>
	<style type="text/css">
		.gridContainer{
   width:95%;
   margin: 0 auto;
   max-width: 1200px;
}
.project-images ul {
   text-align: center;
   padding-top: 20px;

}
.project-images ul li{
   width: 300px;
   padding: 10px;
   position: relative;
   border:2px solid #eee;
   background-color: #703a3a;
   display: inline-block;
   margin-bottom: 15px;

}
.project-images ul li img{
   display: block;
   width:100%;
   height: auto;

}
.project-images ul li span{
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
	.project-images ul{
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
	<div class="project-images">
		<ul>
		<?php

		$projectId = $_GET['id'];

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

		$sql = "SELECT id, image_url, image_name FROM images where project_id=".$projectId;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       echo "<li>";
       echo "<div class='removeIcon'>
				<i class='fa fa-times' aria-hidden='true' onclick='deleteImage( ".$row[id].")'></i>
			</div>";
			echo "<div class='zoomIn'>
				<i class='fa fa-search-plus' aria-hidden='true'></i>
			</div>";
			echo "<a href='image.php?projectId=".$projectId."'><img src='uploads/".$row[image_url]."'></a>";
			echo "</li>";
    }
    $conn->close();
} 

else {
    echo "0 results"."<br>";
    echo "Add Start photo";
?>

<form action="php/newimage.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="project_id" value="<?php echo $projectId;?>">
  <input type="text" name="title" placeholder="Enter Image Title">
  <input type="password" name="password" placeholder="Enter password">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Add" name="submit">
</form>
<?php
}


		?>
		</ul>
	</div><!-- project-images -->
</div><!-- gridContainer -->
<div id="getPassword">
				<label>Enter password to delete image</label>

		<input type="password" name="" id="passId"> 
</div><!-- getPassword -->
<script type="text/javascript">
	function deleteImage(id){

		var password = document.getElementById("passId").value;
		$.ajax({
                    url: "php/deleteImage.php?imageId="+id+"&password="+password,
                    success: function (data) {
                        alert(data);
                        location.reload();
                    }
                });
	}
</script>
</body>
</html>