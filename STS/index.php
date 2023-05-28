<?php

session_start();

if (!isset($_SESSION['UserLogin'])) {
    header("Location: login.php");
    exit();
}

include_once("connections/connection.php");
$con = connection();

$sql = "SELECT * FROM students_list ORDER BY id DESC";
$students = $con->query($sql) or die ($con->error);
$row = $students->fetch_assoc();
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
                <a href="#0">
                    <i class="fa fa-home"></i><em> Home</em>
                </a>
            </li>
            <li>
                <a href="index.php" target="_self">
                    <i class="fa fa-list"></i><em> Students List</em>
                </a>
            </li>
            <li>
                <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                    <a href="login.php">Log out</a>
                <?php } elseif(isset($_SESSION['Access']) && $_SESSION['Access'] == "guest") { ?>
                    <a href="login.php">Log out</a>
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
                    <h1>Students List <i class="fa fa-list"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                <div class="table-controls">
                <div class="search-tab">
                    <form action="result.php" method="get">
                        <input type="text" name="search" id="searchstu" autocomplete="off" minlength="3" maxlength="20" required>
                        <button class="btn" type="submit">Search</button>
                    </form>
                </div>
                    <div class="table-con-action">
                    <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                        <button class="btn"><a class="add" href="add.php">Add <i class="fa fa-plus"></i></a></button>
                    <?php } ?>
                    </div>
                        </div>
                        <div class="table-container">
                        <table>
                            <tr class="table-headers">
                                <th class="th hlrn">LRN</th>
                                <th class="th hlname">Last name</th>
                                <th class="th hfname">First name</th>
                                <th class="th hmname">Middle name</th>
                                <th class="th hgender">Gender</th>
                                <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                                    <th class="th hdetails">Details</th>
                                <?php } ?>
                            </tr>
                            <?php do { ?>
                                <tr>
                                    <td class="td rlrn"><?php echo $row['lrn']; ?></td>
                                    <td class="td rlname"><?php echo $row['last_name']; ?></td>
                                    <td class="td rfname"><?php echo $row['first_name']; ?></td>
                                    <td class="td rmname"><?php echo $row['middle_name']; ?></td>
                                    <td class="td rgender"><?php echo $row['gender']; ?></td>
                                    <?php if (isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                                        <td class="td rdetails">
                                            <button class="btn-view">
                                            <a href="info.php?ID=<?php echo $row['id']; ?>">View</a>
                                            </button>
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
<script src="js/script.js"></script>
</html>