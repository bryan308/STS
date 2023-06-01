<?php

session_start();

include_once("connections/connection.php");
$con = connection();

// Initialize variables
$lrn = "";
$lname = "";
$fname = "";
$mname = "";
$birthd = "";
$gender = "";
$lrnError = "";

if (isset($_POST['submit'])) {
    $lrn = $_POST['lrn'];
    $lname = $_POST['last_name'];
    $fname = $_POST['first_name'];
    $mname = $_POST['middle_name'];
    $birthd = $_POST['birth_date'];
    $gender = $_POST['gender'];

    // Check if the LRN already exists in the database
    $checkQuery = "SELECT * FROM students_list_new WHERE lrn = '$lrn'";
    $checkResult = $con->query($checkQuery) or die($con->error);

    if ($checkResult->num_rows > 0) {
        // LRN already exists, display an error message
        $lrnError = "LRN already exists in the list.";
    } else {
        // LRN doesn't exist, insert the new record
        $sql = "INSERT INTO `students_list_new`(`lrn`, `last_name`, `first_name`, `middle_name`, `gender`, `birth_date`) VALUES ('$lrn','$lname','$fname','$mname','$gender','$birthd')";
        $con->query($sql) or die($con->error);

        header("Location: new-list.php");
        exit;
    }
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
                    <a href="new-list.php"><i class="fa-solid fa-chevron-left"></i> Back</a>
                </button>
                <div class="table-container">
                    <div class="error-container<?php echo !empty($lrnError) ? ' active' : ''; ?>" id="errorContainer">
                    <span class="error-message"><?php echo $lrnError; ?></span>
                    <span class="error-close" onclick="closeError()"><i class="fa-solid fa-xmark"></i></span>
                </div>
                    <form action="" method="post">
                    <button class="btn" type="submit" name="submit">Add <i class="fa-solid fa-user-plus"></i></button>
                        <table class="table">
                            <tr>
                                <th class="th " colspan="5">LEARNER INFORMATION</th>
                            </tr>
                            <tr>
                                <td colspan="1">LAST NAME: 
                                    <input type="text" name="last_name" id="search" minlength="3" pattern="[A-Za-z\s]+" autocomplete="off"></td>
                                </td>
                                <td colspan="2">FIRST NAME:
                                    <input type="text" name="first_name" id="search" minlength="3" pattern="[A-Za-z\s]+" autocomplete="off"></td>
                                </td>
                                <td colspan="1">NAME EXT. (Jr, I, II): 
                                    <input type="text" name="name_ext" pattern="[A-Za-z\s]+" id="search" autocomplete="off"></td>
                                </td>
                                <td colspan="1">MIDDLE NAME:
                                    <input type="text" name="middle_name" id="search" minlength="3" pattern="[A-Za-z\s]+" autocomplete="off"></td>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Learner Reference Number (LRN):
                                    <input type="text" name="lrn" id="search" inputmode="numeric" pattern="[0-9]*" minlength="12" maxlength="12" autocomplete="off" required>
                                </td>
                                <td colspan="2">Birthdate (mm/dd/yyyy):
                                    <input class="birthdate" type="text" name="birth_date" id="search" maxlength="10" autocomplete="off" oninput="validateBirthdate(this)" value="<?php echo $birthd; ?>">
                                    <span class="birth-error" id="birthdateError"></span>
                                </td>
                                <td colspan="1">Gender: 
                                    <select name="gender" id="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
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
function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
</script>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>
