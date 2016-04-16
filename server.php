<?php

class HttpServer
{
	public static $instance;

	public $http;
	public static $get;
	public static $post;
	public static $header;
	public static $server;
	public static $cookie;
	public static $files;
	public static $rawContent;

	private $application;
	private $output;

	public function __construct() {
		$this->http = new swoole_http_server("127.0.0.1", 9501);

		$this->http->set(
			array(
				'worker_num' => 16,
				'daemonize' => false,
        'max_request' => 10000,
        'dispatch_mode' => 1
			)
		);

		$this->http->on('WorkerStart' , array( $this , 'onWorkerStart'));
		$this->http->on('WorkerStop', array( $this , 'onWorkerStop'));
		$this->http->on('Close', array( $this , 'onClose'));
		$this->http->on('request', function ($request, $response) {
			//prepare Request
				HttpServer::initRequestQuery($request);

			// TODO handle img
				$this -> runApplication();
			// prepare response
	 			$this -> runResponse($response);
			// to end worker
				die();
		});

		$this->http->start();
	}

	public function onWorkerStart($serv,$worker_id) {
		define('APPLICATION_PATH', dirname(__FILE__));
		$this->application = new Yaf_Application( APPLICATION_PATH ."/conf/application.ini");
	}
	public function onWorkerStop($serv, $worker_id)
  {
     echo "WorkerStop[$worker_id]|pid=".posix_getpid().".\n";
	}

	public function runApplication()
	{
		ob_start();
			try{
				$request_uri = trim(HttpServer::$server['request_uri'],'/');
				$yaf_request = new Yaf_Request_Http($request_uri);

				$_SU = array();
				$_SU['_GET'] = HttpServer::$get;
				$_SU['_POST'] = HttpServer::$post;
				$_SU['_FILES'] = HttpServer::$files;
				$_SU['_HEADER'] = HttpServer::$header;
				$_SU['_SERVER'] = HttpServer::$server;
				$_SU['_COOKIE'] = HttpServer::$cookie;
				$_SU['_RAWCONTENT'] = HttpServer::$rawContent;
				Yaf_Registry::set('_SU',$_SU);
				unset($_SU);

				$this->application->bootstrap()->getDispatcher()->dispatch($yaf_request);

			} catch ( Yaf_Exception $e ) {

			}

			$this->output = ob_get_contents();

			ob_end_clean();
	}

	public function runResponse($response)
	{
			if(class_exists('Swoole'))
			{
				// add Header
				// $response->header("Content-Type","text/html");
				if(Swoole::getHeaders())
				{
					$headers = Swoole::getHeaders();
					foreach ( $headers as $key => $value) {
							$response->header($key,$value);
					}

				}
				// add cookies
				// $response->cookie("User", "Swoole");
				if( Swoole::getCookies())
				{
					$cookies = Swoole::getCookies();
					foreach ( $cookies as $cookie) {
							$response->cookie($cookie['key'],$cookie['value'],$cookie['expire'],$cookie['path'],
							$cookie['domain'],$cookie['secure'],$cookie['httponly']);
					}
				}
				// set status
				if(Swoole::getStatus())
				{
							$response->status(Swoole::getStatus());
				}

				Swoole::reset();
			}
			$response->end($this->output);
			HttpServer::resetRequest();
	}




	public static function initRequestQuery($request)
	{
		//init Server Data
		HttpServer::$server = isset($request->server) ? $request->server : [];
		//init Header Data
		HttpServer::$header = isset($request->header) ? $request->header : [];
		//init Cookie Data
		HttpServer::$cookie = isset($request->cookie) ? $request->cookie : [];
		//init Get Query
		HttpServer::$get = isset($request->get) ? $request->get : [];
		//init Post Data
		HttpServer::$post = isset($request->post) ? $request->post : [];
		//init Files Data
		HttpServer::$files = isset($request->files) ? $request->files : [];
		//init Files Data
		HttpServer::$rawContent = isset($request->rawContent) ? $request->rawContent : [];

	}

	public static function resetRequest()
	{
		HttpServer::$get = null;
		HttpServer::$post = null;
		HttpServer::$header = null;
		HttpServer::$server = null;
		HttpServer::$cookie = null;
		HttpServer::$files = null;
		HttpServer::$rawContent = null;
	}


	//Instance Factory
	public static function getInstance() {
		if (!self::$instance) {
            self::$instance = new HttpServer;
    }
    return self::$instance;
	}


}


HttpServer::getInstance();
