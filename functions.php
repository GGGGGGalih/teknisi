<?php
$conn = mysqli_connect("localhost", "root", "", "managementjob");
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
    $rows[]=$row;    
    }
    return $rows;
 }

 function carijob($keyword, $table){
    $query = "SELECT * FROM $table
                WHERE 
                namaclient LIKE '%$keyword%'";
    return query($query);
}
 function registrasiteknisi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM loginteknisi WHERE
                    username = '$username'");
            if (mysqli_fetch_assoc($result)){
                echo "<script>
                        alert ('username sudah terdaftar')
                        </script>";
                        return false;
            }

    if($password !== $password2){
        echo "<script>
        alert('password tidak sama');
        </script>";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO loginteknisi VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
function tambahjob($data, $table, $iskelar=false){
    global $conn;
    $namaclient = htmlspecialchars($data["namaclient"]);
    $alamatClient = htmlspecialchars($data["alamatClient"]);
    $kondisi = htmlspecialchars($data["kondisi"]);
    $kontak = htmlspecialchars($data["kontak"]);
    $tanggaljob = htmlspecialchars($data["tanggaljob"]);
    $tanggalselesai = htmlspecialchars($data["tanggalselesai"]);
    $solusi = htmlspecialchars($data["solusi"]);
    if($iskelar){
        $query = "INSERT INTO $table (namaclient, alamatClient, kondisi, kontak, tanggaljob, tanggalselesai, solusi)
        VALUES
        ( '$namaclient', '$alamatClient', '$kondisi', '$kontak', '$tanggaljob', '$tanggalselesai', '$solusi')";
    }else{
        $query = "INSERT INTO $table (namaclient, alamatClient, kondisi, kontak, tanggaljob)
        VALUES
        ( '$namaclient', '$alamatClient', '$kondisi', '$kontak', '$tanggaljob')";
    }
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
    
}

function ubahjob($data){
    global $conn;

    $id = $data["id"];
    $namaclient = htmlspecialchars($data["namaclient"]);
    $alamatClient = htmlspecialchars($data["alamatClient"]);
    $kondisi = htmlspecialchars($data["kondisi"]);
    $kontak = htmlspecialchars($data["kontak"]);
    $tanggaljob = htmlspecialchars($data["tanggaljob"]);
    $tanggalselesai = htmlspecialchars($data["tanggalselesai"]);
    $solusi = htmlspecialchars($data["solusi"]);
    $query = "UPDATE jobteknisi SET
                namaclient = '$namaclient',
                alamatClient = '$alamatClient',
                kondisi = '$kondisi',
                kontak = '$kontak',
                tanggaljob = '$tanggaljob',
                tanggalselesai = '$tanggalselesai',
                solusi = '$solusi'
                WHERE id = $id";
    tambahjob($data, "jobkelar", true);
    mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
}

function hapusjob($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM jobteknisi WHERE id = $id");

    return mysqli_affected_rows($conn);
}
 ?>