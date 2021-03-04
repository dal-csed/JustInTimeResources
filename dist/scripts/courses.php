<?php
  $query=$conn->prepare("SELECT CourseName, SuggestedCourse, Length, Note, Link, Picture FROM justintimeresources WHERE CourseNumber=?");
  $query->bind_param("i", "CSCI 1105");
  $query->execute();
  $query->store_result();
  if ($result->num_rows >0){
    while($row=$result->fetch_assoc()){
      $CourseName=$row["CourseName"];
      $SuggestedCourse=$row["SuggestedCourse"];
      $Length=$row["Length"];
      $Note=$row["Note"];
      $Link=$row["Link"];
      $Picture=$row["Picture"];

      echo "<div class='col-lg-3 col-md-6 col-sm-6 mb-2'>";
      echo "<div class='card card-block'>";
      echo "<img src=\'assets/".$Picture."\' alt=\'CSCI1105'>";
      echo "<h5 class='card-title m1-2 mr-2 mt-3 mb-3'>".$CourseName."</h5>";
      echo "<p class='card-text m1-2 mr-2'>".$Note."</p>";
    }
  }
  $query->close();
?>