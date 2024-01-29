<?php
session_start();

// Hapus Session
$_SESSION = [];
session_destroy();
session_unset();
// Arahkan ke halaman login.php
header('Location:login.php');
