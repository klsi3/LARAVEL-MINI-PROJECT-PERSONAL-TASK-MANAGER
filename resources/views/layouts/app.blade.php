<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tasks') - Personal Task Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #EDF1F5;
            --surface: #FFFFFF;
            --ink: #18212F;
            --muted: #5B6678;
            --line: #D9E0E8;
            --accent: #1F4FD8;
            --accent-soft: #E4EBFC;
            --pending: #B45309;
            --pending-soft: #FDF0DC;
            --done: #0F7B55;
            --done-soft: #DDF3EA;
            --danger: #B42318;
            --danger-soft: #FCE7E5;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            line-height: 1.5;
        }
        a { color: inherit; }
        :focus-visible { outline: 3px solid var(--accent); outline-offset: 2px; }

        .nav { background: var(--ink); color: #fff; }
        .nav-inner { max-width: 760px; margin: 0 auto; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; }
        .brand { font-weight: 800; font-size: 1.05rem; text-decoration: none; letter-spacing: -0.01em; }
        .nav a.nav-link { color: #C9D3E3; text-decoration: none; font-size: .9rem; }
        .nav a.nav-link:hover { color: #fff; }

        .container { max-width: 760px; margin: 0 auto; padding: 28px 20px 60px; }

        .page-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 1.9rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.15; }
        .sub { margin: 4px 0 0; color: var(--muted); font-size: .95rem; }
        .sub .warn { color: var(--danger); font-weight: 600; }

        .btn { display: inline-block; border: 1px solid transparent; border-radius: 8px; padding: 9px 16px; font: inherit; font-weight: 600; font-size: .92rem; text-decoration: none; cursor: pointer; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #173FB0; }
        .btn-ghost { background: transparent; color: var(--ink); border-color: var(--line); }
        .btn-ghost:hover { background: var(--surface); }
        .btn-small { padding: 5px 10px; font-size: .82rem; }
        .btn-danger { background: transparent; color: var(--danger); border-color: transparent; }
        .btn-danger:hover { background: var(--danger-soft); }

        .flash { background: var(--done-soft); color: var(--done); border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; font-weight: 600; font-size: .92rem; }

        .tabs { display: flex; gap: 6px; margin-bottom: 14px; flex-wrap: wrap; }
        .tabs a { text-decoration: none; padding: 6px 12px; border-radius: 999px; font-size: .88rem; font-weight: 600; color: var(--muted); border: 1px solid var(--line); background: transparent; }
        .tabs a span { margin-left: 4px; font-weight: 500; }
        .tabs a.active { background: var(--ink); border-color: var(--ink); color: #fff; }

        .list { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }
        .task { background: var(--surface); border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; display: grid; grid-template-columns: auto 1fr auto; gap: 14px; align-items: start; }
        .task.is-done .task-name { text-decoration: line-through; color: var(--muted); }
        .task-name { margin: 0; font-size: 1.02rem; font-weight: 600; }
        .task-desc { margin: 4px 0 0; color: var(--muted); font-size: .9rem; white-space: pre-line; }
        .meta { margin-top: 8px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; font-size: .82rem; }
        .badge { padding: 2px 9px; border-radius: 999px; font-weight: 600; }
        .badge-pending { background: var(--pending-soft); color: var(--pending); }
        .badge-completed { background: var(--done-soft); color: var(--done); }
        .due { color: var(--muted); }
        .due.overdue { color: var(--danger); font-weight: 600; }
        .actions { display: flex; gap: 2px; align-items: center; }
        .actions form { margin: 0; }

        .check { width: 28px; height: 28px; border-radius: 50%; border: 2px solid #9AA6B8; background: transparent; cursor: pointer; padding: 0; display: grid; place-items: center; color: transparent; margin-top: 1px; }
        .check:hover { border-color: var(--done); color: var(--done); }
        .is-done .check { background: var(--done); border-color: var(--done); color: #fff; }
        .is-done .check:hover { background: #0B6947; border-color: #0B6947; }
        .check svg { width: 15px; height: 15px; }

        .empty { background: var(--surface); border: 1px dashed #B7C2D2; border-radius: 12px; padding: 36px 20px; text-align: center; color: var(--muted); }
        .empty strong { display: block; color: var(--ink); font-size: 1.05rem; margin-bottom: 4px; }
        .empty .btn { margin-top: 14px; }

        .card { background: var(--surface); border: 1px solid var(--line); border-radius: 12px; padding: 24px; }
        .field { margin-bottom: 18px; }
        label { display: block; font-weight: 600; font-size: .9rem; margin-bottom: 6px; }
        input[type=text], input[type=date], select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #B7C2D2; border-radius: 8px; font: inherit; color: var(--ink); background: #fff; }
        textarea { min-height: 110px; resize: vertical; }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); outline: 3px solid var(--accent-soft); }
        .has-error input, .has-error select, .has-error textarea { border-color: var(--danger); }
        .error { color: var(--danger); font-size: .84rem; margin-top: 5px; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; }
        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        @media (max-width: 560px) {
            .page-head { flex-direction: column; align-items: flex-start; }
            .task { grid-template-columns: auto 1fr; }
            .actions { grid-column: 2; }
            .row-2 { grid-template-columns: 1fr; }
        }
        @media (prefers-reduced-motion: no-preference) {
            .btn, .check, .tabs a { transition: background .15s, color .15s, border-color .15s; }
        }
    </style>
</head>
<body>
    <header class="nav">
        <div class="nav-inner">
            <a class="brand" href="{{ route('tasks.index') }}">Personal Task Manager</a>
            <a class="nav-link" href="{{ route('tasks.create') }}">New task</a>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="flash" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>