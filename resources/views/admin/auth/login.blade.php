<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>এডমিন লগইন - DemandHat BD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-2xl text-white space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto shadow-lg">
                D
            </div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight">এডমিন প্যানেলে লগইন</h1>
            <p class="text-xs text-slate-400">DemandHat eCommerce & Landing Page Builder</p>
        </div>

        @if($errors->any())
        <div class="p-3.5 bg-rose-500/20 border border-rose-500/40 text-rose-300 rounded-xl text-xs">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">ইমেইল এড্রেস</label>
                <input type="email" name="email" value="{{ old('email', 'admin@demandhat.com') }}" required 
                       class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700 rounded-xl text-white focus:border-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">পাসওয়ার্ড</label>
                <input type="password" name="password" value="admin123" required 
                       class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700 rounded-xl text-white focus:border-emerald-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-white">
                    <input type="checkbox" name="remember" checked class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                    <span>মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-sm rounded-xl shadow-lg transition-all">
                লগইন করুন
            </button>
        </form>

        <div class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/60 text-center text-xs text-slate-400">
            <span class="text-emerald-400 font-bold block mb-1">ডেমো ক্রেডেনশিয়াল:</span>
            <span>ইমেইল: <strong>admin@demandhat.com</strong></span><br>
            <span>পাসওয়ার্ড: <strong>admin123</strong></span>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-emerald-400">← মূল ওয়েবসাইটে ফিরে যান</a>
        </div>
    </div>
</body>
</html>
