<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    /** 
	  check if the activity 
	  id set
	**/
	if (isset($_GET['id'])) {
		/** 
		Get data from GET request 
		and store it in var
		**/
		$id = $_GET['id'];

		#simple form Validation
		if (empty($id)) {
			$em = "Error Occurred!";
			header("Location: ../admin.php?error=$em");
            exit;
		}else {
             # GET activity from Database
			 $sql2  = "SELECT * FROM activities
			          WHERE id=?";
			 $stmt2 = $conn->prepare($sql2);
			 $stmt2->execute([$id]);
			 $the_activity = $stmt2->fetch();

			 if($stmt2->rowCount() > 0){
                # DELETE the activity from Database
				$sql  = "DELETE FROM activities
				         WHERE id=?";
				$stmt = $conn->prepare($sql);
				$res  = $stmt->execute([$id]);

				/**
			      If there is no error while 
			      Deleting the data
			    **/
			     if ($res) {
			     	# delete the current activity_photo
                    $photo = $the_activity['photo'];
                    $c_t_p = "../uploads/photo/$photo";
                    
                    unlink($c_t_p);


			     	# success message
			     	$sm = "Successfully removed!";
					header("Location: ../admin.php?success=$sm");
		            exit;
			     }else{
			     	# Error message
			     	$em = "Unknown Error Occurred!";
					header("Location: ../admin.php?error=$em");
		            exit;
			     }
			 }else {
			 	$em = "Error Occurred!";
			    header("Location: ../admin.php?error=$em");
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