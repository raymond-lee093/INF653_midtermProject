<?php
// Checks if a valid authorid or category id exists
    function isValid($requested_id, $model){
      // Set the id on the model
      $model->id = $requested_id;
      // Call read_single query on model
      if($model->read_single()){
        return true;
      }
      return false;
    }
?>