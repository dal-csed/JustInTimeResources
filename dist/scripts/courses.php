<?php
  if(isset($_POST)){
    $dalCourse = $_POST["dalCourse"];
    $suggCourse = $_POST["suggCourse"];
    $comment = $_POST["comment"];

    $query = $conn->prepare("INSERT INTO course_suggestion(Dal_course, suggested_course, note) VALUES (?,?,?)");
    $query->bind_param("sss", $dalCourse, $suggCourse, $commnent);
    $query->execute();

    $query->close();
  }
?>
