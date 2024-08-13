<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";


    /** 
	  check if Year is submitted
	**/

	if (isset($_POST['year_name'])) {
		/** 
		Get data from POST request 
		and store it in var
		**/
		$name = $_POST['year_name'];

		#simple form Validation
		if (empty($name)) {
			$em = "Fill in the blank";
			header("Location: ../add-year.php?error=$em");
            exit;
		}else {
			# Insert Into Database
			$sql  = "INSERT INTO years (name)
			         VALUES (?)";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name]);

			/**
		      If there is no error while 
		      inserting the data
		    **/

		    if ($res) {
		     	# success message
		     	$sm = "Successfully created!";
				header("Location: ../add-year.php?success=$sm");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../add-year.php?error=$em");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}