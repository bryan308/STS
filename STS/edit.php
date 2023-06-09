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
                    <h1>Edit <?php echo $row['first_name']; ?>'s Informations <i class="fa fa-pen"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                    <div class="table-container">
                        
                        <form id="deleteForm_<?php echo $row['id']; ?>" action="delete.php" method="post">
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
                        <button class="delete" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>')">DELETE <i class="fa-solid fa-trash"></i></button>
                        </div>
                        <form action="" method="post">
                            <div class="edit-controls">
                                <button class="update" type="subimt" name="submit">UPDATE <i class="fa-solid fa-upload"></i></button>
                            </div>
                            <table class="table no-line-break">
                                <tr>
                                    <th class="th" colspan="4">LEARNER INFORMATION</th>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            LAST NAME:
                                            <input type="text" name="last_name" id="" value="<?php echo $row['last_name'] ?>" autocomplete="off">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            FIRST NAME:
                                            <input type="text" name="first_name" id="" value="<?php echo $row['first_name'] ?>" autocomplete="off">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            NAME EXT. (Jr, I, II):
                                            <input type="text" name="name_ext" id="" value="<?php echo $row['name_ext'] ?>" autocomplete="off">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            MIDDLE NAME:
                                            <input type="text" name="middle_name" id="" value="<?php echo $row['middle_name'] ?>" autocomplete="off">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="input-wrapper">
                                            Learner Reference Number (LRN):
                                            <input type="text" name="lrn" id="" value="<?php echo $row['lrn'] ?>" maxlength="12" minlength="12" autocomplete="off">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            Birthdate (mm/dd/yyyy):
                                            <input type="text" name="birth_date" id="" value="<?php echo $row['birth_date'] ?>" maxlength="10" autocomplete="off" oninput="validateBirthdate(this)">
                                            <span id="birthdateError" style="color: red;"></span>
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-wrapper">
                                            Gender:
                                            <select name="gender" id="gender">
                                                <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                                <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="th" colspan="4">ELIGIBILITY FOR JHS ENROLMENT</th>
                                </tr>
                                <tr>
                                    <td colspan="2">Elementary School Completer:
                                        <input type="checkbox" name="elementary_completer">
                                    </td>
                                    <td colspan="2">General Average:
                                        <input type="text" name="" value="" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name of Elementary School:</td>
                                    <td colspan="3"></td>
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