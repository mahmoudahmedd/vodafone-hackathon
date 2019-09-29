<?php
class Ad
{
    // table name
    private $tableName = "ads";
    private $db;

    // constructor with $db as database connection
    public function __construct($db)
    { 
        $this->db = $db; 
    }

    // read the ad
    function get()
    {
        // select all query
        $query = "SELECT * FROM " . $this->tableName . " ORDER BY `ad_id` DESC LIMIT 1";

        $result = $this->db->query($query);

        return $result;
    }

    public function __destruct()
    {
        $this->db = null;
    }

}


?>
