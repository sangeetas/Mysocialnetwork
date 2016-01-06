<?
class Posts {
	public $post_id;
	public $user_id;
	public $time;
	public $texts;
	public $likes;

	public function __construct($pid,$uid,$tm,$txt,$lks)
	{
	$this->post_id  = $pid;
	$this->user_id = $uid;
	$this->texts = $txt;
	$this->time = $tm;
	$this->likes = $lks;
	}

	

}


?>