<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

global $TMPL, $CONF, $db, $settings;

// include object file
include_once("../../objects/ad.php");

// initialize object
$ad               = new Ad($db);
$rows_num         = $ad->get()->num_rows;
$data["rows_num"] = $rows_num;

// Check the number of rows that match the SELECT statement
if($rows_num > 0)
{
    // the request has succeeded
    $data["status"] = "Ok";

    // ads data
    $data["data"] = "";

    $query = $ad->get();

    while($result = $query->fetch_assoc()) 
    {
        // extract result
        // this will make $row['ad_id'] to
        // just $ad_id only
        extract($result);

        $row = array
        (
            "ad_id"     => $ad_id,
            "pic_path"  => $CONF['url'] . '/' . $pic_path,
            "type"      => $type,
            "ad_url"    => $ad_url,
            "status"    => $status,
            "published" => $published
        );

        $data["data"] = $row;
        
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show ad data in json format
    echo json_encode($data);
}
else
{
    $data["status"]  = "Fail";
    $data["message"] = "No ad found.";

	// set response code - 404 Not found
    http_response_code(404);
    
    // tell the user no ad found
    echo json_encode($data);
}

?>