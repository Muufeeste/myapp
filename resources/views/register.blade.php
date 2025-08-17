<!DOCTYPE html>
<html>
<head>
    <title>Mini Task Management</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
      
        html,body { height:100%; margin:0; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
        
        body {
            background-image: linear-gradient(rgba(12,18,28,0.45), rgba(12,18,28,0.45)), url('https://images.unsplash.com/photo-1503264116251-35a269479413?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color:#f8fafc;
            padding:32px;
        }
        .container { max-width:1000px; margin:0 auto; }
       
        .card { background: rgba(255,255,255,0.06); border-radius:12px; box-shadow:0 8px 30px rgba(2,6,23,0.45); padding:20px; margin-bottom:18px; backdrop-filter: blur(4px); }
        h1 { margin:0 0 12px; font-weight:600; color:#ecfeff; }
        h2 { color:#ecfeff; }
        .small { font-size:13px; color:rgba(255,255,255,0.75); }
        form.inline { display:flex; gap:8px; align-items:center; }
        input[type="text"], input[type="email"], input[type="number"] { padding:10px 12px; border:1px solid rgba(255,255,255,0.08); border-radius:8px; background:rgba(255,255,255,0.03); color:#fff; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; align-items:center; }
        .actions { display:flex; gap:8px; }
        button.primary { background:#06b6d4; color:#042b3a; border:none; padding:8px 14px; border-radius:8px; cursor:pointer; font-weight:600; }
        button.ghost { background:transparent; border:1px solid rgba(255,255,255,0.08); padding:8px 12px; border-radius:8px; cursor:pointer; color:#e6eef5; }
        table { width:100%; border-collapse:collapse; margin-top:12px; background:transparent; }
        th, td { text-align:left; padding:12px 14px; border-bottom:1px solid rgba(255,255,255,0.04); color:rgba(255,255,255,0.95); }
        th { font-weight:700; color:#e6f7ff; }
        a.link { color:#a7f3d0; text-decoration:none; font-weight:600; }
        .badge { padding:6px 8px; border-radius:8px; font-weight:700; font-size:12px; }
        .pending { background:#f59e0b; color:#fff; }
        .done { background:#10b981; color:#042b3a; }
        @media (max-width:700px){ .grid{ grid-template-columns:1fr; } .actions{ flex-direction:column; } }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Mini Task Management</h1>

        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; margin-top:12px;">
            <form method="GET" action="/register" class="inline">
                <input type="text" name="query" placeholder="Search by title or details" value="{{ $query ?? '' }}">
                <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}">
                <button type="submit" class="primary">Search</button>
            </form>

            <div style="margin-left:auto;" class="actions">
                <a href="/users/edit-all"><button class="ghost" type="button">Edit All</button></a>
                <a href="/register"><button class="ghost" type="button">Refresh</button></a>
                <button id="toggleNewcomer" class="ghost" type="button">Register Newcomer</button>
            </div>
        </div>

        <div style="margin-top:10px; display:flex; gap:8px; align-items:center;">
            <span class="small">Filter:</span>
            <a class="link" href="/register?filter=all">All</a> &middot;
            <a class="link" href="/register?filter=pending">Pending</a> &middot;
            <a class="link" href="/register?filter=done">Done</a>
        </div>
    </div>

    <div class="card">
        @if(isset($editUser))
            <h2>Edit Task</h2>
            <form method="POST" action="/users/update/{{ $editUser['id'] }}">
                @csrf
                <div class="grid">
                    <label>
                        Task Title<br>
                        <input type="text" id="name" name="name" value="{{ $editUser['name'] }}" required>
                    </label>
                    <label>
                        Details (email field used for demo)<br>
                        <input type="email" id="email" name="email" value="{{ $editUser['email'] }}" required>
                    </label>
                    <label>
                        Due / Priority<br>
                        <input type="number" id="age" name="age" value="{{ $editUser['age'] }}" required>
                    </label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <button class="primary" type="submit">Update</button>
                        <a class="link" href="/register">Cancel</a>
                    </div>
                </div>
            </form>
        @else
            <h2>Create Task</h2>
            <form method="POST" action="/register">
                @csrf
                <div class="grid">
                    <label>
                        Task Title<br>
                        <input type="text" id="name" name="name" required>
                    </label>
                    <label>
                        Details (email field used for demo)<br>
                        <input type="email" id="email" name="email" required>
                    </label>
                    <label>
                        Due / Priority<br>
                        <input type="number" id="age" name="age" required>
                    </label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <button class="primary" type="submit">Add Task</button>
                        <button type="reset" class="ghost">Clear</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

   
    <div id="newcomerCard" class="card" style="display:none;">
        <h2>Register New User</h2>
        <form method="POST" action="/register">
            @csrf
            <div class="grid">
                <label>
                    Name<br>
                    <input type="text" name="name" required>
                </label>
                <label>
                    Email<br>
                    <input type="email" name="email" required>
                </label>
                <label>
                    Age<br>
                    <input type="number" name="age" required>
                </label>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button class="primary" type="submit">Register User</button>
                    <button type="button" class="ghost" id="cancelNewcomer">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        @if($accessDenied)
            <p>Access Denied</p>
        @elseif($showUsers && count($users) > 0)
            <h2>Tasks</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width:35%;">Task</th>
                        <th style="width:35%;">Details</th>
                        <th style="width:10%;">Due</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['age'] }}</td>
                        <td>
                            <span class="badge {{ ($user['status'] ?? 'pending') === 'done' ? 'done' : 'pending' }}">
                                {{ ucfirst($user['status'] ?? 'pending') }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="/users/toggle/{{ $user['id'] }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="ghost">{{ ($user['status'] ?? 'pending') === 'done' ? 'Mark Pending' : 'Mark Done' }}</button>
                            </form>
                            <a class="link" href="/users/edit/{{ $user['id'] }}">Edit</a>
                            <form method="POST" action="/users/delete/{{ $user['id'] }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="ghost" onclick="return confirm('Delete this task?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No tasks found.</p>
        @endif
    </div>
</div>


<script>
    (function(){
        const btn = document.getElementById('toggleNewcomer');
        const card = document.getElementById('newcomerCard');
        const cancel = document.getElementById('cancelNewcomer');
        if(btn && card){
            btn.addEventListener('click', function(){
                card.style.display = card.style.display === 'block' ? 'none' : 'block';
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            });
        }
        if(cancel && card){
            cancel.addEventListener('click', function(){ card.style.display = 'none'; });
        }
    })();
</script>
</body>
</html>
