<?php  

# Get All teachers function
function get_all_teachers($con){
   $sql  = "SELECT * FROM teachers";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $teachers = $stmt->fetchAll();
   }else {
      $teachers = 0;
   }

   return $teachers;
}

# Get All teachers function
function get_all_teacher_pages($con){
   $sql  = "SELECT * FROM teachers LIMIT 0,4";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $teacherpages = $stmt->fetchAll();
   }else {
      $teacherpages = 0;
   }

   return $teacherpages;
}

# Get  teacher by ID function
function get_teacher($con, $id){
   $sql  = "SELECT * FROM teachers WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $teacher = $stmt->fetch();
   }else {
      $teacher = 0;
   }

   return $teacher;
}