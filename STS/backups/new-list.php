<?php
session_start();

if (!isset($_SESSION['UserLogin'])) {
    header("Location: login.php");
    exit();
}

include_once("connections/connection.php");

// Establish the database connection
$con = connection();

$sql = "SELECT * FROM students_list_new ORDER BY id DESC";
$students = $con->query($sql) or die ($con->error);
$row = $students->fetch_assoc();
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
    <style>
        .empty-birthdate {
            background: #ff8b8f;
        }
    </style>
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
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li>
                <a href="new-list.php" target="_self">
                    <i class="fa-solid fa-table-list"></i>  Students List New
                </a>
            </li>
            <li>
                <a href="old-list.php" target="_self">
                    <i class="fa-solid fa-table-list"></i> Students List Old
                </a>
            </li>
            <li>
                <a href="settings.php" target="_self">
                    <i class="fa-solid fa-gear"></i> Settings
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
                    <h1>Students List <i class="fa-regular fa-rectangle-list"></i>(New Curriculum)</h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                <div class="table-controls">
                <div class="search-tab">

                <form class="search-form" action="new-result.php" method="get">
                    <label for="search">
                        <input placeholder="search student" type="text" name="search" id="searchstu" autocomplete="off" minlength="3" maxlength="15" required>
                        <button type="submit" class="icon">
                            <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="swap-on">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linejoin="round" stroke-linecap="round"></path>
                            </svg>
                            <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="swap-off">
                                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linejoin="round" stroke-linecap="round"></path>
                            </svg>
                        </button>
                        <button type="reset" class="close-btn">
                            <svg viewBox="0 0 20 20" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" fill-rule="evenodd"></path>
                            </svg>
                        </button>
                    </label>
                </form>

                </div>
                    <div class="table-con-action">
                    <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                        <button class="btn">
                            <a class="add" href="new-add.php">Add <i class="fa-solid fa-user-plus"></i></a>
                        </button>
                    <?php } ?>
                    </div>
                        </div>
                        <div class="table-container">
                            <table class="table">
                                <tr class="table-headers">
                                    <th class="th hlrn">LRN</th>
                                    <th class="th hlname">Last name</th>
                                    <th class="th hfname">First name</th>
                                    <th class="th hmname">Middle name</th>
                                    <th class="th ">Birthdate</th>
                                    <th class="th hgender">Gender</th>
                                    <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                                        <th class="th hdetails">Details</th>
                                <?php } ?>
                                </tr>
                                    <?php do { ?>
                                    <tr class="row-list">
                                        <td class="td rlrn"><?php echo $row['lrn']; ?></td>
                                        <td class="td rlname"><?php echo $row['last_name']; ?></td>
                                        <td class="td rfname"><?php echo $row['first_name']; ?></td>
                                        <td class="td rmname"><?php echo $row['middle_name']; ?></td>
                                        <td class="td <?php if (empty($row['birth_date'])) echo 'empty-birthdate'; ?>"><?php echo $row['birth_date']; ?></td>
                                        <td class="td rgender"><?php echo $row['gender']; ?></td>
                                        <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                                            <td class="td view rdetails">
                                                <a href="new-info.php?ID=<?php echo $row['id']; ?>">View</a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } while ($row = $students->fetch_assoc()) ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
<script src="js/clock.js"></script>
<script src="js/theme.js"></script>
<script src="js/script.js"></script>
</html>
