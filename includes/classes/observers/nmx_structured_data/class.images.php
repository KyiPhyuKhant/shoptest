<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}




class nmx_structured_data_image extends base {

  function __construct() 
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array('NOTIFY_HANDLE_IMAGE'));
  }
function update(&$class, $eventID, $paramsArray = array())
  {
  global $parameters; 
  //echo 'NOTIFY_HANDLE_IMAGE';
  $parameters .= ' itemprop="image" ';
  
  
    }
}