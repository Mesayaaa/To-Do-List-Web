<?php
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

// Initialize the error message variable
$error_message = '';

if (isset($_POST['register'])) {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $confirm_password = sanitize_input($_POST['confirm_password']);

    // Check if the username and password are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Username and password cannot be empty. Please enter both.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password and confirm password do not match. Please enter them again.";
    } else {
        // Check if the username already exists
        $check_sql = "SELECT * FROM users WHERE username = '{$username}'";
        $check_result = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Username already exists. Please choose a different username.";
        } else {
            $hashed_password = hash_password($password);

            // Ensure that the username is not empty before attempting to insert
            if (!empty($username)) {
                $sql = "INSERT INTO users (username, password) VALUES ('{$username}', '{$hashed_password}')";

                // Use mysqli_query and check for errors
                $result = mysqli_query($koneksi, $sql);

                if ($result) {
                    // Registration successful, redirect to login page
                    header("Location: login.php");
                    exit();
                } else {
                    // Handle registration failure
                    $error_message = "Registration failed. Error: " . mysqli_error($koneksi);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <!-- Display error message if it exists -->
        <?php if (!empty($error_message)) : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
            <input type="submit" value="Register" name="register">
        </form>
    </div>

</body>

</html>

<?php
mysqli_close($koneksi);
?>
