<?php // Set connection to database

    function connect(){
        $db_host = 'projects.cs.dal.ca';
        $db_database = 'justintime';
        $db_username = 'justintime';
        $db_password = 'quoo6ooFiSoh1eic';
        $conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);
        if($conn->connect_error){
        echo "This is bad\n";
        die("Connection failed!");
        }
        return $conn;
    }

    function closeConn($conn){
        $conn->close();
    }

    //function to calculate the percent
    function percent($num_amount, $num_total) {
      $count1 = $num_amount / $num_total;
      $count2 = $count1 * 100;
      $count = number_format($count2, 0);
      return $count;
    }


    function mysqli_result($res,$row=0,$col=0){
      $numrows = mysqli_num_rows($res);
      if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
          return $resrow[$col];
        }
      }
      return false;
    }



    function getCourse($conn, $pageID){
        $query=$conn->prepare("SELECT ID, SuggestedCourse, Length, Note, Link, Picture FROM just_in_time_resources WHERE CourseNumber = ?");
        $query->bind_param("s", $pageID);
        $query->execute();
        $result = $query->get_result();

        $user_ip = $_SERVER['REMOTE_ADDR'];

        $link = mysqli_connect('projects.cs.dal.ca', 'justintime', 'quoo6ooFiSoh1eic', 'justintime');
        $dislike_sql = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE ip = "'.$user_ip.'" and id_item = "'.$pageID.'" and rate = 2 ');
        $dislike_count = mysqli_result($dislike_sql);

        $like_sql = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE ip = "'.$user_ip.'" and id_item = "'.$pageID.'" and rate = 1 ');
        $like_count = mysqli_result($like_sql);

        // count all the rate
        $rate_all_count = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE id_item = "'.$pageID.'"');
        $rate_all_count = mysqli_result($rate_all_count);

        $rate_like_count = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE id_item = "'.$pageID.'" and rate = 1');
        $rate_like_count = mysqli_result($rate_like_count);
        $rate_like_percent = percent($rate_like_count, $rate_all_count);

        $rate_dislike_count = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE id_item = "'.$pageID.'" and rate = 2');
        $rate_dislike_count = mysqli_result($rate_dislike_count);
        $rate_dislike_percent = percent($rate_dislike_count, $rate_all_count);


        if ($result->num_rows >0){
            while($row=$result->fetch_assoc()){
            $SuggestedCourse=$row["SuggestedCourse"];
            $Length=$row["Length"];
            $Note=$row["Note"];
            $Link=$row["Link"];
            $Picture=$row["Picture"];

            $pageID = $row["ID"]; // The ID of the page, the article or the video ...


            echo "\n\t\t\t\t\t\t<div class='col-lg-3 col-md-6 col-sm-6 mb-2'>\n";
            echo "\t\t\t\t\t\t\t<a style='color: black; text-decoration: none;' target=\"_blank\" href=\"".$Link."\">\n";
            echo "\t\t\t\t\t\t\t<div class='card card-block'>\n";
            echo "\t\t\t\t\t\t\t\t<img src='assets/img/".$Picture."' alt='".$Picture."'>\n";
            echo "\t\t\t\t\t\t\t\t<h5 class='card-title ml-2 mr-2 mt-3 mb-3'>".$SuggestedCourse."</h5>\n";
            echo "\t\t\t\t\t\t\t\t<p class='card-text ml-2 mr-2 scrollable'>".$Note."</p>\n";
          	echo "\t\t\t\t\t\t\t\t<div class='like-btn".(($like_count == 1)?'like-h':"")."'>Like (".$rate_like_count.")</div>\n";
            echo "\t\t\t\t\t\t\t\t<div class='dislike-btn".(($dislike_count == 1)?'dislike-h':"")."'>Like (".$rate_dislike_count.")</div>\n";
            echo "\t\t\t\t\t\t\t\t<div class='card-footer text-muted'>".$Length."</div>\n";
            echo "\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n";
            }
        }


        $query->close();
    }

    function getCourseName($conn, $pageID){
        $query=$conn->prepare("SELECT CourseName FROM courses WHERE WebPage = ?");
        $query->bind_param("s", $pageID);
        $query->execute();
        $result = $query->get_result();

        while($row=$result->fetch_assoc()){
            $CourseName=$row["CourseName"];
        }
        return $CourseName;

        $query->close();
    }

    function getCourseNum($conn, $pageID){
        $query=$conn->prepare("SELECT Code FROM courses WHERE WebPage = ?");
        $query->bind_param("s", $pageID);
        $query->execute();
        $result = $query->get_result();

        while($row=$result->fetch_assoc()){
            $CourseNum=$row["Code"];
        }
        return $CourseNum;

        $query->close();
    }

    function getCourseSubj($conn, $pageID){
        $query=$conn->prepare("SELECT Subject FROM courses WHERE WebPage = ?");
        $query->bind_param("s", $pageID);
        $query->execute();
        $result = $query->get_result();

        while($row=$result->fetch_assoc()){
            $Subj=$row["Subject"];
        }
        return $Subj;

        $query->close();
    }

    function submitForm($conn, $dalCourse, $suggCourse, $comment){
        $query = $conn->prepare("INSERT INTO course_suggestion(Dal_course, suggested_course, note) VALUES (?,?,?)");
        $query->bind_param("sss", $dalCourse, $suggCourse, $comment);
        $query->execute();

        $query->close();

    }
?>
<script>
$(function(){
	var pageID = <?php echo $pageID;  ?>;

$('.like-btn').click(function(){
	$('.dislike-btn').removeClass('dislike-h');
    	$(this).addClass('like-h');
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:'act=like&pageID='+pageID,
                success: function(){
                }
            });
        });
$('.dislike-btn').click(function(){
    $('.like-btn').removeClass('like-h');
         $(this).addClass('dislike-h');
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:'act=dislike&pageID='+pageID,
                success: function(){
                }
            });
        });
$('.share-btn').click(function(){
            $('.share-cnt').toggle();
        });
    });
</script>
