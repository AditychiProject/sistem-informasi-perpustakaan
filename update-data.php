<?php
session_start();

// Jika session tidak ada maka arahkan ke halaman login.php
if (!$_SESSION['login']) {
  header('Location:login.php');
}

require 'inc/inc_functions.php';

// Tangkap id untuk mengubah data tersebut
$id_update_data = $_GET['id'];
// Tampilkan data berdasarkan id yang telah ditangkap
$books = querydata("SELECT * FROM books WHERE id=$id_update_data");
// Jika tombol updatedata data di-klik
if (isset($_POST['updatedata'])) {
  if (queryupdatedata($_POST) > 0) {
    echo "
      <script>
        alert('Data berhasil diubah!');
        document.location.href = 'index.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data gagal diubah!');
        document.location.href = 'index.php';
      </script>
    ";
  }
}
?>

<!-- Header Template -->
<?php require 'header.php' ?>
<!-- Update Data Section -->
<section id="update-data" class="flex w-full min-h-screen bg-cover py-16" style="background-image: url('src/img/login-bg.jpg')">
  <div class="container m-auto">
    <!-- Logo Website -->
    <div class="mb-8">
      <a href="index.php" class="block text-3xl text-light text-center font-semibold mx-auto">SI Perpustakaan</a>
    </div>
    <!-- Form Update Data -->
    <div class="max-w-lg bg-light rounded-xl mx-auto px-6 py-12">
      <h2 class="text-2xl text-center uppercase font-bold mb-8">Ubah Data Buku</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <?php foreach ($books as $book) : ?>
          <!-- Input Hidden -->
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <input type="hidden" name="coverbukulama" value="<?= $book['coverbuku']; ?>">
          <!-- Judul Buku -->
          <div class="mb-6">
            <label for="judulbuku" class="block text-sm mb-2">Judul Buku</label>
            <input type="text" name="judulbuku" id="judulbuku" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" value="<?= $book['judulbuku']; ?>" />
          </div>
          <!-- Penerbit -->
          <div class="mb-6">
            <label for="penerbit" class="block text-sm mb-2">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" value="<?= $book['penerbit']; ?>" />
          </div>
          <!-- Pengarang -->
          <div class="mb-6">
            <label for="pengarang" class="block text-sm mb-2">Pengarang</label>
            <input type="text" name="pengarang" id="pengarang" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" value="<?= $book['pengarang']; ?>" />
          </div>
          <!-- Tahun Terbit -->
          <div class="mb-6">
            <label for="tahunterbit" class="block text-sm mb-2">Tahun Terbit</label>
            <input type="text" name="tahunterbit" id="tahunterbit" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" value="<?= $book['tahunterbit']; ?>" />
          </div>
          <!-- Cover Buku -->
          <div class="mb-6">
            <label for="coverbuku" class="block text-sm mb-2">Cover Buku</label>
            <div class="w-[90px] lg:w-[180px] mt-2 mb-4">
              <img src="dist/img/<?= $book['coverbuku']; ?>" class="aspect-[9/16]" alt="<?= $book['judulbuku']; ?>">
            </div>
            <input type="file" accept="image/*" name="coverbuku" id="coverbuku" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" value="<?= $book['coverbuku']; ?>" />
          </div>
        <?php endforeach; ?>
        <!-- Update Data Button -->
        <button type="submit" name="updatedata" class="w-full text-sm text-light font-medium bg-bluecstm hover:bg-blue-800 rounded-md p-4 transition duration-200">Ubah</button>
      </form>
    </div>
  </div>
</section>
<!-- Footer Template -->
<?php require 'footer.php' ?>