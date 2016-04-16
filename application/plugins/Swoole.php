<?php
/**
* @name swooleplugin
* @desc 在swoole模式下 模拟相关超全局变量
* @author kasiss
*
*/

class SwoolePlugin extends Yaf_Plugin_Abstract
{
  public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
  {
  }

  public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
  {
    if(!Yaf_Registry::get("_SU"))
    {
      Yaf_Registry::set("_PLUGIN_CHECK",false);
      return;
    }else{
      Yaf_Registry::set("_PLUGIN_CHECK",true);
    }

    //初始化 超全局数组
    $_SU = Yaf_Registry::get("_SU");

    $_GET = $_SU["_GET"];
    $_POST = $_SU["_POST"];
    $_FILES = $_SU["_FILES"];
    $_SERVER = $_SU["_SERVER"];
    $_COOKIE = $_SU["_COOKIE"];
    $_HEADER = $_SU["_HEADER"];
    $_RAWCONTENT = $_SU["_RAWCONTENT"];

    Yaf_Registry::set("_SU",null);
    // 初始化session
    Yaf_Loader::import(APPLICATION_PATH."/application/library/Swoole/SessionRewrite.php");
    $config = Yaf_Application::app()->getConfig();
    $session = $config->session->toArray();
    $session_save_path = $session['save_path'];
    $session_name = $session['session_name'];
    $session_gc_maxlifetime = $session['gc_maxlifetime'];


    SessionRewrite::getInstance($session_save_path,$session_name,$session_gc_maxlifetime);
    // !SessionRewrite::sessionCheck() && session_start();
    if(isset($_COOKIE[$session_name]) && file_exists($session_save_path.'/sess_'.$_COOKIE[$session_name]))
    {
      $sess_data = @file_get_contents($session_save_path.'/sess_'.$_COOKIE[$session_name]);
      $_SESSION = json_decode($sess_data,1);
    }


  }

  public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {

    if(!Yaf_Registry::get("_PLUGIN_CHECK")) return;

    if(!Swoole::getHeaders())
    {
      Swoole::setHeader("Content-Type","text/html");
      Swoole::setHeader("charset",'utf-8');
    }
    if(!empty($_SESSION) && class_exists('SessionRewrite') && SessionRewrite::sessionCheck())
    {
      $session_name = SessionRewrite::$session_name;
      $session_id = SessionRewrite::$session_id;

      if(!isset($_COOKIE[$session_name]))
      {
        Swoole::setCookie($session_name,$session_id);
        Swoole::setHeader("Set-Cookie","$session_name=$session_id");
      }

      SessionRewrite::getInstance()->write($session_id,json_encode($_SESSION));
    }

  }


}









 ?>
