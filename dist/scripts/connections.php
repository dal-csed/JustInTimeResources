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

    function getCourse($conn, $pageID){
        $query=$conn->prepare("SELECT ID, SuggestedCourse, Length, Note, Link, Picture FROM just_in_time_resources WHERE CourseNumber = ?");
        $query->bind_param("s", $pageID);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows >0){
            while($row=$result->fetch_assoc()){
            $CourseID=$row["ID"];
            $SuggestedCourse=$row["SuggestedCourse"];
            $Length=$row["Length"];
            $Note=$row["Note"];
            $Link=$row["Link"];
            $Picture=$row["Picture"];
            
            echo "\n\t\t\t\t\t\t<div class='col-lg-3 col-md-6 col-sm-6 mb-2'>\n";
            echo "\t\t\t\t\t\t\t<a style='color: black; text-decoration: none;' target=\"_blank\" href=\"".$Link."\">\n";
            echo "\t\t\t\t\t\t\t<div class='card card-block'>\n";
            echo "\t\t\t\t\t\t\t\t<img src='assets/img/".$Picture."' alt='".$Picture."'>\n";
            echo "\t\t\t\t\t\t\t\t<h5 class='card-title ml-2 mr-2 mt-3 mb-3'>".$SuggestedCourse."</h5>\n";
            echo "\t\t\t\t\t\t\t\t<p class='card-text ml-2 mr-2 scrollable'>".$Note."</p>\n";
            echo "\t\t\t\t\t\t\t\t<div class='card-footer text-muted'>".$Length."</div>\n";
            echo "\t\t\t\t\t\t\t\t";
            echo "<span class=\"likebtn-wrapper like-dislike\" data-theme=\"bootstrap\" data-identifier=\"item_1\"></span>";
            echo '<script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>';
            //likeDislike();
            //likeDislike(checkLike($conn, $userIP, $CourseID), checkDislike($conn, $userIP, $CourseID));
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

    // function likeDislike($d,$e,$s){
    //     if(d.getElementById("likebtn_wjs"))
    //         return;
    //     a=d.createElement(e);
    //     m=d.getElementsByTagName(e)[0];
    //     a.async=1;a.id="likebtn_wjs";a.src=s;
    //     m.parentNode.insertBefore(a, m))(document,"script","//w.likebtn.com/js/w/widget.js");
    // }

    function checkLike($conn, $userIP, $courseID){
        $query = $conn->prepare("SELECT COUNT(*) FROM rating WHERE ip=? AND id_item=? AND rate=?");
        $rate=1;
        $query->bind_param("ssi", $userIP, $courseID, $rate);
        $query->execute();

        $result = $query->get_result();
        $count=0;

        if ($result > 1){
            $count=$result;
        }
        return $count;

        $query->close();
    }
    
    function checkDislike($conn, $userIP, $courseID){
        $query = $conn->prepare("SELECT COUNT(*) FROM rating WHERE ip=? AND id_item=? AND rate=?");
        $rate=2;
        $query->bind_param("ssi", $userIP, $courseID, $rate);
        $query->execute();

        $result = $query->get_result();
        $count=0;

        if ($result > 1){
            $count=$result;
        }
        return $count;

        $query->close();
    }
?>