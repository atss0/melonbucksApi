<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sipariş Detayı - #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding: 40px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #007BFF;
            color: white;
            text-align: left;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Sipariş Detayı – #{{ $order->id }}</h2>

    <p><strong>Kullanıcı:</strong> {{ $order->user->name ?? '—' }}</p>
    <p><strong>Masa:</strong> {{ $order->table->name ?? '—' }}</p>
    <p><strong>Durum:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Toplam Tutar:</strong> {{ number_format($order->total_price, 2) }} ₺</p>
    <p><strong>Oluşturulma:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>

    <h3>Ürünler</h3>
    <table>
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Ara Toplam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} ₺</td>
                    <td>{{ number_format($item->quantity * $item->price, 2) }} ₺</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/admin/orders">← Tüm Siparişlere Dön</a>
</body>
</html>