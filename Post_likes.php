<?
class Post_likes{
	public $id;
	public $eid;
	public $eType;
	public $uid;

	public function __construct($id,$eid,$eType,$uid)
	{
	$this->id  = $id;
	$this->eid  = $eid;
	$this->eType = $eType;
	$this->uid = $uid;
	}
} 
?>