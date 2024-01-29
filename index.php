<?php
session_start();

// Jika session tidak ada maka arahkan ke halaman login.php
if (!$_SESSION['login']) {
  header('Location:login.php');
}

require 'inc/inc_functions.php';

// Konfigurasi Paginate
$jmlDataPerHalaman = 2;
// Hitung jumlah data pada tabel
$jmlData = count(querydata("SELECT * FROM books"));
$jmlHalaman = ceil($jmlData / $jmlDataPerHalaman);
// Cek paginate sedang di halaman berapa sekarang
$halamanActive = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jmlDataPerHalaman * $halamanActive) - $jmlDataPerHalaman;

// Cari data
$books = querydata("SELECT * FROM books LIMIT $awalData, $jmlDataPerHalaman");

// Jika tombol cari di-klik maka tampilkan data sesuai pencarian saja
if (isset($_POST["search"])) {
  $books = searchdata($_POST["keyword"]);
}
?>

<!-- Header Template -->
<?php require 'header.php' ?>
<!-- Navbar -->
<nav class="flex justify-between items-center w-full fixed bg-light p-4">
  <!-- Nav Brand -->
  <a href="index.php" class="text-xl lg:text-2xl text-black font-bold">SI Perpustakaan</a>
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
    <!-- Programming -->
    <li>
      <a href="logout.php" class="text-sm text-black font-semibold mx-6">Programming</a>
    </li>
    <!-- UI UX Design -->
    <li>
      <a href="logout.php" class="text-sm text-black font-semibold mx-6">UI UX Design</a>
    </li>
    <!-- Setting -->
    <li>
      <a href="logout.php" class="text-sm text-black font-semibold mx-6">Setting</a>
    </li>
  </ul>
  <!-- Logout Button -->
  <a href="" class="hidden lg:inline-block text-sm text-light font-medium bg-red-500 hover:bg-red-700 rounded-md lg:ml-auto lg:mr-4 px-8 py-3 transition duration-200">Logout</a>
</nav>
<!-- Navbar Mobile -->
<div class="navbar-menu hidden relative z-50">
  <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
  <nav class="flex flex-col max-w-sm w-5/6 overflow-y-auto fixed top-0 left-0 bottom-0 bg-light border-r p-6">
    <!-- Close Button -->
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
          <a href="" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">Dashboard</a>
        </li>
        <!-- Programming -->
        <li class="mb-1">
          <a href="" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">Programming</a>
        </li>
        <!-- UI UX Design -->
        <li class="mb-1">
          <a href="" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">UI UX Design</a>
        </li>
        <!-- Setting -->
        <li class="mb-1">
          <a href="" class="block text-sm text-black font-semibold hover:bg-blue-50 rounded-md px-4 py-3">Setting</a>
        </li>
      </ul>
    </div>
    <!-- Bottom Elements -->
    <div class="mt-auto">
      <div class="pt-6">
        <!-- Search Bar -->
        <form action="" method="post" class="mb-4">
          <div class="flex justify-between gap-2">
            <input type="text" name="keyword" class="w-full max-h-[44px] box-border text-sm text-black font-medium bg-light border border-slate-300 focus:border-transparent focus:outline focus:outline-2 focus:outline-bluecstm rounded-md lg:ml-auto lg:mr-4 p-3" />
            <button type="submit" name="search" class="inline-block text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md px-4 py-3 transition duration-200">Cari</button>
          </div>
        </form>
        <!-- Logout Button -->
        <a href="" class="block lg:hidden text-sm text-light text-center font-medium bg-red-500 hover:bg-red-700 rounded-md lg:ml-auto lg:mr-4 mb-8 px-8 py-3 transition duration-300">Logout</a>
      </div>
    </div>
  </nav>
</div>
<!-- Dashboard Section -->
<div class="container">
  <div class="mx-auto">
    <!-- Header Section -->
    <div class="pt-[64px] lg:pt-[96px] mb-6">
      <h2 class="text-3xl text-slate-800 font-bold mt-8 mb-10">Dashboard</h2>
      <div class="flex justify-between gap-2">
        <!-- Create Data Link -->
        <a href="create-data.php" class="inline-block text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md px-4 py-3 transition duration-200">Tambah data buku</a>
        <!-- Search Bar -->
        <form action="" method="post" class="hidden lg:inline-block">
          <input type="text" name="keyword" class="hidden lg:inline-block w-64 max-h-[44px] box-border text-sm text-black font-medium bg-light border border-slate-400 focus:border-transparent focus:outline focus:outline-2 focus:outline-bluecstm rounded-md lg:ml-auto lg:mr-4 p-3" placeholder="Cari data" />
          <button type="submit" name="search" class="inline-block text-sm text-light bg-bluecstm hover:bg-blue-700 rounded-md px-4 py-3 transition duration-200">Cari</button>
        </form>
      </div>
    </div>
    <div class="overflow-x-auto">
      <div class="inline-block min-w-full overflow-hidden border border-slate-300 rounded-lg">
        <table class="min-w-full leading-normal">
          <!-- Table Head -->
          <thead>
            <tr>
              <th class="table-head">No</th>
              <th class="table-head">Judul Buku</th>
              <th class="table-head">Penerbit</th>
              <th class="table-head">Pengarang</th>
              <th class="table-head">Tahun Terbit</th>
              <th class="table-head">Cover Buku</th>
              <th class="table-head">Aksi</th>
            </tr>
          </thead>
          <!-- Table Body -->
          <tbody>
            <tr class="bg-light border-b border-gray-200">
              <!-- Nomor Urut -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">1</p>
              </td>
              <!-- Judul Buku -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">HTML Dasar</p>
              </td>
              <!-- Penerbit -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">Elex Media Computindo</p>
              </td>
              <!-- Pengarang -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">Aditychi</p>
              </td>
              <!-- Tahun Terbit -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">2024</p>
              </td>
              <!-- Cover Buku -->
              <td class="text-sm text-center p-4">
                <div class="flex-shrink-0 w-[80px] mx-auto">
                  <img class="aspect-[9/16]" src="dist/img/archons.jpg" alt="HTML Dasar" />
                </div>
              </td>
              <!-- Aksi -->
              <td class="mx-auto p-4">
                <div class="flex justify-center gap-2">
                  <!-- Edit Button -->
                  <a href="" class="flex justify-center items-center text-light text-center bg-yellow-500 hover:bg-yellow-600 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                    </svg>
                  </a>
                  <!-- Delete Button -->
                  <a href="" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="flex justify-center items-center text-light text-center bg-red-500 hover:bg-red-600 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                  </a>
                </div>
              </td>
            </tr>
            <tr class="bg-light border-b border-gray-200">
              <!-- Nomor Urut -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">2</p>
              </td>
              <!-- Judul Buku -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">Pemrograman Dasar dengan Bahasa Python</p>
              </td>
              <!-- Penerbit -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">Elex Media Computindo</p>
              </td>
              <!-- Pengarang -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">Yudi Muttaqin</p>
              </td>
              <!-- Tahun Terbit -->
              <td class="text-sm text-center p-4">
                <p class="text-gray-900 whitespace-no-wrap">2022</p>
              </td>
              <!-- Cover Buku -->
              <td class="text-sm text-center p-4">
                <div class="flex-shrink-0 w-[80px] mx-auto">
                  <img class="aspect-[9/16]" src="dist/img/wanderer.jpg" alt="Pemrograman Dasar dengan Bahasa Python" />
                </div>
              </td>
              <!-- Aksi -->
              <td class="mx-auto p-4">
                <div class="flex justify-center gap-2">
                  <!-- Edit Button -->
                  <a href="" class="flex justify-center items-center text-light text-center bg-yellow-500 hover:bg-yellow-600 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                    </svg>
                  </a>
                  <!-- Delete Button -->
                  <a href="" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="flex justify-center items-center text-light text-center bg-red-500 hover:bg-red-600 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Paginate Link -->
    <div class="flex justify-end gap-x-1 mt-3 pb-[64px] lg:pb-[96px]">
      <!-- Pre Button -->
      <div class="w-[40px] h-[40px] text-black hover:text-light bg-light hover:bg-bluecstm border border-slate-300 rounded-lg">
        <a href="" class="flex justify-center items-center w-full h-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
          </svg>
        </a>
      </div>
      <!-- Paginate Unactive -->
      <div class="w-[40px] h-[40px] hover:text-light bg-light hover:bg-bluecstm border border-slate-300 rounded-lg">
        <a href="" class="flex justify-center items-center w-full h-full">1</a>
      </div>
      <!-- Paginate Active -->
      <div class="w-[40px] h-[40px] text-light font-bold bg-bluecstm border border-bluecstm rounded-lg">
        <a href="" class="flex justify-center items-center w-full h-full">2</a>
      </div>
      <!-- Paginate Unactive -->
      <div class="w-[40px] h-[40px] hover:text-light bg-light hover:bg-bluecstm border border-slate-300 rounded-lg">
        <a href="" class="flex justify-center items-center w-full h-full">3</a>
      </div>
      <!-- Next Button -->
      <div class="w-[40px] h-[40px] hover:text-light bg-light hover:bg-bluecstm border border-slate-300 rounded-lg">
        <a href="" class="flex justify-center items-center w-full h-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708" />
            <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>
    </div>
  </div>
</div>
<!-- Footer Template -->
<?php require 'footer.php' ?>