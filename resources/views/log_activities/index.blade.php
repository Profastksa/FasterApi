<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Activities</title>
</head>
<body>
    <h1>Log Activities</h1>

    <form action="{{ route('log.activities.index') }}" method="GET">
        <div>
            <label for="action">Action:</label>
            <select name="action" id="action">
                <option value="">Select Action</option>
                @foreach($actions as $action)
                    <option value="{{ $action->action }}" {{ request('action') == $action->action ? 'selected' : '' }}>
                        {{ $action->action }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="content_type">Content Type:</label>
            <select name="content_type" id="content_type">
                <option value="">Select Content Type</option>
                @foreach($contentTypes as $contentType)
                    <option value="{{ $contentType->content_type }}" {{ request('content_type') == $contentType->content_type ? 'selected' : '' }}>
                        {{ $contentType->content_type }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="user_id">User ID:</label>
            <input type="number" name="user_id" id="user_id" value="{{ request('user_id') }}">
        </div>
        <div>
            <label for="date_from">Date From:</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
        </div>
        <div>
            <label for="date_to">Date To:</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
        </div>
        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Action</th>
                <th>Content Type</th>
                <th>Content ID</th>
                <th>Description</th>
                <th>Details</th>
                <th>User ID</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logActivities as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->content_type }}</td>
                    <td>{{ $log->content_id }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->details }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>{{ $log->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logActivities->links() }}
</body>
</html>
