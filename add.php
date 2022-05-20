<?php 
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
    require "fungsi.php";
    


    if(isset($_POST["submit"])){
        
        if(add($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Data gagal ditambahkan!');
                    document.location.href = 'index.php';
                </script>
        ";
        }
        
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add data</title>
    <style>
        ul{
            list-style: none;
        }
    </style>
</head>
<body>
    <h1>Add data siswa</h1>

    <a href="index.php">Back to Table Data</a>

    <form action="" method="post" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="nama">Nama Siswa</label>
            <input type="text" name="nama" placeholder="Nama" id="nama" required autocomplete="off">
        </li>
        <li>
            <label for="nrp">Nomor Registrasi</label>
            <input type="text" name="nrp" placeholder="NRP" id="nrp" required autocomplete="off">
        </li>
        <li>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" id="email" required autocomplete="off">
        </li>
        <li>
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" placeholder="Jurusan" id="jurusan" required autocomplete="off">
        </li>
        <li>
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" id="gambar">
        </li>
        <li>
            <button type="submit" name="submit">Submit</button>
        </li>
    </ul>
    </form>
</body>
</html>