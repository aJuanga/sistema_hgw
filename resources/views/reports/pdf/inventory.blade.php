<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Inventario - HGW</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #3b82f6;
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
            color: #3b82f6;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #3b82f6;
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
            color: #3b82f6;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #3b82f6;
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
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin-bottom: 15px;
        }
        .critical {
            color: #dc2626;
            font-weight: bold;
        }
        .good {
            color: #059669;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE INVENTARIO</h1>
        <p><strong>Sistema HGW - Cafetería Saludable</strong></p>
        <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-label">Total Productos</div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Stock Bajo</div>
            <div class="stat-value" style="color: #f59e0b;">{{ $stats['low_stock_count'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Sin Stock</div>
            <div class="stat-value" style="color: #dc2626;">{{ $stats['out_of_stock'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Valor Total</div>
            <div class="stat-value" style="color: #059669;">{{ number_format($stats['total_stock_value'], 2) }} Bs</div>
        </div>
    </div>

    @if($lowStockProducts->count() > 0)
    <div class="alert">
        <strong>ALERTAS DE STOCK BAJO: {{ $lowStockProducts->count() }} productos</strong>
    </div>

    <div class="section-title">Productos con Stock Bajo o Agotados</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                <td class="{{ $product->current_stock == 0 ? 'critical' : 'alert' }}">
                    {{ $product->current_stock ?? 0 }}
                </td>
                <td>{{ $product->minimum_stock ?? 0 }}</td>
                <td>
                    @if($product->current_stock == 0)
                        <span class="critical">AGOTADO</span>
                    @else
                        <span style="color: #f59e0b; font-weight: bold;">CRÍTICO</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="section-title">Inventario Completo</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Vendidos</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                <td>{{ number_format($product->price, 2) }} Bs</td>
                <td class="{{ ($product->current_stock ?? 0) <= ($product->minimum_stock ?? 0) ? 'critical' : 'good' }}">
                    {{ $product->current_stock ?? 0 }}
                </td>
                <td>{{ $soldProducts[$product->id] ?? 0 }}</td>
                <td>{{ number_format(($product->current_stock ?? 0) * $product->price, 2) }} Bs</td>
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
