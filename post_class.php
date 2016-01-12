<?
session_start();
include 'Posts.php';
include 'Comments.php';
include 'CommentPersist.php';
include 'UserPersist.php';
include 'LikesPersist.php';
//include 'Connection.php';
include 'Post_persist.php';

$host = $_SERVER["HTTP_HOST"];
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");	

date_default_timezone_set('Asia/Kolkata');

//redirecting to the searched person's page
if(isset($_POST['searchKey']))
{ try {

	$us = new UserPersist();
	$rslt2 = $us->getUserByName($_POST['searchKey']);

		foreach($rslt2 as $row3) 
			{
  			$suid = $row3['id'];
			}
	
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
{   $user_id =  $_SESSION["curruser"];
	$user = print $_SESSION["user"]; 

	try {
		//inserting data of the posts into the table 
		$tme = date( "Y-m-d h:i:s");
		$post = new Posts(NULL, $_SESSION["curruser"], $tme , $_POST['status'], 0 );
		$ps = new Post_persist();
		$ps->save($post); 
		}

	catch(PDOException $e)
		{
	echo $e->getMessage();
		}
}

//inserting the comments for a post into DB
if(isset($_POST['cmnt']))
{ 	try {
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

<!-- if the user is logged in with right credentials, display their wall -->
<? if(isset($_SESSION['authenticated'])) 
	{?>
	<script type="text/javascript" language="javascript" src="actions.js"></script>
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
		<br><br>
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
	<section>
		<td><input type="submit" value="Go to your Wall" onclick="redirect(); return false;"></td>
	</section>

	<? if($_SESSION['curruser']==$_SESSION['userid']) {?>
		<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
			<h1>Home</h1>
			<h3>
			You are logged in!
			<br>
			<a href="logout.php">log out</a>
			</h3>
			<br>
			<b>Your Wall</b>
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
				<td><input type="submit" value="Post"></td>
				<br><br>
	<? }
 }
 else {?>  <!-- if the user isnt logeed in, redirect to login page-->
		You are not logged in! 
		<br>
		<a href = "index.html">Login</a>
	<?}?>
<tr>
<td> 

<? 
// getch the all the posts,comments,likes from the DB for that user id
$ps1 = new Post_persist();
$reslt = $ps1->getPostByUserId($_SESSION['curruser']); 

$us1 = new UserPersist();
$urw = $us1->getUserById($_SESSION['curruser']);
$user = $urw['user'];

foreach($reslt as $row1) 
{
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
			<p>Post:<? print($row1['post_id'])?></p>
			<? $id1 = $row1['post_id']."p"."b";
			$idb1 = $row1['post_id']."p";
			$lp = new LikesPersist();
			$count = $lp->isLikedByUser($row1['post_id'],"p",$_SESSION['userid']);
			if($count != 0)
				$value = "Unlike";
			else
				$value = "Like";
		 	?>
			<input type="button"  id = "<?print $id1?>" value=<?echo $value?> onclick= " 
		 	updateLike( '<?print $row1['post_id']?>','p'); "/>
		 	<label id="<?echo $idb1?>"><? echo $likes?> people like it!</label> <br/>
			<br/>
	</div>
	<section class="w3-container w3-border">
		<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
			<input name="cmnt" type="text">
			<input type="submit" value="comment"></input>
			<input type="hidden" name="postid" value="<? print($row1['post_id'])?>">
		</form>
	</section>

<?
	$cs3 = new CommentPersist();
	$result2 = $cs3->getCommentByPostId($row1['post_id']);

	foreach($result2 as $row2 )
	{ 
		?>
	 	<section class="w3-container w3-border">
		<b><? print $row2['user']?>: </b>
			<?
	 		printf("%s <br/></section>", $row2['texts']); ?>
	 			<div class="likes">
						<? $id1 = $row2['comm_id']."c"."b";
						$idb1 = $row2['comm_id']."c";
						$lp = new LikesPersist();
						$count = $lp->isLikedByUser($row2['comm_id'],"c",$_SESSION['userid']);
						$likesc = $pls->getTotalLikesId($row2['comm_id'],"c");
						if($count != 0)
							$val = "Unlike";
						else
							$val = "Like";
		 				?>
						<input type="button"  id = "<?print $id1?>" value= <?echo $val?> onclick= " 
		 				updateLike( '<?print $row2['comm_id']?>','c'); "/>
						<label id="<?echo $idb1?>"><? echo $likesc?> people like it!</label><br/>
				</div>
		</section>
				
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
