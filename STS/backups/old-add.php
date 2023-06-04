<?php
session_start();

include_once("connections/connection.php");
$con = connection();

if (isset($_POST['submit'])) {

    $citizenship = $_POST['citizenship'];
    $birthDate = $_POST['date_of_birth'];
    $placeBirth = $_POST['place_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['stu_address'];
    $schoolYear = $_POST['school_year'];
    $generalAverage = $_POST['gen_average'];
    $lastName = $_POST['last_name'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $guardian = $_POST['guardian'];
    $occupation = $_POST['occupation'];
    $interCourseComplete = $_POST['inter_course_com'];
    
    // Insert values into students_list_old table
    $sql1 = "INSERT INTO `students_list_old` (
        `last_name`, 
        `first_name`, 
        `middle_name`, 
        `citizenship`, 
        `date_of_birth`, 
        `place_of_birth`, 
        `gender`, 
        `stu_address`, 
        `school_year`, 
        `gen_average`, 
        `guardian`, 
        `occupation`, 
        `inter_course_com`
    ) VALUES (
        '$lastName', 
        '$firstName', 
        '$middleName', 
        '$citizenship', 
        '$birthDate', 
        '$placeBirth', 
        '$gender', 
        '$address', 
        '$schoolYear', 
        '$generalAverage', 
        '$guardian', 
        '$occupation', 
        '$interCourseComplete'
    )";
    
    $con->query($sql1) or die($con->error);
    
    // Insert values into old_subjects_list table
    $sql2 = "INSERT INTO `old_subjects_list` (
        `table1_school_name`,
        `table1_classification`,
        `table1_school_year`,
        `table1_curr_year`,
        `table1_subject`,
        `table1_final_rating`,
        `table1_action_taken`,
        `table1_credits_earned`,
        `table1_days_of_school`,
        `table1_total_units_earned`,
        `table1_days_present`,
        `table1_general_average`
    ) VALUES ";

    // Loop through the array values and construct the SQL statement
    for ($i = 0; $i < count($table1_schoolName); $i++) {
        $sql2 .= "(
            '{$table1_schoolName[$i]}',
            '{$table1_classification[$i]}',
            '{$table1_schoolYear[$i]}',
            '{$table1_currYear[$i]}',
            '{$table1_subject[$i]}',
            '{$table1_finalRating[$i]}',
            '{$table1_actionTaken[$i]}',
            '{$table1_creditsEarned[$i]}',
            '{$table1_daysOfSchool[$i]}',
            '{$table1_totalUnitsEarned[$i]}',
            '{$table1_daysPresent[$i]}',
            '{$table1_generalAverage[$i]}'
        )";

        // Add comma after each value set except the last one
        if ($i < count($table1_schoolName) - 1) {
            $sql2 .= ",";
        }
    }

    $con->query($sql2) or die($con->error);


    header("Location: old-list.php");
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/buttons.css">
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
                    <h1>Add Student <i class="fa-solid fa-user-plus"></i></h1>
                    <hr class="section-divider">
            </div>
            <div class="main-content">
                <button class="btn">
                    <a href="old-list.php"><i class="fa-solid fa-chevron-left"></i> Back</a>
                </button>
                <div class="table-container">
                    <form action="" method="post">
                        <button class="btn" type="submit" name="submit">Add <i class="fa-solid fa-user-plus"></i></button>
                        <table class="table">
                            <tr>
                                <th class="th" colspan="5">SECONDARY STUDENT'S PERMANENT RECORD</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Last name: 
                                    <span class="value">
                                        <input type="text" name="last_name" id="" autocomplete="off" required>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">First name: 
                                    <span class="value">
                                        <input type="text" name="first_name" id="" autocomplete="off" required>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Middle name: 
                                    <span class="value">
                                        <input type="text" name="middle_name" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="bold-letter">Date of Birth: 
                                    <span class="value">
                                        <input type="text" name="date_of_birth" id="" autocomplete="off" required>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Place of Birth: 
                                    <span class="value">
                                        <input type="text" name="place_of_birth" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Citizenship: 
                                    <span class="value">
                                        <input type="text" name="citizenship" id="" autocomplete="off" required>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Gender: 
                                    <span class="value">
                                        <select name="gender" id="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Address: 
                                    <span class="value">
                                        <input type="text" name="stu_address" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">School year: 
                                    <span class="value">
                                        <input type="text" name="school_year" id="" autocomplete="off" required>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">General Average: 
                                    <span class="value">
                                        <input type="text" name="gen_average" id="" autocomplete="off" required>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Guardian: 
                                    <span class="value">
                                        <input type="text" name="guardian" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Occupation: 
                                    <span class="value">
                                        <input type="text" name="occupation" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="bold-letter">Intermediate Course Completed: 
                                    <span class="value">
                                        <input type="text" name="inter_course_com" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table class="sub-table">
                            <tr>
                                <th class="row-devide" colspan="5"></th>
                            </tr>
                            <tr>
                                <td colspan="5" class="bold-letter">School:
                                    <span class="value">
                                        <input type="text" name="table1_school_name" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Classified as:
                                    <span class="value">
                                        <input type="text" name="table1_classification" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="3" class="bold-letter">School Year:
                                    <span class="value">
                                        <input type="text" name="table1_school_year" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1" class="bold-letter">Current Year</td>
                                <td colspan="1" class="bold-letter">Subject</td>
                                <td colspan="1" class="bold-letter">Final Rating</td>
                                <td colspan="1" class="bold-letter">Action taken</td>
                                <td colspan="1" class="bold-letter">Credits Earned</td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="trcenter">
                                <td colspan="1">
                                    <input type="text" name="table1_curr_year[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_subject[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_final_rating[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_action_taken[]" autocomplete="off">
                                </td>
                                <td colspan="1">
                                    <input type="text" name="table1_credits_earned[]" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Days of School:
                                    <span class="value">
                                        <input type="text" name="table1_days_of_school" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="3">
                                    Total Units Earned:
                                    <span class="value">
                                        <input type="text" name="table1_total_units_earned" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Days Present:
                                    <span class="value">
                                        <input type="text" name="table1_days_present" id="" autocomplete="off">
                                    </span>
                                </td>
                                <td colspan="3">
                                    General Average:
                                    <span class="value">
                                        <input type="text" name="table1_general_average" id="" autocomplete="off">
                                    </span>
                                </td>
                            </tr>
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
