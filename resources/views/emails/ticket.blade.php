<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Ticket - AmikomEventHub</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #4f46e5; margin: 0; padding: 40px 20px; color: #ffffff; }
        .container { max-width: 450px; margin: 0 auto; width: 100%; }
        .header-text { text-align: center; margin-bottom: 30px; }
        .header-text h1 { font-size: 28px; font-weight: 900; margin: 0 0 10px 0; }
        .header-text p { color: #e0e7ff; margin: 0; }
        .ticket-card { background-color: #ffffff; color: #0f172a; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .ticket-top { background-color: #eef2ff; padding: 20px; text-align: center; border-bottom: 2px dashed #c7d2fe; }
        .ticket-top p { color: #4f46e5; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 10px 0; }
        .ticket-top h2 { font-size: 20px; font-weight: 900; margin: 0; }
        .ticket-body { padding: 20px; }
        .grid { display: block; width: 100%; margin-bottom: 10px; }
        .grid-item { display: inline-block; width: 48%; vertical-align: top; margin-bottom: 10px; }
        .label { color: #94a3b8; font-size: 11px; font-weight: bold; text-transform: uppercase; margin: 0 0 5px 0; }
        .value { font-weight: bold; font-size: 14px; margin: 0; }
        .qr-section { background-color: #f8fafc; padding: 15px; border-radius: 12px; text-align: center; margin-top: 10px; }
        .qr-container { background-color: white; padding: 10px; border-radius: 8px; display: inline-block; margin-bottom: 10px; }
        .footer { text-align: center; padding: 10px 20px 20px 20px; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-text">
            <h1>Pembayaran Berhasil!</h1>
            <p>Tiket Anda telah terbit dan siap digunakan.</p>
        </div>

        <div class="ticket-card">
            <div class="ticket-top">
                <p>E-Ticket Resmi</p>
                <h2>{{ $transaction->event->title ?? 'Acara' }}</h2>
            </div>
            <div class="ticket-body">
                <div class="grid">
                    <div class="grid-item">
                        <p class="label">Nama Pembeli</p>
                        <p class="value">{{ $transaction->customer_name }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Tanggal & Waktu</p>
                        <p class="value">{{ \Carbon\Carbon::parse($transaction->event->date ?? now())->format('d M, H:i') }}</p>
                    </div>
                </div>

                <div class="grid">
                    <div class="grid-item">
                        <p class="label">Order ID</p>
                        <p class="value">{{ $transaction->order_id }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Lokasi</p>
                        <p class="value">{{ $transaction->event->location ?? '-' }}</p>
                    </div>
                </div>

                <div class="qr-section">
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaction->order_id) }}" alt="QR Code">
                    </div>
                    <div>{{ $transaction->order_id }}</div>
                </div>
            </div>
        </div>

        <div class="footer">
            Mohon tunjukkan E-Ticket ini saat memasuki area acara.<br>
            © {{ date('Y') }} AmikomEventHub.
        </div>
    </div>
</body>
</html>
