<?php
session_start();

if (!isset($_SESSION['UserLogin'])) {
    header("Location: login.php");
    exit();
}

include_once("connections/connection.php");
$con = connection();


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
                <a href="login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Log In</a>
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
                <h1>Settings <i class="fa fa-gear"></i></h1>
                <hr class="section-divider">
            </div>
        <div class="settings-container">
            <div class="settings-table-head">
                <h3 class="setting-head">Color Themes <i class="fa-solid fa-brush"></i>
                </h3>
                <hr class="setting-divider">
            </div>
            <div class="theme-container">
                <div class="theme-controls">
                    <div class="container">
                    <form class="theme-radio">
                        <label>
                            <input class="radio" type="radio" name="radio" value="default" checked>
                            <span>
                            <div class="radio-color-grid">
                                <div class="default-color"></div>
                                <div class="default-color"></div>
                                <div class="default-color"></div>
                                <div class="default-color"></div>
                            </div>
                            </span>
                        </label>
                        <label>
                            <input class="radio" type="radio" name="radio" value="blue">
                            <span>
                            <div class="radio-color-grid">
                                <div class="blue-color"></div>
                                <div class="blue-color"></div>
                                <div class="blue-color"></div>
                                <div class="blue-color"></div>
                            </div>
                            </span>
                        </label>
                        <label>
                            <input class="radio" type="radio" name="radio" value="dark">
                            <span>
                            <div class="radio-color-grid">
                                <div class="dark-color"></div>
                                <div class="dark-color"></div>
                                <div class="dark-color"></div>
                                <div class="dark-color"></div>
                            </div>
                            </span>
                        </label>
                        </form>
                    </div>
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