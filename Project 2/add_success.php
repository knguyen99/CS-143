<html>
<head><title>CS 143 Project 2 </title></head>
<body>
	<?php
		echo "<button onclick=\"window.location.href='index.php'\">Home</button>";
		echo "<button onclick=\"window.location.href='movie_detail.php?mid=".$_GET["mid"]."'\">Go Back</button>";
		echo '<h1> Add Review Result </h1>';
		$mid= $_GET["mid"];
		$rating  = $_GET["rating"];
		$name = $_GET["name"];
		$comment = $_GET["comment"];
		$time = date("Y-m-d H:i:s");
		$db = new mysqli('localhost','cs143','','cs143');
		if($db->connect_errno > 0)
		{ 
			die('Connection to Database Error: [' . $db->connect_error . ']');
		}
		$reviewDet = "INSERT INTO Review VALUES ('".$name."', '".$time."', ".$mid.", ".$rating.", '".$comment."')";
		$rev_res = $db->query($reviewDet);
		if(!$rev_res)
		{
			echo $db->error;
			echo "<br> Unable to add review";
			exit(1);
		}
		echo "Successfully added review to movie!";
		$rev_res->free();
		$db->close();
	?>
</body>
</html>