<?php

session_start();

if(!isset($_SESSION["role"]) || $_SESSION["role"] != "user"){
    header("Location: login.php");
}

?>

<!DOCTYPE html>

<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport", content="width=device-width, initial-scale = 1.0">
        <title>User Panel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>

    <body>

    <div class="container mt-5 d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <h1>User Panel</h1>
            <h1>Welcome to Role Management System! <?php echo $_SESSION["username"]; ?></h1>
            <h2>Role: <?php echo $_SESSION["role"];?></h2>
            <form action="logout.php">
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </div>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    
    </body>
</html>