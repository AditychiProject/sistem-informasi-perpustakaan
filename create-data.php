<?php
session_start();

// Jika session tidak ada maka arahkan ke halaman login.php
if (!$_SESSION['login']) {
	header('Location:login.php');
}

require 'inc/inc_functions.php';

// Jika tombol createdata di-klik
if (isset($_POST['createdata'])) {
	if (querycreatedata($_POST) > 0) {
		echo "
      <script>
        alert('Data berhasil ditambahkan!');
        document.location.href = 'index.php';
      </script>
    ";
	} else {
		echo "
      <script>
        alert('Data gagal ditambahkan!');
        document.location.href = 'index.php';
      </script>
    ";
	}
}
?>

<!-- Header Template -->
<?php require 'header.php' ?>
<!-- Create Data Section -->
<section id="create-data" class="flex w-full min-h-screen bg-cover py-16" style="background-image: url('dist/img/login-bg.jpg')">
	<div class="container">
		<!-- Logo Website -->
		<div class="mb-8">
			<a href="index.php" class="block text-3xl text-light text-center font-semibold mx-auto">SI Perpustakaan</a>
		</div>
		<!-- Form Create Data -->
		<div class="max-w-lg bg-light rounded-xl mx-auto px-6 py-12">
			<h2 class="text-2xl text-center uppercase font-bold mb-8">Tambah Data Buku</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<!-- Judul Buku -->
				<div class="mb-6">
					<label for="judulbuku" class="block text-sm mb-2">Judul Buku</label>
					<input type="text" name="judulbuku" id="judulbuku" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" required placeholder="Masukan judul buku" />
				</div>
				<!-- Penerbit -->
				<div class="mb-6">
					<label for="penerbit" class="block text-sm mb-2">Penerbit</label>
					<input type="text" name="penerbit" id="penerbit" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" required placeholder="Masukan nama penerbit" />
				</div>
				<!-- Pengarang -->
				<div class="mb-6">
					<label for="pengarang" class="block text-sm mb-2">Pengarang</label>
					<input type="text" name="pengarang" id="pengarang" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" required placeholder="Masukan nama pengarang" />
				</div>
				<!-- Tahun Terbit -->
				<div class="mb-6">
					<label for="tahunterbit" class="block text-sm mb-2">Tahun Terbit</label>
					<input type="text" name="tahunterbit" id="tahunterbit" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" required placeholder="Masukan tahun terbit" />
				</div>
				<!-- Cover Buku -->
				<div class="mb-6">
					<label for="coverbuku" class="block text-sm mb-2">Cover Buku</label>
					<input type="file" accept="image/*" name="coverbuku" id="coverbuku" class="block w-full text-sm text-paragraph border border-slate-500 outline-bluecstm rounded-md p-3" required />
				</div>
				<!-- Create Data Button -->
				<button type="submit" name="createdata" class="w-full text-sm text-light font-medium bg-bluecstm hover:bg-blue-800 rounded-md p-4 transition duration-200">Tambah</button>
			</form>
		</div>
	</div>
</section>
<!-- Footer Template -->
<?php require 'footer.php' ?>