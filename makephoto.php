<?php
session_start();
if (!$_SESSION[login])
{
	header('location: index.php');
	exit;
}
?>
<!DOCTYPE html>

<head>
    <title>CAMAGRU</title>
    <link rel="stylesheet" href="style2.css">
    <style media="screen">
      .video{
				margin-left: 250px;
        margin-top: 100px;
      }
      #take{
        background-color: gold;
        text-align: center;
        position: relative;
        left: 33%;
        width: 150px;
        height: 50px;
      }

			#frames{
				float: left;
				border: 1px black solid;
				width: 70%;
				height: 150px;
			}
			#photo{
				text-align: center;

			}
		#snow1
			{
				float: left;
				margin-right: 20px;
			}
			#batman2
				{
					float: left;
					margin-right: 20px;
				}
				#frame3
					{
						float: left;
						margin-right: 20px;
					}
					#flower4
						{
							float: left;
							margin-right: 20px;
						}

    </style>
</head>
    <!-- the header -->
    <?php require_once('header.php'); ?>

  <body>

		<div id="frames">
			<p>Select Efect:</p>

<div id="snow1">
  <input type="radio" id="snow" name="chose" value="snow"
         checked>
  <label for="snow">snow</label>
	<br>
	<img src="filters/snow.png" width="50" height="50" alt="">
</div>

<div id="batman2">
  <input type="radio" id="batman" name="chose" value="batman">
  <label for="batman">batman</label>
	<br>
	<img src="filters/batman.png" width="50" height="50" alt="">
</div>

<div id="frame3">
  <input type="radio" id="frame" name="chose" value="frame">
  <label for="frame">frame</label>
	<br>
	<img src="filters/frame.png" width="50" height="50" alt="">
</div>
<div id="flower4">
  <input type="radio" id="flower" name="chose" value="flower">
  <label for="flower">flower</label>
	<br>
	<img src="filters/flower.png" width="50" height="50" alt="">
</div>

		</div>
    <div class="video">
      <video id="vidDisplay" autoplay="true">
        NOONONOOOO
      </video>

			<br>
      <script type="text/javascript">
      navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.msGetUserMedia || navigator.oGetUserMedia;

    if (navigator.getUserMedia) {
    navigator.getUserMedia({video: true}, handleVideo, videoError);
    }
    function handleVideo(stream) {
       document.querySelector('#vidDisplay').src = window.URL.createObjectURL(stream);
      }
    function videoError(e) {
    console.log("The following error occurred: " + err.name);
    }

      </script>
    </div>
    <br>
		<form action="makephoto.php" method="POST">
    <button id="take" type="button" name="button">Take Picture</button>
		<br>
		
		<br>
		<input type="file" id="input" name="file"\>
					 <button id="mixbutton">Mix Photo</button>
				 <img id="output" style="display:none">
	</form>
				 <br>
		<canvas id="photo" width=600 height=500>
		</canvas>

    <script type="text/javascript">
  var player = document.getElementById('vidDisplay');
  var canvas = document.getElementById('photo');
  var context = canvas.getContext('2d');
  var captureButton = document.getElementById('take');
	var download = document.getElementById('download');
	var	mix = document.getElementById('mixbutton');
	var input = document.getElementById('input');
	var output = document.getElementById('output');

	  const constraints = {
    video: true,
  };
	input.addEventListener("change", function()
	{
		var reader = new FileReader();
		reader.addEventListener("loadend", function(arg)
		{
			var src_image = new Image();
			src_image.onload = function()
			{
					context.drawImage(src_image, 0, 0, 600, 500);
					var imageData = canvas.toDataURL("image/png");
					output.src = imageData;
				}
				src_image.src = this.result;
		});

		reader.readAsDataURL(this.files[0]);

		context.drawImage(output, 0, 0, 600, 500);
});
	mix.addEventListener('click', () =>
	{
		var imageData = canvas.toDataURL("image/png");
		if (document.getElementById('snow').checked == true)
			var filter = "snow";
		else if (document.getElementById('batman').checked == true)
			var filter = "batman";
		else if (document.getElementById('frame').checked == true)
			var filter = "frame";
		else if (document.getElementById('flower').checked == true)
				var filter = "flower";
		else
		{
			alert ('Please select a filter');
			exit();
		}
		var xhr = new XMLHttpRequest();

		xhr.open("POST", "makephoto.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("img=" + imageData + "&filter=" + filter);
  });


  captureButton.addEventListener('click', () => {
    context.drawImage(player, 0, 0, 600, 500);
		//file_put_contents('images/'.$_SESSION[login].$i.'.png', $encodeData);

		 var data = canvas.toDataURL('image/png');
		// //data = data.replace(/^data:image\/(png|jpg);base64,/, "");
    //
		// window.location = "makephoto.php?msg=" + data;
		if (document.getElementById('snow').checked == true)
      var filter = "snow";
    else if (document.getElementById('batman').checked == true)
      var filter = "batman";
    else if (document.getElementById('frame').checked == true)
      var filter = "frame";
		else if (document.getElementById('flower').checked == true)
				var filter = "flower";
    else
    {
      alert ('Please select a filter');
      exit();
    }
		var xhr = new XMLHttpRequest();

		xhr.open("POST", "makephoto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("img=" + data + "&filter=" + filter);
    // Stop all video streams.
    //player.srcObject.getVideoTracks().forEach(track => track.stop());
  });

  navigator.mediaDevices.getUserMedia(constraints)
    .then((stream) => {
      // Attach the video stream to the video element and autoplay.
      player.srcObject = stream;
    });


</script>


		 <?php
		  $i = 0;
			 if (array_key_exists('img',$_POST)) {
				 //$imgData = base64_decode($_POST['img']);

				 $img = $_POST['img'];
				 $filter = $_POST['filter'];
				 $img = str_replace(' ', '+', $img);

						 $filterData = substr($img, strpos($img, ",") + 1);
						 $encodeData = base64_decode($filterData);

						 while (file_exists('images/'.$_SESSION[login].$i.'.png') === TRUE)
							 $i++;
						 file_put_contents('images/'.$_SESSION[login].$i.'.png', $encodeData);
						 //create photo with frames
						 $source = imagecreatefrompng('filters/'.$filter.'.png');
						 $dest = imagecreatefrompng('images/'.$_SESSION[login].$i.'.png');
						 $width = imagesx($source);
						 $height = imagesy($source);
						 imagecopy($dest, $source, 0, 0, 0, 0, $width, $height);
						 imagepng($dest, 'images/'.$_SESSION[login].$i.'.png');


						 $path = 'images/'.$_SESSION[login].$i.'.png';

						 $date = date("Y-m-d H:i:s");
						 $name = $_SESSION[login];
						 try
							{
							 $pdo = new PDO('mysql:host=localhost;dbname=db_camagru;charset=utf8', 'root', 'root');
							 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							}
							catch(PDOException $e)
							{
							 die($e->getMessage());
							}
						 $reqest = "INSERT INTO `photo`(`name`, `photo_path`, `photo_date`) VALUES ('$name','$path','$date');";
						 $pdo->prepare($reqest)->execute();
			 	 			}
				?>



  </body>
    <!-- the footer -->
    <?php require_once('footer.php'); ?>

</body>
</html>
