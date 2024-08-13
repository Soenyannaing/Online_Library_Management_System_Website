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
        if (isset($_POST['activity_id'])             &&
            isset($_POST['activity_title'])           &&
            isset($_POST['activity_description'])    &&
            isset($_FILES['activity_photo'])       &&
            isset($_POST['current_photo'])) {

            /** 
            Get data from POST request 
            and store them in var
            **/
            $id             = $_POST['activity_id'];
            $title           = $_POST['activity_title'];
            $description    = $_POST['activity_description'];
            
            /** 
             Get current cover from POST request and store it in var
            **/

            $current_photo = $_POST['current_photo'];

            #simple form Validation
            $text = "Title";
            $location = "../edit-activity.php";
            $ms = "id=$id&error";
            is_empty($title, $text, $location, $ms, "");

            $text = "Description";
            $location = "../edit-activity.php";
            $ms = "id=$id&error";
            is_empty($description, $text, $location, $ms, "");

            /**
             if the admin try to 
            update the activity photo
            **/
            if(!empty($_FILES['activity_photo']['name'])){
                # update just the photo
              
                # activity photo Uploading
                $allowed_image_exs = array("jpg", "jpeg", "png", "gif", "tiff", "eps", "ai", "webp", "indd", "raw", "svg", "jfif");
                $path = "photo";
                $activity_photo = upload_file($_FILES['activity_photo'], $allowed_image_exs, $path);
              
                /**
                     If error occurred while 
                    uploading
                **/
                if ($activity_photo['status'] == "error") {
  
                    $em = $activity_photo['data'];
  
                  /**
                    Redirect to '../edit-activity.php' 
                    and passing error message & the id
                  **/
                  header("Location: ../edit-activity.php?error=$em&id=$id");
                  exit;
                }else {
                    # current activity photo path
                    $c_p_activity_photo = "../uploads/photo/$current_photo";
  
                    # Delete from the server
                    unlink($c_p_activity_photo);
  
                    /**
                        Getting the new activity photo name
                    **/
                    $activity_photo_URL = $activity_photo['data'];
  
                    # update just the data
                    $sql = "UPDATE activities
                                SET title=?,
                                    description=?,
                                    photo=?
                                WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res  = $stmt->execute([$title, $description, $activity_photo_URL, $id]);

  
                    /**
                        If there is no error while 
                        updating the data
                    **/
                    if ($res) {
                        # success message
                        $sm = "Successfully updated!";
                        header("Location: ../edit-activity.php?success=$sm&id=$id");
                        exit;
                    }else{
                        # Error message
                        $em = "Unknown Error Occurred!";
                        header("Location: ../edit-activity.php?error=$em&id=$id");
                        exit;
                    }
                }
            
            }else {
                # update just the data
                $sql = "UPDATE activities
                                SET title=?,
                                description=?
                                WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$title, $description, $id]);

                /**
                 If there is no error while 
                updating the data
                **/
                if ($res) {
                    # success message
                    $sm = "Successfully updated!";
                    header("Location: ../edit-activity.php?success=$sm&id=$id");
                    exit;
                }else{
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../edit-activity.php?error=$em&id=$id");
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