<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}


class nmx_structured_data_metatags extends base {

  function __construct() 
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array('NOTIFY_MODULE_END_META_TAGS'));
  }
function update(&$class, $eventID, $paramsArray = array())
  {
  //global $parameters;
	  if (!defined('FACEBOOK_OPEN_GRAPH_STATUS') || FACEBOOK_OPEN_GRAPH_STATUS != 'true') { 
	  echo '<meta property="og:title" content="'.META_TAG_TITLE.'"/>';
	  echo '<meta property="og:site_name" content="'.STORE_NAME.'"/>';
	  echo '<meta property="author" content="'.STORE_NAME.'"/>';
	}
  //echo '<meta property="og:url" content="'.zen_href_link($current_page, zen_get_all_get_params($excludeParams), 'NONSSL', false).'"/>';
  }
}