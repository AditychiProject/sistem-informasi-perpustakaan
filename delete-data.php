<?php
session_start();

// Jika session tidak ada maka arahkan ke halaman login
if (!$_SESSION['login']) {
  header('Location:login.php');
}

require 'inc/inc_functions.php';

$id_delete_data = $_GET['id'];
// Cek apakah data berhasil dihapus atau gagal
if (querydeletedata($id_delete_data) > 0) {
  echo "
    <script>
      alert('Data berhasil dihapus!');
      document.location.href = 'index.php';
    </script>
  ";
} else {
  echo "
    <script>
      alert('Data gagal dihapus!');
      document.location.href = 'index.php';
    </script>
  ";
}
