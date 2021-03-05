<?php
include 'scripts/connections.php';
$conn = connect();
$query = $conn->prepare("SELECT CourseName, SuggestedCourse, Length, Note, Link, Picture FROM just_in_time_resources WHERE CourseNumber = ?");
$query->bind_param("s", $pageID);
$pageID = "CSCI 1105";
$query->execute();
$result = $query->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $CourseName = $row["CourseName"];
    $SuggestedCourse = $row["SuggestedCourse"];
    $Length = $row["Length"];
    $Note = $row["Note"];
    $Link = $row["Link"];
    $Picture = $row["Picture"];
    echo "<div class='col-lg-3 col-md-6 col-sm-6 mb-2'>\n";
    echo "\t\t\t\t\t\t\t<div class='card card-block'>\n";
    echo "\t\t\t\t\t\t\t\t<img src='assets/img/" . $Picture . "' alt='CSCI1105'>\n";
    echo "\t\t\t\t\t\t\t\t<h5 class='card-title ml-2 mr-2 mt-3 mb-3'>" . $CourseName . "</h5>\n";
    echo "\t\t\t\t\t\t\t\t<p class='card-text ml-2 mr-2'>" . $Note . "</p>\n";
    echo "\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n";
  }
}

$query->close();
closeConn($conn);
