<?php
include "koneksi.php";

$no_hp = $_GET['no_hp'] ?? '';
$pesanan = [];

if ($no_hp) {
    $sql = "
      SELECT 
        w.nama_wisata,
        p.total_harga,
        p.metode_pembayaran,
        p.status_pembayaran
      FROM pemesanan p
      JOIN wisata w ON p.id_wisata = w.id
      WHERE p.no_hp = '$no_hp'
      ORDER BY p.id DESC
    ";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $pesanan = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Status Pembayaran</title>
<link rel="stylesheet" href="stylephp.css">
</head>
<body>
<div class="container">
  <h2>Status Pembayaran Tiket</h2>
  
  <form method="get" class="form-status">
      <label>Masukkan No. HP:</label>
      <input type="text" name="no_hp" value="<?= htmlspecialchars($no_hp) ?>" required placeholder="Contoh: 08123456789">
      <button type="submit">Cek Status</button>
  </form>

  <?php if($no_hp): ?>
      <?php if($pesanan): ?>
      <table class="tabel-status">
          <thead>
            <tr>
                <th>Nama Wisata</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($pesanan as $row): ?>
          <tr>
              <td><?= htmlspecialchars($row['nama_wisata']) ?></td>
              <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
              <td class="<?= strtolower($row['status_pembayaran']) ?>">
                  <?= htmlspecialchars($row['status_pembayaran']) ?>
              </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
      </table>
      <?php else: ?>
      <p class="tidak-ada">❌ Pesanan tidak ditemukan untuk No. HP <b><?= htmlspecialchars($no_hp) ?></b>.</p>
      <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
