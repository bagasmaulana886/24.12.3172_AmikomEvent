<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-[32px] shadow-2xl border border-slate-200 p-10">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Login Admin</h1>
            <p class="mt-3 text-slate-500">Masuk menggunakan akun admin Amikom untuk mengakses dashboard.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-3xl bg-rose-50 border border-rose-200 p-4 text-rose-700">
                <p class="font-semibold">Gagal masuk</p>
                <ul class="mt-2 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2" for="password">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>

            <button type="submit"
                class="w-full rounded-3xl bg-indigo-600 px-5 py-3 text-white font-semibold transition hover:bg-indigo-700">Masuk</button>
        </form>
        
    </div>
</body>
</html>
