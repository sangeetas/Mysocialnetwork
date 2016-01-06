<?
//include 'Connection.php';
class LikesPersist
{ private $con=null;

	public function __construct()
	{
		$this->con = new Connect();
		$this->con = $this->con->dbhfn();
	}

	public function save(Post_likes $likes)
	{
		$STH = $this->con->prepare("INSERT INTO post_likes(id, eid, eType, uid) value (:id, :eid, :eType, :uid)");
		$varq = array(':id' => $likes->id, ':eid' => $likes->eid,':eType' => $likes->eType,
				 ':uid' => $likes->uid );
//$STH->setFetchMode(PDO::FETCH_OBJ);
//$STH->execute((array)$new_post);
 
	$STH->execute($varq);

	}

	public function delete(Post_likes $likes)
	{
		$STH = $this->con->prepare("DELETE FROM post_likes WHERE eid = :eid AND eType = :eType AND uid = :uid");
		$varq = array(':eid' => $likes->eid,':eType' => $likes->eType,
				 ':uid' => $likes->uid );
 
	$STH->execute($varq);

	}

	public function getTotalLikesId($eid,$type)
	{ 
		
		$STH = $this->con->prepare("SELECT COUNT(*) FROM post_likes WHERE eid = :eid AND eType= :etype");
		
		$vars = array(':eid' => $eid , ':etype' => $type);
		
		$STH->execute($vars);

		 return $STH->fetchColumn(0);
    		



	}

}


?>