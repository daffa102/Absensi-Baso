<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Baso</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f4f4f9; }
        .navbar { background-color: #ffffff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar .brand { font-size: 1.25rem; font-weight: bold; color: #333; }
        .navbar .user-info { display: flex; gap: 1rem; align-items: center; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.9rem; }
        .btn-primary { background-color: #4CAF50; color: white; }
        .btn-secondary { background-color: #607d8b; color: white; }
        .btn-danger { background-color: #f44336; color: white; }
        .container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-control { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #eee; }
        .radio-group { display: flex; gap: 10px; }
        .radio-label { cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="brand">Absensi Baso</div>
        @auth
            <div class="user-info">
                <span>Halo, <strong>{{ Auth::user()->name }}</strong> ({{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }})</span>
                
                @if(Auth::user()->role === 'guru_piket')
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Input Absen</a>
                    <a href="{{ route('guru.edit') }}" class="btn btn-secondary">Edit Absen</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        @endauth
    </nav>
    
    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>