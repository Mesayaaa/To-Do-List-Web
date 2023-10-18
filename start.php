<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "UPDATE tbl_tugas SET status='On Progress' WHERE id = $id";
  mysqli_query($koneksi, $sql);
}

header("Location: todo.php");
?>