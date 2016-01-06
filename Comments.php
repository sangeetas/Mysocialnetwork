<?
class Comments {
	public $comm_id;
	public $post_id;
	public $user_id;
	public $time;
	public $texts;

	public function __construct($cid,$pid,$uid,$tm,$txt)
	{
	$this->comm_id = $cid;
	$this->post_id  = $pid;
	$this->texts = $txt;
	$this->time = $tm;
	$this->user_id = $uid;
	
	}

	

}


?>