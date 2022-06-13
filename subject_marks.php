<?php
error_reporting(0);
session_start();
if (isset($_SESSION["uid"])) {
    //echo "session in progress";
    //header('location:index_with.php');
    include('./connect.php');
    if (isset($_POST['id'])) {
        $enroll = mysqli_real_escape_string($conn, $_POST['id']);
        if ($enroll) {
            $_SESSION["enroll"] = $enroll;
        }
        $Student = "SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'";
        $student_run = mysqli_query($conn, $Student);
        $Student_data = mysqli_fetch_array($student_run);
        $query = "SELECT * FROM `registration` r, subject s WHERE r.Subject_id=s.Subject_id AND r.Enrollment_id='$enroll';";
        $run = mysqli_query($conn, $query);
    }
    function get_recent()
    {
        global $run;
        if ($run == true) {
            while ($data = mysqli_fetch_assoc($run)) {

                include('Student_marks_scroll.php');
            }
        } else {
            #include('Final_marks_submission.php');
        }
    }
} else {
    header('location:Login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jury Landing</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous">
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap 5.1 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />


</head>


<!-- NAVBAR-->
<nav class="navbar navbar-expand-lg py-3 navbar-light bg-light shadow-sm">
    <div class="container">
        <a href="#" class="navbar-brand">
            <!-- Logo Image -->
            <img src="Avantika_Logo.png" width="75" alt="" class="d-inline-block align-middle mr-2" />
            <!-- Logo Text -->
        </a>

        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">About</a></li>
            </ul>
            <h5 style="margin-left: 15%">Jury Assessment Portal</h5>
            <!-- Facebook -->
            <i style="margin-left: 35%" class="fab fa-facebook-f"></i>

            <!-- Twitter -->
            <i style="margin-left: 1%" class="fab fa-twitter"></i>

            <!-- Google -->
            <i style="margin-left: 1%" class="fab fa-google"></i>

            <!-- Instagram -->
            <i style="margin-left: 1%" class="fab fa-instagram"></i>

            <!-- Linkedin -->
            <i style="margin-left: 1%" class="fab fa-linkedin-in"></i>

            <!-- Pinterest -->
            <i style="margin-left: 1%" class="fab fa-pinterest"></i>
        </div>
        <!-- Small modal -->
        <a href="session_end.php">
            <button class="btn" data-toggle="modal" data-target=".bs-example-modal-sm">
                Logout
            </button>
        </a>
        <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Logout <i class="fa fa-lock"></i></h4>
                    </div>
                    <div class="modal-body">
                        <i class="fa fa-question-circle"></i> Are you sure you want to
                        log-off?
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-primary btn-block">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Small modal -->
    </div>
</nav>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<body oncontextmenu="false" class="snippet-body">
    <h5 style="margin-top: 3%; margin-left: 43px; margin-bottom: 20px; color:#737474"> <?php echo $_SESSION["enroll"];
                                                                                        echo ' - ';
                                                                                        echo $Student_data['Name'] ?></h5>
    <form target="_blank" action="" method="post">
        <div class="container-fluid">
            <div class="row" style="margin-left: 20px; margin-right: 20px; margin-top: 20px">
                <?php get_recent(); ?>

            </div>
        </div>

        <div class="text-center" style="padding-top: 10px;">
            <button id="marks" type="submit" name="submit" class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px"> Submit </button>

        </div>
    </form>
    <?php
    function display()
    {
        include('connect.php');
        // Check whether member already exists in the database with the same email
        $prevQuery = "SELECT `Rubrics_id`, `Marks`, `Enrollment_id` FROM `grades` WHERE `Enrollment_id` = '$enroll';";
        $prevResult = $conn->query($prevQuery);
        if ($prevResult->num_rows > 0) {
            foreach ($_REQUEST['data'] as $index => $datas) {
                $enroll =  $_SESSION["enroll"];
                $grades_id = $_REQUEST['Grades_id'][$index];
                $rubrics_id = $_REQUEST['rubrics'][$index];
                $query = $conn->query("UPDATE `grades` SET `Marks`= " . $datas . " WHERE `Grades_id`= " . $grades_id . ""); // execute $query ...

                     }
        } else {
            //inserting in database
            foreach ($_REQUEST['data'] as $index => $datas) {
                $enroll =  $_SESSION["enroll"];
                $rubrics_id = $_REQUEST['rubrics'][$index];
                $insert_row = $conn->query("INSERT INTO `grades`(`Grades_id`, `Rubrics_id`, `Marks`, `Enrollment_id`) VALUES ('','$rubrics_id','$datas', '$enroll')");
            }
        }


        // Check whether member already exists in the database with the same email
        $prevQuery = "SELECT `Name`, `Enrollment_id` FROM `marks` WHERE `Enrollment_id` = '$enroll';";
        $prevResult = $conn->query($prevQuery);

        if ($prevResult->num_rows > 0) {
            // Update member data in the database
            $graded = $_SESSION["uid"];
            $external = $conn->query("SELECT * FROM `user` WHERE `user_id` = $graded;");
            $graded_by = $external->fetch_array(MYSQLI_ASSOC);
            $external_member = $graded_by['Fname'] . ' ' . $graded_by['Lname'];
            $comments = implode(".", $_REQUEST['comments']);
            $Students_data = $conn->query("SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'");
            $studata = $Students_data->fetch_array(MYSQLI_ASSOC);
            $name = $studata['Name'];
            $semester = $studata['Semester'];
            $discipline = $studata['Discipline'];
            $school = $studata['School'];
            $total_grades = array_sum($_REQUEST['data']);
            $conn->query("UPDATE `marks` SET `Name`=''" . $name . "'',`Enrollment_id`=''" . $enroll . "'',`Grades`=''" . $total_grades . "'',`Grades_by`=''" . $external_member . "'',`School`=''" . $school . "'',`Discipline`=''" . $discipline . "'',`Semester`=''" . $semester . "'',`Feedback`=''" . $comments . "'' modified = NOW() WHERE `Enrollment_id` = '" . $enroll . "'");
        } else {

            //inserting in database
            $graded = $_SESSION["uid"];
            $external = $conn->query("SELECT * FROM `user` WHERE `user_id` = $graded;");
            $graded_by = $external->fetch_array(MYSQLI_ASSOC);
            $external_member = $graded_by['Fname'] . ' ' . $graded_by['Lname'];
            $comments = implode(".", $_REQUEST['comments']);
            $Students_data = $conn->query("SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'");
            $studata = $Students_data->fetch_array(MYSQLI_ASSOC);
            $name = $studata['Name'];
            $semester = $studata['Semester'];
            $discipline = $studata['Discipline'];
            $school = $studata['School'];
            $total_grades = array_sum($_REQUEST['data']);
            $marks = $conn->query("INSERT INTO `marks`(`Marks_id`, `Name`, `Enrollment_id`, `Grades`, `Grades_by`, `School`, `Discipline`, `Semester`, `Feedback`) VALUES ('','$name','$enroll','$total_grades','$external_member','$school','$discipline','$semester','$comments')");
            if ($marks) {
                print 'Success! ID of last inserted record is : ' . $conn->insert_id . '<br />';
            }
        }
    }

    if (isset($_POST['submit'])) {
        display();
    ?>

        <script type="text/javascript">
            window.location = "Final_marks_submission.php";
        </script>
    <?php
    }

    ?>

</body>

</html>
<style>
    .center {
        font-family: arial;
        font-size: 24px;
        margin: 25px;
        width: fit-content;
        height: fit-content;

        /* Setup */
        position: relative;
    }
</style>