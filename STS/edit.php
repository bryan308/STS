<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

$id = $_GET['ID'];

$sql = "SELECT * FROM students_list WHERE id = '$id'";
$students = $con->query($sql) or die ($con->error);
$row = $students->fetch_assoc();

if(isset($_POST['submit'])) {

    $lname = $_POST['last_name'];
    $fname = $_POST['first_name'];
    $name_ext = $_POST['name_ext'];
    $mname = $_POST['middle_name'];
    $lrn = $_POST['lrn'];
    $birthd = $_POST['birth_date'];
    $gender = $_POST['gender'];

    $sql = "UPDATE students_list SET last_name = '$lname', first_name = '$fname', name_ext = '$name_ext', middle_name = '$mname', lrn = '$lrn', birth_date = '$birthd', gender = '$gender' WHERE id = '$id'";

    $con->query($sql) or die ($con->error);

    header("Location: info.php?ID=".$id);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/style.css">
    <title>Students Transcripts System</title>
</head>


<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <div class="show-access">
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
                <a class="s-sidebar__nav-link" href="#0">
                    <i class="fa fa-home"></i><em> Home</em>
                </a>
            </li>
            <li>
                <a class="s-sidebar__nav-link" href="index.php" target="_self">
                    <i class="fa fa-list"></i><em> Students List</em>
                </a>
            </li>
            <li>
                <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                    <a href="logout.php">Log out</a>
                <?php } elseif(isset($_SESSION['Access']) && $_SESSION['Access'] == "guest") { ?>
                    <a href="logout.php">Log out</a>
                <?php } else { ?>
                    <a href="login.php">Log In</a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
                <button class="menu-btn" id="menu-toggle">
                <span><i class="fa fa-bars"></i></span>
                </button>
                <div class="section-header">
                    <h1>Edit <?php echo $row['first_name']; ?>'s Informations <i class="fa fa-pen"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                
                    <div class="table-controls">
                    <button class="btn delete" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>')">DELETE</button>
                    </div>
                <div class="table-container">
                    
                
                    <form id="deleteForm_<?php echo $row['id']; ?>" action="delete.php" method="post">
                        <input type="hidden" name="delete" value="1">
                        <input type="hidden" name="ID" value="<?php echo $row['id']; ?>" autocomplete="off">
                    </form>
                    
                    <div class="overlay" id="overlay"></div>
                    
                    <div id="confirmDialog" class="confirm-dialog">
                        <p>Are you sure you want to delete this student's record? This action cannot be undone. <i class='fa fa-exclamation-triangle' style='color: orange;'></i></p>
                        
                        <div class="btn-wrapper">
                            <button class="btn btn-primary" onclick="deleteItem('<?php echo $row['id']; ?>')">Delete</button>
                            <button class="btn btn-secondary" onclick="hideDeleteConfirmation()">Cancel</button>
                        </div>
                    
                    </div>
                    
                    <form action="" method="post">
                        <button class="btn update" type="subimt" name="submit">UPDATE</button>
                        <table>
                            <tr>
                                <th class="th" colspan="4">LEARNER INFORMATION</th>
                            </tr>
                            <tr>
                                <td colspan="2">Learner Reference Number (LRN):</td>
                                <td colspan="2"><input type="text" name="lrn" id="search" value="<?php echo $row['lrn'] ?>" maxlength="12" minlength="12" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td colspan="1">LAST NAME:</td>
                                <td colspan="1"><input type="text" name="last_name" id="search" value="<?php echo $row['last_name'] ?>" autocomplete="off"></td>
                                <td colspan="1">FIRST NAME:</td>
                                <td colspan="1"><input type="text" name="first_name" id="search" value="<?php echo $row['first_name'] ?>" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td colspan="1">NAME EXT. (Jr, I, II):</td>
                                <td colspan="1"><input type="text" name="name_ext" id="search" value="<?php echo $row['name_ext'] ?>" autocomplete="off"></td>
                                <td colspan="1">MIDDLE NAME:</td>
                                <td colspan="1"><input type="text" name="middle_name" id="search" value="<?php echo $row['middle_name'] ?>" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Birthdate (mm/dd/yyyy):</td>
                                <td colspan="1">
                                    <input type="text" name="birth_date" id="search" value="<?php echo $row['birth_date'] ?>" maxlength="10" autocomplete="off" oninput="validateBirthdate(this)">
                                    <span id="birthdateError" style="color: red;"></span>
                                </td>
                                <td colspan="1">Gender:</td>
                                <td colspan="1">
                                <select name="gender" id="gender">
                                    <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th class="th" colspan="4">ELIGIBILITY FOR JHS ENROLMENT</th>
                            </tr>
                            <tr>
                                <td>Elementary School Completer:
                                <input type="checkbox" name="elementary_completer">
                                </td>
                                <td colspan="1">General Average:</td>
                                <td colspan="2"><input type="text" name="" value="" readonly autocomplete="off"></td>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/script.js"></script>
</html>