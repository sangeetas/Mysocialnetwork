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
		if($post->texts != "")
		{
		$STH = $this->con->prepare("INSERT INTO posts(post_id,user_id, time, texts) value (:post_id,:user_id,:time, :texts)");

		$vars = array(':post_id' => $post->post_id,':user_id' =>  $post->user_id,':time' => $post->time, 'texts'=> $post->texts); 
		
		$STH->execute($vars);
	}
	

	}

	public function getPostByUserId($id)
	{ 
		$STH = $this->con->prepare("SELECT post_id,texts,time,user_id FROM posts WHERE user_id = :user_id ORDER BY time DESC");
		
		$vars = array(':user_id' => $id  );
		
		$STH->execute($vars);

		 $row = $STH->fetchAll();
    		return $row;



	}

}


?>
