<?php

$userName = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$role = "user";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $existingUsers = file_get_contents("./Data/users.txt");

    if (empty($userName) || empty($email) || empty($password)) {
        $errorMessage = "All fields are required.";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email address. Please enter a valid email.";
    } else if (strpos($existingUsers, $email) !== false) {
        $errorMessage = "Email already exists. Please choose another email.";
    } else if (strpos($existingUsers, $userName) !== false) {
        $errorMessage = "Username already exists. Please choose another username.";
    } 
    elseif($email !="" && $password !="" && $userName !="") {
    
        $fp = fopen("./Data/users.txt", "a");
        fwrite($fp, "\n{$role}, {$email}, {$password}, {$userName}");
        fclose($fp);
        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>

<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport", content="width=device-width, initial-scale = 1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

    <div class="center-container">

        <div class="login-form">
        
            <div class="container mt-5">

        <h1 class="text-center">Create Your Account</h1>

    <form action="signup.php" method="POST">


    <div class="form-group">
        <label for="Username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" style="width: 250px;">
    </div>

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" style="width: 250px;">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="width: 250px;"><br>
    </div>

    <p class="text-warning">
        <?php echo $errorMessage;?>
    </p>

    <button type="submit" class="btn btn-warning custom-button">Sign Up</button>

    </form>
        
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    </body>
</html>