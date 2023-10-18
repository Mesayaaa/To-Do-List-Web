<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

function sanitize_input($input)
{
    global $koneksi;
    return mysqli_real_escape_string($koneksi, $input);
}

function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in()
{
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '{$username}'";
    $result = mysqli_query($koneksi, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: todo.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Login failed. Please check your username and password.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column; /* Updated to column */
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-bottom: 20px; /* Add margin to the login container */
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], .register-button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover, .register-button:hover {
            background-color: #45a049;
        }

        .register-button {
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php
    // Display login error message if it exists
    if (isset($_SESSION['login_error'])) {
        echo "<p style='color: red; text-align: center;'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']); // Clear the error message
    }
    ?>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login" name="login">
        </form>
        <a href="register.php" class="register-button">Register</a>
    </div>

</body>

</html>

<?php
mysqli_close($koneksi);
?>
