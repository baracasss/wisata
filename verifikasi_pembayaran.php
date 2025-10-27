<?php
$conn = new mysqli("localhost", "root", "", "web_wisata");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Hapus data
if (isset($_GET['hapus'])) {
  $conn->query("DELETE FROM pemesanan WHERE id=".(int)$_GET['hapus']);
  header("Location: verifikasi_pembayaran.php");
  exit;
}

// Update status
if (isset($_GET['id']) && isset($_GET['status'])) {
  $conn->query("UPDATE pemesanan SET status_pembayaran='{$_GET['status']}' WHERE id=".(int)$_GET['id']);
  header("Location: verifikasi_pembayaran.php");
  exit;
}

// Proses update data (setelah form edit disubmit)
if (isset($_POST['update'])) {
  $id = (int)$_POST['id'];
  $nama = $_POST['nama'];
  $destinasi = $_POST['destinasi'];
  $tipe = $_POST['tipe'];
  $total = $_POST['total_harga'];
  $metode = $_POST['metode_pembayaran'];
  $status = $_POST['status_pembayaran'];

  $sql = "UPDATE pemesanan SET 
          nama='$nama', destinasi='$destinasi', tipe='$tipe', 
          total_harga='$total', metode_pembayaran='$metode', 
          status_pembayaran='$status'
          WHERE id=$id";
  $conn->query($sql);
  header("Location: verifikasi_pembayaran.php");
  exit;
}

$result = $conn->query("SELECT * FROM pemesanan ORDER BY id DESC");
$edit = null;

// Ambil data yang mau diedit
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $edit = $conn->query("SELECT * FROM pemesanan WHERE id=$id")->fetch_assoc();
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Verifikasi & Kelola Pemesanan</title>
<style>
body{margin:0;font-family:sans-serif;background:#071021;color:#e6f0f2;padding:20px;}
h2{text-align:center;color:#2dd4bf;}
table{width:100%;border-collapse:collapse;background:rgba(255,255,255,.05);margin-top:20px;}
th,td{padding:10px;border-bottom:1px solid #333;text-align:left;}
th{background:#2dd4bf;color:#071021;}
button{padding:6px 10px;border:none;border-radius:4px;cursor:pointer;font-weight:bold;}
.sukses{background:#16a34a;color:#fff;}
.gagal{background:#dc2626;color:#fff;}
.hapus{background:#9333ea;color:#fff;}
.edit{background:#2563eb;color:#fff;}
form.edit-form{background:#0b132b;padding:20px;border-radius:8px;margin-bottom:20px;}
input,select{padding:6px;width:100%;margin:6px 0;border-radius:4px;border:none;}
label{display:block;margin-top:8px;font-weight:bold;}
</style>
</head>
<body>
<h2>📋 Verifikasi & Kelola Pemesanan</h2>

<?php if($edit): ?>
<form method="post" class="edit-form">
  <h3>✏️ Edit Pemesanan ID <?= $edit['id'] ?></h3>
  <input type="hidden" name="id" value="<?= $edit['id'] ?>">
  <label>Nama:</label>
  <input type="text" name="nama" value="<?= htmlspecialchars($edit['nama']) ?>" required>
  <label>Destinasi:</label>
  <input type="text" name="destinasi" value="<?= htmlspecialchars($edit['destinasi']) ?>" required>
  <label>Tipe:</label>
  <select name="tipe">
    <option <?= $edit['tipe']=='Domestik'?'selected':'' ?>>Domestik</option>
    <option <?= $edit['tipe']=='Mancanegara'?'selected':'' ?>>Mancanegara</option>
  </select>
  <label>Total Harga:</label>
  <input type="number" name="total_harga" value="<?= $edit['total_harga'] ?>" required>
  <label>Metode Pembayaran:</label>
  <input type="text" name="metode_pembayaran" value="<?= htmlspecialchars($edit['metode_pembayaran']) ?>" required>
  <label>Status Pembayaran:</label>
  <select name="status_pembayaran">
    <option <?= $edit['status_pembayaran']=='Menunggu'?'selected':'' ?>>Menunggu</option>
    <option <?= $edit['status_pembayaran']=='Sukses'?'selected':'' ?>>Sukses</option>
    <option <?= $edit['status_pembayaran']=='Gagal'?'selected':'' ?>>Gagal</option>
  </select>
  <button type="submit" name="update" class="sukses">💾 Simpan Perubahan</button>
  <a href="verifikasi_pembayaran.php"><button type="button" class="gagal">Batal</button></a>
</form>
<?php endif; ?>

<table>
<tr>
  <th>ID</th><th>Nama</th><th>Destinasi</th><th>Tipe</th>
  <th>Total</th><th>Metode</th><th>Status</th><th>Aksi</th>
</tr>
<?php if($result && $result->num_rows): ?>
  <?php while($r=$result->fetch_assoc()): ?>
  <tr>
    <td><?= $r['id'] ?></td>
    <td><?= htmlspecialchars($r['nama']) ?></td>
    <td><?= htmlspecialchars($r['destinasi']) ?></td>
    <td><?= htmlspecialchars($r['tipe']) ?></td>
    <td>Rp <?= number_format($r['total_harga'],0,',','.') ?></td>
    <td><?= htmlspecialchars($r['metode_pembayaran']) ?></td>
    <td><?= htmlspecialchars($r['status_pembayaran']) ?></td>
    <td>
      <a href="?id=<?= $r['id'] ?>&status=Sukses"><button class="sukses">Terima</button></a>
      <a href="?id=<?= $r['id'] ?>&status=Gagal"><button class="gagal">Tolak</button></a>
      <a href="?edit=<?= $r['id'] ?>"><button class="edit">Edit</button></a>
      <a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Hapus data ini?')"><button class="hapus">Hapus</button></a>
    </td>
  </tr>
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="8" align="center">Belum ada data pemesanan.</td></tr>
<?php endif; ?>
</table>
</body>
</html>
