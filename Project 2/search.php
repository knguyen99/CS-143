<html>
<head><title>CS 143 Project 2</title></head>
<body>
	<button onclick="window.location.href='index.php'">Home</button>

	<h1> Search Results</h1>   <br/><!-- <?php 
		echo $_GET["query"]; 
	?> -->
 	<?php 
		$query_string = $_GET["query"];
		$words_arr = explode(" ",$query_string);
		$db = new mysqli('localhost','cs143','','cs143');
		if($db->connect_errno > 0)
		{ 
			die('Connection to Database Error: [' . $db->connect_error . ']');
		}

		$actorsList = "SELECT * FROM Actor WHERE (first LIKE '%{$words_arr[0]}%' OR last LIKE '%{$words_arr[0]}%')"; 

		for( $i = 1; $i < count($words_arr); $i++){
			$actorsList .= "AND (first LIKE '%{$words_arr[$i]}%'OR last LIKE '%{$words_arr[$i]}%')";
		}
		$actorsList .= " ORDER BY Actor.last";
		// echo $actorsList
		$actor_res = $db->query($actorsList);
		if(!$actor_res)
		{
			echo $db->error;
			exit(1);
		}
		echo "<h2> Actor Results </h2>";
		if($actor_res->num_rows > 0)
		{
			while($row = $actor_res->fetch_assoc())
			{
				echo "<a href='/actor_detail.php?aid=".$row["id"]."'>". $row["first"]. " " . $row["last"]."</a><br>";
			}
			$actor_res->free();
		}
		else
		{
			echo "Results not found in Actor";
		}

		$movieList = "SELECT * FROM Movie WHERE (title LIKE '%{$words_arr[0]}%' )";
		for( $i = 1; $i < count($words_arr); $i++){
			$movieList .= "AND (title LIKE '%{$words_arr[$i]}%')";
		}
		$movieList .= " ORDER BY Movie.title";
		$movie_res = $db->query($movieList);
		if(!$movie_res)
		{
			echo $db->error;
			exit(1);
		}
		echo "<br> <h2> Movie Results </h2>";
		// echo "{$movieList}";
		if($movie_res->num_rows > 0)
		{
			while($row = $movie_res->fetch_assoc())
			{
				echo "<a href='/movie_detail.php?mid=".$row["id"]."'>". $row["title"]."</a><br>";
			}
			$movie_res->free();
		}
		else{
			echo "Results not found in Movie";
		}
		$db.close();
	?>
</body>
</html>