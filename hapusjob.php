<?php
session_start();
if (!isset($_SESSION["loginteknisi"])) {
  header("location: loginteknisi.php");
  exit;
}
require 'functions.php'; 
$id = $_GET["id"];

if( hapusjob($id) > 0) {
    echo "<script>
            alert('data job sudah dihapus');
            document.location.href =  'listjob.php';
            </script>
    ";
} else {
    echo "<script>
            alert('data job gagal dihapus');
            document.location.href =  'listjob.php';
            </script>
    ";
}
?>