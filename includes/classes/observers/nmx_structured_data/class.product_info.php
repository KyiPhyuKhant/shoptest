<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

class nmx_structured_data_pinfo extends base {

  function __construct() 
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array('NOTIFY_MAIN_TEMPLATE_VARS_EXTRA_DOWNLOAD_PRODUCT_INFO',
                                       'NOTIFY_MAIN_TEMPLATE_VARS_EXTRA_PRODUCT_INFO',
                                        'NOTIFY_MAIN_TEMPLATE_VARS_PRODUCT_TYPE_VARS_PRODUCT_MUSIC_INFO',
                                        'NOTIFY_MAIN_TEMPLATE_VARS_START_PRODUCT_FREE_SHIPPING_INFO',
                                        'NOTIFY_MAIN_TEMPLATE_VARS_START_SERVICE_PRODUCT_INFO',
                                        'NOTIFY_MAIN_TEMPLATE_VARS_START_DOCUMENT_GENERAL_INFO',
                                        'NOTIFY_MAIN_TEMPLATE_VARS_START_DOCUMENT_PRODUCT_INFO'));
  }

  function update(&$class, $eventID, $paramsArray = array())
  {
  global $products_description, $products_name, $_GET, $products_weight, $products_model, $products_manufacturer,
          $products_length, $products_width, $products_height, $products_condition, $products_upc, $products_isbn,
          $products_sku, $products_date_available, $products_description2;
  
  //echo 'NOTIFY_MAIN_TEMPLATE_VARS_EXTRA_DOWNLOAD_PRODUCT_INFO';
  echo '<div itemscope itemtype="http://schema.org/Product">';
  echo '<meta itemprop="name" content="'.$products_name.'"/>';
  //echo '<meta itemprop="seller" content="'.STORE_NAME.'"/>';
  if(isset($products_weight)) echo '<meta itemprop="weight" content="'.$products_weight.'"/>';
  if(isset($products_model)) echo '<meta itemprop="model" content="'.$products_model.'"/>';
  if(isset($products_manufacturer)) echo '<meta itemprop="manufacturer" content="'.$products_manufacturer.'"/>';
  if(isset($products_length)) echo '<meta itemprop="length" content="'.$products_length.'"/>';
  if(isset($products_width)) echo '<meta itemprop="depth" content="'.$products_width.'"/>';
  if(isset($products_height)) echo '<meta itemprop="height" content="'.$products_height.'"/>';
  if(isset($products_condition)) echo '<meta itemprop="itemCondition" content="'.$products_condition.'"/>';
  if(isset($products_upc)) echo '<meta itemprop="upc" content="upc:'.$products_upc.'"/>';
  if(isset($products_isbn)) echo '<meta itemprop="isbn" content="isbn:'.$products_isbn.'"/>';
  if(isset($products_sku)) echo '<meta itemprop="sku" content="'.$products_sku.'"/>';
  if(isset($products_date_available)) echo '<meta itemprop="releaseDate" content="'.$products_date_available.'"/>';
  
  
  if(isset($products_description2)) $products_description2 = '<span itemprop="description">'.$products_description2.'</span>';
  $products_description = '<span itemprop="description">'.$products_description.'</span>';
  
  
  echo '<span itemprop="offers" itemscope itemtype="http://schema.org/Offer"><meta itemprop="price" content="'.round(zen_get_products_actual_price((int)$_GET['products_id']),2).'">';
  //currency
  if (zen_products_lookup((int)$_GET['products_id'], 'products_status') == 1 && !zen_get_products_virtual((int)$_GET['products_id'])) echo '<link itemprop="availability" href="http://schema.org/InStock" />';
  echo '</span>';
  
  
    }
}



class nmx_structured_data_pend extends base {

  function __construct() 
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array('NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_INFO',
        'NOTIFY_MAIN_TEMPLATE_VARS_END_DOWNLOAD_PRODUCT_INFO',
        'NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_MUSIC_INFO',
        'NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_FREE_SHIPPING_INFO',
        'NOTIFY_MAIN_TEMPLATE_VARS_END_DOCUMENT_GENERAL_INFO',
        'NOTIFY_MAIN_TEMPLATE_VARS_END_DOCUMENT_PRODUCT_INFO'
        ));
  }
function update(&$class, $eventID, $paramsArray = array())
  {
  echo '</div>';
   
  
    }
}