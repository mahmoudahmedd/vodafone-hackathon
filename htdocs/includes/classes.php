<?php

function getSettings() 
{
	$querySettings = "SELECT * from `settings`";
	return $querySettings;
}

class Admin 
{
	public $db; 		// Database Property
	public $url; 		// Installation URL Property
	public $username;	// Username Property
	public $password;	// Password Property

	/**
     * Select an admin
     *
     * @param	int     $type   Switch the query between verification and retrieving
     * @return	array
     */
    public function get($type = null) 
    {
		$query = sprintf("SELECT * FROM `admins` WHERE `username` = '%s'", $this->db->real_escape_string($this->username));
		
		$result = $this->db->query($query);
				
		$output = $result->fetch_assoc();
		
        return $output;
    }
	
	/**
     * Check whether the user can be authed or not
     *
     * @return	array | bool
     */
    function auth() {
        // If the user has previously been authenticated
        if(isset($_SESSION['adminUsername']) && isset($_SESSION['adminPassword'])) 
        {
            $this->username = $_SESSION['adminUsername'];
            $this->password = $_SESSION['adminPassword'];
            $auth = $this->get(1);

            if($this->password == $auth['password']) 
            {
				$logged = true;
            }
        }
        else // If the user is authenticating
        {
            $auth = $this->get(0);
			
            // Set the sessions
            $_SESSION['adminUsername'] = $this->username;

            if($this->password == $auth['password']) 
            {
                $logged = true;
				session_regenerate_id();
            }
        }

        if(isset($logged)) 
        {
            $_SESSION['is_admin'] = true;
            return $auth;
        }

        return false;
    }
	
	function logOut() 
	{
		unset($_SESSION['adminUsername']);
        unset($_SESSION['adminPassword']);
        unset($_SESSION['is_admin']);
		unset($_SESSION['token_id']);
	}
}
?>