<?php

require_once 'config.php';

// Proses jika form submit_split dikirim
if (isset($_POST['submit_split'])) {
    $jumlah_orang = intval($_POST['jumlah_orang']);
    $biaya_ongkir = floatval($_POST['biaya_ongkir']);
    $biaya_lain = floatval($_POST['biaya_lain']);
    $diskon_persen = floatval($_POST['diskon_persen']);
    $diskon_rupiah = floatval($_POST['diskon_rupiah']);
    $total_sebelum_diskon = 0;

    // Menghitung total harga sebelum diskon
    for ($i = 1; $i <= $jumlah_orang; $i++) {
        $total_sebelum_diskon += floatval($_POST["harga_sebelum_diskon_$i"]);
    }

    // Perhitungan total
    $persentase_diskon_rupiah = $diskon_rupiah / $total_sebelum_diskon;
    $total_diskon_persen = $total_sebelum_diskon * $diskon_persen / 100;
    $total_diskon = $total_diskon_persen + $diskon_rupiah;
    $total_setelah_diskon = $total_sebelum_diskon - $total_diskon;
    $total_akhir = $total_setelah_diskon + $biaya_ongkir + $biaya_lain;

    // Buat URL unik untuk hasil split bill
    $url_id = uniqid();

    // Simpan data utama ke tabel split_bills
    $query = "INSERT INTO split_bills (url_id, jumlah_orang, biaya_ongkir, biaya_lain, diskon_persen, diskon_rupiah, total_sebelum_diskon, total_akhir, created_at)
          VALUES ('$url_id', $jumlah_orang, $biaya_ongkir, $biaya_lain, $diskon_persen, $diskon_rupiah, $total_sebelum_diskon, $total_akhir, NOW())";
    $conn->query($query);
    $split_bill_id = $conn->insert_id;

    // Simpan data detail ke tabel split_bill_details
    $total_ongkir_lain = $biaya_ongkir + $biaya_lain; // Total ongkir dan biaya lain
    $sisa_pembulatan = $total_ongkir_lain; // Awalnya sama dengan total ongkir dan biaya lain

    for ($i = 1; $i <= $jumlah_orang; $i++) {
        $nama = $conn->real_escape_string($_POST["nama_$i"]);
        $harga_sebelum_diskon = floatval($_POST["harga_sebelum_diskon_$i"]);
        $diskon_individual_persen = $harga_sebelum_diskon * $diskon_persen / 100;
        $diskon_individual_rupiah = $harga_sebelum_diskon * $persentase_diskon_rupiah;
        $biaya_individual = $harga_sebelum_diskon - $diskon_individual_persen - $diskon_individual_rupiah;

        // Hitung bagian ongkir dan biaya lain (proporsional)
        $bagian_ongkir_lain = round($total_ongkir_lain / $jumlah_orang, 2);
        $sisa_pembulatan -= $bagian_ongkir_lain;

        // Jika ini iterasi terakhir, tambahkan sisa pembulatan untuk akurasi total
        if ($i === $jumlah_orang) {
            $bagian_ongkir_lain += $sisa_pembulatan;
        }

        $biaya_individual_akhir = $biaya_individual + $bagian_ongkir_lain;

        $query = "INSERT INTO split_bill_details (split_bill_id, nama, harga_sebelum_diskon, harga_setelah_diskon, biaya_akhir)
                  VALUES ($split_bill_id, '$nama', $harga_sebelum_diskon, $biaya_individual, $biaya_individual_akhir)";
        $conn->query($query);
    }

    // Simpan data nomor pembayaran (rekening/metode pembayaran)
    $pembayaran = $_POST['pembayaran'] ?? '';  // Ambil nomor pembayaran jika ada
    if ($pembayaran) {
        $pembayaran = $conn->real_escape_string($pembayaran); // Escape data untuk mencegah SQL Injection
        $query_pembayaran = "INSERT INTO split_bill_payments (split_bill_id, pembayaran)
                             VALUES ($split_bill_id, '$pembayaran')";
        $conn->query($query_pembayaran);
    }

    // Redirect ke halaman view_split_bill dengan URL unik
    header("Location: /$url_id");
    exit;
}
?>
