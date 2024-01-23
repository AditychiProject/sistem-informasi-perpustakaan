<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'si_perpustakaan';

$conn = mysqli_connect($host, $user, $password, $database);

// Cek apakah berhasil terhubung ke database atau gagal
// if ($conn) {
//     echo "Koneksi ke database berhasil";
// } else {
//     die("Koneksi ke database gagal");
// }

// Query ambil data dari database
function querydata($query_data)
{
	global $conn;

	$dataqueryconts = [];
	// Query
	$resultquery = mysqli_query($conn, $query_data);
	// Ambil data satu per satu lalu tampung sementara ke dataquerycont
	while ($dataquerycont = mysqli_fetch_assoc($resultquery)) {
		$dataqueryconts[] = $dataquerycont;
	}
	return $dataqueryconts;
}

// Query tambah data
function querycreatedata($query_create_data)
{
	global $conn;

	$judulbuku = htmlspecialchars($query_create_data['judulbuku']);
	$penerbit = htmlspecialchars($query_create_data['penerbit']);
	$pengarang = htmlspecialchars($query_create_data['pengarang']);
	$tahunterbit = htmlspecialchars($query_create_data['tahunterbit']);
	$coverbuku = upload($_FILES);
	if (!$coverbuku) {
		return false;
	}

	// Tambah data ke database
	$inserttodb = "INSERT INTO books VALUE ('', '$judulbuku', '$penerbit', '$pengarang', '$tahunterbit', '$coverbuku')";
	mysqli_query($conn, $inserttodb);
	// Kembalikan nilai 1 atau 0
	return mysqli_affected_rows($conn);
}

// Upload cover buku
function upload()
{
	$namaFile = $_FILES['coverbuku']['name'];
	$ukuranFile = $_FILES['coverbuku']['size'];
	$error = $_FILES['coverbuku']['error'];
	$tmpName = $_FILES['coverbuku']['tmp_name'];
	// Cek apakah ada gambar yang di-upload
	if ($error === 4) {
		echo "
            <script>alert('Silakan pilih gambar terlebih dahulu!');</script>
        ";
		return false;
	}

	// Cek apakah yang di-upload adalah file gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	// Ambil ekstensi pada file gambar
	$ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);
	// Cek apakah ekstensi file gambar tersebut sudah sesuai atau tidak
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "
            <script>alert('File yang di-upload harus gambar!');</script>
        ";
		return false;
	}

	// Cek ukuran file gambar
	if ($ukuranFile > 2000000) {
		echo "
            <script>alert('Ukuran gambar yang di-upload tidak lebih dari 2 MB!');</script>
        ";
		return false;
	}

	// Lanjutan baris 76 jika ekstensi sesuai
	// Nama file baru ini merupakan kode unik dari gambar sehingga gambar tidak terduplikat
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	// Gabungkan dengan ekstensi file
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, 'src/img/' . $namaFileBaru);
	return $namaFileBaru;
}

// Query hapus data
function querydeletedata($id_delete_data)
{
	global $conn;

	// Hapus file gambar dari lokasi penyimpanan img
	$filegambar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id='$id_delete_data'"));
	unlink('src/img/' . $filegambar['coverbuku']);
	// Hapus data dari database berdasarkan id
	$deletefromdb = "DELETE FROM books WHERE id=$id_delete_data";
	mysqli_query($conn, $deletefromdb);
	// Kembalikan nilai 1 atau 0
	return mysqli_affected_rows($conn);
}

// Query ubah data
function queryupdatedata($id_update_data)
{
	global $conn;

	$id = $id_update_data['id'];
	$judulbuku = htmlspecialchars($id_update_data['judulbuku']);
	$penerbit = htmlspecialchars($id_update_data['penerbit']);
	$pengarang = htmlspecialchars($id_update_data['pengarang']);
	$tahunterbit = htmlspecialchars($id_update_data['tahunterbit']);
	$coverbukulama = htmlspecialchars($id_update_data['coverbukulama']);
	// Cek apakah file gambar juga diubah atau tidak
	if ($_FILES['coverbuku']['error'] === 4) {
		// Jika tidak ada maka file gambar tidak ditimpa
		$coverbuku = $coverbukulama;
	} else {
		// Hapus file gambar lama sebelum ditimpa dengan gambar baru
		$result = mysqli_query($conn, "SELECT coverbuku FROM books WHERE id=$id");
		$filecoverlama = mysqli_fetch_assoc($result);
		$filegambar = implode('.', $filecoverlama);
		unlink('src/img/' . $filegambar);
		// Timpa file gambar lama dengan file gambar yang baru
		$coverbuku = upload();
	}

	// Ubah data yang ada pada database
	$updatedata = "UPDATE books SET
    judulbuku='$judulbuku', 
    penerbit='$penerbit', 
    pengarang='$pengarang', 
    tahunterbit='$tahunterbit', 
    coverbuku='$coverbuku'
    WHERE id=$id";
	mysqli_query($conn, $updatedata);
	return mysqli_affected_rows($conn);
}

// Cari data pada database
function searchdata($input_result)
{
	$querysearch = "SELECT * FROM books WHERE judulbuku LIKE '%$input_result%' OR pengarang LIKE '%$input_result%'";
	// Query data yang dicari berdasarkan data yang ada pada database
	return querydata($querysearch);
}

// Register
function register($data_register)
{
	global $conn;

	// stripslashes berguna untuk mencegah input berupa tanda backslash
	$email = strtolower(stripslashes($data_register['email']));
	// mysqli_real_escape_string memungkinkan input berupa tanda kutip
	$password = mysqli_real_escape_string($conn, $data_register['password']);
	$konfirmasi_password = mysqli_real_escape_string($conn, $data_register['konfirmasi_password']);

	// Cek apakah email sudah terdaftar atau belum
	$querydataemail = "SELECT email FROM users WHERE email='$email'";
	$result = mysqli_query($conn, $querydataemail);
	if (mysqli_fetch_assoc($result)) {
		echo "
      <script>
        alert('Email telah terdaftar!');
        document.location.href = 'login.php';
      </script>
    ";
		return false;
	}

	// Cek konfirmasi password
	if ($password !== $konfirmasi_password) {
		echo "
        <script>
            alert('Konfirmasi password tidak sesuai!');
        </script>
        ";
		return false;
	}

	// Enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);
	// Tambahkan user baru ke database
	mysqli_query($conn, "INSERT INTO users VALUES('', '$email', '$password')");
	// Kembalikan nilai 1 atau 0
	return mysqli_affected_rows($conn);
}
