<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carnets - Impresión</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            @page { margin: 0; size: 85mm 108mm; }
            body { margin: 0; padding: 2mm; }
            .page-break { page-break-after: always; }
        }
        body { font-family: 'Helvetica', 'Arial', sans-serif; background: #fff; }
        .carnet-pair { display: flex; flex-direction: column; align-items: center; gap: 2mm; padding: 2mm 0; }
    </style>
</head>
<body>
    {{ $slot }}
    <script>window.print();</script>
</body>
</html>
