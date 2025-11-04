<?php
/**
* @package Pages
* @copyright Copyright 2008-2009 RubikIntegration.com
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: link.php 149 2009-03-04 05:23:35Z yellow1912 $
*/
if (!(in_array($_GET['main_page'], array(FILENAME_AJAX_LOGIN, FILENAME_CHECKOUT_SHIPPING_ADDRESS, FILENAME_CHECKOUT_PAYMENT_ADDRESS, FILENAME_PASSWORD_FORGOTTEN)))) {
$pages = explode(',', HIGHSLIDE_PAGES);                                             
$loaders[] = array('conditions' => array('pages' => $pages),
										'jscript_files' => array(
										  'auto_loaders/highslide.js' => 1,
                      'auto_loaders/highslide_mobile.js' => 2,
										  'auto_loaders/highslide.php' => 3
										),
                    'css_files' => array(
                      'auto_loaders/highslide.css' => 1
                    )
                  );
}