<?php
/**
* @name smartyplugin
* @desc 在swoole模式下 模拟相关超全局变量
* @author kasiss
*
*/

class SmartyPlugin extends Yaf_Plugin_Abstract
{

  public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
  {
  }
  public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
  {
    $module_name = $request->getModuleName();

    $config = Yaf_Application::app()->getConfig();
    $smarty_conf = $config->smarty->toArray();

    $template_dir = APPLICATION_PATH.'/application/modules/'.$module_name.'/views/';
    if(is_dir($template_dir))
    {
      $smarty_conf['template_dir'] =$template_dir;
    }
    $smarty_conf['debug']=true;
    $smarty = new Smarty_Adapter(null, $smarty_conf);
    if(!$config->autorender)
    {
      Yaf_Dispatcher::getInstance()->setView($smarty)->autoRender(false);
    }else{
      Yaf_Dispatcher::getInstance()->setView($smarty);
    }
  }


}









 ?>
