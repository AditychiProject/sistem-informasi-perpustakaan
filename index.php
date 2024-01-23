<?php
session_start();

// Jika session tidak ada maka arahkan ke halaman login
if (!$_SESSION['login']) {
  header('Location:login.php');
}

// File functions.php
require 'inc/inc_functions.php';

// konfigurasi
$jmlDataPerHalaman = 2;
// hitung jumlah data pada tabel
$jmlData = count(querydata("SELECT * FROM books"));
$jmlHalaman = ceil($jmlData / $jmlDataPerHalaman);
// cek sedang di halaman berapa sekarang
$halamanActive = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jmlDataPerHalaman * $halamanActive) - $jmlDataPerHalaman;




$books = querydata("SELECT * FROM books LIMIT $awalData, $jmlDataPerHalaman");
if (isset($_POST["cari"])) {
  $books = searchdata($_POST["keyword"]);
}

// Tampilkan semua data
// $books = querydata("SELECT * FROM books");
// // Jika tombol cari di-klik maka tampilkan data sesuai pencarian saja
// if (isset($_POST['search'])) {
//   $books = searchdata($_POST["keyword"]);
// }

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <!-- My CSS -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dist/output.css" />
  <!-- Script -->
  <script src="src/js/script.js"></script>
</head>

<body class="bg-slate-200">
  <!-- Navbar Section -->
  <nav class="flex justify-between items-center w-full fixed bg-light p-4">
    <!-- Nav Brand -->
    <a href="index.php" class="text-xl lg:text-2xl text-greencstm font-bold">
      SI Perpustakaan
    </a>
    <!-- Hamburger Menu Button -->
    <div class="lg:hidden">
      <button class="navbar-burger flex items-center text-black">
        <svg class="block w-6 h-6 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
        </svg>
      </button>
    </div>
    <!-- Nav Links -->
    <ul class="hidden lg:flex lg:items-center lg:w-auto absolute top-1/2 left-1/2 lg:mx-auto transform -translate-x-1/2 -translate-y-1/2">
      <!-- Dashboard -->
      <li>
        <a href="index.php" class="text-sm text-black font-semibold mx-6">Dashboard</a>
      </li>
      <!-- Logout -->
      <li>
        <a href="logout.php" class="text-sm text-black font-semibold mx-6">Logout</a>
      </li>
    </ul>
  </nav>
  <!-- Navbar Mobile -->
  <div class="navbar-menu hidden relative z-50">
    <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
    <nav class="flex flex-col max-w-sm w-5/6 overflow-y-auto fixed top-0 left-0 bottom-0 bg-light border-r p-6">
      <!-- Close Navbar Mobile Button -->
      <div class="flex justify-end items-center mb-8">
        <button class="navbar-close">
          <svg class="cursor-pointer w-6 h-6 text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <!-- Nav Links Mobile -->
      <div>
        <ul>
          <!-- Dashboard -->
          <li class="mb-1">
            <a href="index.php" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">Dashboard</a>
          </li>
          <!-- Logout -->
          <li class="mb-1">
            <a href="logout.php" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">Logout</a>
          </li>
        </ul>
      </div>
      <!-- Bottom Elements -->
      <div class="mt-auto">
        <div class="pt-6">
          <!-- Search Bar -->
          <form action="" method="post" class="mb-4">
            <div class="flex justify-between gap-2">
              <input type="text" name="keyword" class="w-full h-full box-border text-sm text-black font-medium bg-light border border-slate-300 outline-bluecstm rounded-md lg:ml-auto lg:mr-4 p-3" placeholder="Cari data disini">
              <button type="submit" name="search" class="inline-block text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md p-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </nav>
  </div>
  <!-- Dashboard Section -->
  <div class="container">
    <div class="mx-auto">
      <!-- Header -->
      <div class="pt-[64px] lg:pt-[96px] mb-6 ">
        <h2 class="text-3xl text-slate-800 font-bold mt-8 mb-10">Dashboard</h2>
        <div class="flex justify-between gap-2">
          <!-- Create Data Link -->
          <a href="create-data.php" class="inline-block text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md px-4 py-3">Tambah data buku</a>
          <!-- Search Bar -->
          <form action="" method="post" class="hidden lg:flex lg:items-center">
            <input type="text" name="keyword" class="hidden lg:inline-block w-64 h-full text-sm text-black font-medium bg-light border border-slate-300 outline-bluecstm rounded-md lg:ml-auto lg:mr-4 p-3" placeholder="Cari data disini">
            <button type="submit" name="search" class="inline-block h-full text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md p-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
              </svg>
            </button>
          </form>
        </div>
      </div>
      <!-- Table -->
      <div class="overflow-x-auto">
        <div class="inline-block min-w-full overflow-hidden border border-slate-300 rounded-lg">
          <table class="min-w-full leading-normal">
            <!-- Table Header -->
            <thead>
              <tr>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">No</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Judul Buku</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Penerbit</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Pengarang</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Tahun Terbit</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Cover Buku</th>
                <th class="text-nowrap text-xs text-light uppercase tracking-wider font-bold bg-gray-800 border-b-2 border-gray-200 p-4">Aksi</th>
              </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
              <?php $no_urut = 1; ?>
              <?php foreach ($books as $book) : ?>
                <tr class="bg-light border-b border-gray-200">
                  <!-- Nomor Urut -->
                  <td class="text-sm text-center p-4">
                    <p class="text-gray-900 whitespace-no-wrap"><?php echo $no_urut; ?></p>
                  </td>
                  <!-- Judul Buku -->
                  <td class="text-sm text-center p-4">
                    <p class="text-gray-900 whitespace-no-wrap"><?php echo $book["judulbuku"]; ?></p>
                  </td>
                  <!-- Penerbit -->
                  <td class="text-sm text-center p-4">
                    <p class="text-gray-900 whitespace-no-wrap"><?= $book["penerbit"]; ?></p>
                  </td>
                  <!-- Pengarang -->
                  <td class="text-sm text-center p-4">
                    <p class="text-gray-900 whitespace-no-wrap"><?= $book["pengarang"]; ?></p>
                  </td>
                  <!-- Tahun Terbit -->
                  <td class="text-sm text-center p-4">
                    <p class="text-gray-900 whitespace-no-wrap"><?= $book["tahunterbit"]; ?></p>
                  </td>
                  <!-- Cover Buku -->
                  <td class="text-sm text-center p-4">
                    <div class="flex-shrink-0 w-[80px] mx-auto">
                      <img class="aspect-[9/16]" src="src/img/<?= $book["coverbuku"]; ?>" alt="<?= $book["judulbuku"]; ?>" />
                    </div>
                  </td>
                  <!-- Aksi -->
                  <td class="mx-auto p-4">
                    <div class="flex justify-center gap-2">
                      <!-- Edit Button -->
                      <a href="update-data.php?id=<?php echo $book["id"]; ?>" class="flex justify-center items-center text-light text-center bg-yellow-500 hover:bg-yellow-600 rounded-md p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                          <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                      </a>
                      <!-- Delete Button -->
                      <a href="delete-data.php?id=<?php echo $book["id"]; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="flex justify-center items-center text-light text-center bg-red-500 hover:bg-red-600 rounded-md p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                          <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                      </a>
                    </div>
                  </td>
                  <?php $no_urut++; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Paginate Link -->
      <div class="flex justify-end gap-x-1 pb-[64px] lg:pb-[96px]">
        <!-- Pre Button -->
        <?php if ($halamanActive > 1) : ?>
          <div class="w-[40px] h-[40px] text-black bg-light border border-slate-300 rounded-lg">
            <a href="?page=<?php echo $halamanActive - 1; ?>" class="flex justify-center items-center w-full h-full">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
              </svg>
            </a>
          </div>
        <?php endif; ?>
        <!-- Center -->
        <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
          <?php if ($i == $halamanActive) : ?>
            <!-- Paginate Active -->
            <div class="w-[40px] h-[40px] text-light font-bold bg-bluecstm border border-bluecstm rounded-lg">
              <a href="?page=<?php echo $i; ?>" class="flex justify-center items-center w-full h-full">
                <?= $i; ?>
              </a>
            </div>
          <?php else : ?>
            <!-- Paginate Unactive -->
            <div class="w-[40px] h-[40px] text-black bg-light border border-slate-300 rounded-lg">
              <a href="?page=<?php echo $i; ?>" class="flex justify-center items-center w-full h-full">
                <?= $i; ?>
              </a>
            </div>
          <?php endif; ?>
        <?php endfor; ?>
        <!-- Next Button -->
        <?php if ($halamanActive < $jmlHalaman) : ?>
          <div class="w-[40px] h-[40px] text-black bg-light border border-slate-300 rounded-lg">
            <a href="?page=<?php echo $halamanActive + 1; ?>" class="flex justify-center items-center w-full h-full">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708" />
                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708" />
              </svg>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>