<?php

if (!isset($_SESSION)) {
    session_start();
}

// echo "<div style='text-align: center;'>";
// if (isset($_SESSION['UserLogin'])) {
//     echo "Welcome " . $_SESSION['UserLogin'];
// } else {
//     echo "Welcome Guest";
// }
// echo "</div>";

include_once("connections/connection.php");
$con = connection();
$search = $_GET['search'];

if ($search != '') {
    $sql = "SELECT * FROM students_list_old WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' ORDER BY id DESC";
    $students = $con->query($sql) or die($con->error);
    $row = $students->fetch_assoc();
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
                    <h1>Students List <i class="fa fa-list"></i></h1>
                    <hr class="section-divider">
                </div> 
                <div class="main-content">
                    <div class="table-controls">
                        <div class="search-tab">
                        <form class="search-form" action="old-result.php" method="get">
                            <label for="search">
                                <input placeholder="search student" type="text" name="search" id="searchstu" autocomplete="off" minlength="3" maxlength="15" value="<?php echo $_GET['search'] ?>">
                                <button type="submit" class="icon">
                                    <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="swap-on">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linejoin="round" stroke-linecap="round"></path>
                                    </svg>
                                    <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="swap-off">
                                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linejoin="round" stroke-linecap="round"></path>
                                    </svg>
                                </button>
                            </label>
                        </form>
                        </div>
                        <div class="table-con-action">
                        <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                            <button class="btn">
                                <a class="add" href="old-add.php">Add <i class="fa-solid fa-user-plus"></i></a>
                            </button>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="table-container">
                    <table class="table">
                        <tr>
                            <th class="th hlrn">Last name</th>
                            <th class="th hlname">First name</th>
                            <th class="th hfname">Middle name</th>
                            <th class="th hmname">Birth Date</th>
                            <th class="th hmname">School Year</th>
                            <th class="th hgender">Gender</th>
                            <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                                <th class="th hdetails">Details</th>
                            <?php } ?>
                        </tr>
                        <?php if ($search != '') { 
                            if ($students->num_rows > 0) {
                                do { ?>
                                    <tr>
                                        <td class="td "><?php echo $row['last_name']; ?></td>
                                        <td class="td "><?php echo $row['first_name']; ?></td>
                                        <td class="td "><?php echo $row['middle_name']; ?></td>
                                        <td class="td "><?php echo $row['date_of_birth']; ?></td>
                                        <td class="td tdcenter"><?php echo $row['school_year']; ?></td>
                                        <td class="td tdcenter"><?php echo $row['gender']; ?></td>
                                        <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration"): ?>
                                            <td class="td view rdetails">
                                                <a href="old-info.php?ID=<?php echo $row['id']; ?>">View</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php } while ($row = $students->fetch_assoc());
                            } else {
                                if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") {
                                    echo "<tr><td colspan='7' style='text-align: center;'>No records found. <i class='fa-solid fa-triangle-exclamation' style='color: orange;'></i></td></tr>";
                                } else {
                                    echo "<tr><td colspan='5' style='text-align: center;'>No records found. <i class='fa-solid fa-triangle-exclamation' style='color: orange;'></i></td></tr>";
                                }
                            }
                        } else {
                            if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") {
                                echo "<tr><td colspan='7' style='text-align: center;'>No records found. <i class='fa-solid fa-triangle-exclamation' style='color: orange;'></i></td></tr>";
                            } else {
                                echo "<tr><td colspan='5' style='text-align: center;'>No records found. <i class='fa-solid fa-triangle-exclamation' style='color: orange;'></i>></td></tr>";
                            }
                        } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>
