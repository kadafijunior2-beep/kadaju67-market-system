<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendors Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; padding: 20px; }
        h1 { color: #D4AF37; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #000; color: #D4AF37; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .footer { text-align: center; margin-top: 30px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <h1>KADAJU67 MARKET</h1>
    <h3 style="text-align: center;">Vendors Report</h3>
    <p style="text-align: center;">Generated: {{ now()->format('d F Y') }}</p>

    <table>
        <thead>
            <tr><th>Name</th><th>Phone</th><th>Business Type</th><th>Status</th><th>Reg. Date</th></tr>
        </thead>
        <tbody>
            @foreach($vendors as $vendor)
            <tr>
                <td>{{ $vendor->full_name }}</td>
                <td>{{ $vendor->phone }}</td>
                <td>{{ ucfirst($vendor->business_type) }}</td>
                <td>{{ ucfirst($vendor->status) }}</td>
                <td>{{ $vendor->registration_date->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Kadaju67 Market Vendor Management System</p>
        <p>Total Vendors: {{ $vendors->count() }}</p>
    </div>
</body>
</html>
