<?php



class SessionRewrite
{

	public static $sess_save_path = '';
	public static $session_name = '';
	public static $maxlifetime = 0;
	public static $session_file = '';
	public static $instance;

	public static $session_id = '';

	public function __construct($sess_save_path,$session_name='PHPSESSID',$maxlifetime=1440)
	{
		self::$sess_save_path = $sess_save_path;
    	self::$session_name = $session_name;
    	self::$maxlifetime = $maxlifetime;

    	ini_set("session.session_handler","user");
    	ini_set("session.name",self::$session_name);
    	ini_set('session.gc_maxlifetime',self::$maxlifetime);
			session_set_save_handler(array($this,'open'),array($this,'close'),array($this,'read'),array($this,'write'),array($this,'destroy'),array($this,'gc'));
	}
	//SESSION初始化的时候调用
  	public  function open($save_path,$session_name)
	{
        return (true);
    }

      //关闭的时候调用
 	public  function close()
    {
        return (true);
    }

    public function read($id)
    {
    		self::$session_id = $id;
        $sess_save_path = self::$sess_save_path;
        $sess_file="$sess_save_path/sess_$id";
				self::$session_file = $sess_file;
        return (string) @file_get_contents($sess_file);
    }
      //脚本执行结束之前，执行写入操作
    public  function write($id,$sess_data)
    {
        $sess_save_path = self::$sess_save_path;
        $sess_file="$sess_save_path/sess_$id";
        if ($fp= @fopen($sess_file,"w")) {
          $return=fwrite($fp,$sess_data);
          fclose($fp);
          return $return;
        } else {
          return (false);
        }
    }

    public  function destroy($id)
    {
        $sess_save_path = self::$sess_save_path;

        $sess_file="$sess_save_path/sess_$id";
        return (@unlink($sess_file));
    }

    public  function gc($maxlifetime)
    {
        $sess_save_path = self::$sess_save_path;

        foreach (glob("$sess_save_path/sess_*") as$filename) {
          if (filemtime($filename) +$maxlifetime<time()) {
            @unlink($filename);
          }
        }
        return (true);
    }

    public static function getInstance($sess_save_path='',$session_name='PHPSESSID',$maxlifetime=1440)
    {
    	if (!self::$instance) {
            self::$instance = new SessionRewrite($sess_save_path,$session_name,$maxlifetime);
  		  }
   		return self::$instance;
    }

		public static function sessionCheck()
		{
			if ( version_compare(phpversion(), '5.4.0', '>=') )
	    {
	        return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
	    } else {
	        return session_id() === '' ? FALSE : TRUE;
	    }
		}



}
