<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $destinasi = $_POST["destinasi"];
  $nama = $_POST["nama"];
  $no_hp = $_POST["no_hp"];
  $jumlah = (int)$_POST["jumlah"];
  $tanggal = $_POST["tanggal"];
  $tipe = $_POST["tipe"];
  $metode = $_POST["metode_pembayaran"];

  $qWisata = $conn->query("SELECT id FROM wisata WHERE LOWER(nama_wisata)=LOWER('$destinasi') LIMIT 1");
  if ($qWisata && $qWisata->num_rows > 0) {
    $id_wisata = $qWisata->fetch_assoc()["id"];
    $harga = ($tipe == "Domestik") ? 25000 : 100000;
    $total = $harga * $jumlah;

    $sql = "INSERT INTO pemesanan (id_wisata,nama,no_hp,jumlah,tanggal,tipe,metode_pembayaran,total_harga,status_pembayaran)
            VALUES ('$id_wisata','$nama','$no_hp','$jumlah','$tanggal','$tipe','$metode','$total','Menunggu Verifikasi')";
    if ($conn->query($sql) === TRUE) {
      echo "<div class='wrap'><section>
            <h3>✅ Pesanan berhasil disimpan!</h3>
            <p>Terima kasih <b>$nama</b>, pesanan kamu untuk <b>$destinasi</b> telah diterima.</p>
            <p><b>Total:</b> Rp " . number_format($total,0,',','.') . "</p>
            <p><b>Metode:</b> $metode</p>
            <p>Status: <span class='menunggu'>Menunggu Verifikasi</span></p>
            <a href='status_pembayaran.php'>Cek Status Pembayaran</a></section></div>";
    } else echo "❌ Gagal menyimpan: " . $conn->error;
  } else echo "❌ Destinasi tidak ditemukan di database.";
}
?>

<style>
body{margin:0;font-family:sans-serif;background:linear-gradient(180deg,#071021,#071827 60%);color:#e6f0f2;padding:20px;display:flex;justify-content:center}
.wrap{max-width:700px;width:100%}
section{background:rgba(255,255,255,.05);padding:20px;border-radius:8px}
h3{color:#2dd4bf}
a,button{background:#2dd4bf;color:#071021;text-decoration:none;padding:8px 15px;border-radius:6px;font-weight:bold}
a:hover,button:hover{background:#20bda8}
.menunggu{color:#facc15;font-weight:bold}
</style>
