<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Landscape | AMIN JUNIAR S</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #2b3e4f;
            background: linear-gradient(145deg, #1e2e3a 0%, #2f4a5e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', 'Roboto', system-ui, sans-serif;
            padding: 20px;
        }

        /* SERTIFIKAT LANDSCAPE - MEMANJANG KE SAMPING */
        .certificate {
            width: 1200px;  /* lebih lebar untuk landscape */
            max-width: 100%;
            background: #fcfaf5;
            background-image: radial-gradient(circle at 30% 40%, rgba(230, 215, 190, 0.3) 0%, transparent 30%),
                              linear-gradient(165deg, #ffffff 0%, #f6f1e6 100%);
            border-radius: 42px 42px 38px 38px;
            box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(200, 180, 150, 0.5) inset, 0 0 0 3px #ede3d3 inset;
            padding: 45px 60px;  /* padding kiri-kanan lebih besar */
            position: relative;
            transition: all 0.2s ease;
            /* properti tambahan untuk cetak */
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* border dekoratif samar - menyesuaikan landscape */
        .certificate::before {
            content: "";
            position: absolute;
            top: 25px; left: 25px; right: 25px; bottom: 25px;
            border: 2px double #b89b7e;
            border-radius: 30px;
            opacity: 0.45;
            pointer-events: none;
        }

        /* header: logo + teks DISKOMINFO SOLUSI */
        .header {
            display: flex;
            align-items: center;
            gap: 40px;  /* lebih renggang untuk landscape */
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        /* SIMULASI LOGO PNG */
        .logo-graphic {
            width: 120px;  /* sedikit lebih besar */
            height: 120px;
            background: radial-gradient(circle at 30% 30%, #005c86, #003753);
            border-radius: 30% 70% 70% 30% / 30% 55% 45% 70%;
            box-shadow: 6px 8px 12px rgba(0,20,30,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 3px solid rgba(255,215,150,0.7);
            transform: rotate(-2deg);
        }

        .logo-graphic span:first-child {
            font-size: 24px;
            margin-bottom: -4px;
            text-shadow: 2px 2px 0 #002a44;
        }

        .logo-graphic span:last-child {
            font-size: 16px;
            background: #f5b034;
            color: #003753;
            padding: 4px 14px 5px 14px;
            border-radius: 40px;
            font-weight: 800;
            margin-top: 5px;
            box-shadow: inset 0 -2px 0 #b1640e;
        }

        .logo-text {
            font-weight: 600;
            border-left: 4px solid #f5b034;
            padding-left: 25px;
        }

        .logo-text .diskominfo {
            font-size: 42px;  /* lebih besar */
            font-weight: 800;
            letter-spacing: 1px;
            color: #003753;
            line-height: 1;
            text-transform: uppercase;
        }

        .logo-text .solusi {
            font-size: 40px;
            font-weight: 800;
            color: #1d6f8f;
            letter-spacing: 3px;
            margin-top: -5px;
        }

        .logo-text .tagline {
            font-size: 16px;
            font-weight: 500;
            color: #5f5a4f;
            font-style: italic;
            margin-top: 8px;
            letter-spacing: 0.5px;
            word-spacing: 1px;
        }

        .tagline-detail {
            font-size: 16px;
            color: #003753;
            background: #ede3d1;
            padding: 8px 25px;
            border-radius: 40px;
            margin-left: auto;
            font-weight: 500;
            box-shadow: 0 2px 0 #b89b7e;
            white-space: nowrap;
        }

        /* main title sertifikat */
        .certificate-title {
            text-align: center;
            margin: 30px 0 25px 0;
            position: relative;
        }

        .certificate-title .main {
            font-size: 52px;  /* lebih besar untuk landscape */
            font-weight: 700;
            letter-spacing: 8px;
            color: #2c4c5e;
            text-transform: uppercase;
            background: linear-gradient(180deg, #003753, #1c6177);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 0 rgba(180, 145, 100, 0.2);
        }

        .certificate-title .sub {
            font-size: 24px;
            font-weight: 400;
            color: #6a5f4b;
            border-bottom: 1px dashed #cbae8c;
            padding-bottom: 15px;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        /* badge / icon dekoratif */
        .elec-badge {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0 20px;
            color: #6c4f2e;
            font-weight: 500;
        }

        .elec-badge span {
            background: #e6d8c0;
            padding: 6px 25px;
            border-radius: 40px;
            font-size: 18px;
            box-shadow: inset 0 0 0 1px #ccb690;
        }

        /* konten nama / penerima */
        .recipient {
            text-align: center;
            margin: 20px 0 20px;
        }

        .recipient-label {
            font-size: 22px;
            text-transform: uppercase;
            color: #4e4a40;
            letter-spacing: 4px;
            margin-bottom: 12px;
        }

        .recipient-name {
            font-size: 72px;  /* lebih besar dan lebar */
            font-weight: 800;
            color: #1a4352;
            line-height: 1.2;
            border-bottom: 3px solid #cdb28b;
            border-top: 3px solid #cdb28b;
            display: inline-block;
            padding: 15px 60px;
            background: rgba(250, 240, 225, 0.7);
            font-family: 'Times New Roman', serif;
            text-shadow: 2px 2px 0 rgba(255, 215, 150, 0.5);
            margin-bottom: 12px;
            letter-spacing: 2px;
        }

        .recipient-desc {
            font-size: 24px;
            color: #3d3529;
            font-weight: 400;
        }

        /* DETAIL INFO - DIBUAT LEBIH LEBAR DAN SEJAJAR UNTUK LANDSCAPE */
        .detail-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 40px 0 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .detail-item {
            font-size: 20px;
            color: #2e4b53;
            border-left: 6px solid #f5b034;
            padding: 15px 30px;
            background: rgba(255,245,230,0.6);
            border-radius: 0 40px 40px 0;
            width: fit-content;
            flex: 1 1 auto;
            min-width: 250px;
        }

        .detail-item strong {
            font-weight: 700;
            color: #003753;
            display: inline-block;
            min-width: 140px;
            font-size: 20px;
        }

        .qrcode-sim {
            background: #1d2c34;
            width: 110px;
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e0d6c0;
            font-size: 13px;
            text-align: center;
            border: 5px solid #cbb088;
            padding: 5px;
            background: repeating-linear-gradient(45deg, #2d4a55 0px, #2d4a55 8px, #3b5f6b 8px, #3b5f6b 16px);
            border-radius: 20px;
            box-shadow: 0 10px 0 #0a1e26;
        }

        .qrcode-sim span {
            background: #fef7e9;
            padding: 6px 8px;
            border-radius: 12px;
            font-weight: 700;
            color: #003753;
        }

        /* FOOTER - DIATUR LEBIH LEBAR UNTUK LANDSCAPE */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 30px;
            border-top: 2px solid #d6bfa0;
            padding-top: 30px;
            gap: 30px;
        }

        .signature {
            text-align: center;
            width: 280px;  /* lebih lebar */
        }

        .signature .line {
            border-bottom: 2px solid #8b7a60;
            width: 250px;
            margin: 8px 0 5px;
            height: 40px;
        }

        .signature p {
            font-weight: 600;
            color: #3e4d4a;
            font-size: 20px;
        }

        .signature small {
            font-size: 16px;
            color: #6b5b44;
        }

        .stamp {
            background: #bc9b6b;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 8px double #fbe6b0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            color: #ffeec9;
            text-transform: uppercase;
            transform: rotate(-10deg);
            background: radial-gradient(circle, #ad7f4a, #7b572b);
            box-shadow: 0 0 0 4px #ecdba8 inset;
            font-family: 'Times New Roman', serif;
            opacity: 0.9;
            margin: 0 auto;
        }

        .stamp span {
            transform: rotate(10deg);
            letter-spacing: 4px;
        }

        /* Container tombol cetak - hanya di layar */
        .print-button-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }

        .print-button {
            background: #f5b034;
            border: none;
            color: #003753;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 8px 0 #b1640e, 0 10px 20px rgba(0,0,0,0.2);
            transition: 0.1s ease;
            border: 2px solid #ffe6b3;
        }

        .print-button:hover {
            transform: translateY(2px);
            box-shadow: 0 6px 0 #b1640e, 0 10px 20px rgba(0,0,0,0.2);
        }

        .print-button:active {
            transform: translateY(8px);
            box-shadow: 0 0px 0 #b1640e, 0 10px 20px rgba(0,0,0,0.2);
        }

        /* style untuk cetak - Tombol TIDAK IKUT CETAK */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
                display: block;
            }
            .certificate {
                box-shadow: none;
                border: 2px solid #b89b7e;
                margin: 0 auto;
                page-break-after: avoid;
                page-break-inside: avoid;
                width: 100%;
                max-width: 1200px;
                background: white;
            }
            .tagline-detail, .elec-badge span, .detail-item {
                background: #f0e9db !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .logo-graphic {
                background: #003753 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .stamp {
                background: #ad7f4a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border-color: #fbe6b0 !important;
            }
            /* SEMBUNYIKAN TOMBOL CETAK SAAT PRINT */
            .print-button-container {
                display: none !important;
            }
        }

        /* responsif untuk layar lebih kecil */
        @media (max-width: 1000px) {
            .certificate {
                padding: 30px 35px;
            }
            .recipient-name {
                font-size: 54px;
                padding: 10px 30px;
            }
            .footer {
                flex-wrap: wrap;
                justify-content: center;
            }
            .print-button-container {
                bottom: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <!-- HEADER dengan logo Diskominfo Solusi -->
        <div class="header">
            <div class="logo-area">
                <!-- Representasi grafis logo -->
                <div class="logo-graphic">
                    <span>DISKOMINFO</span>
                    <span>SOLUSI</span>
                </div>
                <div class="logo-text">
                    <div class="diskominfo">DISKOMINFO</div>
                    <div class="solusi">SOLUSI</div>
                    <div class="tagline">Sinergi Optimal dalam Berinovasi, <br> Layanan Unggul, Smart, dan Informatif.</div>
                </div>
            </div>
            <div class="tagline-detail">
                ⚡ SISTEM ELEKTRONIK TERDAFTAR
            </div>
        </div>

        <!-- Judul Sertifikat Pendaftaran -->
        <div class="certificate-title">
            <div class="main">SERTIFIKAT PENDAFTARAN</div>
            <div class="sub">SISTEM ELEKTRONIK LINGKUP DISKOMINFO</div>
        </div>

        <!-- badge informasi -->
        <div class="elec-badge">
            <span>🏛️ PENDAFTARAN RESMI</span>
            <span>📋 NOMOR REG : SE-2025/DIKOM.022</span>
        </div>

        <!-- Recipient dengan nama AMIN JUNIAR S -->
        <div class="recipient">
            <div class="recipient-label">DIBERIKAN KEPADA</div>
            <div class="recipient-name">AMIN JUNIAR S</div>
            <div class="recipient-desc">sebagai Penyelenggara Sistem Elektronik yang Telah Terdaftar</div>
        </div>

        <!-- Detail informasi sistem elektronik - sekarang 3 kolom sejajar untuk landscape -->
        <div class="detail-info">
            <div class="detail-item"><strong>Nama Sistem</strong> SRIKANDI PLUS • e-Office Diskominfo</div>
            <div class="detail-item"><strong>Tanggal Daftar</strong> 20 Februari 2026</div>
            <div class="detail-item"><strong>Berlaku s.d.</strong> 19 Februari 2029</div>
        </div>

        <!-- bagian validasi dengan QR dan tanda tangan -->
        <div class="footer">
            <div class="signature">
                <div class="line"></div>
                <p>Kepala Dinas Kominfo</p>
                <small>Dr. IR. BUDI SANTOSO, M.T.</small><br>
                <small>NIP. 19750314 200512 1 002</small>
            </div>

            <!-- Simulasi QR code untuk verifikasi -->
            <div class="qrcode-sim">
                <span>⚙️ SCAN ME <br> VERIFIKASI</span>
            </div>

            <div class="signature">
                <div class="line"></div>
                <p>Plt. Kepala UPT Sertifikat</p>
                <small>ANITA WIJAYA, S.Kom., M.M.</small><br>
                <small>NIP. 19850612 201001 2 017</small>
            </div>
        </div>

        <!-- cap/stamp pengesahan Diskominfo -->
        <div style="display: flex; justify-content: center; margin-top: 30px;">
            <div class="stamp">
                <span>DISKOMINFO</span>
            </div>
        </div>

        <!-- footer dengan sinergi dan info kontak -->
        <div style="text-align: center; margin-top: 30px; font-size: 15px; color: #776b58; border-top: 1px dashed #d0b793; padding-top: 20px;">
            <span>🔹  Sinergi Optimal dalam Berinovasi, Layanan Unggul, Smart, dan Informatif  🔹</span><br>
            <span style="letter-spacing: 1px;">sisteminformasi.diskominfo.go.id  |  @diskominfosolusi</span>
        </div>

        <!-- watermark subtle -->
        <div style="position: absolute; bottom: 25px; right: 60px; opacity: 0.05; font-size: 100px; font-weight: 800; color: #3f4f5a; transform: rotate(-15deg); pointer-events: none;">⚡SE</div>
    </div>

    <!-- Tombol cetak - sekarang dalam container terpisah dan akan disembunyikan saat print -->
    <div class="print-button-container">
        <button class="print-button" onclick="window.print()">
            🖨️ CETAK SERTIFIKAT
        </button>
    </div>
</body>
</html>