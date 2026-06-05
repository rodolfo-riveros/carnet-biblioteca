<div style="
    width:79.6mm; height:48mm;
    background:#ffffff;
    border-radius:2.5mm;
    overflow:hidden;
    font-family:Helvetica,Arial,sans-serif;
    color:#1e293b;
    position:relative;
    margin:0; padding:0;
">

    {{-- ── BANDA SUPERIOR AZUL ── --}}
    <div style="
        background:#002395;
        padding:1.8mm 3mm;
        border-bottom:0.4mm solid #ffffff;
    ">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:0;">
            <tr>
                <td style="vertical-align:middle;">
                    <div style="font-size:5.5pt;font-weight:bold;color:#ffffff;letter-spacing:0.4pt;text-transform:uppercase;">
                        {{ mb_strtoupper(mb_substr($data['institucion'], 0, 35)) }}
                    </div>
                    <div style="font-size:3.5pt;color:#93c5fd;letter-spacing:0.5pt;text-transform:uppercase;margin-top:0.3mm;">
                        CARNET DE BIBLIOTECA
                    </div>
                </td>
                <td style="text-align:right;vertical-align:middle;">
                    <div style="
                        background:#ffffff;
                        border-radius:0.8mm;
                        padding:0.4mm 1.5mm;
                        display:inline-block;
                        text-align:center;
                    ">
                        <span style="font-size:3.5pt;color:#002395;font-weight:bold;letter-spacing:0.3pt;">
                            {{ $data['numero_carnet'] }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── CUERPO BLANCO (ahora con 3 columnas) ── --}}
    <div style="padding:2.5mm 3mm;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:0;">
            <tr>

                {{-- Columna 1: Foto --}}
                <td style="width:14mm;vertical-align:top;padding-right:1.5mm;">
                    <div style="
                        width:14mm;height:18mm;
                        background:#f1f5f9;
                        border-radius:1.2mm;
                        border:0.4mm solid #002395;
                        overflow:hidden;
                        text-align:center;
                        line-height:0;
                    ">
                        @if (!empty($data['foto_ruta']) && file_exists(storage_path('app/public/' . $data['foto_ruta'])))
                            <img src="{{ storage_path('app/public/' . $data['foto_ruta']) }}"
                                width="53" height="68"
                                style="width:14mm;height:18mm;object-fit:cover;display:block;" />
                        @else
                            <div style="padding-top:2mm;">
                                <div style="width:6mm;height:6mm;border-radius:50%;background:#002395;margin:0 auto 0.8mm;"></div>
                                <div style="width:10mm;height:7mm;border-radius:4mm 4mm 0 0;background:#153e8a;margin:0 auto;"></div>
                            </div>
                        @endif
                    </div>
                </td>

                {{-- Columna 2: Datos personales --}}
                <td style="vertical-align:top;">

                    <div style="font-size:7.5pt;font-weight:bold;color:#002395;line-height:1.15;margin-bottom:0.5mm;text-transform:uppercase;">
                        {{ mb_strtoupper($data['estudiante_apellido_paterno']) }}
                        {{ mb_strtoupper($data['estudiante_apellido_materno']) }}
                    </div>
                    <div style="font-size:6pt;color:#475569;margin-bottom:2mm;">
                        {{ $data['estudiante_nombres'] }}
                    </div>

                    {{-- Programa --}}
                    <div style="
                        background:#f1f5f9;
                        border-left:0.8mm solid #ed2939;
                        border-radius:0 0.8mm 0.8mm 0;
                        padding:0.6mm 1.2mm;
                        margin-bottom:2mm;
                    ">
                        <div style="font-size:3.5pt;color:#94a3b8;text-transform:uppercase;letter-spacing:0.3pt;">Programa de Estudio</div>
                        <div style="font-size:5pt;color:#002395;font-weight:bold;margin-top:0.3mm;">{{($data['programa']) }}</div>
                    </div>

                    {{-- DNI y código --}}
                    <table cellpadding="0" cellspacing="0" style="border:0;">
                        <tr>
                            <td style="padding-right:4mm;">
                                <div style="font-size:3pt;color:#94a3b8;text-transform:uppercase;letter-spacing:0.3pt;">DNI</div>
                                <div style="font-size:6.5pt;color:#002395;font-weight:bold;font-family:Courier,monospace;">{{ $data['estudiante_dni'] }}</div>
                            </td>
                            <td>
                                <div style="font-size:3pt;color:#94a3b8;text-transform:uppercase;letter-spacing:0.3pt;">Código</div>
                                <div style="font-size:5.5pt;color:#475569;font-family:Courier,monospace;">{{ $data['estudiante_codigo'] }}</div>
                            </td>
                        </tr>
                    </table>

                </td>

                {{-- Columna 3: Código de barras VERTICAL --}}
                <td style="width:20mm; vertical-align:middle; text-align:right; padding:0;">
                    <div style="
                        display:inline-block;
                        transform:rotate(-90deg);
                        transform-origin: center center;
                        /* Usa márgenes para forzar la posición tras la rotación */
                        margin-right: -6mm; /* Aumenta en negativo (ej. -8mm) para pegarlo más al borde */
                        margin-top: 4mm; /* Ajusta para centrarlo perfectamente en la vertical */
                    ">
                        @php
                            /* Nota: Reduje ligeramente el factor de ancho (de 2 a 1.5) 
                               para evitar que se desborde al rotarlo, puedes volver a 2 si tienes espacio */
                            $barcodePngFront = DNS1D::getBarcodePNG($data['codigo_barras'], 'C128', 1.5, 30, [0, 0x23, 0x95], false);
                        @endphp
                        <div style="
                            background:#ffffff;
                            border:0.3mm solid #e2e8f0;
                            border-radius:1mm;
                            padding:1mm;
                            text-align:center;
                        ">
                            <img src="data:image/png;base64,{{ $barcodePngFront }}" alt="Código de barras"
                                style="width:100%; height:auto; display:block;" />
                            <div style="font-size:3pt; color:#475569; font-family:Courier,monospace; letter-spacing:0.2pt; margin-top:0.5mm;">
                                {{ $data['codigo_barras'] }}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── BANDA INFERIOR ROJA ── --}}
    <div style="
        background:#ed2939;
        padding:1.2mm 3mm;
        position:absolute;
        bottom:0;left:0;right:0;
        border-top:0.4mm solid rgba(255,255,255,0.3);
    ">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:0;">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" style="border:0;">
                        <tr>
                            <td style="padding-right:4mm;">
                                <div style="font-size:3pt;color:#fca5a5;text-transform:uppercase;">Emisión</div>
                                <div style="font-size:4.5pt;color:#ffffff;font-weight:bold;">{{ $data['fecha_emision'] }}</div>
                            </td>
                            <td>
                                <div style="font-size:3pt;color:#fca5a5;text-transform:uppercase;">Vence</div>
                                <div style="font-size:4.5pt;color:#ffffff;font-weight:bold;">
                                    {{ $data['fecha_vencimiento'] }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:right;">
                    <div style="
                        background:{{ $data['vencido'] ? '#991b1b' : '#ffffff' }};
                        color:{{ $data['vencido'] ? '#ffffff' : '#002395' }};
                        font-size:4pt;
                        font-weight:bold;
                        padding:0.6mm 2mm;
                        border-radius:0.8mm;
                        letter-spacing:0.4pt;
                        text-transform:uppercase;
                        display:inline-block;
                    ">
                        {{ $data['vencido'] ? 'VENCIDO' : 'VIGENTE' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>