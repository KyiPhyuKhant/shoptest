<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}



class nmx_structured_data_breadcrumbs extends base
{
  function __construct()
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array(
      'NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_INFO',
      'NOTIFY_MAIN_TEMPLATE_VARS_END_DOWNLOAD_PRODUCT_INFO',
      'NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_MUSIC_INFO',
      'NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_FREE_SHIPPING_INFO',
      'NOTIFY_MAIN_TEMPLATE_VARS_END_DOCUMENT_GENERAL_INFO',
      'NOTIFY_MAIN_TEMPLATE_VARS_END_DOCUMENT_PRODUCT_INFO',
      'NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT'
    ));
  }
  function update(&$class, $eventID, $paramsArray = array())
  {
    global $breadcrumb, $request_type, $db, $_GET;
    echo '<span style="display: none;" id="navBreadCrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="visibility:hidden;">';
    $breadcrumbs_array = explode('<span class="current">', $breadcrumb->trail(''));
    $breadcrumbs = $breadcrumbs_array[0];
    $breadcrumbs = str_replace('">', '"><meta itemprop="title" content="', $breadcrumbs);
    $breadcrumbs = str_replace('<a href="', '<span itemprop="url" content="', $breadcrumbs);
    $breadcrumbs = str_replace('</a>', '"/></span>', $breadcrumbs);
    echo $breadcrumbs;
    echo '</span>';
    echo '<span style="display: none;" itemscope itemtype="http://schema.org/Organization" >
        <meta itemprop="name" content="' . STORE_NAME . '"/>
        <meta itemprop="url" content="' . (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG) . '"/>
        </span>';

    if (isset($_GET['products_id'])) {
      $reviews_count = (int)0;
      $reviews_total = (int)0;
      $reviews_content = '';

      $reviews = $db->Execute("select * from " . TABLE_REVIEWS . " r, "
        . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$_GET['products_id'] . "'
                       and r.reviews_id = rd.reviews_id and r.status=1");
      while (!$reviews->EOF) {
        $reviews_total = $reviews_total + (int)$reviews->fields['reviews_rating'];
        $reviews_content .= '<span itemprop="review" itemscope itemtype="http://schema.org/Review">' .
          '<meta itemprop="author" content="' . $reviews->fields['customers_name'] . '">' .
          '<meta itemprop="datePublished" content="' . $reviews->fields['date_added'] . '">' .
          '<span style="display: none;" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">' .
          '<meta itemprop="worstRating" content = "1">' .
          '<meta itemprop="ratingValue" content="' . $reviews->fields['reviews_rating'] . '">' .
          '<span style="display: none;" itemprop="bestRating" content="5">' .
          '</span>' .
          '<meta itemprop="description" content="' . stripslashes($reviews->fields['reviews_text']) . '">' .
          '</span>' . '</span>';

        $reviews_count++;
        $reviews->MoveNext();
      }

      if ($reviews_count >= 1) {
        $reviews_avg = $reviews_total / $reviews_count;
        echo '<span style="display: none;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        echo '<meta itemprop="ratingValue" content="' . $reviews_avg . '"/>';
        echo '<meta itemprop="bestRating" content="5"/>';
        echo '<meta itemprop="reviewCount" content="' . $reviews_count . '"/>';
        echo '</span>';

        echo $reviews_content;
      }
    }
  }
}