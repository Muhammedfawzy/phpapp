<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Tour</title>
     <!--[if lt IE 9]>
  <script src="js/shiv.js"></script>
  <![endif]-->
    <link rel="stylesheet" href="css/pannelum.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css">
        <script type="text/javascript" src="js/jquery.js"></script>
     <script type="text/javascript" src="js/pannellum.js"></script>
     <script type="text/javascript" src="js/libpannellum.js"></script>
 


    <style>
    #panorama {
        width: 100%;
        height: 600px;
    }
    </style>
</head>
<body>

<div id="panorama">
<div class="controllContainer">
  <div class="gridContainer">
    <ul class="controllIcons">
      <li><span id="goTop">&#8679;</span></li>
      <li><span id="goBottom">&#8681;</span></li>
      <li><span id="goRight">&#8680;</span></li>
      <li><span id="goLeft">&#8678;</span></li>
    </ul><!--controllIcons-->
    
  </div><!--gridContainer-->
</div><!--controlContainer-->
</div>
<div class="form-rorm">
    <form action="php/addSpot.php" method="post">
    <input type="text"    name="pitch" id="pitch">
    <input type="text"    name="yaw" id="yaw">
    <input type="text"    name="sceneId" id="sceneId">
    <input type="text"    name="title" id="title">
    <input type="submit" value="add spot">
    <!--<button onclick="sendValues()"> send values</button> -->
    </form>
</div><!-- form-rorm -->
<?php

$projectId = $_GET['projectId'];

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

        $sql = "SELECT id, image_url, image_name FROM images where project_id=".$projectId." and defult = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       $defultImagePath =  $row['image_url'];
       $defultImageName = $row['image_name'];
       $id = $row['id'];
    }
    
}

$sql2 = "SELECT * FROM hotspots where image_id = ".$id." ";
$result2 = $conn->query($sql2);

class spot
{
       public $pitch;
       public $yaw;
       public $stype;
       public $title;
       public $sceneId;
}
if ($result2->num_rows > 0) {
    
    $spots = array();
    // output data of each row
    while($row = $result2->fetch_assoc()) {
       $newSpot = new spot();
       $pitch = $row['pitch'];
       $newSpot->pitch = $pitch;
       $yaw = $row['yaw'];
       $newSpot->yaw = $yaw;
       $stype =  $row['stype'];
       $newSpot->stype = $stype;
       $title =  $row['title'];
       $newSpot->title = $title;
       $sceneId = $row['sceneId'];
       $newSpot->sceneId = $sceneId;
       $spots[] = $newSpot;
    }

}
$conn->close();

?>
<script>
       
var pan =
pannellum.viewer('panorama', {   
    "default": {
        "firstScene": "<?php echo $defultImageName;?>",
        "author": "Matthew Petroff",
        "sceneFadeDuration": 1000,
		"autoLoad":true
    },

    "scenes": {
        "<?php echo $defultImageName; ?>": {
            "title": "Mason Circle",
            "hfov": 110,
            "pitch":-3,
            "yaw": 117,
            "type": "equirectangular",
            "panorama": "uploads/<?php echo $defultImagePath ;?>"           
        },

        "house": {
            "title": "Spring House or Dairy",
            "hfov": 110,
            "yaw": 5,
            "type": "equirectangular",
            "panorama": "images/cerro-toco-0.jpg",
            "hotSpots": [
                {
                    "pitch": -0.6,
                    "yaw": 37.1,
                    "type": "scene",
                    "text": "Mason Circle",
                    "sceneId": "circle",
                    "targetYaw": -23,
                    "targetPitch": 2,
					"hotSpotDebug":true
                }
            ]
        }
    }
});

    function addHotss(){
          var obj = JSON.parse('<?php echo json_encode($spots) ?>');
         for (i = 0; i < obj.length; i++) {           
            pan.addHotSpot({"pitch": obj[i].pitch,
                    "yaw": obj[i].yaw,
                    "type": obj[i].stype,
                    "text": obj[i].title,
                    "sceneId": obj[i].sceneId
                });
    }
}

$("#goTop").click(function(){
	
addHotss();
pan.setPitch(pan.getPitch()+10)

	})
	$("#goBottom").click(function(){
	

pan.setPitch(pan.getPitch()-10)

	})
	$("#goRight").click(function(){
	

pan.setYaw(pan.getYaw()+10)

	})
	$("#goLeft").click(function(){
	

pan.setYaw(pan.getYaw()-10)
	})
	$("#goImage").attr("href","circle")
	
</script>

</body>
</html>
