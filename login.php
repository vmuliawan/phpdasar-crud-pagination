<?php 
    session_start();

    require 'fungsi.php';

    //cek cookie
    if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        // ambil username berdasarkan id
        $result = mysqli_query($db,"SELECT username FROM user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        //cek cookie dengan username
        if($key === hash('joaat',$row['username'])){
            $_SESSION['login'] = true;
        }

    }

    if(isset($_SESSION["login"])){
        header("Location: index.php");
        exit;
    }


    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $result = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");

        // cek username
        if(mysqli_num_rows($result) === 1){

            // cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password,$row['password'])){
                // cek session
                $_SESSION["login"] = true;

                //cek remember me
                if(isset($_POST["remember"])){
                    // buat cookie
                    setcookie('id',$row['id'],time()+60);
                    setcookie('key',hash('joaat',$row['username']),time()+60);

                }

                header('Location: index.php');
                exit;     
            }
        }
        // jika username/password salah
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman login</h1>

    <?php if(isset($error)) : ?>
        <h3 style="color: red;">Username/Password yang dimasukan salah!</h3>
        <?php endif;?>

    <form action="" method="post">
    <ul style="list-style: none;">
        <li>
            <label for="username">Username</label>
            <input type="text" placeholder="Username" name="username" id="username" autofocus autocomplete="off" required>
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" required>
        </li>
        <li>
            <label for="remember">Keep me signed in</label>
            <input type="checkbox" name="remember" id="remember">
        </li>
        <li>
            <button type="submit" name="login">Login</button>
        </li>
    </ul>
    </form>
</body>
</html>