<?php 

include_once("connections/connection.php");
$con = connection();

if(isset($_POST['delete'])) {

    $id = $_POST['ID'];
    $sql = "DELETE FROM students_list WHERE id = '$id'";
    $con->query($sql) or die ($con->error);

    header("Location: index.php");
    exit;
}