<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $sql = "SELECT * FROM students_list_old WHERE id = '$id'";
    $students = $con->query($sql) or die($con->error);
    $row = $students->fetch_assoc();

} else {
    // Handle the case when 'ID' parameter is not set
    // For example, redirect to another page or display an error message
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
                    <h1><?php echo $row['first_name']; ?>'s Information</span> <i class="fa-solid fa-circle-info"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                    <div class="table-controls">
                        <button class="btn"><a href="old-list.php"><i class="fa-solid fa-chevron-left"></i> Back</a></button>
                        <button class="btn"><a href="old-edit.php?ID=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a></button>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <tr>
                                <th class="th" colspan="5">SECONDARY STUDENT'S PERMANENT RECORD</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Last name: 
                                    <span class="value">
                                        <?php echo $row['last_name'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">First name: 
                                    <span class="value">
                                        <?php echo $row['first_name'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Middle name: 
                                    <span class="value">
                                        <?php echo $row['middle_name'] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="bold-letter">Date of Birth: 
                                    <span class="value">
                                        <?php echo $row['date_of_birth'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Place of Birth: 
                                    <span class="value">
                                        <?php echo $row['place_of_birth'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Citizenship: 
                                    <span class="value">
                                        <?php echo $row['citizenship'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Gender: 
                                    <span class="value">
                                        <?php if ($row['gender'] === 'Male'): ?>
                                            <span>Male</span>
                                        <?php else: ?>
                                            <span>Female</span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Address: 
                                    <span class="value">
                                        <?php echo $row['stu_address'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">School year: 
                                    <span class="value">
                                        <?php echo $row['school_year'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">General Average: 
                                    <span class="value">
                                        <?php echo $row['gen_average'] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Guardian: 
                                    <span class="value">
                                        <?php echo $row['guardian'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Occupation: 
                                    <span class="value">
                                        <?php echo $row['occupation'] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="bold-letter">Intermediate Course Completed: 
                                    <span class="value">
                                        <?php echo $row['inter_course_com'] ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>