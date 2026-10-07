<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'PetCare') }} · Acesso</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-100 text-slate-800" style="font-family:Inter,system-ui">
<div class="min-h-screen flex flex-col justify-center items-center px-4 py-10">
  <a href="/" class="flex items-center gap-3 mb-6">
    <span class="w-11 h-11 rounded-2xl bg-primary-600 grid place-items-center text-white font-extrabold text-xl">P</span>
    <span class="text-left"><span class="block font-extrabold text-lg text-slate-900 leading-tight">PetCare</span><span class="block text-xs text-slate-400">Gestão para petshop</span></span>
  </a>
  <div class="w-full sm:max-w-md bg-white border border-slate-200 rounded-2xl shadow-card px-6 py-6">{{ $slot }}</div>
  <p class="text-xs text-slate-400 mt-6">Acesso interno da equipe · <a href="{{ route('booking.show') }}" class="text-primary-600 font-semibold">agendamento público</a></p>
</div>
</body>
</html>
