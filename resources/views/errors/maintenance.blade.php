<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sedang Dalam Perbaikan</title>
    <style>
        :root {
            --primary: #0992C2;
            --dark: #1f2937;
            --muted: #6b7280;
            --bg: #f3f4f6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #e0f2fe, var(--bg));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--dark);
        }

        .card {
            width: 100%;
            max-width: 680px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 35px rgba(31, 41, 55, 0.12);
            padding: 36px 28px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .badge {
            display: inline-block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #fff;
            background: var(--primary);
            padding: 8px 12px;
            border-radius: 999px;
            margin-bottom: 16px;
        }

        h1 {
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            margin-bottom: 10px;
            color: var(--dark);
        }

        p {
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 18px;
            font-size: 1rem;
        }

        .status {
            margin-top: 6px;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .btn-primary {
            color: #fff;
            background: var(--primary);
        }

        .btn-outline {
            color: var(--dark);
            border-color: #d1d5db;
            background: #fff;
        }

        .note {
            margin-top: 18px;
            font-size: 0.86rem;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="card">
        <span class="badge">INFORMASI SISTEM</span>
        <h1>Website Sedang Dalam Perbaikan</h1>
        <p>
            Mohon maaf atas ketidaknyamanannya. Tim kami sedang melakukan pemeliharaan
            agar layanan website kembali normal dan lebih stabil.
        </p>
        <div class="status">Kode Status: {{ $status ?? 500 }}</div>
        <div class="actions">
            <a class="btn btn-primary" href="{{ url('/') }}">Kembali ke Beranda</a>
            <a class="btn btn-outline" href="javascript:location.reload()">Coba Lagi</a>
        </div>
        <div class="note">BLUD SMKN 1 Ciamis</div>
    </div>
</body>

</html>
