<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas - HGW</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #10b981;
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
            color: #10b981;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #10b981;
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
            color: #10b981;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #10b981;
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
        .rank {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #10b981;
            color: white;
            text-align: center;
            line-height: 24px;
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE VENTAS</h1>
        <p><strong>Sistema HGW - Cafetería Saludable</strong></p>
        <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-label">Ventas Totales</div>
            <div class="stat-value">{{ number_format($stats['total_sales'], 2) }} Bs</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Total Pedidos</div>
            <div class="stat-value" style="color: #3b82f6;">{{ $stats['total_orders'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Promedio/Pedido</div>
            <div class="stat-value" style="color: #8b5cf6;">{{ number_format($stats['average_order_value'], 2) }} Bs</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Pendientes</div>
            <div class="stat-value" style="color: #f59e0b;">{{ $stats['pending_orders'] ?? 0 }}</div>
        </div>
    </div>

    <div class="section-title">Top 10 Productos Más Vendidos</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $index => $product)
            <tr>
                <td><span class="rank">{{ $index + 1 }}</span></td>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ number_format($product->price, 2) }} Bs</td>
                <td style="color: #10b981; font-weight: bold;">{{ $product->total_quantity }}</td>
                <td style="font-weight: bold;">{{ number_format($product->total_revenue, 2) }} Bs</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Ventas Diarias</div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Pedidos</th>
                <th>Ventas Totales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesByPeriod as $sale)
            <tr>
                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                <td>{{ $sale->total_orders }}</td>
                <td style="color: #10b981; font-weight: bold;">{{ number_format($sale->total_sales, 2) }} Bs</td>
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
