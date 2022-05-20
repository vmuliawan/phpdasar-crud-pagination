<?php 
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }

    require "fungsi.php";

    if(isset($_POST["submit"])){
        if(registrasi($_POST) > 0){
            echo "<script>
                  alert('User baru berhasil ditambahkan');
                  </script>";
        }else{
            echo mysqli_error($db);
        };
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>

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
                <label for="confirm">Confirm Password</label>
                <input type="password" placeholder="Confirm" name="confirm" id="confirm" required>
            </li>
            <li>
                <button type="submit" name="submit">Buat Akun</button>
            </li>
        </ul>
    </form>
</body>
</html>