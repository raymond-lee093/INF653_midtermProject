<?php
// Checks if a valid authorid or category id exists
    function isValid($requested_id, $model){
      // Set the id on the model
      $model->id = $requested_id;
      // Call read_single query on model
      $result = $model->read_single();
      // Get row count
      $num_of_rows = $result->rowCount();
      if($num_of_rows > 0){
        return true;
      }
      return false;
    }
?>