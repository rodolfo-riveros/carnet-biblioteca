<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Código de Barras</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6mm;
        }
        .label {
            border: 1px solid #ccc;
            border-radius: 2mm;
            padding: 4mm 3mm;
            text-align: center;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .title {
            font-size: 8pt;
            font-weight: bold;
            color: #222;
            margin-bottom: 2mm;
            line-height: 1.3;
            text-align: center;
            max-width: 100%;
        }
        .barcode-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .code {
            font-size: 8pt;
            color: #333;
            font-family: 'Courier New', monospace;
            margin-top: 2mm;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .meta {
            font-size: 7pt;
            color: #666;
            margin-top: 1mm;
        }
    </style>
</head>
<body>
    <div class="grid">
        <div class="label">
            <div class="title">{{ $titulo }}</div>
            <div class="barcode-wrapper">
                {!! DNS1D::getBarcodeHTML($codigo_barra, 'C128', 1.5, 40, 'black', 0) !!}
            </div>
            <div class="code">{{ $codigo_barra }}</div>
            <div class="meta">
                C.I: {{ $codigo_interno }}
                @if(isset($numero_copia) && $numero_copia)
                     · Copia: {{ $numero_copia }}
                @endif
            </div>
        </div>
    </div>
</body>
</html>
