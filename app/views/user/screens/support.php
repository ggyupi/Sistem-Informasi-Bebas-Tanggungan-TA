<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Section</title>
    <style>
        #support-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            padding: 24px;
            border-radius: 12px;
            background-color: var(--bs-body-bg, #ffffff);
            margin: auto;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #support-section h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px; /* Jarak antara ikon dan teks */
            width: 100%;
            padding: 12px 16px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .contact-item:hover {
            background-color: #e9ecef;
        }

        .contact-item img {
            width: 24px;x
        }

        .info-text {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div id="support-section">
        <h1>Hubungi Kami</h1>
        <a href="https://wa.me/+6289517032681" class="contact-item">
            <img src="https://www.cdnlogo.com/logos/w/29/whatsapp-icon.svg" alt="WhatsApp Icon">
            <span>WhatsApp - Admin Candra</span>
        </a>
        <a href="https://wa.me/+6281456010040" class="contact-item">
            <img src="https://www.cdnlogo.com/logos/w/29/whatsapp-icon.svg" alt="WhatsApp Icon">
            <span>WhatsApp - Admin Beryl</span>
        </a>
        <a href="mailto:polinema@ac.id" class="contact-item">
            <img src="https://mailmeteor.com/logos/assets/PNG/Gmail_Logo_512px.png" alt="Email Icon">
            <span>Email - polinema@ac.id</span>
        </a>
        <div class="info-text">
            Pesan Akan Dibalas Pada Hari Dan Jam Kerja <br>
        </div>
    </div>
</body>

</html>
