<?php

include_once("connections/connection.php");
$con = connection();

if(isset($_POST['delete'])) {

    $id = $_POST['ID'];

    // Delete from students_list_old
    $deleteStudentSql = "DELETE FROM students_list_old WHERE id = '$id'";
    $con->query($deleteStudentSql) or die ($con->error);

    // Delete from old_subjects_list
    $deleteSubjectsSql = "DELETE FROM old_subjects_list WHERE id = '$id'";
    $con->query($deleteSubjectsSql) or die ($con->error);

    header("Location: old-list.php");
    exit;
}