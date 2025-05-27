<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Admin - Siparişler</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 40px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background: white;
            font-size: 14px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>🧾 Sipariş Listesi</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kullanıcı</th>
                <th>Masa</th>
                <th>Toplam</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '—' }}</td>
                    <td>{{ $order->table->name ?? '—' }}</td>
                    <td>{{ number_format($order->total_price, 2) }} ₺</td>
                    <td>
                        <form method="POST" action="/admin/orders/{{ $order->id }}/update-status">
                            @csrf
                            <select name="status" onchange="this.form.submit()">
                                @foreach(['pending', 'preparing', 'ready', 'served', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="admin/orders/{{ $order->id }}" target="_blank">Detay</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>