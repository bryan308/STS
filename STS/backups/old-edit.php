<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

$id = $_GET['ID'];

$sql = "SELECT * FROM students_list_old WHERE id = '$id'";
$students = $con->query($sql) or die ($con->error);
$row = $students->fetch_assoc();

if(isset($_POST['submit'])) {

    $studentId = $_POST['student_id'];
    $lastName = $_POST['last_name'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $birthDate = $_POST['date_of_birth'];
    $placeBirth = $_POST['place_of_birth'];
    $citizenship = $_POST['citizenship'];
    $gender = $_POST['gender'];
    $address = $_POST['stu_address'];
    $schoolYear = $_POST['school_year'];
    $generalAverage = $_POST['gen_average'];
    $guardian = $_POST['guardian'];
    $occupation = $_POST['occupation'];
    $interCourseComplete = $_POST['inter_course_com'];


    $sql = "UPDATE students_list_old SET 
    student_id = '$studentId',
    last_name = '$lastName',
    first_name = '$firstName', 
    middle_name = '$middleName', 
    date_of_birth = '$birthDate', 
    place_of_birth = '$placeBirth', 
    citizenship = '$citizenship', 
    gender = '$gender', 
    stu_address = '$address', 
    school_year = '$schoolYear', 
    gen_average = '$generalAverage', 
    guardian = '$guardian', 
    occupation = '$occupation', 
    inter_course_com = '$interCourseComplete' WHERE id = '$id'";
    
    $con->query($sql) or die ($con->error);

    header("Location: old-info.php?ID=".$id);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Students Transcripts System</title>
</head>


<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
        <li class="sidebar-user">
                <div class="show-access">
                <i class="fa-regular fa-circle-user"></i>
                    <?php
                    if (isset($_SESSION['UserLogin'])) {
                        if ($_SESSION['UserLogin'] === 'admin') {
                            echo "Welcome Admin";
                        } else {
                            echo "Welcome " . $_SESSION['UserLogin'];
                        }
                    } else {
                        echo "Welcome Guest";
                    }
                    ?>
                </div>
            </li>
            <li>
                <a href="home.php">
                    <i class="fa fa-home"></i><em> Home</em>
                </a>
            </li>
            <li>
                <a href="new-list.php" target="_self">
                    <i class="fa-solid fa-table-list"></i><em> Students List New</em>
                </a>
            </li>
            <li>
                <a href="old-list.php" target="_self">
                    <i class="fa-solid fa-table-list"></i><em> Students List Old</em>
                </a>
            </li>
            <li>
                <a href="settings.php" target="_self">
                    <i class="fa-solid fa-gear"></i><em> Settings</em>
                </a>
            </li>
            <li>
                <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                    <a href="login.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
                <?php } elseif(isset($_SESSION['Access']) && $_SESSION['Access'] == "guest") { ?>
                    <a href="login.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
                <?php } else { ?>
                    <a href="login.php">Log In</a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="top-section">
                <button class="menu-btn" id="menu-toggle">
                    <span><i class="fa-solid fa-bars-staggered"></i></span>
                </button>
                <div class="clock-container">
                    <i class="fa-regular fa-calendar"></i><div id="clock"></div>
                </div>                
            </div>
            <div class="section-header">
                <h1>Edit <?php echo $row['first_name']; ?>'s Informations <i class="fa fa-pen"></i></h1>
                <hr class="section-divider">
            </div>
            <div class="main-content">
                <div class="table-container">        
                    <form id="deleteForm_<?php echo $row['id']; ?>" action="old-delete.php" method="post">
                        <input type="hidden" name="delete" value="1">
                        <input type="hidden" name="ID" value="<?php echo $row['id']; ?>" autocomplete="off">
                    </form>    
                    <div class="overlay" id="overlay"></div>
                    <div id="confirmDialog" class="confirm-dialog">
                        <p>Are you sure you want to delete <?php echo $row['first_name']; ?>'s record?</br> This action cannot be undone. <i class='fa fa-exclamation-triangle' style='color: orange;'></i></p>
                        <div class="btn-wrapper">
                            <button class="delete" onclick="deleteItem('<?php echo $row['id']; ?>')">Delete</button>
                            <button class="cancel" onclick="hideDeleteConfirmation()">Cancel</button>
                        </div>
                    </div>
                    <div class="edit-controls">
                        <button class="delete" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>')">
                        DELETE <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="edit-controls">
                            <button class="update" type="subimt" name="submit">UPDATE <i class="fa-solid fa-upload"></i></button>
                        </div>
                        <table class="table">
                            <tr>
                                <th class="th" colspan="5">SECONDARY STUDENT'S PERMANENT RECORD</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Last name: 
                                    <span class="value">
                                        <input type="text" name="last_name" id="" value="<?php echo $row['last_name'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">First name: 
                                    <span class="value">
                                        <input type="text" name="first_name" id="" value="<?php echo $row['first_name'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Middle name: 
                                    <span class="value">
                                        <input type="text" name="middle_name" id="" value="<?php echo $row['middle_name'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="bold-letter">Date of Birth: 
                                    <span class="value">
                                        <input type="text" name="date_of_birth" id="" value="<?php echo $row['date_of_birth'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Place of Birth: 
                                    <span class="value">
                                        <input type="text" name="place_of_birth" id="" value="<?php echo $row['place_of_birth'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Citizenship: 
                                    <span class="value">
                                        <input type="text" name="citizenship" id="" value="<?php echo $row['citizenship'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Gender: 
                                    <span class="value">
                                        <select name="gender" id="gender">
                                            <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                            <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Address: 
                                    <span class="value">
                                        <input type="text" name="stu_address" id="" value="<?php echo $row['stu_address'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">School year: 
                                    <span class="value">
                                        <input type="text" name="school_year" id="" value="<?php echo $row['school_year'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">General Average: 
                                    <span class="value">
                                        <input type="text" name="gen_average" id="" value="<?php echo $row['gen_average'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Guardian: 
                                    <span class="value">
                                        <input type="text" name="guardian" id="" value="<?php echo $row['guardian'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Occupation: 
                                    <span class="value">
                                        <input type="text" name="occupation" id="" value="<?php echo $row['occupation'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="bold-letter">Intermediate Course Completed: 
                                    <span class="value">
                                    <input type="text" name="inter_course_com" id="" value="<?php echo $row['inter_course_com'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <!-- <h2>Subjects</h2>
                        <table style="margin-top: 30px;" class="table">
                            <tr>
                                <th class="row-devide" colspan="5"></th>
                            </tr>
                            <tr>
                                <td colspan="5" class="bold-letter">School:
                                    <span class="value">
                                        <input type="text" name="school_tbl1" id="" value="<?php echo $row['school_tbl1'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Classified as:
                                    <span class="value">
                                        <input type="text" name="class_as_tbl1" id="" value="<?php echo $row['class_as_tbl1'] ?>" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="3" class="bold-letter">School Year:
                                    <span class="value">
                                        <input type="text" name="school_year_tbl1" id="" value="<?php echo $row['school_year_tbl1'] ?>" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1" class="bold-letter">
                                    Current Year
                                </td>
                                <td colspan="1" class="bold-letter">
                                    Subject
                                </td>
                                <td colspan="1" class="bold-letter">
                                    Final Rating
                                </td>
                                <td colspan="1" class="bold-letter">
                                    Action taken
                                </td>
                                <td colspan="1" class="bold-letter">
                                    Credits Earned
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input class="inputcenter" type="text" name="curr_yr1_tbl1" id="" value="<?php echo $row['curr_yr1_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="subject1_tbl1" id="" value="<?php echo $row['subject1_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="final_rating1_tbl1" id="" value="<?php echo $row['final_rating1_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="action_taken1_tbl1" id="" value="<?php echo $row['action_taken1_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="credits_earned1_tbl1" id="" value="<?php echo $row['credits_earned1_tbl1'] ?>" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="curr_yr2_tbl1" id="" value="<?php echo $row['curr_yr2_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="subject2_tbl1" id="" value="<?php echo $row['subject2_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="final_rating2_tbl1" id="" value="<?php echo $row['final_rating2_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="action_taken2_tbl1" id="" value="<?php echo $row['action_taken2_tbl1'] ?>" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="credits_earned2_tbl1" id="" value="<?php echo $row['credits_earned2_tbl1'] ?>" autocomplete="off">
                                </td>
                            </tr> -->
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>