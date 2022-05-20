<?php 
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }

    require "fungsi.php";
    
//ambil data di url
$id = $_GET["id"];

$data = query("SELECT * FROM siswa WHERE id = $id")[0];   

    if(isset($_POST["submit"])){    
        
        if(ubah($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Data gagal diubah!');
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
    <title>Edit data</title>
    <style>
        ul{
            list-style: none;
        }
    </style>
</head>
<body>
    <h1>Edit data siswa</h1>

    <a href="index.php">Back to Table Data</a>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data["id"]?>">
        <input type="hidden" name="gambarLama" value="<?= $data["gambar"]?>">
    <ul>
        <li>
            <label for="nama">Nama Siswa</label>
            <input type="text" name="nama" placeholder="Nama" id="nama" required autocomplete="off" value="<?= $data["nama"]?>">
        </li>
        <li>
            <label for="nrp">Nomor Registrasi</label>
            <input type="text" name="nrp" placeholder="NRP" id="nrp" required autocomplete="off" value="<?= $data["nrp"]?>">
        </li>
        <li>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" id="email" required autocomplete="off" value="<?= $data["email"]?>">
        </li>
        <li>
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" placeholder="Jurusan" id="jurusan" required autocomplete="off" value="<?= $data["jurusan"]?>">
        </li>
        <li>
            <label for="gambar">Gambar</label> <br>
            <img src="img/<?= $data["gambar"];?>" alt="not found" width="50"> <br>
            <input type="file" name="gambar" placeholder="Gambar" id="gambar">
        </li>
        <li>
            <button type="submit" name="submit">Save</button>
        </li>
    </ul>
    </form>
</body>
</html>