<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$userFile = file_get_contents("Data/users.txt");
$userData = explode("\n", $userFile);

if (isset($_POST["update_role"])) {
    $newRole = $_POST["role"];
    $userIndexToUpdate = (int)$_POST["update_role"];
    if ($newRole === "user" || $newRole === "admin") {
        $userInfo = explode(", ", $userData[$userIndexToUpdate]);
        $userInfo[0] = $newRole;
        $userData[$userIndexToUpdate] = implode(", ", $userInfo);
        $newUserData = implode("\n", $userData);
        file_put_contents("Data/users.txt", $newUserData);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete"])) {
        $userIndexToDelete = (int)$_POST["delete"];
        if ($userIndexToDelete >= 0 && $userIndexToDelete < count($userData)) {
            unset($userData[$userIndexToDelete]);
            $newUserData = implode("\n", $userData);
            file_put_contents("Data/users.txt", $newUserData);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
    $newRole = $_POST["newRole"];
    $newEmail = $_POST["newEmail"];
    $newPassword = $_POST["newPassword"];
    $newUsername = $_POST["newUsername"];

    if ($newRole === "user" || $newRole === "admin") {
        $newUser = "$newRole, $newEmail, $newPassword, $newUsername";
        $userData[] = $newUser;
        $newUserData = implode("\n", $userData);
        file_put_contents("Data/users.txt", $newUserData);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div class="container">

    <div class="d-flex justify-content-center flex-column align-items-center">
        <h1 class="text-center mb-3">Admin Panel</h1>
    </div>

    <div class="d-flex justify-content-center flex-column align-items-center">
        <h1 class="text-center mb-3">Welcome to Role Management System! <?php echo $_SESSION["username"]; ?></h1>
    </div>

    <div>
        <h2 class="text-center mb-3">Role: <?php echo $_SESSION["role"]; ?></h2>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Role</th>
                <th class="text-center">Email</th>
                <th class="text-center">Password</th>
                <th class="text-center">Username</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody class="text-center">
        <?php
        foreach ($userData as $userIndex => $user) {
            $userInfo = explode(", ", $user);

            echo "<tr>";
            foreach ($userInfo as $info) {
                echo "<td>$info</td>";
            }

            if ($_SESSION["role"] === "admin") {
                echo '<td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary update-button" data-index="' . $userIndex . '">Update</button>
                            <form method="post" class="update-dropdown" id="dropdown' . $userIndex . '" style="display: none;">
                                <select name="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <input type="hidden" name="update_role" value="' . $userIndex . '">
                                <button type="submit" class="btn btn-success" name="update">Save</button>
                            </form>
                            <form method="post">
                                <button type="submit" class="btn btn-danger" name="delete" value="' . $userIndex . '">Delete</button>
                            </form>
                        </div>
                    </td>';
            }
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <div>
        <button type="button" class="btn btn-success mb-3" id="showAddUserForm">Create User</button>
    </div>

    <!-- Create User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddUserModal">&times;</span>
            <h2>Create User</h2>
            <form action="admin.php" method="post">
                <div class="form-group">
                    <label for="newRole">Role:</label>
                    <select class="form-control" id="newRole" name="newRole">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="newEmail">Email:</label>
                    <input type="text" class="form-control" id="newEmail" name="newEmail" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">Password:</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="newUsername">Username:</label>
                    <input type="text" class="form-control" id="newUsername" name="newUsername" required><br>
                </div>
                <button type="submit" class="btn btn-success" name="addUser">Add</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the modal and close button elements
            var addUserModal = document.getElementById('addUserModal');
            var closeAddUserModal = document.getElementById('closeAddUserModal');

            // Get the "Create User" button
            var showAddUserFormButton = document.getElementById('showAddUserForm');

            // When the button is clicked, show the modal
            showAddUserFormButton.addEventListener('click', function () {
                addUserModal.style.display = 'block';
            });

            // When the close button is clicked or outside the modal is clicked, close the modal
            closeAddUserModal.addEventListener('click', function () {
                addUserModal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target === addUserModal) {
                    addUserModal.style.display = 'none';
                }
            });

            // Add code for handling the update button
            var updateButtons = document.querySelectorAll('.update-button');
            var updateDropdowns = document.querySelectorAll('.update-dropdown');

            for (var i = 0; i < updateButtons.length; i++) {
                updateButtons[i].addEventListener('click', function () {
                    var index = this.getAttribute('data-index');
                    updateDropdowns[index].style.display = 'block';
                });
            }
        });
    </script>

    <div class="d-flex justify-content-center mb-3">
        <form action="logout.php">
            <button type="submit" class="btn btn-secondary custom-logout-button">Logout</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
            crossorigin="anonymous"></script>
</body>
</html>