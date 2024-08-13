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
        if (isset($_POST['teacher_id'])             &&
            isset($_POST['teacher_name'])           &&
            isset($_POST['teacher_description'])    &&
            isset($_POST['teacher_age'])            &&
            isset($_POST['teacher_role'])           &&
            isset($_FILES['teacher_profile'])       &&
            isset($_POST['current_profile'])) {

            /** 
            Get data from POST request 
            and store them in var
            **/
            $id             = $_POST['teacher_id'];
            $name           = $_POST['teacher_name'];
            $description    = $_POST['teacher_description'];
            $age            = $_POST['teacher_age'];
            $role           = $_POST['teacher_role'];
            
            /** 
             Get current cover from POST request and store it in var
            **/

            $current_profile = $_POST['current_profile'];

            #simple form Validation
            $text = "Teacher name";
            $location = "../edit-teacher.php";
            $ms = "id=$id&error";
            is_empty($name, $text, $location, $ms, "");

            $text = "Teacher description";
            $location = "../edit-teacher.php";
            $ms = "id=$id&error";
            is_empty($description, $text, $location, $ms, "");

            $text = "Teacher age";
            $location = "../edit-teacher.php";
            $ms = "id=$id&error";
            is_empty($age, $text, $location, $ms, "");

            $text = "Teacher role";
            $location = "../edit-teacher.php";
            $ms = "id=$id&error";
            is_empty($role, $text, $location, $ms, "");

            /**
             if the admin try to 
            update the teacher profile
            **/
            if(!empty($_FILES['teacher_profile']['name'])){
                # update just the profile
              
                # teacher profile Uploading
                $allowed_image_exs = array("jpg", "jpeg", "png", "gif", "tiff", "eps", "ai", "webp", "indd", "raw", "svg", "jfif");
                $path = "profile";
                $teacher_profile = upload_file($_FILES['teacher_profile'], $allowed_image_exs, $path);
              
                /**
                     If error occurred while 
                    uploading
                **/
                if ($teacher_profile['status'] == "error") {
  
                    $em = $teacher_profile['data'];
  
                  /**
                    Redirect to '../edit-teacher.php' 
                    and passing error message & the id
                  **/
                  header("Location: ../edit-teacher.php?error=$em&id=$id");
                  exit;
                }else {
                    # current teacher profile path
                    $c_p_teacher_profile = "../uploads/profile/$current_profile";
  
                    # Delete from the server
                    unlink($c_p_teacher_profile);
  
                    /**
                        Getting the new teacher profile name
                    **/
                    $teacher_profile_URL = $teacher_profile['data'];
  
                    # update just the data
                    $sql = "UPDATE teachers
                                SET name=?,
                                    age=?,
                                    description=?,
                                    role=?,
                                    profile=?
                                WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res  = $stmt->execute([$name, $age, $description, $role,$teacher_profile_URL, $id]);

  
                    /**
                        If there is no error while 
                        updating the data
                    **/
                    if ($res) {
                        # success message
                        $sm = "Successfully updated!";
                        header("Location: ../edit-teacher.php?success=$sm&id=$id");
                        exit;
                    }else{
                        # Error message
                        $em = "First Error Occurred!";
                        header("Location: ../edit-teacher.php?error=$em&id=$id");
                        exit;
                    }
                }
            
            }else {
                # update just the data
                $sql = "UPDATE teachers
                                SET name=?,
                                age=?,
                                description=?,
                                role=?
                                WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$name, $age, $description, $role, $id]);

                /**
                 If there is no error while 
                updating the data
                **/
                if ($res) {
                    # success message
                    $sm = "Successfully updated!";
                    header("Location: ../edit-teacher.php?success=$sm&id=$id");
                    exit;
                }else{
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../edit-teacher.php?error=$em&id=$id");
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