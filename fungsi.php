<?php 
    $db = mysqli_connect("localhost","root","","phpdasar");

    function query($query){
        global $db;
        $result = mysqli_query($db, $query);
        $wadah = [];

        while($tempat = mysqli_fetch_assoc($result)){
            $wadah[] = $tempat;
        }
        return $wadah;
    }

    function add($add){
        global $db;

        $nama = htmlspecialchars($add["nama"]);
        $nrp = htmlspecialchars($add["nrp"]);
        $email = htmlspecialchars($add["email"]);
        $jurusan = htmlspecialchars($add["jurusan"]);
        //upload gambar
        $gambar = upload();
        if(!$gambar){
            return false;
        }

        $data = "INSERT INTO siswa VALUES('','$nama','$nrp','$email','$jurusan','$gambar')";

        mysqli_query($db, $data);

        
        return mysqli_affected_rows($db); 
    }

    function upload(){

        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        //cek apakah tidak ada gambar yang diupload
        if($error === 4){
            echo "<script>
                    alert('Butuh Gambar untuk data!');
                 </script>";
                 return false;
        }

        //cek apakah yang diupload merupakan ekstensi gambar
        $gambarValid = ['jpg','jpeg','png'];
        $ekstensiGambar = explode('.',$namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if(!in_array($ekstensiGambar, $gambarValid)){
            echo "<script>
                    alert('File yang anda upload bukan Gambar!');
                 </script>";
                 return false;
        }

        //cek ukuran file yang diupload
        if($ukuranFile > 1500000){
            echo "<script>
                    alert('Ukuran file terlalu besar (batas ukuran 1MB)');
                 </script>";
                 return false;
        }

        //generate nama file baru
        $namaBaru = uniqid();
        $namaBaru .= '.';
        $namaBaru .= $ekstensiGambar; 

        //lolos pengecekan, gambar siap dipindahkan
        move_uploaded_file($tmpName, 'img/' . $namaBaru);

        return $namaBaru;
    }

    function hapus($id){
        global $db;
        $del = "DELETE FROM siswa WHERE id = $id";
        mysqli_query($db, $del);
        return mysqli_affected_rows($db);
    }

    function ubah($ubah){
        global $db;

        $id = $ubah["id"];
        $nama = htmlspecialchars($ubah["nama"]);
        $nrp = htmlspecialchars($ubah["nrp"]);
        $email = htmlspecialchars($ubah["email"]);
        $jurusan = htmlspecialchars($ubah["jurusan"]);
        $gambarLama = htmlspecialchars($ubah["gambarLama"]);
        
        //cek apakah gambar di update
        if($_FILES['gambar']['error'] === 4 ){
            $gambar = $gambarLama;
        }else{
            $gambar = upload();
        }
        

        $data = "UPDATE siswa SET
                    nama = '$nama',
                    nrp = '$nrp',
                    email = '$email',
                    jurusan = '$jurusan',
                    gambar = '$gambar'

                    WHERE id = $id;
                ";

        mysqli_query($db, $data);

        
        return mysqli_affected_rows($db); 

    }

    function cari($cari){
        $query = "SELECT * FROM SISWA WHERE 
                  nama LIKE '%$cari%' OR
                  nrp LIKE '%$cari%' OR
                  email LIKE '%$cari%' OR
                  jurusan LIKE '%$cari%'
                  ";
        return query($query);
    }

    function registrasi($data){
        global $db;

        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($db,$data["password"]);
        $confirm = mysqli_real_escape_string($db,$data["confirm"]);

        //cek username yang sama
        $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");
        if(mysqli_fetch_assoc($result)){
            echo "<script>
                alert('Username telah terdaftar, coba username yang lain!')
            </script>";
            return false;
        }

        if($password !== $confirm){
            echo "<script>
            alert('Konfirmasi password yang anda masukan salah!');
            </script>";
            return false;
        }

        //enkripsi passwaord
        $password = password_hash($password, PASSWORD_DEFAULT);

        //insert database
        mysqli_query($db, "INSERT INTO user VALUES('','$username','$password')");
        return mysqli_affected_rows($db);
    }
?>
