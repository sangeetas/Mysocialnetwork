<?
include_once 'Connection.php';
class Post_persist
{ private $con=null;

	public function __construct()
	{
		$this->con = new Connect();
		$this->con = $this->con->dbhfn();
	}

	public function save(\Posts $post)
	{
		$STH = $this->con->prepare("INSERT INTO posts(post_id,user_id, time, texts,likes) value (:post_id,:user_id,:time, :texts,:likes)");

		$vars = array(':post_id' => $post->post_id,':user_id' =>  $post->user_id,':time' => $post->time, 'texts'=> $post->texts ,
					 'likes'=> $post->likes); 
		
		$STH->execute($vars);

	}

	public function getPostByUserId($id)
	{ 
		$STH = $this->con->prepare("SELECT post_id,texts,time,user_id,likes FROM posts WHERE user_id = :user_id ORDER BY time DESC");
		
		$vars = array(':user_id' => $id  );
		
		$STH->execute($vars);

		 $row = $STH->fetchAll();
    		return $row;



	}

}


?>