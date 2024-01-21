<?php
session_start();

// Hapus session
$_SESSION = [];
session_destroy();
session_unset();
// Arahkan ke halaman login.php
header('Location:login.php');
