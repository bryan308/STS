<?php
session_start();

include_once("connections/connection.php");
$con = connection();

if (isset($_POST['submit'])) {
    $withLRN = $_POST['with_lrn']; // Get the selected LRN option

    if ($withLRN == "With") {
        $lrn = $_POST['lrn']; // Get the LRN value if "With" option is selected
    } else {
        $lrn = ""; // Set the LRN value as empty if "Without" option is selected
    }
    
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
    $schooltable1 = $_POST['school_tbl1'];
    $classAstable1 = $_POST['class_as_tbl1'];
    $schoolYeartable1 = $_POST['school_year_tbl1'];
    $currentYearr1table1 = $_POST['curr_yr1_tbl1'];
    $subject1table1 = $_POST['subject1_tbl1'];
    $finalRating1table1 = $_POST['final_rating1_tbl1'];
    $actionTaken1table1 = $_POST['action_taken1_tbl1'];
    $creditsEarned1table1 = $_POST['credits_earned1_tbl1'];

    $sql = "INSERT INTO `students_list_old` (`lrn`, `citizenship`, `date_of_birth`, `place_of_birth`, `gender`, `stu_address`, `school_year`, `gen_average`, `last_name`, `first_name`, `middle_name`, `guardian`, `occupation`, `inter_course_com`, `school_tbl1`, `class_as_tbl1`, `school_year_tbl1`, `curr_yr1_tbl1`, `subject1_tbl1`, `final_rating1_tbl1`, `action_taken1_tbl1`, `credits_earned1_tbl1`) VALUES ('$lrn', '$citizenship', '$birthDate', '$placeBirth', '$gender', '$address', '$schoolYear', '$generalAverage', '$lastName', '$firstName', '$middleName', '$guardian', '$occupation', '$interCourseComplete', '$schooltable1', '$classAstable1', '$schoolYeartable1', '$currentYearr1table1', '$subject1table1', '$finalRating1table1', '$actionTaken1table1', '$creditsEarned1table1')";
    
    $con->query($sql) or die($con->error);

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
                                            <input type="text" name="last_name" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">First name: 
                                        <span class="value">
                                            <input type="text" name="first_name" id="" autocomplete="off">
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
                                            <input type="text" name="date_of_birth" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">Place of Birth: 
                                        <span class="value">
                                            <input type="text" name="place_of_birth" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="1" class="bold-letter">Citizenship: 
                                        <span class="value">
                                            <input type="text" name="citizenship" id="" autocomplete="off">
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
                                            <input type="text" name="school_year" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="1" class="bold-letter">General Average: 
                                        <span class="value">
                                            <input type="text" name="gen_average" id="" autocomplete="off">
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
                                    <td colspan="3" class="bold-letter">Intermediate Course Completed: 
                                        <span class="value">
                                            <input type="text" name="inter_course_com" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">
                                        <span class="value">
                                        <select name="with_lrn" id="withLrnSelect" onchange="toggleLRNInput(this)">
                                            <option value="With" <?php if (!empty($row['lrn'])) echo 'selected'; ?>>With</option>
                                            <option value="Without" <?php if (empty($row['lrn'])) echo 'selected'; ?>>Without</option>
                                        </select>
                                        LRN:
                                        <?php if (!empty($row['lrn'])) : ?>
                                        <input type="text" name="lrn" id="lrnInput" maxlength="12" minlength="12" autocomplete="off" required>
                                        <?php else : ?>
                                        <input type="text" name="lrn" id="lrnInput" value="" maxlength="12" minlength="12" autocomplete="off" disabled>
                                        <?php endif; ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="row-devide" colspan="5">
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="5" class="bold-letter">School:
                                        <span class="value">
                                            <input type="text" name="school_tbl1" id="" autocomplete="off">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bold-letter">Classified as:
                                        <span class="value">
                                            <input type="text" name="class_as_tbl1" id="" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="3" class="bold-letter">Classified as:
                                        <span class="value">
                                            <input type="text" name="school_year_tbl1" id="" autocomplete="off">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
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
                                <tr>
                                    <td colspan="1">
                                        <input type="text" name="curr_yr1_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="subject1_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="final_rating1_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="action_taken1_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="credits_earned1_tbl1" id="" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        <input type="text" name="curr_yr2_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="subject2_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="final_rating2_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="action_taken2_tbl1" id="" autocomplete="off">
                                    </td>
                                    <td colspan="1">
                                        <input type="text" name="credits_earned2_tbl1" id="" autocomplete="off">
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
<script>
function toggleLRNInput(selectElement) {
    var lrnInput = document.getElementById("lrnInput");
    if (selectElement.value === "With") {
        lrnInput.disabled = false;
        lrnInput.setAttribute("required", "required");
    } else {
        lrnInput.disabled = true;
        lrnInput.removeAttribute("required");
    }
}
</script>
<script>
function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
</script>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>
