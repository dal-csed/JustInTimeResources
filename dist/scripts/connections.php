<?php // Set connection to database

    function connect(){
        $db_host = 'projects.cs.dal.ca';
        $db_database = 'justintime';
        $db_username = 'justintime';
        $db_password = 'quoo6ooFiSoh1eic';
        $conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);
        if($conn->connect_error){
        echo "This is bad\n";
        die("Connection failed!".mysqli_connect_error);
        } 

        return $conn;
    }

    function closeConn($conn){
        $conn->close();
    }
?>