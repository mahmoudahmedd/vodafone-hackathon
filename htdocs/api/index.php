<?php
// include autoload and core files
require_once("../includes/autoload.php");
include_once "core.php";

$data["api_version"] = $CONF['api_version'];

if(isset($_GET['a']) && isset($_GET['b']) && isset($objects[$_GET['a']]) && isset($methods[$_GET['b']])) 
{
	$object = $objects[$_GET['a']];
	$method = $methods[$_GET['b']];

	// include object file
	include_once("objects/{$object}.php");
	include_once("sources/{$object}/{$method}.php");
} 
else 
{
    $data["status"]   = "Fail";
    $data["message"]  = "Unsupported get request. Please read the API documentation.";

	// set response code - 404 Not found
    http_response_code(404);
    
    // tell the user no products found
    echo json_encode($data);
}
?>
