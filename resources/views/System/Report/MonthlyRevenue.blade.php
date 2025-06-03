<!DOCTYPE html>
<html>
<head>
    <title>Monthly Revenue Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; background: #f4f6f8; color: #222; }
        .container { max-width: 800px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #e2e8f0; padding: 32px; }
        .title { font-size: 32px; font-weight: bold; margin-bottom: 10px; color: #256029; }
        .subtitle { font-size: 18px; color: #555; margin-bottom: 30px; }
        .section { margin-bottom: 25px; }
        .label { font-weight: bold; color: #256029; }
        .value { font-size: 22px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px 8px; text-align: center; }
        th { background: #256029; color: #fff; }
        tr:nth-child(even) { background: #f0fdf4; }
        .footer { margin-top: 40px; font-size: 13px; color: #888; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Monthly Revenue Report</div>
        <div class="subtitle">As of {{ $month }}</div>

        <div class="section">
            <span class="label">Total Sales (This Month):</span>
            <span class="value">RM{{ number_format($currentRevenue, 2) }}</span>
        </div>
        <div class="section">
            <span class="label">Total Stock Purchases (This Month):</span>
            <span class="value">RM{{ number_format($stockPurchases, 2) }}</span>
        </div>
        <div class="section">
            <span class="label">Gross Profit (This Month):</span>
            <span class="value" style="color:#16a34a;">RM{{ number_format($grossProfit, 2) }}</span>
        </div>

        <h3 style="margin-top:40px;margin-bottom:10px;font-size:20px;color:#256029;">Previous Months' Gross Profit</h3>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total Sales (RM)</th>
                    <th>Total Cost (RM)</th>
                    <th>Gross Profit (RM)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monthlyRevenues as $rev)
                    <tr>
                        <td>{{ DateTime::createFromFormat('!m', $rev->month)->format('F') }}</td>
                        <td>{{ $rev->year }}</td>
                        <td>
                            {{ isset($rev->total_sales) ? number_format($rev->total_sales, 2) : '-' }}
                        </td>
                        <td>
                            {{ isset($rev->total_cost) ? number_format($rev->total_cost, 2) : '-' }}
                        </td>
                        <td>{{ number_format($rev->revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No previous records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Generated on {{ now()->format('d M Y, H:i') }}
        </div>
    </div>
</body>
</html>