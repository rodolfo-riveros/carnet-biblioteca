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
        padding:1.5mm 3mm;
        border-bottom:0.4mm solid #ffffff;
    ">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:0;">
            <tr>
                <td>
                    <span style="color:white;font-size:5pt;font-weight:bold;letter-spacing:0.4pt;text-transform:uppercase;">
                        Carnet de Biblioteca
                    </span>
                </td>
                <td style="text-align:right;">
                    <span style="color:#93c5fd;font-size:4pt;">{{ $data['numero_carnet'] }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── CUERPO BLANCO ── --}}
    <div style="padding:2mm 3mm;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:0;">
            <tr>

                {{-- Código de barras --}}
                <td style="width:26mm;vertical-align:top;padding-right:2.5mm;">
                    <div style="
                        background:#ffffff;
                        border:0.3mm solid #e2e8f0;
                        border-radius:1mm;
                        padding:1mm;
                        text-align:center;
                    ">
                        @php
                            $barcodePng = DNS1D::getBarcodePNG($data['codigo_barras'], 'C128', 2, 30, [0, 0x23, 0x95], false);
                        @endphp
                        <img src="data:image/png;base64,{{ $barcodePng }}" alt="Código de barras"
                            style="width:100%;height:auto;display:block;" />
                        <div style="font-size:3pt;color:#475569;font-family:Courier,monospace;letter-spacing:0.2pt;">
                            {{ $data['codigo_barras'] }}
                        </div>
                    </div>
                </td>

                {{-- Información --}}
                <td style="vertical-align:top;">

                    <div style="font-size:4pt;font-weight:bold;color:#002395;text-transform:uppercase;letter-spacing:0.3pt;margin-bottom:1.5mm;border-bottom:0.3mm solid #ed2939;padding-bottom:0.8mm;">
                        Condiciones de uso
                    </div>
                    <table cellpadding="0" cellspacing="0" style="border:0;margin-bottom:2mm;">
                        <tr><td style="padding-bottom:0.8mm;">
                            <div style="font-size:3.8pt;color:#64748b;line-height:1.4;">
                                · Carnet personal e intransferible.
                            </div>
                        </td></tr>
                        <tr><td style="padding-bottom:0.8mm;">
                            <div style="font-size:3.8pt;color:#64748b;line-height:1.4;">
                                · Preséntelo al solicitar préstamos.
                            </div>
                        </td></tr>
                        <tr><td style="padding-bottom:0.8mm;">
                            <div style="font-size:3.8pt;color:#64748b;line-height:1.4;">
                                · Reporte pérdida a la biblioteca.
                            </div>
                        </td></tr>
                        <tr><td>
                            <div style="font-size:3.8pt;color:#64748b;line-height:1.4;">
                                · Responsable por libros prestados.
                            </div>
                        </td></tr>
                    </table>

                    <div style="
                        background:#f1f5f9;
                        border-left:0.8mm solid #002395;
                        border-radius:0 0.8mm 0.8mm 0;
                        padding:0.8mm 1.5mm;
                    ">
                        <div style="font-size:3pt;color:#94a3b8;text-transform:uppercase;letter-spacing:0.3pt;margin-bottom:0.3mm;">Titular</div>
                        <div style="font-size:5.5pt;font-weight:bold;color:#002395;line-height:1.2;">
                            {{ mb_strtoupper($data['estudiante_apellido_paterno']) }}
                            {{ mb_strtoupper($data['estudiante_apellido_materno']) }},
                            {{ $data['estudiante_nombres'] }}
                        </div>
                        <div style="font-size:4pt;color:#64748b;margin-top:0.3mm;">
                            DNI: {{ $data['estudiante_dni'] }}
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
        text-align:center;
        border-top:0.4mm solid rgba(255,255,255,0.3);
    ">
        <span style="color:rgba(255,255,255,0.75);font-size:3.5pt;letter-spacing:0.6pt;text-transform:uppercase;">
            Sistema de Gestión de Biblioteca
        </span>
    </div>

</div>