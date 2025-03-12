<?php
session_start();
include 'koneksi.php';

$userid = $_SESSION['userid'];
$fotoid = isset($_POST['fotoid']) ? $_POST['fotoid'] : (isset($_GET['fotoid']) ? $_GET['fotoid'] : null);
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($fotoid) {
    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

    if (mysqli_num_rows($ceksuka) > 0) {
        // Jika sudah like, maka batalkan like
        $row = mysqli_fetch_array($ceksuka);
        $likeid = $row['likeid'];

        if (mysqli_query($koneksi, "DELETE FROM likefoto WHERE likeid='$likeid'")) {
            $status = 'unliked';
        } else {
            $status = 'error';
        }
    } else {
        // Jika belum like, tambahkan like
        if (mysqli_query($koneksi, "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')")) {
            $status = 'liked';
        } else {
            $status = 'error';
        }
    }

    // Ambil jumlah like terbaru
    $likeCount = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));

    // Jika request berasal dari AJAX, kirimkan respon JSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(['status' => $status, 'likeCount' => $likeCount]);
        exit();
    }

    // Jika request berasal dari URL (GET), redirect kembali
    echo "<script>location.href='../admin/$page.php';</script>";
} else {
    echo "Foto ID tidak ditemukan.";
}
