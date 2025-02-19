<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        
        </form>
    </div>
   
    <?php
    session_start(); 
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $conn = new mysqli('localhost', 'root', '', 'hotel');

       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
           
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            
           
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials');</script>";
        }

        $stmt->close();
        $conn->close();
    }
    
    ?>
</body>

</html>
