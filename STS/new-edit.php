<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

$id = $_GET['ID'];

$sql = "SELECT * FROM students_list_new WHERE id = '$id'";
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

    $sql = "UPDATE students_list_new SET last_name = '$lname', first_name = '$fname', name_ext = '$name_ext', middle_name = '$mname', lrn = '$lrn', birth_date = '$birthd', gender = '$gender' WHERE id = '$id'";

    $con->query($sql) or die ($con->error);

    header("Location: new-info.php?ID=".$id);
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
                        
                        <form id="deleteForm_<?php echo $row['id']; ?>" action="new-delete.php" method="post">
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
                            <table class="table no-line-break">
                                <tr>
                                    <th class="th" colspan="8">LEARNER INFORMATION</th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bold-letter">
                                            LAST NAME:
                                        <span class="value">
                                            <input type="text" name="last_name" id="" value="<?php echo $row['last_name'] ?>" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">
                                            FIRST NAME:
                                        <span class="value">
                                            <input type="text" name="first_name" id="" value="<?php echo $row['first_name'] ?>" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">
                                            NAME EXT. (Jr, I, II):
                                        <span class="value">
                                            <input type="text" name="name_ext" id="" value="<?php echo $row['name_ext'] ?>" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">
                                            MIDDLE NAME:
                                        <span class="value">
                                            <input type="text" name="middle_name" id="" value="<?php echo $row['middle_name'] ?>" autocomplete="off">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="bold-letter">
                                            Learner Reference Number (LRN):
                                        <span class="value">
                                            <input type="text" name="lrn" id="" value="<?php echo $row['lrn'] ?>" maxlength="12" minlength="12" autocomplete="off">
                                        </span>
                                    </td>
                                    <td colspan="3" class="bold-letter">
                                            Birthdate (mm/dd/yyyy):
                                        <span class="value">
                                            <input type="text" name="birth_date" id="" value="<?php echo $row['birth_date'] ?>" maxlength="10" autocomplete="off" oninput="validateBirthdate(this)">
                                            <span id="birthdateError" style="color: red;"></span>
                                        </span>
                                    </td>
                                    <td colspan="2" class="bold-letter">
                                            Gender:
                                        <span class="value">
                                            <select name="gender" id="gender">
                                                <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                                <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                            </select>
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