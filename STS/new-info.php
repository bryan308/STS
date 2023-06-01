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

    $sql = "SELECT * FROM students_list_new WHERE id = '$id'";
    $students = $con->query($sql) or die ($con->error);
    $row = $students->fetch_assoc();
} else {
    // Handle the case when 'ID' parameter is not set
    // For example, redirect to another page or display an error message
    header("Location: new-list.php");
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
                        <i class="fa-solid fa-table-list"></i><em> Students List</em>
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
                    <h1><?php echo $row['first_name']; ?><span>'s Information</span> <i class="fa-solid fa-circle-info"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                    <div class="table-controls">
                        <button class="btn"><a href="new-list.php"><i class="fa-solid fa-chevron-left"></i> Back</a></button>
                        <button class="btn"><a href="new-edit.php?ID=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a></button>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <tr>
                                <th class="th" colspan="8">LEARNER INFORMATION</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">LAST NAME: 
                                    <span class="value">
                                        <?php echo $row['last_name'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">FIRST NAME: 
                                    <span class="value">
                                        <?php echo $row['first_name'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">NAME EXT. (Jr, I, II): 
                                    <span class="value">
                                        <?php echo $row['name_ext'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">MIDDLE NAME:
                                    <span class="value">
                                        <?php echo $row['middle_name'] ?>
                                    </span> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bold-letter">Learner Reference Number (LRN):
                                    <span class="value">
                                        <?php echo $row['lrn'] ?>
                                    </span>
                                </td>
                                <td colspan="3" class="bold-letter">Birthdate (mm/dd/yyyy): 
                                    <span class="value">
                                        <?php echo $row['birth_date'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">Gender: 
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
                                <th class="th" colspan="8">ELIGIBILITY FOR JHS ENROLMENT</th>
                            </tr>
                            <tr>
                                <td colspan="3">Elementary School Completer:
                                    <input type="checkbox" name="">
                                </td>
                                <td colspan="3">General Average:
                                    <input type="text" name="" value="" readonly autocomplete="off">
                                <td colspan="2">Citation (If Any):

                                </td>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Name of Elem. Sch.: 
                                    <input type="text">
                                </td>
                                <td colspan="2">School ID:
                                    <input type="text">
                                </td>
                                <td colspan="3">Address Of School:
                                    <input type="text">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">Other Credential Presented:
                                    <input type="text">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"> 
                                    <input type="checkbox" name="">
                                    PEPT Passer 
                                </td>
                                <td colspan="1">Rating  :
                                    <input type="text">
                                </td>
                                <td colspan="2">
                                    <input type="checkbox" name="">
                                    ALS A & E Passer
                                </td>
                                <td colspan="1">Rating  :
                                    <input type="text">
                                </td>
                                <td colspan="2">
                                    <input type="checkbox" name="">
                                    Others (Pls. Specify)
                                    <input type="text">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">Date of Examination/Assessment(mm/dd/yyyy)  :
                                    <input type="text">
                                </td>
                                
                                <td colspan="4">Name of Address of Testing Center  :
                                    <input type="text">
                                </td>
                            </tr>
                            <tr>
                                <th class="th" colspan="8">SCHOLASTIC RECORD    </th>
                            </tr>
                            <tr>
                                <td colspan="2">School: 
                                    <input type="Text">                         
                                </td>
                                <td colspan="1">School ID:
                                    <input type="text">
                                </td>
                                <td colspan="2">District:
                                    <input type="Text">
                                </td>
                                <td colspan="2">Division  :
                                    <input type="text">
                                </td>
                                <td colspan="1">Region  :
                                    <input type="text">
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Classified as Grades: 
                                        <input type="Text">                         
                                    </td>
                                    <td colspan="2">Section:
                                        <input type="text">
                                    </td>
                                    <td colspan="1">School Year:
                                        <input type="Text">
                                    </td>
                                    <td colspan="2">Name of Adviser/Teacher :
                                        <input type="text">
                                    </td>
                                    <td colspan="1">Signature:
                                        <input type="text">
                                    </td>
                                </tr>
                                    <tr>
                                    <td rowspan="2" colspan="2">
                                        Learning Areas 
                                    </td>
                                    <td colspan="4">
                                        Quarterly Rating 
                                    </td>
                                    <td rowspan="2" >
                                        Final Rating 
                                    </td>
                                    <td rowspan="2"> Remarks:
                                    
                                    </td>
                                <tr>
                                    <td>
                                        1 
                                    </td>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        3
                                    </td>
                                    <td>
                                        4 
                                    </td>
                                </tr>
                                <tr>
                                    <td  colspan="2">
                                        
                                        Filipino
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        English
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Mathematics
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Science
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Araling Panlipunan(AP)
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Edukasyon sa Pagpapakatao(EsP)
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Technology And Livelyhood Education(TLE)
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        MAPEH
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        music
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        arts
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        P.E
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Health
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    </td>
                                    <td colspan="4">
                                        General Average
                                    </td>
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="th" colspan="8  "> </th>
                                </tr>
                                <tr>
                                    <td colspan="1">Remedial Classes:                         
                                    </td>
                                    <td colspan="4">Conducted from(mm/dd/yyyy):
                                        <input type="text">
                                    </td>
                                    <td colspan="3">to (mm/dd/yyyy):
                                        <input type="Text">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Learning Areas : 
                                        <input type="Text">                         
                                    </td>
                                    <td colspan="1" >Final Rating:
                                        <input type="text">
                                    </td>
                                    <td colspan="2" >Remedial Class Mark:
                                        <input type="Text">
                                    </td>
                                    <td colspan="2">Recomputed Final Grade:
                                        <input type="text">
                                    </td>
                                    <td colspan="1" >Remarks  :
                                        <input type="text">
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="2">  
                                        <input type="Text">                         
                                    </td>
                                    <td colspan="1" >
                                        <input type="text">
                                    </td>
                                    <td colspan="2" >
                                        <input type="Text">
                                    </td>
                                    <td colspan="2">
                                        <input type="text">
                                    </td>
                                    <td colspan="1" >
                                        <input type="text">
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="2">  
                                        <input type="Text">                         
                                    </td>
                                    <td colspan="1" >
                                        <input type="text">
                                    </td>
                                    <td colspan="2" >
                                        <input type="Text">
                                    </td>
                                    <td colspan="2">
                                        <input type="text">
                                    </td>
                                    <td colspan="1" >
                                        <input type="text">
                                </td>
                                </tr>
                                <tr>
                                    <th class="th" colspan="8  "> </th>
                                </tr>
                                <tr>
                                    <th class="th" colspan="8  "> </th>
                                </tr>

                                <tr>
                                    <th class="th" colspan="8">   </th>
                                </tr>
                                <tr>
                                    <td colspan="2">School: 
                                        <input type="Text">                         
                                    </td>
                                    <td colspan="1">School ID:
                                        <input type="text">
                                    </td>
                                    <td colspan="2">District:
                                        <input type="Text">
                                    </td>
                                    <td colspan="2">Division  :
                                        <input type="text">
                                    </td>
                                    <td colspan="1">Region  :
                                        <input type="text">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Classified as Grades: 
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="2">Section:
                                            <input type="text">
                                        </td>
                                        <td colspan="1">School Year:
                                            <input type="Text">
                                        </td>
                                        <td colspan="2">Name of Adviser/Teacher :
                                            <input type="text">
                                        </td>
                                        <td colspan="1">Signature:
                                            <input type="text">
                                        </td>
                                    </tr>
                                        <tr>
                                        <td rowspan="2" colspan="2">
                                            Learning Areas 
                                        </td>
                                        <td colspan="4">
                                            Quarterly Rating 
                                        </td>
                                        <td rowspan="2" >
                                            Final Rating 
                                        </td>
                                        <td rowspan="2"> Remarks:
                                        
                                        </td>
                                    <tr>
                                        <td>
                                            1 
                                        </td>
                                        <td>
                                            2
                                        </td>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            4 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  colspan="2">
                                            
                                            Filipino
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            English
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Mathematics
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Science
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Araling Panlipunan(AP)
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Edukasyon sa Pagpapakatao(EsP)
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Technology And Livelyhood Education(TLE)
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            MAPEH
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            music
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            arts
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            P.E
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Health
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        </td>
                                        <td colspan="4">
                                            General Average
                                          </td>
                                          <td>
                                            <input type="text">
                                          </td>
                                          <td>
    
                                          </td>
                                    </tr>
                                    <tr>
                                        <th class="th" colspan="8  "> </th>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Remedial Classes:                         
                                        </td>
                                        <td colspan="4">Conducted from(mm/dd/yyyy):
                                            <input type="text">
                                        </td>
                                        <td colspan="3">to (mm/dd/yyyy):
                                            <input type="Text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Learning Areas : 
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="1" >Final Rating:
                                            <input type="text">
                                        </td>
                                        <td colspan="2" >Remedial Class Mark:
                                            <input type="Text">
                                        </td>
                                        <td colspan="2">Recomputed Final Grade:
                                            <input type="text">
                                        </td>
                                        <td colspan="1" >Remarks  :
                                            <input type="text">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">  
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="1" >
                                            <input type="text">
                                        </td>
                                        <td colspan="2" >
                                            <input type="Text">
                                        </td>
                                        <td colspan="2">
                                            <input type="text">
                                        </td>
                                        <td colspan="1" >
                                            <input type="text">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">  
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="1" >
                                            <input type="text">
                                        </td>
                                        <td colspan="2" >
                                            <input type="Text">
                                        </td>
                                        <td colspan="2">
                                            <input type="text">
                                        </td>
                                        <td colspan="1" >
                                            <input type="text">
                                    </td>
                                    </tr>
                                    <tr>
                                        <th class="th" colspan="8  "> </th>
                                    </tr>
                                    <tr>
                                        <th class="th" colspan="8  "> </th>
                                    </tr>
                                    <tr>
                                    <th class="th" colspan="8">Certification   </th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">  I CERTIFY that this is a true record of 
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="2" > with LRN
                                            <input type="text">
                                        </td>
                                        <td colspan="3" > and that he/she is eligible for admission to Grade 
                                            <input type="Text">
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td colspan="3">  Name of School:
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="2" > School ID:
                                            <input type="text">
                                        </td>
                                        <td colspan="3" > Last School Year Attended: 
                                            <input type="Text">
                                        </td>  
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td colspan="3">  Date
                                            <input type="Text">                         
                                        </td>
                                        <td colspan="3" > Signature of Principal/School Head over Printed Name:
                                            <input type="text">
                                        </td>
                                        <td colspan="2" > (Affix School Seal Here): 
                                            <input type="Text">
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