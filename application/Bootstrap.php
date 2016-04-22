<?php

/*
 *  _init 开头的方法将被自动执行 用来初始化各种组件
 */
class Bootstrap extends Yaf_Bootstrap_Abstract {
	protected $config;
	protected $server_config;

//加载配置文件
	public function _initConfig(Yaf_Dispatcher $dispatcher) {
		$this->config = Yaf_Application::app()->getConfig();
		$this->server_config = new Yaf_Config_Ini(APPLICATION_PATH."/conf/server.ini");

		Yaf_Registry::set('config', $this->config);
		Yaf_Registry::set('server_config', $this->server_config);

		// 判断请求方式，命令行请求应跳过一些HTTP请求使用的初始化操作，如模板引擎初始化
		!defined('REQUEST_METHOD') && define('REQUEST_METHOD', strtoupper($this->config->application->mode));
	}
// debug模式开关
	public function _initError(Yaf_Dispatcher $dispatcher) {
		if ($this->config->application->debug)
		{
			!defined('DEBUG_MODE') && define('DEBUG_MODE', TRUE);
			ini_set('display_errors', 'On');
		}else{
			!defined('DEBUG_MODE') && define('DEBUG_MODE', FALSE);
			ini_set('display_errors', 'Off');
		}
	}
//加载本地非共享 类库
	public function _initLocalLibrary()
	{
		/**
		* //if need
		*	if(!Swoole::getPlugin('locallibrary'))
		*	{
		*		Swoole::setPlugin('locallibrary');
		*		$loader = Yaf_Loader::getInstance();
		*		$loader->setLibraryPath(APP_APPLICATION.'/locallibrary');
		*		$loader->registerLocalNamespace(array('Foo'));
		*	}
		*/
	}
//加载组件
	public function _initPlugin(Yaf_Dispatcher $dispatcher) {

		//性能监控组件
		if (isset($this->config->application->benchmark) && $this->config->application->benchmark == true )
		{
			if(REQUEST_METHOD == 'SWOOLE' && !Swoole::getPlugin('benchmark'))
			{
					Swoole::setPlugin('benchmark');
					$benchmark = new BenchmarkPlugin();
					$dispatcher->registerPlugin($benchmark);
			}

			if(REQUEST_METHOD != 'SWOOLE')
			{
					$benchmark = new BenchmarkPlugin();
					$dispatcher->registerPlugin($benchmark);
			}

		}
		//在swoole模式下 需要加载或重置的方法
		if(REQUEST_METHOD == 'SWOOLE' && !Swoole::getPlugin('swoole'))
		{
			Swoole::setPlugin('swoole');
			$swoole = new SwoolePlugin();
			$dispatcher ->registerPlugin($swoole);
		}


		//命令行下基本不需要使用smarty
		if (REQUEST_METHOD != 'CLI' && !Swoole::getPlugin('smarty'))
		{
			Swoole::setPlugin('smarty');
			$smarty = new SmartyPlugin();
			$dispatcher ->registerPlugin($smarty);
		}

	}
//初始化路由
	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		//在正常http模式下 开启router

		if (REQUEST_METHOD != 'CLI' && REQUEST_METHOD != 'SWOOLE')
		{
			$routes = $this->config->routes;
			if(!empty($routes))
			{
				$router = $dispatcher->getRouter();
				$router->addConfig($routes);
			}
		}
	}
//初始化数据库
	public function _initDatabase() {
		$configs = $this->server_config->mysqli->toArray();
		$configs = reset($configs);

		Server::set_maker('MysqliDb');

		if(!$configs) return;

		foreach($configs as $server_name => $config)
		{
			$server = new MysqliDb($config);
			Server::set($server_name,$server,$config,Server::mysqli);
			unset($server);
		}

	}
//初始化memcache
	public function _initMemcache() {
			// $configs = $this->server_config->memcache->toArray();
	}
//初始化redis
	public function _initRedis() {

	}
//初始化 mail 服务器
	public function _initMailer(Yaf_Dispatcher $dispatcher) {

	}



}
