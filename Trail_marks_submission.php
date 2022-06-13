<?php
include('connect.php');

//Output any connection error
if ($conn->connect_error) {
    die('Error : (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

$capture_field_vals = "";
if (isset($_POST["data"]) && is_array($_POST["data"])) {
    $capture_field_vals = implode(",", $_POST["data"]);
    echo $capture_field_vals;
}

//MySqli Insert Query
$insert_row = $conn->query("INSERT INTO `grades`(`Grades_id`, `Marks_id`, `Rubrics_id`, `Marks`, `Enrollment_id`) VALUES ('','1','1','$capture_field_vals','$enroll')");

if ($insert_row) {
    print 'Success! ID of last inserted record is : ' . $conn->insert_id . '<br />';
}
?>



<?php

include('connect.php');
echo "$enroll";
foreach ($_REQUEST['data'] as $data) {
    echo "$enroll";
    $insert_row = $conn->query("INSERT INTO `grades`(`Grades_id`, `Marks_id`, `Rubrics_id`, `Marks`, `Enrollment_id`) VALUES ('','','','$data','$enroll')");
    if ($insert_row) {
        print 'Success! ID of last inserted record is : ' . $conn->insert_id . '<br />';
    }
}


//MySqli Update Query
$update_row = $mysqli->query("update table set captured_field = $capture_field_vals where captured_field_id=$capture_field_id_vals");

if ($update_row) {
    print 'Success! ID of last updated record is : ' . $mysqli->updated_id . '';
}





//Open a new connection to the MySQL server
$mysqli = new mysqli('host', 'username', 'password', 'database_name');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$capture_field_vals = "";
if (isset($_POST["mytext"]) && is_array($_POST["mytext"])) {
    $capture_field_vals = implode(",", $_POST["mytext"]);
}

//MySqli Insert Query
$insert_row = $mysqli->query("INSERT INTO table ( captured_fields ) VALUES( $capture_field_vals )");

if ($insert_row) {
    print 'Success! ID of last inserted record is : ' . $mysqli->insert_id . '<br />';
}
?>


<?php
if (isset($_POST["data"]) && is_array($_POST["data"])) {
    $capture_field_vals = "";
    foreach ($_POST["mytext"] as $key => $text_field) {
        $capture_field_vals .= $text_field . ", ";
    }
    echo $capture_field_vals;
    //MySqli Update Query
    $update_row = $mysqli->query("update table set captured_field = $capture_field_vals where captured_field_id=$capture_field_id_vals");

    if ($update_row) {
        print 'Success! ID of last updated record is : ' . $mysqli->updated_id . '';
    }
}
/*
returns
value1, value2, value3
*/
?>



<?php
if (isset($_POST["data"]) && is_array($_POST["data"])) {
                $enroll = $_SESSION["enroll"];
                $capture_field_vals = "";
                $capture_field_id_vals = "";
            
                foreach ($_POST["data"] as $key => $text_field) {
                    $capture_field_id_vals = $_REQUEST['Grades_id'][$key];
                    $grades_id = $_REQUEST['Grades_id'][$key];
                    $capture_field_vals .= $text_field . ", ";
                    $query = $conn->query("UPDATE `grades` SET `Marks`= $text_field WHERE `Enrollment_id`= $enroll"); // execute $query ...
                
                    #$delete_all = $conn->query("DELETE FROM `grades` WHERE `Enrollment_id` = '$enroll';");
                    #$update_row = $conn->query("UPDATE `grades` SET `Marks`='$capture_field_vals'  WHERE `Enrollment_id` = '$enroll'; ");

                    if ($query) {
                        print 'Success! ID of last updated record is : ' . $conn->updated_id . '';
                    }
                }
                echo $capture_field_vals;
                //MySqli Update Query

            }
?>