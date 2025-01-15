<?php
require_once 'config.php';

// Ambil URL ID dari parameter  
$url_id = $_GET['url_id'] ?? '';

// Query data utama split bill  
$query = "SELECT *, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s') AS formatted_date FROM split_bills WHERE url_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $url_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Data tidak ditemukan!";
    exit;
}

$split_bill = $result->fetch_assoc();

// Query data detail split bill  
$query_details = "SELECT * FROM split_bill_details WHERE split_bill_id = ?";
$stmt_details = $conn->prepare($query_details);
$stmt_details->bind_param("i", $split_bill['id']);
$stmt_details->execute();
$result_details = $stmt_details->get_result();

// Query data pembayaran  
$query_payment = "SELECT * FROM split_bill_payments WHERE split_bill_id = ?";
$stmt_payment = $conn->prepare($query_payment);
$stmt_payment->bind_param("i", $split_bill['id']);
$stmt_payment->execute();
$result_payment = $stmt_payment->get_result();
$payment = $result_payment->fetch_assoc();

// URL screenshot untuk Open Graph  
$screenshot_url = "https://hitung.zekriansyah.com/screenshots/$url_id.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Hasil Split Bill - zekri.id">
    <meta property="og:description" content="Total Akhir: Rp. <?= number_format($split_bill['total_akhir'], 2, ',', '.') ?>">
    <meta property="og:image" content="<?= $screenshot_url ?>">
    <meta property="og:url" content="https://hitung.zekriansyah.com/view_split_bill.php?url_id=<?= $url_id ?>">
    <meta property="og:type" content="website">
    <title>Result Split Bill - zekri.id</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
        }
        
        .gradient-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .gradient-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
        
        .main-card {
            background: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .btn-hover {
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .table-hover tr:hover {
            background: linear-gradient(90deg, #f8fafc 0%, #ffffff 100%);
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f4f8 0%, #edf2f7 50%, #f0f4f8 100%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E0 #F7FAFC;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F7FAFC;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 3px;
        }
    </style>
</head>
<body class="min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-5xl animate-fade-in">
        <!-- Main Card -->
        <div class="main-card rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="text-center p-10 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h1 class="text-4xl font-bold text-gray-800 mb-3">Hasil Split Bill</h1>
                <p class="text-gray-500 flex items-center justify-center gap-2">
                    <i class="far fa-calendar-alt"></i>
                    <?= htmlspecialchars($split_bill['formatted_date']) ?>
                </p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Cost Summary Card -->
                <div class="gradient-card rounded-xl p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-receipt text-blue-500 mr-3"></i>
                        Ringkasan Biaya
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600">Total Sebelum Diskon</span>
                            <span class="font-medium">Rp. <?= number_format($split_bill['total_sebelum_diskon'], 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600">Biaya Ongkir</span>
                            <span class="font-medium">Rp. <?= number_format($split_bill['biaya_ongkir'], 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600">Biaya Lain</span>
                            <span class="font-medium">Rp. <?= number_format($split_bill['biaya_lain'], 0, ',', '.') ?></span>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="text-gray-600">Total Diskon</span>
                                <span class="font-medium text-green-600">Rp. <?= number_format($split_bill['total_sebelum_diskon'] - $split_bill['total_akhir'] + $split_bill['biaya_ongkir'] + $split_bill['biaya_lain'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final Total Card -->
                <div class="gradient-card rounded-xl p-8 bg-gradient-to-br from-green-50 to-emerald-50 border-green-100">
                    <h3 class="text-xl font-semibold text-green-800 mb-6 flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        Total Akhir
                    </h3>
                    <div class="text-4xl font-bold text-green-600 mb-3">
                        Rp. <?= number_format($split_bill['total_akhir'], 0, ',', '.') ?>
                    </div>
                    <p class="text-green-700 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Sudah termasuk semua biaya dan diskon
                    </p>
                </div>
            </div>

            <!-- Payment Info -->
            <?php if ($payment): ?>
            <div class="px-8 py-6 bg-gray-50">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    Informasi Pembayaran
                </h3>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                        <?= nl2br(htmlspecialchars($payment['pembayaran'])) ?>
                    </p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Details Table -->
            <div class="px-8 py-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-list-ul text-blue-500 mr-3"></i>
                    Rincian Split Bill
                </h3>
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider rounded-l-lg">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Sebelum Diskon</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Setelah Diskon</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider rounded-r-lg">Biaya Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php while ($detail = $result_details->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    <?= htmlspecialchars($detail['nama']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    Rp. <?= number_format($detail['harga_sebelum_diskon'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    Rp. <?= number_format($detail['harga_setelah_diskon'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    Rp. <?= number_format($detail['biaya_akhir'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-8 py-8 bg-gray-50 space-y-6">
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="index.php" class="btn-hover inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    
                    <a href="/screenshots/<?= $url_id ?>.png" download class="btn-hover inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-download mr-2"></i>
                        Download Screenshot
                    </a>
                </div>

                <div class="flex flex-wrap gap-4 justify-center">
                    <button onclick="copyURL()" class="btn-hover inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                        <i class="fas fa-copy mr-2"></i>
                        Copy URL
                    </button>
                    
                    <a href="#" onclick="shareToWhatsApp()" class="btn-hover inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Share ke WhatsApp
                    </a>
                    
                    <a href="#" onclick="shareToSlack()" class="btn-hover inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700">
                        <i class="fab fa-slack mr-2"></i>
                        Share ke Slack
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            © <?= date('Y') ?> Split Bill By ZEKRI.ID. Everything Here Generated By AI.
        </div>
    </div>

    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            } shadow-lg transform transition-all duration-300 ease-out`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Fungsi untuk copy URL
        function copyURL() {
            navigator.clipboard.writeText(window.location.href)
                .then(() => showToast("URL berhasil disalin!"))
                .catch(() => showToast("Gagal menyalin URL. Silakan salin manual.", "error"));
        }

        // Fungsi untuk share ke WhatsApp
        function shareToWhatsApp() {
            const message = encodeURIComponent(`Halo! Berikut adalah hasil split bill: ${window.location.href}`);
            window.open(`https://api.whatsapp.com/send?text=${message}`, '_blank');
            return false;
        }
        // Fungsi untuk share ke Slack
    function shareToSlack() {
        const message = encodeURIComponent(`Halo! Berikut adalah hasil split bill: ${window.location.href}`);
        window.open(`https://slack.com/app_redirect?channel=culinary&message=${message}`, '_blank');
        return false;
    }

        // Script untuk screenshot
        window.onload = function() {
    // Menonaktifkan animasi dan transisi sebelum mengambil screenshot
    document.body.style.transition = 'none';
    const elementsWithAnimations = document.querySelectorAll('*');
    elementsWithAnimations.forEach(element => {
        element.style.animation = 'none';
        element.style.transition = 'none';
    });

    html2canvas(document.body).then(canvas => {
        const dataURL = canvas.toDataURL('image/png');
        
        fetch('upload_screenshot.php', {
            method: 'POST',
            body: JSON.stringify({
                image: dataURL,
                url_id: '<?= $url_id ?>'
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Screenshot berhasil diunggah!');
            } else {
                console.error('Gagal mengunggah screenshot:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        // Menghidupkan kembali animasi setelah screenshot selesai
        setTimeout(() => {
            elementsWithAnimations.forEach(element => {
                element.style.animation = ''; // Reset animation
                element.style.transition = ''; // Reset transition
            });
        }, 100);
    });
};

    </script>

    <!-- Script html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</body