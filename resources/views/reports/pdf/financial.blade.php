<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Financiero - HGW</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #a855f7;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #a855f7;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #a855f7;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #a855f7;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #a855f7;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #a855f7;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .payment-method {
            display: inline-block;
            padding: 15px;
            margin: 5px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            width: 30%;
        }
        .payment-method-name {
            font-weight: bold;
            color: #a855f7;
            margin-bottom: 5px;
        }
        .payment-method-total {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .positive {
            color: #10b981;
            font-weight: bold;
        }
        .negative {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE FINANCIERO</h1>
        <p><strong>Sistema HGW - Cafetería Saludable</strong></p>
        <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-label">Ingresos Totales</div>
            <div class="stat-value">{{ number_format($stats['total_revenue'], 2) }} Bs</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Período Anterior</div>
            <div class="stat-value" style="color: #3b82f6;">{{ number_format($stats['previous_revenue'], 2) }} Bs</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Crecimiento</div>
            <div class="stat-value" style="color: {{ $stats['revenue_growth'] >= 0 ? '#10b981' : '#dc2626' }};">
                {{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 2) }}%
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Promedio Diario</div>
            <div class="stat-value" style="color: #f97316;">{{ number_format($stats['average_daily_revenue'], 2) }} Bs</div>
        </div>
    </div>

    <div class="section-title">Ingresos por Método de Pago</div>
    <div style="margin-bottom: 20px;">
        @foreach($paymentMethods as $method)
        <div class="payment-method">
            <div class="payment-method-name">
                @if($method->payment_method == 'efectivo')
                    EFECTIVO
                @elseif($method->payment_method == 'tarjeta')
                    TARJETA
                @elseif($method->payment_method == 'qr')
                    QR
                @else
                    {{ strtoupper($method->payment_method) }}
                @endif
            </div>
            <div class="payment-method-total">{{ number_format($method->total, 2) }} Bs</div>
            <div style="font-size: 10px; color: #666;">{{ $method->count }} transacciones</div>
        </div>
        @endforeach
    </div>

    <div class="section-title">Ingresos Diarios</div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Pedidos</th>
                <th>Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyRevenue as $revenue)
            <tr>
                <td>{{ \Carbon\Carbon::parse($revenue->date)->format('d/m/Y') }}</td>
                <td>{{ $revenue->orders }}</td>
                <td style="color: #a855f7; font-weight: bold;">{{ number_format($revenue->revenue, 2) }} Bs</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generado con Claude Code - https://claude.com/claude-code</p>
        <p>Sistema HGW - Cafetería Saludable</p>
    </div>
</body>
</html>
