<?php
error_reporting(0);

$CONF = $TMPL = array();

// The MySQL credentials
$CONF['host'] = 'localhost';
$CONF['user'] = 'root';
$CONF['pass'] = '';
$CONF['name'] = 'application_database';


// The Installation URL
$CONF['url']         = 'https://46eff2d0.ngrok.io';

// The API Version
$CONF['api_version'] = "1.0.0";

// The Installation IP API
$CONF['ip_api']      = 'http://ip-api.com/json';

// The themes directory
$CONF['theme_path']  = 'themes';


$action = array(
				'login'			=> 'login',
				'info'			=> 'info'
			   );

define('COOKIE_PATH', preg_replace('|https?://[^/]+|i', '', $CONF['url']).'/');
?>