<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        if(isset($_SESSION['user'])){
            echo '<h3>Welcome '. $_SESSION['user']. '!</h3>';
        }
        ?>
        <form action="authenticate.php" method="POST">
            Username: <input type="text" name="user"><br>
            Password: <input type="password" name="pwd"><br>
            <input type="submit" value='Login'>
        </form>
        <a href="register.php">Register a New User</a>
        <p>
            <?php
            if(isset($_SESSION['user'])){
                
                echo '<a href="games.php">UNA NCAA Championship Season</a>';
            }
            ?>
    </body>
</html>
