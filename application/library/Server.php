<?php

/**
 * Server工厂
 * @author kasiss
 */
class Server{
	const mysqli="mysqli";
	const memcache="memcache";
	const redis="redis";
	const msg="msg";
	const mail="mail";

	private static $server_pool = array();
  private static $server_maker = array();
  private static $server_config = array();
	/**
	 * 取得服务实例
	*/
	public static function get($server_name="",$type=self::mysqli){
     if(isset(Server::$server_pool[$type][$server_name]))
     {
       return Server::$server_pool[$type][$server_name];
     }

     if(!isset(Server::$server_config[$type][$server_name]) && isset(Server::$server_maker[$type]))
     {
       return Server::server_maker($server_name,$type);
     }

     return null;
	}

	//存储服务实例
  public static function set($server_name,$server,$server_config=array(),$type=self::mysqli)
  {
    Server::$server_pool[$type][$server_name] = $server;
    Server::$server_config[$type][$server_name] = $server_config;
  }
//保存实例生成方法
  public static function set_maker($origin_obj_name,$type=self::mysqli)
  {
    Server::$server_maker[$type] = $origin_obj_name;
  }
// 生成并保存实例
  private static function server_maker($server_name,$type)
  {
    $server = new Server::$server_maker[$type](Server::$server_config[$type][$server_name]);
    Server::$server_pool[$type][$server_name] =$server;
    return $server;
  }
//清空数据库实例
	public static function reset($type=''){
		if($type)
		{
			self::$server_pool[$type] = array();
			self::$server_maker[$type] = array();
			self::$server_config[$type] = array();
			return;
		}
		self::$server_pool = array();
		self::$server_maker = array();
		self::$server_config = array();
	}


}
