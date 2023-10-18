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
            flex-direction: column;
        }

        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
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

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
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
