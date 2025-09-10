<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Service - {{ $notaNumber }}</title>
    <style>
        @page {
            size: 58mm auto; /* Thermal paper width, auto height */
            margin: 0;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            line-height: 1.2;
            margin: 0;
            padding: 5mm;
            width: 48mm; /* Slightly less than paper width for margins */
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .logo {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
            word-wrap: break-word;
        }
        .shop-info {
            font-size: 7px;
            color: #333;
            line-height: 1.1;
        }
        .nota-number {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
            border: 1px solid #000;
            padding: 3px;
        }
        .info-section {
            margin-bottom: 8px;
        }
        .info-row {
            margin-bottom: 2px;
            font-size: 8px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 35%;
            vertical-align: top;
        }
        .value {
            display: inline-block;
        }
        .device-section {
            border: 1px solid #000;
            padding: 5px;
            margin: 8px 0;
            font-size: 7px;
        }
        .device-title {
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 5px;
            font-size: 8px;
        }
        .price-section {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 8px;
            text-align: left;
        }
        .total-price {
            font-size: 10px;
            font-weight: bold;
            text-align: center
        }
        .signature {
            margin-top: 15px;
            text-align: center;
            font-size: 7px;
        }
        .sign-box {
            margin: 10px 0;
        }
        .sign-line {
            border-bottom: 1px solid #000;
            margin: 15px 0 3px 0;
        }
        .footer {
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 5px;
            text-align: center;
            font-size: 6px;
            line-height: 1.1;
        }
        .footer p {
            margin: 2px 0;
        }
        /* Ensure text fits thermal width */
        * {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SERVICE ELEKTRONIK</div>
        <div class="shop-info">
            Jl. Contoh No. 123<br>
            Kota Contoh<br>
            Telp: 021-1234567<br>
            WA: 081234567890
        </div>
    </div>

    <div class="nota-number">
        {{ $notaNumber }}
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="label">Nama:</span>
            <span class="value">{{ $deviceRepair->customers->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Masuk:</span>
            <span class="value">{{ $deviceRepair->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Target:</span>
            <span class="value">{{ $deviceRepair->complete_in ? $deviceRepair->complete_in->format('d/m/Y') : '-' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value">{{ $deviceRepair->status ?? 'Baru Masuk' }}</span>
        </div>
    </div>

    <div class="device-section">
        <div class="device-title">DATA PERANGKAT</div>
        <div class="info-row">
            <span class="label">Merek:</span>
            <span class="value">{{ $deviceRepair->brand }}</span>
        </div>
        <div class="info-row">
            <span class="label">Model:</span>
            <span class="value">{{ $deviceRepair->model }}</span>
        </div>
        <div class="info-row">
            <span class="label">S/N:</span>
            <span class="value">{{ $deviceRepair->serial_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kerusakan:</span>
            <span class="value">{{ $deviceRepair->reported_issue }}</span>
        </div>
        @if($deviceRepair->technician_note)
        <div class="info-row">
            <span class="label">Catatan:</span>
            <span class="value">{{ $deviceRepair->technician_note }}</span>
        </div>
        @endif
    </div>
    

    <div class="price-section">
        
        @if(isset($paidAmount) && $paidAmount > 0)
        <div class="info-row">
            <span class="label">Bayar:</span>
            <span class="value">Rp.{{ number_format($paidAmount, 0, ',', '.') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Harga:</span>
            <span class="value">{{ $deviceRepair->price ? 'Rp.' . number_format($deviceRepair->price, 0, ',', '.') : 'Belum ditentukan' }}</span>
        </div>
        <div class="info-row" style="border-bottom: 1px dashed #000; line-height: 1;"></div>
        @if(isset($change) && $change > 0)
        <div class="info-row">
            <span class="label">Kembali:</span>
            <span class="value">Rp.{{ number_format($change, 0, ',', '.') }}</span>
        </div>
        @endif
        <br>
        <div class="total-price">
            <strong>STATUS: LUNAS</strong>
        </div>
        @else
        <div class="total-price">
            <strong>STATUS: BELUM LUNAS</strong>
        </div>
        @endif
    </div>

    <div class="signature">
        <div class="sign-box">
            <div>Pelanggan</div>
            <div class="sign-line"></div>
            <div>({{ Str::limit($deviceRepair->customers->name ?? '...........', 15) }})</div>
        </div>
        <div class="sign-box">
            <div>PT.LaptopService</div>
            <div class="sign-line"></div>
            <div>(...........)</div>
        </div>
    </div>

    <div class="footer">
        <p><strong>SYARAT & KETENTUAN:</strong></p>
        <p>1. Barang sudah diperbaiki tidak dapat dikembalikan</p>
        <p>2. Garansi service 30 hari kerusakan sama</p>
        <p>3. Barang tidak diambil 30 hari bukan tanggung jawab kami</p>
        <p>4. Pembayaran saat pengambilan</p>
        <br>
        <p><em>Terima kasih atas kepercayaan Anda</em></p>
    </div>

    <script>
        window.onload = function() {
            // Auto print when page loads
            window.print();
            
            // Optional: Close window after printing (for popup windows)
            setTimeout(function() {
                if (window.opener) {
                    window.close();
                }
            }, 1000);
        }
        
        // Handle print button click if needed
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
