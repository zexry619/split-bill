<?php
// Set header untuk respon JSON
header('Content-Type: application/json');

try {
    // Ambil data dari POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi data
    if (!isset($data['image']) || !isset($data['url_id'])) {
        throw new Exception("Data tidak lengkap. Pastikan 'image' dan 'url_id' tersedia.");
    }

    $image = $data['image'];
    $url_id = $data['url_id'];

    // Tentukan path penyimpanan file
    $directory = __DIR__ . '/screenshots';
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true); // Buat folder jika belum ada
    }

    $file_name = $directory . '/' . $url_id . '.png';

    // Periksa apakah file sudah ada
    if (file_exists($file_name)) {
        echo json_encode([
            'success' => true,
            'message' => 'File sudah ada, tidak perlu diunggah ulang.',
            'file' => $file_name
        ]);
        exit;
    }

    // Pecah string base64 untuk mendapatkan data mentah gambar
    $image_parts = explode(";base64,", $image);
    if (count($image_parts) !== 2) {
        throw new Exception("Format data gambar tidak valid.");
    }

    $image_base64 = base64_decode($image_parts[1]);
    if ($image_base64 === false) {
        throw new Exception("Data base64 tidak dapat didekode.");
    }

    // Simpan file ke server
    if (file_put_contents($file_name, $image_base64) === false) {
        throw new Exception("Gagal menyimpan file ke server.");
    }

    // Respon sukses
    echo json_encode([
        'success' => true,
        'message' => 'File berhasil diunggah.',
        'file' => $file_name
    ]);
} catch (Exception $e) {
    // Respon jika terjadi kesalahan
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
