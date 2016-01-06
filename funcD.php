<?
session_start();
function connection()
{ 
	$host="localhost";
$dbname = "facebook";
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", "root", "password");
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
return $DBH;
} 

try {
$DBH = connection();
	//$query1 = $DBH->prepare("UPDATE posts SET likes = likes+1 where post_id = :post_id");

	$query1 = $DBH->prepare("INSERT INTO post_likes(rid,post_id, user_id,action) value (:rid, :post_id,:user_id,:action)");
	$varq = array(':rid' => NULL, ':post_id' => $_GET['pid'], ':user_id' => $_SESSION['userid'], ':action' => "D");
	$query1->execute($varq);


	$query2 = $DBH->prepare("SELECT COUNT(*) FROM post_likes WHERE post_id = :post_id AND action = :action");
	$varq2 = array('post_id' => $_GET['pid'], ':action' => "D");
	$query2->execute($varq2);
		$count = $query2->fetchColumn(0);	
		print (" {$count} people dislike it!");

		$query3 = $DBH->prepare("UPDATE posts SET dislikes = :dislikes where post_id = :post_id");
		$varq3 = array('dislikes' => $count, 'post_id' => $_GET['pid']);
		$query3->execute($varq3);

		/*$query2 = $DBH->prepare("UPDATE posts SET likes = (
       SELECT COUNT(rid) 
         FROM post_likes 
        WHERE posts.post_id = post_likes.post_id) WHERE post_id = :post_id"
       );

		$varq2 = array('post_id' => $_GET['pid']);
		$query2->execute($varq2); */

		$query4 = $DBH->prepare("SELECT dislikes FROM posts where post_id = :post_id");
	$varq4 = array('post_id' => $_GET['pid']);
	
	$query4->execute($varq4);

	while($row1 = $query2->fetch())
	{
		print (" {$row1['dislikes']} people like it!");
	}



	
	/*$STH = $DBH->prepare("INSERT INTO posts(post_id,user_id, time, texts,likes) value (:post_id,:user_id,:time, :texts,:likes)");
//$STH->setFetchMode(PDO::FETCH_OBJ);
//$STH->execute((array)$new_post);
 
$tme = date( "Y-m-d H:i");

$vars = array(':post_id' => NULL,':user_id' =>  $_SESSION["curruser"],':time' => $tme, 'texts'=> $_POST['status'] , 'likes'=>0);
$STH->execute($vars);

	*/

	
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
?>