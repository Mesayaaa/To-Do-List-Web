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
    <link rel="stylesheet" href="style.css">
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
