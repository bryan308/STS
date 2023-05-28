<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

$error = "";

if(isset($_POST['login'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_list WHERE username = '$username' AND password = '$password'";
    $user = $con->query($sql) or die ($con->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;

    if ($total > 0) {
        $_SESSION['UserLogin'] = $row['username'];
        $_SESSION['Access'] = $row['access'];
        
        header("Location: index.php");
        exit();

    }else{
        $error = "No User found!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Students Transcripts System</title>
</head>

<body>

<!-- <div class="login-body">
    <div class="login-card">
        <div class="card-header">
            <div class="log">Login</div>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input required="" name="username" id="username" type="text">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input required="" name="password" id="password" type="password">
            </div>
                <div class="form-group">
                <button value="Login" name="login" type="submit">Log In</button>
            </div>
        </form>
    </div>
</div> -->

<div class="form-wrapper">

    <div class="main">  	
        <input type="checkbox" id="chk" aria-hidden="true">

			<div class="login">
				<form class="form" method="post">
					<label class="login-text" for="chk" aria-hidden="true">Log in</label>
                        <label class="label" for="username">Username:</label>
                        <input class="input" required="" name="username" id="username" type="text">
                        <label class="label" for="password">Password:</label>
                        <input class="input" required="" name="password" id="password" type="password">
                    <button value="login" name="login" type="submit">Log In</button>
				</form>
			</div>

        <div class="register">
				<form class="form">
					<label class="register-text" for="chk" aria-hidden="true">Register</label>
					<label class="label" for="username">Username:</label>
                    <input required="" name="username" id="username" type="text">
                    <label class="label" for="password">Password:</label>
                    <input required="" name="password" id="password" type="password">
					<button>Register</button>
				</form>
			</div>
        </div>
    </div>
        
    <div class="error-container<?php echo !empty($error) ? ' active' : ''; ?>" id="errorContainer">
        <span class="error-message"><?php echo $error; ?></span>
        <span class="error-close" onclick="closeError()"><span class="material-symbols-outlined">close</span></span>
    </div>

</body>
<script>
    function closeError() {
        var errorContainer = document.getElementById("errorContainer");
        errorContainer.classList.remove("active");
    }
</script>
<script src="js/script.js"></script>
</html>