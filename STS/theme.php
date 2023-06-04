<?php
session_start(); // Start the session

// Check if a theme is selected
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'];

  // Store the selected theme in the session
    $_SESSION['theme'] = $theme;
}
?>