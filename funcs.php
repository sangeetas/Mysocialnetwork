<?
session_start();
include 'Post_likes.php';
include 'LikesPersist.php';
include 'Connection.php';

try {
	$pl = new Post_likes(NULL,$_GET['eid'],$_GET['etype'],$_SESSION['userid'] );
	$pls = new LikesPersist();
	if($_GET['btype']== 'l')
	$pls->save($pl);
else
	$pls->delete($pl);

	//$query1 = $DBH->prepare("UPDATE posts SET likes = likes+1 where post_id = :post_id");

	$count = $pls->getTotalLikesId($pl->eid,$pl->eType);

	
		
		print (" {$count} people like it!");

		/*$query3 = $DBH->prepare("UPDATE posts SET likes = :likes where post_id = :post_id");
		$varq3 = array('likes' => $count, 'post_id' => $_GET['pid']);
		$query3->execute($varq3);*/




		/*$query2 = $DBH->prepare("UPDATE posts SET likes = (
       SELECT COUNT(rid) 
         FROM post_likes 
        WHERE posts.post_id = post_likes.post_id) WHERE post_id = :post_id"
       );

		$varq2 = array('post_id' => $_GET['pid']);
		$query2->execute($varq2); */

		/*$query4 = $DBH->prepare("SELECT likes FROM posts where post_id = :post_id");
	$varq4 = array('post_id' => $_GET['pid']);
	
	$query4->execute($varq4);

	while($row1 = $query2->fetch())
	{*/
		//print (" {$row1['likes']} people like it!");
	//}



	
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