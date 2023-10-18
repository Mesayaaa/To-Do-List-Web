<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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

        .choice-container {
            display: flex;
            justify-content: space-around;
            width: 300px;
        }

        .choice-button {
            padding: 10px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h2>Welcome bangg</h2>
    <div class="choice-container">
        <a href="register.php" class="choice-button">Register</a>
        <a href="login.php" class="choice-button">Login</a>
    </div>
</body>

</html>
