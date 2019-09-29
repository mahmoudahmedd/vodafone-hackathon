<?php

function pageMain() 
{
	global $TMPL, $CONF, $db, $settings;
	
	$admin      = new Admin();
	$admin->db  = $db;
	$admin->url = $CONF['url'];

	if(isset($_POST['login'])) 
	{
		$admin->username = $_POST['username'];
		$admin->password = $_POST['password'];
		
		// Attempt to auth the user
        $auth = $admin->auth();


        // If the user has been logged-in
        if($auth) 
        {
            header("Location: ".$CONF['url']."/index.php?a=admin");
        }
        elseif(isset($_POST['login'])) // If the user could not be logged-in
        {
            $TMPL['message'] = "Email address and/or password invalid";
            $admin->logOut(false);
        }
	} 
	else 
	{
		if(isset($_SESSION['adminUsername'])) 
		{
			$admin->username = $_SESSION['adminUsername'];
			$admin->password = $_SESSION['adminPassword'];
			
			// Attempt to auth the user
			$user = $admin->auth();


			if(isset($_GET['logout']) == 1) 
			{
				$admin->logOut();
				header("Location: " . $CONF['url']);
			}
		}
	}

	if(isset($_SESSION['adminUsername']) && isset($_POST['upload'])) 
	{		
		$uploadOk = 1;

		$targetDir     = "uploads/ads/";
		$targetFile    = $targetDir . md5(rand()) . '-' . basename($_FILES["file"]["name"]);
		$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

		// Check if file already exists
		if (file_exists($targetFile)) 
		{
		    $TMPL['message'] = "Sorry, file already exists.";
		    $uploadOk = 0;
		}

		// Check file size
		if ($_FILES["file"]["size"] > 500000) 
		{
		    $TMPL['message'] = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "mp4" )
		{
		    $TMPL['message'] = "Sorry, only JPG, JPEG, PNG & MP4 files are allowed.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
		    $TMPL['message'] = "Sorry, your file was not uploaded.";
		} 
		else // if everything is ok, try to upload file
		{
		    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile) && 
		    	isset($_POST['url']) && 
		    	filter_var($_POST['url'], FILTER_VALIDATE_URL)
		       ) 
		    {
		        $TMPL['message'] = "The file '" . $targetFile . "' has been uploaded.";

		        $stmt = $db->prepare(sprintf("INSERT INTO `ads` (`pic_path`,`type`,`ad_url`) VALUES ('%s','%s','%s')",$db->real_escape_string($targetFile), $db->real_escape_string($_FILES["file"]["type"]), $db->real_escape_string($_POST['url'])));

				$stmt->execute();
				$stmt->close();

				
				header("Refresh:1; ". $CONF['url']);

			} 
		    else 
		    {
		        $TMPL['message'] = "Sorry, there was an error uploading your file.";
		    }
		}
	}

	if(isset($_SESSION['adminUsername']) && isset($_SESSION['is_admin'])) 
	{		
		// Set the content to true, change the $skin to content
		$content = true;

		$TMPL['username'] = $_SESSION['adminUsername'];
		$TMPL['token_id'] = $_SESSION['token_id'];
	}

	$TMPL['url']        = $CONF['url'];
	$TMPL['title']      = "Sign in " . ' - ' . $settings['title'];
	$TMPL['site_name']  = $settings['title'];

	if($content) 
	{
		$skin = new skin('admin/content');
	} 
	else 
	{
		$skin = new skin('admin/login');
	}

	return $skin->make();

}

?>