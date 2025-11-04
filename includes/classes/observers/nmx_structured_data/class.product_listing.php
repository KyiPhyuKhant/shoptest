<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}


class nmx_structured_data_plist extends base
{

  function __construct()
  {
    global $zco_notifier;
    $zco_notifier->attach($this, array('NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT'));
  }
  function update(&$class, $eventID, $paramsArray = array())
  {
    global $listing_sql, $_GET, $db;
    $sdlisting_split = new splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
    $sdlisting = $db->Execute($sdlisting_split->sql_query);
    while (!$sdlisting->EOF) {
      echo '<span style="display: none;" itemscope itemtype="http://schema.org/Product">';
      echo '<meta itemprop="name" content="' . $sdlisting->fields['products_name'] . '"/>';
      echo '<meta itemprop="URL" content="' . zen_href_link(zen_get_info_page($sdlisting->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($sdlisting->fields['master_categories_id']))) . '&products_id=' . $sdlisting->fields['products_id']) . '"/>';
      echo '<meta itemprop="image" content="' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $sdlisting->fields['products_image'] . '"/>';
      echo '<meta itemprop="description" content="' . zen_clean_html(stripslashes(zen_get_products_description($sdlisting->fields['products_id']))) . '"/>';
      if (isset($sdlisting->fields['products_weight'])) echo '<meta itemprop="weight" content="' . $sdlisting->fields['products_weight'] . '"/>';
      echo '<span style="display: none;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
      echo '<meta itemprop="price" content="' . round(zen_get_products_actual_price((int)$sdlisting->fields['products_id']), 2) . '">';
      if (zen_products_lookup((int)$sdlisting->fields['products_id'], 'products_status') == 1) echo '<link itemprop="availability" href="http://schema.org/InStock" />';
      echo '</span>';
      if (isset($sdlisting->fields['manufacturers_name'])) echo '<meta itemprop="manufacturer" content="' . $sdlisting->fields['manufacturers_name'] . '"/>';
      if (isset($sdlisting->fields['products_model'])) echo '<meta itemprop="model" content="' . $sdlisting->fields['products_model'] . '"/>';
      $reviews_count = (int)0;
      $reviews_total = (int)0;
      $reviews = $db->Execute("select * from " . TABLE_REVIEWS . " r, "
        . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$sdlisting->fields['products_id'] . "'
                       and r.reviews_id = rd.reviews_id and r.status=1");
      while (!$reviews->EOF) {
        $reviews_total = $reviews_total + (int)$reviews->fields['reviews_rating'];
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
      }

      echo '</span>';
      $sdlisting->MoveNext();
    }
  }
}