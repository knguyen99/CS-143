<html>
<head><title>CS 143 Project 2 </title></head>
<body>
	<button onclick="window.location.href='index.php'">Home</button>
	<h1> Movie Details </h1>
	<?php 
		$mid = $_GET["mid"];
		$db = new mysqli('localhost','cs143','','cs143');
		if($db->connect_errno > 0)
		{ 
			die('Connection to Database Error: [' . $db->connect_error . ']');
		}
		$movieDet = "SELECT * FROM Movie WHERE (id = '{$mid}')";
		$movie_res = $db->query($movieDet);
		if(!$movie_res)
		{
			echo $db->error;
			exit(1);
		}
		echo "<h2>Movie Information is: </h2><br>";
		if($movie_res->num_rows == 1)
		{
			$row = $movie_res->fetch_assoc();
			echo "Title: ".$row["title"]."(".$row["year"].")<br>";
			echo "Producer: ".$row["company"]."<br>";
			echo "MPAA Rating: ".$row["rating"]."<br>";
			$movie_res->free();
		}
		else{
			echo "No result found for Movie ID";
		}

		$directorDet = "SELECT * FROM Director WHERE Director.id IN (SELECT MovieDirector.did FROM MovieDirector WHERE mid = '{$mid}')";
		$d_res = $db->query($directorDet);
		if(!$d_res)
		{
			echo $db->error;
			exit(1);
		}
		echo "Director: ";
		if($d_res->num_rows < 1)
		{
			echo "No Director Found";
		}
		else{
			$string = "";
			while($row = $d_res->fetch_assoc())
			{
				$string .= $row["first"]." ".$row["last"].", ";
			}
			echo substr($string,0,-2)."<br><br>";
			$d_res->free();
		}

		echo "<h2>Actors in this Movie: </h2>";
		$actor_det = "SELECT aid, first, last, role FROM MovieActor a, Actor b WHERE (a.aid = b.id AND a.mid = '{$mid}')";
		$a_res = $db->query($actor_det);
		if(!$a_res)
		{
			echo $db->error;
			exit(1);
		}
		if($a_res->num_rows < 1)
		{
			echo "No Actors found for this movie";
		}
		else{
			while($row = $a_res->fetch_assoc())
			{
				echo "Name: <a href='/actor_detail.php?aid=" . $row["aid"] . "'>" . $row["first"] . " " . $row["last"]."</a> | Role: ".$row["role"]."<br>";
			}
			$a_res->free();
		}

		echo "<br><h2>Reviews: </h2>";
		echo "<h3> Add a Review: </h3>";
		echo '
			<form action="add_success.php">
				<label for="name">Name: </label> <br>
				<input type="text" maxlength="20" name="name" id="name" placeholder="Your Name" required> <br> <br>
				<input type="hidden" name="mid" value='.$mid.'>
				<label for="rating">Rating: </label> <br>
				<select name="rating" id="rating" required>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select> <br> <br>
				<label for="comment">Comment: </label><br>
				<textarea name="comment" id="comment" rows="5" required> </textarea><br> <br>
				<button type="submit">Submit</button>
			</form>
		';
		echo '<h3>View Comments: </h3>';
		$avg = "SELECT AVG(rating), COUNT(*) FROM Review WHERE (mid = '{$mid}')";
		$avg_res = $db->query($avg);
		if(!$avg_res){
			echo $db->error;
			exit(1);
		}
		$row = $avg_res->fetch_assoc();
		if($row["COUNT(*)"] == 0)
		{
			echo "No reviews for this movie yet!";
		}
		else{
			echo "Average score for this Movie is ".$row["AVG(rating)"]."/5 based on ".$row["COUNT(*)"]." people's reviews. <br>";
			$reviews = "SELECT * FROM Review WHERE (mid = '{$mid}')";
			$rev_res = $db->query($reviews);
			if(!$rev_res)
			{
				echo $db->error;
				exit(1);
			}
			echo "<h3>Comments:</h3><br>";
			while($rev_row = $rev_res->fetch_assoc()){
				echo "<b>".$rev_row["name"]."</b> rates this movie with score <b>".$rev_row["rating"]."</b> on ".$rev_row["time"]." comment: <br>".$rev_row["comment"]."<br> <br>";

			}
			$rev_res->free();

		}
		$avg_res->free();
		$db->close();
	?>

</body>
</html>