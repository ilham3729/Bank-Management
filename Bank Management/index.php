<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>Bank Management System</title>
</head>
<body>
    
    <h1>
        <span class="mb-5">
            <img src="./images/nsu.png" alt="NSU Logo" id="nsu-img">
        </span>
            Welcome To 
        <span id="nsu">NSU Central Bank</span>
    </h1>
    <div class="container ml-5">
        <h2 id="loginMessage">Please Login</h2>
        <?php 
        if(isset($_GET["message"])){
            echo "<h4 class='text-danger'>".$_GET["message"]."</h4>";
        }
        ?>
        <form action="Controller/userLogin.php" method="post">
            <label for="username">Email:</label>
            <input type="text" name="username" id="username">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <input type="submit" name="login" value="Login">
        </form>
        <br>
        <a href="Views/register.php" class="btn btn-primary">Register</a>
    </div>
</body>
</html>