<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    # Validation helper function
    include "func-validation.php";

    # File Upload helper function
    include "func-file-upload.php";

    /** 
	  If all Input field
	  are filled
	**/

		if (isset($_POST['activity_title'])           &&
			isset($_POST['activity_description'])    &&
			isset($_FILES['activity_photo'])) {
			/** 
			Get data from POST request 
			and store them in var
			**/
			$title           = $_POST['activity_title'];
			$description    = $_POST['activity_description'];

			# making URL data format
			$user_input = 'title='.$title.'&desc='.$description;

			# simple form Validation

			$text = "Title";
			$location = "../add-activity.php";
			$ms = "error";
			is_empty($title, $text, $location, $ms, $user_input);

			$text = "Description";
			$location = "../add-activity.php";
			$ms = "error";
			is_empty($description, $text, $location, $ms, $user_input);

			# activity photo Uploading
			$allowed_image_exs = array("jpg", "jpeg", "png", "gif", "tiff", "eps", "ai", "webp", "indd", "raw", "svg", "jfif");
			$path = "photo";
			$activity_photo = upload_file($_FILES['activity_photo'], $allowed_image_exs, $path);

			/**
			If error occurred while 
			uploading the activity photo
			**/
			if ($activity_photo['status'] == "error") {
				$em = $activity_photo['data'];

				/**
				 Redirect to '../add-activity.php' 
				and passing error message & user_input
				**/
				header("Location: ../add-activity.php?error=$em&$user_input");
				exit;
			
			}else {
					/**
					 Getting the new activity photo  
					**/
					$activity_photo_URL = $activity_photo['data'];
					
					# Insert the data into database
					$sql  = "INSERT INTO activities (title,
												description,
												photo)
							VALUES (?,?,?)";
					$stmt = $conn->prepare($sql);
					$res  = $stmt->execute([$title, $description, $activity_photo_URL]);

				/**
				 If there is no error while 
				inserting the data
				**/
					if ($res) {
						# success message
						$sm = "The new activity was successfully created!";
						header("Location: ../add-activity.php?success=$sm");
						exit;
					}else{
						# Error message
						$em = "Unknown Error Occurred!";
						header("Location: ../add-activity.php?error=$em");
						exit;
					}

			}
		}

		
	}else {
      header("Location: ../admin.php");
      exit;
	}