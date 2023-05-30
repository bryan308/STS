<?php 

if (!isset($_SESSION)) {
    session_start();
}

// echo "<div style='text-align: center;'>";
// if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration"){
//     echo "Welcome " . $_SESSION['UserLogin'];
// } else {
//     header("Location: index.php");
//     exit;
// }
// echo "</div>";

include_once("connections/connection.php");
$con = connection();

// Check if the 'ID' parameter is set in the URL
if(isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $sql = "SELECT * FROM students_list WHERE id = '$id'";
    $students = $con->query($sql) or die ($con->error);
    $row = $students->fetch_assoc();
} else {
    // Handle the case when 'ID' parameter is not set
    // For example, redirect to another page or display an error message
    header("Location: index.php");
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
                    <a href="#0">
                        <i class="fa fa-home"></i><em> Home</em>
                    </a>
                </li>
                <li>
                    <a href="index.php" target="_self">
                        <i class="fa-solid fa-table-list"></i><em> Students List</em>
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
                <button class="menu-btn" id="menu-toggle">
                    <span><i class="fa-solid fa-bars-staggered"></i></span>
                </button>
                <div class="section-header">
                    <h1><?php echo $row['first_name']; ?><span>'s Information</span> <i class="fa-solid fa-circle-info"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                    <div class="table-controls">
                        <button class="btn"><a href="index.php"><i class="fa-solid fa-chevron-left"></i> Back</a></button>
                        <button class="btn"><a href="edit.php?ID=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a></button>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <tr>
                                <th class="th" colspan="4">LEARNER INFORMATION</th>
                            </tr>
                            <tr>
                                <td colspan="1">LAST NAME: 
                                    <?php echo $row['last_name'] ?>
                                </td>
                                <td colspan="1">FIRST NAME: 
                                    <?php echo $row['first_name'] ?>
                                </td>
                                <td colspan="1">NAME EXT. (Jr, I, II): 
                                    <?php echo $row['name_ext'] ?>
                                </td>
                                <td colspan="1">MIDDLE NAME: 
                                    <?php echo $row['middle_name'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Learner Reference Number (LRN):
                                    <?php echo $row['lrn'] ?>
                                </td>
                                <td colspan="1">Birthdate (mm/dd/yyyy): 
                                    <?php echo $row['birth_date'] ?>
                                </td>
                                <td colspan="1">Gender: 
                                    <?php if ($row['gender'] === 'Male'): ?>
                                        <span>Male</span>
                                    <?php else: ?>
                                        <span>Female</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="th" colspan="4">ELIGIBILITY FOR JHS ENROLMENT</th>
                            </tr>
                            <tr>
                                <td colspan="2">Elementary School Completer:
                                    <input type="checkbox" name="">
                                </td>
                                <td colspan="1">General Average:
                                    <input type="text" name="" value="" readonly autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td>Name of Elementary School:</td>
                                <td colspan="3">LA FUENTE ELEM. SCHOOL</td>
                            </tr>
                            <tr>
                                <td>School ID:</td>
                                <td>105752</td>
                                <td>Address of School:</td>
                                <td>LA FUENTE, STA. ROSA, N.E.</td>
                            </tr>
                            <tr>
                                <td>Elementary School Completer</td>
                                <td colspan="3">General Average: 79</td>
                            </tr>
                            <tr>
                                <td>Name of Elementary School:</td>
                                <td colspan="3">LA FUENTE ELEM. SCHOOL</td>
                            </tr>
                            <tr>
                                <td>School ID:</td>
                                <td>105752</td>
                                <td>Address of School:</td>
                                <td>LA FUENTE, STA. ROSA, N.E.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/script.js"></script>
</html>