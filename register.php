<?php
session_start();

// Jika sudah login maka jangan akses halaman register.php lagi
if (isset($_SESSION['login'])) {
	header('Location:index.php');
	exit;
}

// Jika session tidak ada maka arahkan ke halaman login.php
if (!$_SESSION['login']) {
	header('Location:login.php');
}

require 'inc/inc_functions.php';

// Jika tombol register di-klik
if (isset($_POST['register'])) {
	if (register($_POST) > 0) {
		echo "
      <script>
        alert('User baru berhasil ditambahkan!');
        document.location.href = 'login.php';
      </script>
    ";
	} else {
		// user gagal ditambahkan
		echo mysqli_error($conn);
	}
}
?>

<!-- Header Template -->
<?php require 'header.php' ?>
<!-- Register Section -->
<section id="register" class="flex w-full min-h-screen bg-cover" style="background-image: url('dist/img/login-bg.jpg')">
	<div class="container m-auto">
		<!-- Logo Website -->
		<div class="mb-8">
			<a href="index.php" class="block text-3xl text-light text-center font-semibold mx-auto">SI Perpustakaan</a>
		</div>
		<!-- Form Register -->
		<div class="max-w-lg bg-light rounded-xl mx-auto px-6 py-12">
			<h2 class="text-2xl text-center uppercase font-bold mb-8">Register</h2>
			<form action="" method="post">
				<!-- Email -->
				<div class="mb-6">
					<label for="email" class="block text-sm mb-2">Email</label>
					<input type="email" name="email" id="email" class="block w-full border border-slate-500 outline-bluecstm rounded-md p-3" />
				</div>
				<!-- Password -->
				<div class="mb-6">
					<label for="password" class="block text-sm mb-2">Password</label>
					<input type="password" name="password" id="password" class="block w-full border border-slate-500 outline-bluecstm rounded-md p-3" />
				</div>
				<!-- Konfirmasi Password -->
				<div class="mb-6">
					<label for="konfirmasi_password" class="block text-sm mb-2">Konfirmasi Password</label>
					<input type="password" name="password" id="konfirmasi_password" class="block w-full border border-slate-500 outline-bluecstm rounded-md p-3" />
				</div>
				<!-- Login Button -->
				<button type="submit" name="register" class="w-full text-sm text-light font-medium bg-bluecstm hover:bg-blue-800 rounded-md p-4 transition duration-300">Register</button>
			</form>
		</div>
	</div>
</section>
<!-- Footer Template -->
<?php require 'footer.php' ?>
</body>

</html>