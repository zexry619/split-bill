<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Split Bill - zekri.id</title>
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
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            transition: all 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-2px);
        }

        .input-label {
            transition: all 0.2s ease;
        }

        .input-focus:focus + .input-label {
            color: #3B82F6;
        }
    </style>
</head>
<body class="min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-4xl animate-fade-in">
        <!-- Form Input -->
        <div class="main-card rounded-2xl shadow-xl overflow-hidden mb-8">
            <!-- Header -->
            <div class="text-center p-10 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h1 class="text-4xl font-bold text-gray-800 mb-3">Split Bill Calculator</h1>
                <p class="text-gray-500">Masukkan detail pembagian biaya</p>
            </div>

            <div class="p-8">
                <form action="" method="post" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div class="bg-gray-50 p-6 rounded-xl mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-users text-blue-500 mr-3"></i>
                            Informasi Dasar
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="jumlah_orang" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Orang
                                </label>
                                <div class="relative">
                                    <input type="number" name="jumlah_orang" id="jumlah_orang" min="1" required 
                                           class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                    <i class="fas fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="biaya_ongkir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biaya Ongkir
                                </label>
                                <div class="relative">
                                    <input type="number" name="biaya_ongkir" id="biaya_ongkir" step="0.01" required 
                                           class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                    <i class="fas fa-truck absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Costs Section -->
                    <div class="bg-gray-50 p-6 rounded-xl mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-coins text-blue-500 mr-3"></i>
                            Biaya Tambahan & Diskon
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="biaya_lain" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biaya Lainnya
                                </label>
                                <div class="relative">
                                    <input type="number" name="biaya_lain" id="biaya_lain" step="0.01" 
                                           class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                    <i class="fas fa-plus-circle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="diskon_persen" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diskon (%)
                                </label>
                                <div class="relative">
                                    <input type="number" name="diskon_persen" id="diskon_persen" step="0.01" min="0" max="100" 
                                           class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                    <i class="fas fa-percent absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="diskon_rupiah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diskon (Rp)
                                </label>
                                <div class="relative">
                                    <input type="number" name="diskon_rupiah" id="diskon_rupiah" step="0.01" min="0" 
                                           class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                    <i class="fas fa-tag absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information Section -->
                    <div class="bg-gray-50 p-6 rounded-xl mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                            Informasi Pembayaran
                        </h2>
                        <div class="form-group">
                            <label for="pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Detail Pembayaran
                            </label>
                            <textarea name="pembayaran" id="pembayaran" rows="4" 
                                      class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none"
                                      placeholder="Masukkan informasi rekening atau metode pembayaran..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" name="submit" 
                                class="btn-hover inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-calculator mr-2"></i>
                            Lanjut ke Detail Orang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($_POST['submit'])): ?>
        <div class="main-card rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <div class="text-center p-10 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Detail Peserta Split Bill</h2>
                <p class="text-gray-500">Masukkan rincian untuk setiap orang</p>
            </div>

            <div class="p-8">
                <form action="split_bill.php" method="post" class="space-y-6">
                    <!-- Hidden inputs for previous form data -->
                    <?php foreach ($_POST as $key => $value): ?>
                        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endforeach; ?>

                    <div class="grid grid-cols-1 gap-6">
                        <?php for ($i = 1; $i <= $_POST['jumlah_orang']; $i++): ?>
                        <div class="gradient-card rounded-xl p-6 space-y-4">
                            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                                Peserta <?= $i ?>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="nama_<?= $i ?>" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="nama_<?= $i ?>" id="nama_<?= $i ?>" required 
                                               class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                        <i class="fas fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="harga_sebelum_diskon_<?= $i ?>" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga Sebelum Diskon
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="harga_sebelum_diskon_<?= $i ?>" id="harga_sebelum_diskon_<?= $i ?>" 
                                               step="0.01" required 
                                               class="input-focus block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none">
                                        <i class="fas fa-money-bill absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="flex justify-center pt-6">
                        <button type="submit" name="submit_split" 
                                class="btn-hover inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-calculator mr-2"></i>
                            Hitung Split Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            © <?= date('Y') ?> Split Bill By ZEKRI.ID. All rights reserved.
        </div>
    </div>

    <script>
        // Add smooth scroll when new form appears
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('[name="submit_split"]')) {
                window.scrollTo({
                    top: document.querySelector('[name="submit_split"]').offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const diskonPersen = document.getElementById('diskon_persen');
        const diskonRupiah = document.getElementById('diskon_rupiah');

        function handleDiskonInput() {
            if (diskonPersen.value.trim() !== '') {
                diskonRupiah.disabled = true;
                diskonRupiah.value = ''; // Reset value if disabled
            } else {
                diskonRupiah.disabled = false;
            }

            if (diskonRupiah.value.trim() !== '') {
                diskonPersen.disabled = true;
                diskonPersen.value = ''; // Reset value if disabled
            } else {
                diskonPersen.disabled = false;
            }
        }

        // Event listeners for both inputs
        diskonPersen.addEventListener('input', handleDiskonInput);
        diskonRupiah.addEventListener('input', handleDiskonInput);
    });
</script>
</body>
</html>