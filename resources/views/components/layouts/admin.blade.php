<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Hadirin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="globals.css" rel="stylesheet" />
    <style>
        .sidebar-item-active {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.layouts.partials.sidebar')

        <!-- Main Content -->
        {{ $slot }}
    </div>
</body>

</html>