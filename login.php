<?php
session_start();

// Jika sudah login maka jangan akses halaman login.php lagi
if (isset($_SESSION['login'])) {
	header('Location:index.php');
	exit;
}

require 'inc/inc_functions.php';

// Jika tombol login di-klik
if (isset($_POST['login'])) {
	$email =  $_POST['email'];
	$password =  $_POST['password'];
	// Tampilkan data email yang ada pada database untuk dicocokkan
	$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
	// Cek email berdasarkan data yang ada di database
	if (mysqli_num_rows($result) === 1) {
		$row = mysqli_fetch_assoc($result);
		// Cek password
		if (password_verify($password, $row['password'])) {
			// Jika sesuai maka arahkan ke halaman dashboard.php
			$_SESSION['login'] = true;
			header('Location:index.php');
			exit;
		} else {
			echo "
      <script>
        alert('Username atau password salah!');
      </script>
    ";
		}
	}
}
?>

<!-- Header Template -->
<?php require 'header.php' ?>
<!-- Login Section -->
<section id="login" class="flex w-full min-h-screen bg-cover" style="background-image: url('dist/img/login-bg.jpg')">
	<div class="container m-auto">
		<!-- Logo Website -->
		<div class="mb-8">
			<a href="index.php" class="block text-3xl text-light text-center font-semibold mx-auto">SI Perpustakaan</a>
		</div>
		<!-- Form Login -->
		<div class="max-w-lg bg-light rounded-xl mx-auto px-6 py-12">
			<h2 class="text-2xl text-center uppercase font-bold mb-8">Login</h2>
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
				<!-- Login Button -->
				<button type="submit" name="login" class="w-full text-sm text-light font-medium bg-bluecstm hover:bg-blue-800 rounded-md p-4 transition duration-300">Login</button>
			</form>
		</div>
	</div>
</section>
<!-- Footer Template -->
<?php require 'footer.php' ?>