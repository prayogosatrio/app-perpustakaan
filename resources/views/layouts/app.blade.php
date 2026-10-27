{{-- File: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Digital Kampus')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; color: #1f2937; }
        body > nav { background: #1e3a8a; padding: 14px 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
        body > nav .brand { color: #fff; font-weight: bold; font-size: 18px; }
        body > nav ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
        body > nav ul li a { color: #cbd5e1; text-decoration: none; padding: 6px 4px; }
        body > nav ul li a.active { color: #fff; font-weight: bold; border-bottom: 2px solid #fff; }
        main { max-width: 900px; margin: 0 auto; padding: 30px 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .btn { display: inline-block; padding: 6px 14px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        form.inline { display: inline; }
        footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb; margin-top: 40px; }
        /* Style form (dipakai halaman create/edit) */
        form.form-box { max-width: 500px; }
        form.form-box label { display: block; margin-top: 12px; font-weight: bold; }
        form.form-box input, form.form-box select, form.form-box textarea { width: 100%; padding: 6px; margin-top: 4px; }
        form.form-box .btn { margin-top: 20px; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
        form.form-box input[type="checkbox"] { width: auto; margin: 0 6px 0 0; }
        .checkbox-list { border: 1px solid #ccc; border-radius: 4px; padding: 10px; margin-top: 4px; max-height: 200px; overflow-y: auto; }
        form.form-box .checkbox-list label { font-weight: normal; margin-top: 4px; }
        .readonly { background: #f3f4f6; padding: 8px; border-radius: 4px; margin-top: 4px; }
        .form-label { display: block; margin-top: 12px; font-weight: bold; }
        /* Tabel detail (halaman show) */
        table.info th { width: 180px; background: #f3f4f6; }
        /* Pagination */
        .pagination { list-style: none; display: flex; gap: 4px; padding: 0; margin: 16px 0; }
        .pagination .page-link { display: block; padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; color: #2563eb; text-decoration: none; }
        .pagination .page-item.active .page-link { background: #2563eb; border-color: #2563eb; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main>
        @include('partials.alert')

        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Sistem Perpustakaan Digital Kampus
    </footer>
</body>
</html>
