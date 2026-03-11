2. Melihat License (User Dashboard)
User bisa melihat license key mereka di halaman Dashboard → Downloads & Keys (/dashboard/downloads). Di sana tersedia:

License Key yang bisa di-copy
Info jumlah device yang sudah diaktivasi vs batas maksimal
Tombol Download Latest File
3. Penggunaan License oleh Pembeli
License key ini bersifat informasional — pembeli menyimpannya sebagai bukti pembelian sah. Dalam konteks marketplace software seperti DigtafWare, license key biasanya digunakan untuk:

Aktivasi software yang didownload (jika software-nya memiliki fitur validasi license)
Mendapatkan update di kemudian hari
Bukti kepemilikan produk digital
⚠️ Yang Perlu Diketahui
Saat ini, sistem license di DigtafWare bersifat dasar — artinya key dibuat dan ditampilkan, tapi belum ada API validasi license di sisi server untuk memverifikasi apakah key valid dari dalam software yang dijual. Jika Anda ingin menambahkan fitur itu (misalnya endpoint API /api/license/verify), saya bisa membuatkannya.

Apakah ada yang ingin ditambahkan atau diubah pada sistem license ini?


pasang lisensi
function verifyLicense($licenseKey) {
    $response = file_get_contents('https://yourdomain.com/api/license/verify', false, 
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode([
                    'license_key' => $licenseKey,
                    'device_id'   => gethostname(), // ID unik perangkat
                ]),
            ]
        ])
    );

    $result = json_decode($response, true);

    if (!$result || !$result['valid']) {
        die('❌ License tidak valid! Silakan beli di DigtafWare.');
    }

    echo '✅ License aktif untuk: ' . $result['product']['title'];
}

// Panggil saat aplikasi dimulai
verifyLicense('DGTF-37KM-UNUV-RKRP');
