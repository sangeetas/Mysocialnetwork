<?
class Myconstants
{
	public static $curruser = '0';

	 public static function getValue() {
        return self::$curruser;
    } 

    public static function setValue($val)
    {
    	self::$curruser = '1';
    }
}
?>