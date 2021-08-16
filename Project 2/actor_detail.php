<html>
<head><title>CS 143 Project 2 </title></head>
<body>
	<button onclick="window.location.href='index.php'">Home</button>
	<h1> Actor Details </h1>
	<?php 
		$aid = $_GET["aid"];
		$db = new mysqli('localhost','cs143','','cs143');
		if($db->connect_errno > 0)
		{ 
			die('Connection to Database Error: [' . $db->connect_error . ']');
		}
		$actorDet = "SELECT * FROM Actor WHERE (id = '{$aid}')";
		$actor_res = $db->query($actorDet);


		echo "<h2>Actor Information is: </h2><br>";
		if($actor_res->num_rows == 1)
		{
			$row = $actor_res->fetch_assoc();
			echo "Name: ". $row["first"]. " ". $row["last"] . "<br>";
			echo "Sex: ".$row["sex"]. "<br>";
			echo "Date of Birth: ".$row["dob"]. "<br>";
			if($row["dod"] == "")
			{
				echo "Date of Death: Still Alive <br> <br>";
			}
			else {
				echo "Date of Death: ".$row["dod"]. "<br> <br>";
			}
			
			$actor_res->free();
			echo "<h2> Actor's Movies and Role </h2>";
			$movie_roles = "SELECT * FROM MovieActor a, Movie b WHERE (a.aid = '{$aid}' AND a.mid = b.id)";
			$role_det = $db->query($movie_roles);
			if($role_det->num_rows >= 1)
			{
				while($mrow = $role_det->fetch_assoc()){
					echo "Title: <a href='/movie_detail.php?mid=".$mrow["id"]."'>". $mrow["title"]."</a>". " | Role: ".$mrow["role"]."<br>";
				}
				$role_det->free();
			}
			else
			{
				echo "Actor has no roles";
			}
		}
		else{
			echo "No result found for Actor ID";
		}
		$db->close();
	?>

</body>
</html>