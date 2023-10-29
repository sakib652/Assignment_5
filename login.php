<?php

session_start();

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$errorMessage = "";

$fp = fopen("./Data/users.txt","r");

$roles = array();
$emails= array();
$passwords = array();
$userNames = array();

while($line = fgets($fp)){
    $values = explode(",",$line);

    array_push($roles,trim($values[0]));
    array_push($emails,trim($values[1]));
    array_push($passwords,trim($values[2]));
    array_push($userNames,trim($values[3]));
}

for($i=0; $i<count($roles); $i++){
    
    if($email == $emails[$i] && $password == $passwords[$i]){
        $_SESSION["role"] = $roles[$i];
        $_SESSION["email"] = $emails[$i];
        $_SESSION["username"] = $userNames[$i];
        
        header("Location: index.php");
        exit();
    }    
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorMessage = "Invalid email or password";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["remember"])) {
            setcookie("email", $_POST["email"], time() + 3600);
            setcookie("password", $_POST["password"], time() + 3600);
            echo "Cookies Set Successfully";
        } else {
            echo "Cookies Not Set";
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

        <h1 class="text-center">Login to Your Account</h1>

    <form action="login.php" method="POST">

    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" style="width: 250px;" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="width: 250px;" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
    </div>

    <div class="form-group form-check mt-1">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
    </div>

    <p class="text-warning">
        <?php echo $errorMessage;?>
    </p>

    <button type="submit" class="btn btn-primary custom-login-button">Login</button>

    </form>

    <p style="text-align: center; margin: 0 auto; display: table; margin-left: 10px; margin-right: 10px;">Don't have an account?<a href="signup.php">Sign Up</a></p>
        
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    </body>
</html>