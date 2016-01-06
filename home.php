<? 
//enable sessions: this has to be at the top..there cant be any white 
//spaced befire <?...its a header
session_start();

//supress notices 
//error_reporting(E_ALL ^ E_NOTICE) 

//bring the feed
$user_id;
$user;

//if post is posted: commit it to a database
if(($connection = mysql_connect("localhost","root","password"))===false)
	die("couldnt connect to the database");
//instead of die, return some error

//select database
if(mysql_select_db("facebook", $connection) === false)
die("couldnt select database");

if(isset($_POST['status']))
{ $user_id = print $_SESSION["userid"];
$user = print $_SESSION["user"]; 

//$sql = sprintf("INSERT INTO facebook.posts WHERE user='%s'", mysql_real_escape_string($_POST['user']));

//$sql = sprintf("INSERT INTO posts (`post_id`, `user_id`, `texts`, `like`) 
//				VALUES (NULL, '%d' , '%s' , 0)", print $_SESSION["userid"], mysql_real_escape_string($_POST['status']));
	//execute query..returns a result set(a temp table)

//$sql1 = sprintf("SELECT * FROM posts WHERE username='%s'", mysql_real_escape_string($_POST['user']));
 $sql = sprintf("INSERT INTO posts (`post_id`, `user_id`, `text` , `likes`) 
				VALUES (NULL, '%d' , '%s' , 0)", print $_SESSION["userid"], mysql_real_escape_string($_POST['status']));

	$result = mysql_query($sql);
	if($result===false)
		die("couldnt query database here");

}


?>
<!DOCTYPE html>


<html>
<head>
<title>Home</title>
</head>
<body>
	<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
<h1>Home</h1>
<h3>
<? if(isset($_SESSION['authenticated'])): ?>
You are logged in, <?= htmlspecialchars($_SESSION['user']) ?>!
<br>
<a href="logout.php">log out</a>
<? else: ?>
You are not logged in! 
<? endif ?>
</h3>
<br>
<b>Your Wall</b>
<br><br>
<table>
<tr>
<td>What's on you mind?</td>
<td>
</tr>
<tr>
	<td>
<input name="status" type="text">
</td>
</tr>
<td></td>
<td><input type="submit" value="Post"></td>
<br><br>
<br>

<!-- iterate over posts -->
<tr>
<td> 
<? 
$sql1 = sprintf("SELECT * FROM posts WHERE user_id='%d'", $user_id);
//for each post_id, get comments

$result1 = mysql_query($sql1);

if($result1===false)
die("couldnt query database");

if(mysql_num_rows($result1)!=1)
	{

		
		//fetch row..assoc is for associative array;key value pair
		while($row1 = mysql_fetch_assoc($result1))
	 	{
	 		printf("<br/><br/>%s ", $row1["text"]);
	 		$sql2 = sprintf("SELECT * FROM comments WHERE post_id='%d'", $row1["post_id"]);
	 		$result2 = mysql_query($sql2);
	 		if($result2===false)
			die("couldnt query database");
				
		//fetch row..assoc is for associative array;key value pair
		while($row2 = mysql_fetch_assoc($result2))
	 	{ printf("<br/>Comment: <br/>");
	 		printf("%s <br/><br/>", $row2["text"]);
	 	}
	 

	}
}

  ?>
</td>
</tr>
	</table>
</form>
</body>
</html>