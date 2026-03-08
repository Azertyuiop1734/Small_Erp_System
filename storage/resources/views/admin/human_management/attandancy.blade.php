<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 20px; background-color: #f8f9fa; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; border-left: 5px solid #2196F3; padding-left: 10px; }
        
        /* Filter Section */
        .filter-section { margin-bottom: 20px; padding: 15px; background: #e9ecef; border-radius: 8px; }
        .filter-section input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-filter { background-color: #2196F3; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        /* Status Badges */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .present { background: #d4edda; color: #155724; }
        .absent { background: #f8d7da; color: #721c24; }
        .late { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<div class="container">
    <h2>Daily Attendance Records</h2>

    <div class="filter-section">
        <form action="{{ route('attendance.index') }}" method="GET">
            <label>Filter by Date: </label>
            <input type="date" name="date" value="{{ request('date') }}">
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('attendance.index') }}" style="text-decoration:none; color:#666; margin-left:10px;">Reset</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Worker Name</th>
                <th>Warehouse</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $record)
            <tr>
                <td>{{ $record->date }}</td>
                <td>
                    <strong>{{ $record->user->name }}</strong><br>
                    <small style="color: #666;">{{ $record->user->email }}</small>
                </td>
                <td>{{ $record->user->warehouse->name ?? 'N/A' }}</td>
                <td>{{ $record->check_in ?? '--:--' }}</td>
                <td>{{ $record->check_out ?? '--:--' }}</td>
                <td>
                    <span class="badge {{ strtolower($record->status) }}">
                        {{ ucfirst($record->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No attendance records found for this day.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>