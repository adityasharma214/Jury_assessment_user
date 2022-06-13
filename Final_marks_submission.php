<?php
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
        $enroll =  $_SESSION["enroll"];
    }
} else {
    header('location:Login.php');
}
include('./connect.php');

$enroll =  $_SESSION["enroll"];

$comments = "SELECT * FROM `marks` WHERE `Enrollment_id` = '$enroll';";
$comments_run = $conn->query($comments);

$SQL = "SELECT rubrics.Rubrics_id, grades.Enrollment_id, grades.Grades_id, grades.Marks, rubrics.`Course_id - Name`, rubrics.Criteria, rubrics.`Out of` FROM `grades` grades JOIN rubrics WHERE grades.Rubrics_id=rubrics.Rubrics_id AND Enrollment_id='$enroll';";

$SQLs = "SELECT rubrics.Rubrics_id, grades.Enrollment_id, grades.Grades_id, grades.Marks, rubrics.`Course_id - Name`, rubrics.Criteria, rubrics.`Out of` FROM `grades` grades JOIN rubrics WHERE grades.Rubrics_id=rubrics.Rubrics_id AND Enrollment_id='$enroll';";

$SQLss = "SELECT rubrics.Rubrics_id, grades.Enrollment_id, grades.Grades_id, grades.Marks, rubrics.`Course_id - Name`, rubrics.Criteria, rubrics.`Out of` FROM `grades` grades JOIN rubrics WHERE grades.Rubrics_id=rubrics.Rubrics_id AND Enrollment_id='$enroll';";

$run = $conn->query($SQL);
$runs = $conn->query($SQLs);
$runss = $conn->query($SQLss);

$course_wise_marks = "SELECT rubrics.`Course_id - Name`, SUM(grades.Marks), SUM(rubrics.`Out of`)
FROM grades
INNER JOIN rubrics ON rubrics.Rubrics_id=grades.Rubrics_id WHERE grades.Enrollment_id = '$enroll' GROUP BY rubrics.`Course_id - Name` ASC;";

$run_all = $conn->query($course_wise_marks);

$uidd = $_SESSION["uid"];
$user = "SELECT * FROM `user` WHERE `user_id`='$uidd';";
$user_results = $conn->query($user);
$user_row = $user_results->fetch_assoc();

$Panel_member = $user_row['Fname'] . ' ' . $user_row['Lname'];

$panel = "SELECT `Internal`, `Internal_2` FROM `scheduled` WHERE `Jury_pannel`='$Panel_member' AND `Date` = CURDATE() LIMIT 1;";
$panel_result = $conn->query($panel);

$panel_2 = "SELECT `Internal`, `Internal_2` FROM `scheduled` WHERE `Jury_pannel`='$Panel_member' AND `Date` = CURDATE() LIMIT 1;";
$panel_result_2 = $conn->query($panel_2);

$Student = "SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'";
$student_run = $conn->query($Student);

$Student_school = "SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'";
$student_run_school = $conn->query($Student_school);


$Student_Discipline = "SELECT * FROM `student` WHERE `Enrollment_id` = '$enroll'";
$student_run_Discipline = $conn->query($Student_Discipline);

$uidd = $_SESSION["uid"];
$user = "SELECT * FROM `user` WHERE `user_id`='$uidd';";
$user_results = $conn->query($user);
$user_row = $user_results->fetch_assoc();
$Panel_member = $user_row['Fname'] . ' ' . $user_row['Lname'];







?>

<?php
global $total_grades, $out_of_grades;
function display()
{
    include('connect.php');
    if (isset($_POST["data"]) && is_array($_POST["data"])) {
        $enroll = $_SESSION["enroll"];
        $capture_field_vals = "";
        $capture_field_id_vals = "";
        foreach ($_POST["data"] as $key => $text_field) {
            $capture_field_id_vals = $_REQUEST['Grades_id'][$key];
            $grades_id = $_REQUEST['Grades_id'][$key];
            $capture_field_vals .= $text_field . ", ";
            $query = $conn->query("UPDATE `grades` SET `Marks`= " . $text_field . " WHERE `Grades_id`= " . $grades_id . ""); // execute $query ...
            $total_grades = array_sum($_POST['data']);
        }
    }
}

if (isset($_POST['submit'])) {
    display();
    $total_grades = array_sum($_POST['data']);
    $feedback = $_POST['comments'];
    $completion = $conn->query("UPDATE `scheduled` SET `Status`='1' WHERE `Enrollment`= '$enroll';");
    $marks = $conn->query("UPDATE `marks` SET `Grades`='$total_grades',`Feedback`='$feedback' WHERE `Enrollment_id` = '$enroll';");



?>
    <!-- <script type="text/javascript">
        window.location = "Jury Landing.php";
    </script> -->


<?php
}
?>
<?php
if (isset($_POST['next'])) {

?>
    <script type="text/javascript">
        window.location = "Jury Landing.php";
    </script>


<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jury Landing</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
</head>

<body style="
    
      backdrop-filter: blur(2px);
    ">
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

            </div>
            <!-- Small modal -->
            <button class="btn" id="logout" data-toggle="modal" data-target=".bs-example-modal-sm">
                Logout
            </button>

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

    <div class="container mt-4">
        <table class="table " style="margin-top: 10px;">
            <thead>
                <tr>

                    <th scope="col">Student Name - <?php
                                                    while ($rows = $student_run->fetch_assoc()) {
                                                        echo $rows['Name'];
                                                    } ?></th>
                    <th scope="col">School - <?php
                                                while ($rows = $student_run_school->fetch_assoc()) {
                                                    echo $rows['School'];
                                                } ?></th>
                    <th scope="col">Discipline - <?php
                                                    while ($rows = $student_run_Discipline->fetch_assoc()) {
                                                        echo $rows['Discipline'];
                                                    } ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <form action="" method="post">

        <div>

            <div class="container mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="background-color:#dc4c44; color:#FFFFFF;">
                            <th style="font-weight: bold; font-size:medium;">Subject </th>
                            <th style="font-weight: bold; font-size:medium;">Criteria</th>
                            <th style="font-weight: bold; font-size:medium;text-align:center;">Marks</th>
                            <th style="font-weight: bold; font-size:medium;text-align:center;">/Out off</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php   // LOOP TILL END OF DATA
                            include('connect.php');
                            while ($rows = $run->fetch_assoc()) {
                            ?>
                                <td hidden><input type="text" name="Rubrics_id[]" value="<?php echo $rows['Rubrics_id']; ?> ">
                                </td>
                                <td hidden><input type="text" name="Grades_id[]" value="<?php echo $rows['Grades_id']; ?> ">
                                </td>
                                <td><?php echo $rows['Course_id - Name']; ?></td>
                                <td><?php echo $rows['Criteria'] ?></td>
                                <td style="text-align:center;"> <input type="number" value="<?php echo $rows['Marks'] ?>" required min="0" max="<?php echo $rows['Out of']; ?>" step="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="2" name="data[]"> </td>
                                <td name="Out_off[]" style="text-align:center;"><?php $out_of_grades =  $rows['Out of'];
                                                                                echo $out_of_grades; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <div class="form-floating">
                    <textarea name="comments" id="comments" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"> <?php
                                                                                                                                                                    while ($rows = $comments_run->fetch_assoc()) {
                                                                                                                                                                        echo $rows['Feedback'];
                                                                                                                                                                    } ?></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>

                <div class="text-center" style="padding-top: 10px;">
                    <button id="marks" type="submit" name="submit" class="btn btn-success" onClick="refreshPage()" style="margin-right: 20px;">Final Submit</button>

                </div>

                <table class="table  table-bordered" style="margin-top: 20px;">
                    <thead>
                        <tr>

                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">Subject</th>
                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">Total Marks</th>
                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">/ Out off</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php   // LOOP TILL END OF DATA
                            include('connect.php');
                            while ($rows = $run_all->fetch_assoc()) {
                            ?>
                                <td><?php echo $rows['Course_id - Name']; ?></td>
                                <td style="text-align:center;"><?php echo $rows['SUM(grades.Marks)'] ?></td>
                                <td name="Out_off[]" style="text-align:center;"><?php echo $rows['SUM(rubrics.`Out of`)'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <h5>Total - <?php
                            echo $total_grades; ?> </h5>
                <table class="table  table-bordered" style="margin-top: 20px;">
                    <thead>
                        <tr>

                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">Jury Chair</th>
                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">Jury Member</th>
                            <th scope="col" style="font-weight: bold; font-size:medium; text-align:center;">Jury Member</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td><br><br> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>

                            <td style="font-weight: bold; font-size:medium; text-align:center;"><?php echo  $Panel_member ?></td>
                            <td style="font-weight: bold; font-size:medium; text-align:center;"><?php
                                                                                                while ($rows = $panel_result->fetch_assoc()) {
                                                                                                    echo $rows['Internal_2'];
                                                                                                } ?></td>
                            <td style="font-weight: bold; font-size:medium; text-align:center;"><?php
                                                                                                while ($rows = $panel_result_2->fetch_assoc()) {
                                                                                                    echo $rows['Internal'];
                                                                                                } ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center" style="padding-top: 10px; padding-bottom: 30px;">
                <button type="button" class="btn btn-primary" id="printPageButton" style="margin-right: 20px;" onclick="window.print();return false;">Print</button>
                <button class="btn btn-primary" type="submit" id="next" name="next">Start Next</button>


            </div>
    </form>


    </div>


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

    table {
        width: 70%;
    }

    th {
        height: 50%;
    }

    @media print {
        #printPageButton {
            display: none;
        }
        
    }
    @media print {
        #next {
            display: none;
        }
        
    }
    @media print {
        #marks {
            display: none;
        }
        
    }
    @media print {
        #logout {
            display: none;
        }
        
    }
</style>

<script>
    function refreshPage() {
        window.location.reload();
    }
</script>