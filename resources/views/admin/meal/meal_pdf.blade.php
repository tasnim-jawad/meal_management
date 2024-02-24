<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
            caption-side: top;
        }

        th, td {
            padding: 0.75em;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            border-top: 2px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h1 style="margin-top: 1em; margin-bottom: 1em; text-align: center;">Today's all-meal list</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meals as $key => $meal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $meal['user']['name'] }}</td>
                        <td>{{ $meal['user']['mobile'] }}</td>
                        <td>{{ $meal['quantity'] }}</td>
                        <td>{{ $meal['date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
