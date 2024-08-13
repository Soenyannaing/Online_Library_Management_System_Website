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

		if (isset($_POST['teacher_name'])           &&
			isset($_POST['teacher_age'])            &&
			isset($_POST['teacher_role'])           &&
			isset($_POST['teacher_description'])    &&
			isset($_FILES['teacher_profile'])) {
			/** 
			Get data from POST request 
			and store them in var
			**/
			$name           = $_POST['teacher_name'];
			$age            = $_POST['teacher_age'];
			$role           = $_POST['teacher_role'];
			$description    = $_POST['teacher_description'];

			# making URL data format
			$user_input = 'name='.$name.'&age='.$age.'&role='.$role.'&desc='.$description;

			# simple form Validation

			$text = "Name";
			$location = "../add-teacher.php";
			$ms = "error";
			is_empty($name, $text, $location, $ms, $user_input);

			$text = "Age";
			$location = "../add-teacher.php";
			$ms = "error";
			is_empty($age, $text, $location, $ms, $user_input);

			$text = "Role";
			$location = "../add-teacher.php";
			$ms = "error";
			is_empty($role, $text, $location, $ms, $user_input);

			$text = "Description";
			$location = "../add-teacher.php";
			$ms = "error";
			is_empty($description, $text, $location, $ms, $user_input);

			# teacher profile Uploading
			$allowed_image_exs = array("jpg", "jpeg", "png", "gif", "tiff", "eps", "ai", "webp", "indd", "raw", "svg", "jfif");
			$path = "profile";
			$teacher_profile = upload_file($_FILES['teacher_profile'], $allowed_image_exs, $path);

			/**
			If error occurred while 
			uploading the teacher profile
			**/
			if ($teacher_profile['status'] == "error") {
				$em = $teacher_profile['data'];

				/**
				 Redirect to '../add-teacher.php' 
				and passing error message & user_input
				**/
				header("Location: ../add-teacher.php?error=$em&$user_input");
				exit;
			
			}else {
					/**
					 Getting the new teacher profile name 
					**/
					$techer_profile_URL = $teacher_profile['data'];
					
					# Insert the data into database
					$sql  = "INSERT INTO teachers (name,
												age,
												role,
												description,
												profile)
							VALUES (?,?,?,?,?)";
					$stmt = $conn->prepare($sql);
					$res  = $stmt->execute([$name, $age, $role, $description, $techer_profile_URL]);

				/**
				 If there is no error while 
				inserting the data
				**/
					if ($res) {
						# success message
						$sm = "The teacher Info successfully created!";
						header("Location: ../add-teacher.php?success=$sm");
						exit;
					}else{
						# Error message
						$em = "Unknown Error Occurred!";
						header("Location: ../add-teacher.php?error=$em");
						exit;
					}

			}
		}

		
	}else {
      header("Location: ../admin.php");
      exit;
	}