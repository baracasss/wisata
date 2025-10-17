<?php
$conn = new mysqli("localhost", "root", "", "web_wisata");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Jika admin klik tombol update status
if (isset($_GET['id']) && isset($_GET['status'])) {
  $id = (int)$_GET['id'];
  $status = $_GET['status'];
  $conn->query("UPDATE pemesanan SET status_pembayaran='$status' WHERE id=$id");
}

$result = $conn->query("SELECT * FROM pemesanan ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Verifikasi Pembayaran (Admin)</title>
<style>
body{margin:0;font-family:sans-serif;background:#071021;color:#e6f0f2;padding:20px;}
table{width:100%;border-collapse:collapse;background:rgba(255,255,255,.05);}
th,td{padding:10px;border-bottom:1px solid #333;text-align:left;}
th{background:#2dd4bf;color:#071021;}
button{padding:6px 12px;border:none;border-radius:4px;cursor:pointer;}
.sukses{background:#16a34a;color:white;}
.gagal{background:#dc2626;color:white;}
</style>
</head>
<body>
<h2>📋 Daftar Pemesanan - Verifikasi Pembayaran</h2>
<table>
<tr>
  <th>ID</th><th>Nama</th><th>Destinasi</th><th>Tipe</th><th>Total</th>
  <th>Metode</th><th>Status</th><th>Aksi</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= htmlspecialchars($row['nama']) ?></td>
  <td><?= htmlspecialchars($row['destinasi']) ?></td>
  <td><?= htmlspecialchars($row['tipe']) ?></td>
  <td>Rp <?= number_format($row['total_harga'],0,',','.') ?></td>
  <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
  <td><?= htmlspecialchars($row['status_pembayaran']) ?></td>
  <td>
    <a href="?id=<?= $row['id'] ?>&status=Sukses"><button class="sukses">Terima</button></a>
    <a href="?id=<?= $row['id'] ?>&status=Gagal"><button class="gagal">Tolak</button></a>
  </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
