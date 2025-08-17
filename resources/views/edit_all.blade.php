<!DOCTYPE html>
<html>
<head>
    <title>Edit All Users</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
       
        html,body { height:100%; margin:0; font-family:Inter, sans-serif; }
        body {
            background-image: linear-gradient(rgba(12,18,28,0.45), rgba(12,18,28,0.45)), url('https://images.unsplash.com/photo-1503264116251-35a269479413?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color:#f8fafc;
            padding:24px;
        }
        .container { max-width:1000px; margin:0 auto; }
        .card { background: rgba(255,255,255,0.06); padding:18px; border-radius:12px; box-shadow:0 8px 30px rgba(2,6,23,0.45); backdrop-filter: blur(4px); }
        table { width:100%; border-collapse:collapse; margin-top:10px; background:transparent; }
        th, td { padding:12px; border-bottom:1px solid rgba(255,255,255,0.04); color:rgba(255,255,255,0.95); text-align:left; }
        th { font-weight:700; color:#e6f7ff; }
        input[type="text"], input[type="email"], input[type="number"], select { padding:8px; border:1px solid rgba(255,255,255,0.08); border-radius:8px; background:rgba(255,255,255,0.03); color:#fff; width:100%; }
        .actions { display:flex; gap:8px; margin-top:12px; }
        button.primary { background:#10b981; color:#042b3a; border:none; padding:8px 12px; border-radius:8px; cursor:pointer; font-weight:600; }
        a.link { color:#a7f3d0; text-decoration:none; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Edit All Users</h1>
        <form method="POST" action="/users/update-all">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th style="width:30%;">Name</th>
                        <th style="width:40%;">Email</th>
                        <th style="width:10%;">Age</th>
                        <th style="width:20%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><input type="text" name="users[{{ $user['id'] }}][name]" value="{{ $user['name'] }}" required></td>
                            <td><input type="email" name="users[{{ $user['id'] }}][email]" value="{{ $user['email'] }}" required></td>
                            <td><input type="number" name="users[{{ $user['id'] }}][age]" value="{{ $user['age'] }}" required></td>
                            <td>
                                <select name="users[{{ $user['id'] }}][status]">
                                    <option value="pending" {{ ($user['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="done" {{ ($user['status'] ?? '') === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No users to edit.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="actions">
                <button type="submit" class="primary">Save All</button>
                <a class="link" href="/register">Back to Users</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
