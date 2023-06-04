<?php 

include_once("connections/connection.php");
$con = connection();

if(isset($_POST['delete'])) {

    $id = $_POST['ID'];
    $sql = "DELETE FROM students_list_new WHERE id = '$id'";
    $con->query($sql) or die ($con->error);

    header("Location: new-list.php");
    exit;
}
