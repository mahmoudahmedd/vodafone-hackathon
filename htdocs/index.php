<?php
$time_start = microtime(true); 
require_once(__DIR__ . '/includes/autoload.php');


if(isset($_GET['a']) && isset($action[$_GET['a']])) 
{
  $page_name = $action[$_GET['a']];
} 
else 
{
  $page_name = 'login';
}

// Extra class for the content [main and sidebar]
$TMPL['content_class'] = ' content-'.$page_name;

require_once(__DIR__ . "/sources/{$page_name}.php");


$TMPL['content'] = pageMain();

if(!empty($user['username'])) 
{
  $TMPL['url_logo'] = $CONF['url'] . '/index.php?a=feed';
} 
else 
{
  $TMPL['url_logo'] = $CONF['url'] . '/index.php?a=welcome';
}


$TMPL['url']        = $CONF['url'];
$TMPL['site_name']  = $settings['title'];
$TMPL['footer']     = $settings['title'];
$TMPL['footer_url'] = $CONF['url'] . '/index.php?a=info&b=';
$TMPL['year']       = date('Y');
$TMPL['powered_by'] = 'Powered by <a href="'.$url.'" target="_blank">'.$name.'</a>.';


$skin = new skin('wrapper');

echo $skin->make();

mysqli_close($db);
?>