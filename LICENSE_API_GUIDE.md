# DigtafWare License Verification API Guide

Panduan integrasi verifikasi license ke aplikasi yang dijual melalui DigtafWare.

## API Endpoints

### Verifikasi License
```
POST /api/license/verify
Content-Type: application/json
```

**Request Body:**
```json
{
    "license_key": "DGTF-XXXX-XXXX-XXXX",
    "device_id": "optional-unique-device-id"
}
```

**Response (200 - Valid):**
```json
{
    "valid": true,
    "message": "License is valid and active.",
    "license": { "key": "...", "status": "active", "device_limit": 3, "activated_devices": 1 },
    "product": { "id": 1, "title": "Product Name", "slug": "product-name", "version": "1.0.0" }
}
```

**Error Responses:** `404` (not found), `403` (suspended/expired/device limit reached)

### Deaktivasi Device
```
POST /api/license/deactivate
Content-Type: application/json
```

**Request Body:**
```json
{ "license_key": "DGTF-XXXX-XXXX-XXXX" }
```

---

## Contoh Integrasi

### PHP / Laravel
```php
function verifyLicense($licenseKey) {
    $response = file_get_contents('https://yourdomain.com/api/license/verify', false, 
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode([
                    'license_key' => $licenseKey,
                    'device_id'   => gethostname(),
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

verifyLicense('DGTF-XXXX-XXXX-XXXX');
```

### JavaScript / Node.js
```javascript
async function verifyLicense(licenseKey) {
    const res = await fetch('https://yourdomain.com/api/license/verify', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            license_key: licenseKey,
            device_id: require('os').hostname()
        })
    });

    const data = await res.json();

    if (!data.valid) {
        console.error('❌ License tidak valid:', data.message);
        process.exit(1);
    }

    console.log('✅ License aktif untuk:', data.product.title);
}

verifyLicense('DGTF-XXXX-XXXX-XXXX');
```

### Python
```python
import requests, platform

def verify_license(license_key):
    response = requests.post('https://yourdomain.com/api/license/verify', json={
        'license_key': license_key,
        'device_id': platform.node()
    })
    
    data = response.json()
    
    if not data.get('valid'):
        raise SystemExit(f"❌ License tidak valid: {data.get('message')}")
    
    print(f"✅ License aktif untuk: {data['product']['title']}")

verify_license('DGTF-XXXX-XXXX-XXXX')
```

---

## Alur Kerja

1. **Pembeli** membeli produk di DigtafWare → mendapat **license key**
2. **Pembeli** memasukkan license key ke dalam aplikasi yang didownload
3. **Aplikasi** mengirim request ke `POST /api/license/verify`
4. **Server DigtafWare** mengecek key dan mengembalikan hasilnya
5. Jika **valid** → aplikasi berjalan normal. Jika **tidak valid** → aplikasi menolak

> **Catatan:** Ganti `https://yourdomain.com` dengan domain asli tempat DigtafWare di-deploy.
