<?php
session_start();
include 'koneksi.php';

$komentarid = $_GET['komentarid'];
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

// Cek apakah user adalah pemilik foto
$cekFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid' AND userid='$userid'");
if (mysqli_num_rows($cekFoto) > 0) {
    // Hapus komentar
    mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE komentarid='$komentarid'");
    echo "<script>alert('Komentar berhasil dihapus!'); location.href='../admin/index.php';</script>";
} else {
    echo "<script>alert('Anda tidak berhak menghapus komentar ini!'); location.href='../admin/index.php';</script>";
}
?>