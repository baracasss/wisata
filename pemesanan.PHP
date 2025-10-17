<?php include "koneksi.php"; ?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pemesanan Tiket Wisata</title>
<link rel="stylesheet" href="stylephp.css">
<script>
function hitungTotal(){
  const tipe = document.querySelector('[name="tipe"]').value;
  const jumlah = parseInt(document.querySelector('[name="jumlah"]').value) || 0;
  let harga = 0;
  if(tipe === "Domestik") harga = 25000;
  else if(tipe === "Mancanegara") harga = 100000;
  const total = harga * jumlah;
  document.getElementById("totalHarga").innerText = total ? "Total Harga: Rp " + total.toLocaleString() : "";
}
</script>
</head>
<body>
<div class="wrap">
  <h2>Pemesanan Tiket Wisata</h2>
  <form action="verifikasi.php" method="post">
    <label>Destinasi:</label>
    <input type="text" name="destinasi" required>

    <label>Nama:</label>
    <input type="text" name="nama" required>
    
    <label>No. HP:</label>
    <input type="text" name="no_hp" required>

    <label>Jumlah Tiket:</label>
    <input type="number" name="jumlah" min="1" required oninput="hitungTotal()">

    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Jenis Tiket:</label>
    <select name="tipe" required onchange="hitungTotal()">
      <option value="">-- Pilih --</option>
      <option value="Domestik">Domestik</option>
      <option value="Mancanegara">Mancanegara</option>
    </select>

    <div id="totalHarga" style="margin-top:10px;color:#2dd4bf;font-weight:bold;"></div>

    <label>Metode Pembayaran:</label>
    <select name="metode_pembayaran" required>
      <option value="">-- Pilih Metode --</option>
      <option value="BCA">BCA</option>
      <option value="DANA">DANA</option>
      <option value="OVO">OVO</option>
      <option value="GoPay">GoPay</option>
      <option value="LinkAja">LinkAja</option>
      <option value="ShopeePay">ShopeePay</option>
    </select>

    <button type="submit">Pesan Sekarang</button>
  </form>
</div>
</body>
</html>
