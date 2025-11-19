<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Empleados - HGW</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #f97316;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #f97316;
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
            color: #f97316;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #f97316;
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
            color: #f97316;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #f97316;
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
            background: #f97316;
            color: white;
            text-align: center;
            line-height: 24px;
            font-weight: bold;
            margin-right: 5px;
        }
        .rank.gold {
            background: #fbbf24;
        }
        .progress-bar {
            width: 100%;
            height: 12px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #10b981;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE EMPLEADOS</h1>
        <p><strong>Sistema HGW - Cafetería Saludable</strong></p>
        <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-label">Total Empleados</div>
            <div class="stat-value">{{ $stats['total_employees'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Puntos Totales</div>
            <div class="stat-value" style="color: #fbbf24;">{{ number_format($stats['total_points']) }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Pedidos Totales</div>
            <div class="stat-value" style="color: #3b82f6;">{{ $stats['total_orders'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Promedio Puntos</div>
            <div class="stat-value" style="color: #8b5cf6;">{{ number_format($stats['average_points']) }}</div>
        </div>
    </div>

    <div class="section-title">Desempeño de Empleados</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Empleado</th>
                <th>Email</th>
                <th>Pedidos</th>
                <th>Completados</th>
                <th>Tasa</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employeeStats as $index => $stat)
            <tr>
                <td>
                    @if($index < 3)
                        <span class="rank gold">{{ $index + 1 }}</span>
                    @else
                        <span class="rank">{{ $index + 1 }}</span>
                    @endif
                </td>
                <td><strong>{{ $stat['employee']->name }}</strong></td>
                <td style="font-size: 10px;">{{ $stat['employee']->email }}</td>
                <td>{{ $stat['orders_count'] }}</td>
                <td style="color: #10b981; font-weight: bold;">{{ $stat['completed_orders'] }}</td>
                <td>{{ $stat['completion_rate'] }}%</td>
                <td style="color: #f97316; font-weight: bold;">{{ number_format($stat['points']) }}</td>
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
