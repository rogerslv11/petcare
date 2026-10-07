<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title ?? 'PetCare' }} · PetCare</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css','resources/js/app.js']) @livewireStyles</head>
<body class="bg-slate-100">
<div class="flex min-h-screen" x-data="{ sidebar:false }">
  @include('layouts.sidebar')
  <div class="flex-1 min-w-0 lg:pl-72">
    @include('layouts.topbar')
    <main class="p-4 md:p-8 max-w-[1280px] mx-auto">
      @if(isset($title))
        <div class="mb-5">
          <h1 class="page-title">{{ $title }}</h1>
          @if(isset($subtitle))<p class="page-subtitle">{{ $subtitle }}</p>@endif
        </div>
      @endif
      {{ $slot }}
    </main>
    <footer class="px-8 pb-6 text-xs text-slate-400">PetCare · Gestão para petshop · {{ date('Y') }}</footer>
  </div>
</div>
<x-toast />
@livewireScripts
<script src="//unpkg.com/alpinejs" defer></script>
</body></html>
