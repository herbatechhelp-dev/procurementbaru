<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Purchase Request System') }} - Login</title>

    @if(isset($appFavicon) && $appFavicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $appFavicon) }}">
    @endif

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #0f172a !important;
            color: #e2e8f0;
            min-height: 100vh;
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.6) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }

        /* Override Laravel Breeze / Tailwind component default styles */
        .glass-panel input[type="email"], 
        .glass-panel input[type="password"], 
        .glass-panel input[type="text"] {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
            border-radius: 8px !important;
            padding: 0.75rem 1rem !important;
        }
        
        .glass-panel input[type="email"]:focus, 
        .glass-panel input[type="password"]:focus, 
        .glass-panel input[type="text"]:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3) !important;
            outline: none !important;
        }

        .glass-panel label {
            color: #cbd5e1 !important;
            font-weight: 500 !important;
            margin-bottom: 0.5rem !important;
        }

        .glass-panel button[type="submit"] {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            border: none !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            width: 100% !important;
            justify-content: center !important;
        }
        
        .glass-panel button[type="submit"]:hover {
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.5) !important;
            transform: translateY(-2px) !important;
        }

        /* Adjust any default white text-colors inside Breeze if they conflict */
        .text-gray-600 { color: #94a3b8 !important; }
        .text-gray-900 { color: #f8fafc !important; }

        /* Smooth floating animation for blobs */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center relative overflow-hidden">


    <!-- Main Login Card -->
    <div class="w-full sm:max-w-md px-8 py-10 glass-panel sm:rounded-2xl relative z-10 transition-all duration-300 m-4">
        
        <!-- Header & Branding -->
        <div class="flex flex-col items-center justify-center mb-10 w-full text-center">
            @if(isset($appLogo) && $appLogo)
                <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="w-24 h-24 object-contain mb-4 drop-shadow-lg">
            @else
                <x-logo class="w-16 h-16 mb-5" />
            @endif
            
            <h1 class="text-2xl font-bold tracking-tight text-white mb-2">Purchase Request</h1>
            <p class="text-sm text-slate-400 font-medium tracking-wide">Streamlining Your Procurement</p>
        </div>

        <!-- Auth Content Slot -->
        <div class="w-full">
            {{ $slot }}
        </div>

        <!-- Footer / Copyright -->
        <div class="mt-8 text-center text-xs text-slate-500 font-medium">
            &copy; {{ date('Y') }} PT Herbatech Innopharma Industry.<br>All rights reserved.
        </div>
    </div>
    
</body>
</html>
