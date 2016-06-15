<?php
/**
*
*
*/

class Swoole
{
  private static $headers = array();
  private static $cookies = array();
  private static $status = 200;
  private static $plugins = array();

  public static function setHeader($key,$value)
  {
    self::$headers[$key] = $value;
  }

  public static function setCookie( $key , $value = '', $expire = 0 , $path = '/', $domain  = '',  $secure = false , $httponly = false)
  {
    $cookie = array();
    $cookie['key'] = $key;
    $cookie['value'] = $value;
    $cookie['expire'] = $expire;
    $cookie['path'] = $path;
    $cookie['domain'] = $domain;
    $cookie['secure'] = $secure;
    $cookie['httponly'] = $httponly;
    self::$cookies[] = $cookie;
  }

  public static function setStatus($value)
  {
    self::$status = $value;
  }

  public static function getHeaders($key='')
  {
    if(isset(self::$headers[$key]))
      return self::$headers[$key];

    return self::$headers;
  }

  public static function getCookies($key='')
  {
    if(isset(self::$cookies[$key]))
      return self::$cookies[$key];

    return self::$cookies;
  }

  public static function getStatus()
  {
    return self::$status;
  }

  public static function reset()
  {
    self::$headers = array();
    self::$cookies = array();
    self::$status = 200;
    return true;
  }

   public static function setPlugin($plugin_name)
  {
    self::$plugins[$plugin_name] = 1;
  }
  public static function getPlugin($plugin_name='')
  {
    if($plugin_name)
    {
      return isset(self::$plugins[$plugin_name]) ? true : false;
    }
    return array_keys(self::$plugins);
  }



  public static function setPlugin($plugin_name)
  {
    self::$plugins[$plugin_name] = 1;
  }

  public static function getPlugin($plugin_name='')
  {
    if($plugin_name)
    {
      return isset(self::$plugins[$plugin_name]) ? true : false;
    }
    return array_keys(self::$plugins);
  }



}









 ?>
