<?
//include 'Connection.php';
class CommentPersist
{ private $con=null;

	public function __construct()
	{
		$this->con = new Connect();
		$this->con = $this->con->dbhfn();
	}

	public function save(Comments $cmt)
	{  
		if($cmt->texts!= "")
		{
		$STH = $this->con->prepare("INSERT INTO comments(comm_id, user_id, post_id, timestmps, texts) value (:comm_id, :user_id, :post_id, :time, :texts)");
		$varq = array(':comm_id' => $cmt->comm_id, ':user_id' => $cmt->user_id,':post_id' => $cmt->post_id,
				 ':time' => $cmt->time , ':texts' => $cmt->texts );

	$STH->execute($varq);
}

	}

	public function getPostByUserId($id)
	{ 
		$STH = $this->con->prepare("SELECT * FROM comments LEFT JOIN users ON comments.user_id=users.id
	 			WHERE comments.post_id = :post_id ORDER BY timestmps ASC");
		
		$vars = array(':post_id' => $id);
		
		$STH->execute($vars);

		 $row = $STH->fetchAll();
    		return $row;



	}

}


?>
