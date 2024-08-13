<?php  

# Get All Year function
function get_all_year($con){
   $sql  = "SELECT * FROM years";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $years = $stmt->fetchAll();
   }else {
      $years = 0;
   }

   return $years;
}

# Get year by ID
function get_year($con, $id){
   $sql  = "SELECT * FROM years WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $year = $stmt->fetch();
   }else {
      $year = 0;
   }

   return $year;
}