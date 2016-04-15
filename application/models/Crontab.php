<?php




class CrontabModel extends Yaf_Controller_Abstract
{

  public function init()
  {
    if(REQUEST_METHOD != 'CLI')
    {
      throw new Exception('Please Run In Cli Mode!');
    }
  }

}
 ?>
