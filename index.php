<?php 
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }

    require 'fungsi.php';  

    //ambil data dari table siswa
    $jumlahDatahalaman = 3;
    $jumlahData = count(query("SELECT * FROM siswa"));
    $pagination = ceil($jumlahData / $jumlahDatahalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
    $awalData = ($jumlahDatahalaman * $halamanAktif) - $jumlahDatahalaman;

    $siswa = query("SELECT * FROM siswa LIMIT $awalData,$jumlahDatahalaman");



    //jika tombol cari di tekan
    if(isset($_POST["search"])){
        $siswa = cari($_POST["cari"]);

    }

    //ambil data dari siswa object result
    //mysqli_fetch_row() //mengembalikan array numeric
    //mysqli_fetch_assoc() //mengembalikan array associative
    //mysqli_fetch_array() //mengembalikan array numeric dan associative, kekurangan data yang dikembalikan double
    //mysqli_fetch_object() //

    // while ($sis = mysqli_fetch_assoc($result)){
    // var_dump($sis);
    // }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <a href="logout.php">logout</a>
    <h1>Daftar Siswa</h1>

    <a href="add.php">Add data</a>
    <br><br>

    <form action="" method="post">
        <label for="cari">Search</label>
        <input type="text" name="cari" id="cari" placeholder="Search" size="25" autofocus autocomplete="off">
        <button type="submit" name="search">Cari</button>
    </form>
    <br>

    <?php if($halamanAktif != 1) : ?>
        <a href="?halaman=<?= $halamanAktif ?>" style="margin-right: 3px">&lt;&lt;</a>
    <?php endif; ?>    
    
    <?php if($halamanAktif > 1) : ?>
        <a href="?halaman=<?= $halamanAktif - 1 ?>">&lt;</a>
    <?php endif; ?>

    <!-- navigasi -->
    <?php for($a = 1; $a <= $pagination; $a++) : ?>
        <?php if($a == $halamanAktif) : ?>
            <a href="?halaman=<?= $a; ?>" style="color: red; font-style: bold; font-size: 20px;"><?= $a; ?></a>
        <?php else :?>
            <a href="?halaman=<?= $a; ?>"><?= $a; ?></a>
        <?php endif;?>    
    <?php endfor;?>
    
    <?php if($halamanAktif < $pagination) : ?>        
    <a href="?halaman=<?= $halamanAktif + 1 ?>">&gt;</a>
    <?php endif; ?>

    <?php if($halamanAktif != $pagination) : ?>
        <a href="?halaman=<?= $pagination ?>" style="margin-left: 3px">&gt;&gt;</a>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Action</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
            <th>Gambar</th>
        </tr>

        <?php $i = 1 + $awalData;?>
        <?php foreach($siswa as $sis) : ?>
        <tr>
            <td><?= $i?></td>
            <td><a href="ubah.php?id=<?= $sis["id"]?>">Edit</a> | <a href="hapus.php?id=<?= $sis["id"];?>" onclick="return confirm('yakin?')">Delete</a></td>
            <td><?= $sis['nrp'];?></td>
            <td><?= $sis['nama'];?></td>
            <td><?= $sis['email'];?></td>
            <td><?= $sis['jurusan'];?></td>
            <td><img src="img/<?= $sis['gambar']?>" alt="not found"></td>
        </tr>
        <?php $i++;?>
        <?php endforeach;?>
    </table>
</body>
</html>