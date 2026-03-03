<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fc;
            padding: 30px;
            border: 1px solid #e3e6f0;
        }

        .message-box {
            background-color: white;
            padding: 20px;
            border-left: 4px solid #4e73df;
            margin: 20px 0;
            border-radius: 4px;
        }

        .footer {
            background-color: #f8f9fc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #858796;
            border-top: 1px solid #e3e6f0;
        }

        .original-message {
            background-color: #e7f3ff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
            border-left: 3px solid #2196F3;
        }

        .label {
            font-weight: bold;
            color: #5a5c69;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 style="margin: 0;">Balasan dari {{ config('app.name') }}</h1>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $contact->name }}</strong>,</p>

        <p>Terima kasih telah menghubungi kami. Berikut adalah balasan untuk pesan Anda:</p>

        <div class="message-box">
            {!! nl2br(e($replyMessage)) !!}
        </div>

        <div class="original-message">
            <p class="label">Pesan Asli Anda:</p>
            <p><strong>Subjek:</strong> {{ $contact->subject }}</p>
            <p><strong>Pesan:</strong></p>
            <p>{{ $contact->message }}</p>
            <p style="color: #858796; font-size: 12px; margin-top: 10px;">
                <strong>Dikirim pada:</strong> {{ $contact->created_at->format('d F Y H:i') }}
            </p>
        </div>

        <p style="margin-top: 20px;">
            Jika Anda memiliki pertanyaan lebih lanjut, silakan membalas email ini atau menghubungi kami kembali.
        </p>

        <p>Salam hormat,<br>
            <strong>Tim {{ config('app.name') }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas ke email ini.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>