<?
session_start();
include 'Myconstants.php';
include 'Posts.php';
include 'Comments.php';
include 'CommentPersist.php';
include 'UserPersist.php';
include 'LikesPersist.php';
//include 'Connection.php';
include 'Post_persist.php';

$host = $_SERVER["HTTP_HOST"];
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");	

//$GLOBALS['host'] = $_SERVER["HTTP_HOST"];
//$GLOBALS['path'] = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
date_default_timezone_set('Asia/Kolkata');



function connection()
{ $config = parse_ini_file('/Users/sangeetasingh/config.ini'); 
	$host="localhost";
	$dbname = "facebook";
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $config['username'], $config['password']);
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
return $DBH;
} 

//redirecting to the searched person's page
if(isset($_POST['searchKey']))
{ try {

	$us = new UserPersist();
	$rslt2 = $us->getUserByName($_POST['searchKey']);

foreach($rslt2 as $row3) 
{
	//while($row3 = $STH->fetch())
//{
  $suid = $row3['id'];
}
				
			
			//$host = $_SERVER["HTTP_HOST"];
			//$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");	
			$searchKey = NULL;
			if($suid)
			{$_SESSION['curruser']  =  $suid;
			header("Location: http://$host$path/post_class.php");
		}
		else
			echo "No such user.";

}

catch(PDOException $e)
{
	echo $e->getMessage();
}

}

if(isset($_POST['status']))
{ $user_id =  $_SESSION["curruser"];
$user = print $_SESSION["user"]; 

try {

//inserting data into the table using an array
	$tme = date( "Y-m-d H:i");
$post = new Posts(NULL, $_SESSION["curruser"], $tme , $_POST['status'], 0 );
$ps = new Post_persist();
$ps->save($post); 

}

catch(PDOException $e)
{
	echo $e->getMessage();
}
}

if(isset($_POST['cmnt']))
{ try {
$tme = date( "Y-m-d H:i");
$comm = new Comments(NULL, $_POST['postid'],$_SESSION['userid'], $tme , $_POST['cmnt'] );
$cs = new CommentPersist();
$cs->save($comm); 

}

catch(PDOException $e)
{
	echo $e->getMessage();
}

}
?>
<? if(isset($_SESSION['authenticated'])) {?>
<script type="text/javascript" language="javascript" src="http://localhost/~sangeetasingh/facebook/actions.js"></script>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="w3.css">
<head>
	<style>
	p.solid {border-style: solid;}
	</style>
<title>Home</title>
</head>
<body>
	<section>
	<td><input type="submit" value="Home" onclick="redirect(); return false;"></td>
	</section>
	<form method="post" onsubmit="http://$host$path/post_class.php">
<tr>
<td>Search</td>
</tr>
<tr>
	<td>
<input name="searchKey" type="text">
</td>
</tr>
<td></td>
<td><input type="submit" value="search"></td>
<br><br>
</form> 
<? if($_SESSION['curruser']==$_SESSION['userid']) {?>
	<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
<h1>Home</h1>
<h3>

You are logged in, <?= htmlspecialchars($_SESSION['curruser']) ?>!
<br>
<a href="logout.php">log out</a>
<?}?>
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
<? }
 else {?>
You are not logged in! 
<br>
<a href = "login.php">Login</a>
<?}?>
<!-- iterate over posts -->
<tr>
<td> 
<? 

$DBH = connection();

$ps1 = new Post_persist();
$reslt = $ps1->getPostByUserId($_SESSION['curruser']); 

$us1 = new UserPersist();
$urw = $us1->getUserById($_SESSION['curruser']);
$user = $urw['user'];

foreach($reslt as $row1) {
?>
<div class="w3-container w3-padding-32 w3-teal">
<b><? print $user?> says:</b> <br/>
<?print $row1['time'];?>
</div>
<section class="w3-container w3-border"> 
<p>
<?
printf("%s</p></section> ", $row1['texts']);
$pls = new LikesPersist();
$likes = $pls->getTotalLikesId($row1['post_id'],"p");
?>

<div class="likes">
<section class="w3-container w3-border"> 
	<p>Post:<? print($row1['post_id'])?></p>
	<? $id1 = $row1['post_id']."p"."b";
		$idb1 = $row1['post_id']."p";
		 ?>
	<input type="button"  id = "<?print $id1?>" value="Like" onclick= " 
		 updateLike( '<?print $row1['post_id']?>','p'); "/>
<br/>
</section>
<section class="w3-container w3-border"> 
<div id="<?echo $idb1?>"><? echo $likes?> people like it!</div> <br/>
</section>
</div>
<section class="w3-container w3-border">
	<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
<input name="cmnt" type="text">
<input type="submit" value="comment"></input>
<input type="hidden" name="postid" value="<? print($row1['post_id'])?>">
</form>
</section>

<?
	 		//$sql2 = sprintf();

			$cs3 = new CommentPersist();
			$result2 = $cs3->getPostByUserId($row1['post_id']);

			foreach($result2 as $row2 )
				{ 
				?>
	 		<section class="w3-container w3-border">
			<b><? print $row2['user']?>: </b>
		
			<?
	 		printf("%s <br/></section>", $row2['texts']); ?>
	 		<div class="likes">
			<section class="w3-container w3-border"> 
	
	<? $id1 = $row1['post_id']."c"."b";
		$idb1 = $row1['post_id']."c";
		 ?>
	<input type="button"  id = "<?print $id1?>" value="Like" onclick= " 
		 updateLike( '<?print $row1['post_id']?>','c'); "/>
<label id="<?echo $idb1?>"><? echo $likes?> people like it!</label> <br/>
</section>
			</div>
	 		<?}
	 		printf(" <br/><br/>");
	 
}
  ?>

</td>
</tr>
	</table>
</form>
</body>
</html>