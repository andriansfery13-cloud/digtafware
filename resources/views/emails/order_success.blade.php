<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .order-info h3 {
            margin-top: 0;
            color: #1e293b;
            font-size: 18px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .item-name {
            font-weight: 600;
            color: #334155;
        }
        .item-price {
            color: #64748b;
        }
        .license-key {
            background-color: #f1f5f9;
            padding: 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            color: #475569;
            margin-top: 5px;
            display: block;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            font-weight: 700;
            font-size: 18px;
            color: #1e293b;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #6366f1;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Terima Kasih Atas Pembelian Anda!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $order->user->name }}</strong>,</p>
            <p>Pembayaran Anda untuk pesanan <strong>#{{ $order->order_number }}</strong> telah berhasil diverifikasi. Detail pesanan Anda adalah sebagai berikut:</p>
            
            <div class="order-info">
                <h3>Rincian Pesanan</h3>
                @foreach($order->items as $item)
                    <div class="item-row" style="display: block;">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="item-name">{{ $item->product->name }}</span>
                            <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        @if($item->license_key)
                            <div class="license-key">
                                License: {{ $item->license_key }}
                            </div>
                        @endif
                    </div>
                @endforeach
                
                <div class="total-row">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <p>Anda dapat mengunduh produk digital Anda melalui dashboard akun Anda.</p>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/dashboard" class="button">Ke Dashboard</a>
            </div>

            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami di support@digtafjayainovasi.com.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
            Jl. Digtaf Jaya Inovasi, Indonesia
        </div>
    </div>
</body>
</html>
