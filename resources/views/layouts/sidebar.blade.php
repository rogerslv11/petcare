@php
$link = fn($route, $label, $icon, $pattern=null) => ['route'=>$route,'label'=>$label,'icon'=>$icon,'active'=>request()->routeIs($pattern ?? $route.'*')];
$groups = [
  'Visão geral' => [
    $link('dashboard','Dashboard','M3 12l9-9 9 9M9 21V12', 'dashboard'),
    $link('calendar.index','Agenda','M8 7V3M16 7V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z'),
    $link('kanban.index','Quadro de atendimento','M4 5h6v14H4zM14 5h6v9h-6z'),
  ],
  'Atendimento' => [
    $link('appointments.index','Agendamentos','M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z'),
    $link('checkin.index','Check-in','M5 13l4 4L19 7'),
    $link('checkout.index','Check-out','M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2M7 19h10a2 2 0 002-2v-6a2 2 0 00-2-2H9'),
    $link('grooming.index','Banho & Tosa','M12 3v18M5 8l14 8M19 8L5 16'),
    $link('daycare.index','Creche','M12 21s-7-4.5-7-11a7 7 0 0114 0c0 6.5-7 11-7 11z'),
    $link('boarding.index','Hospedagem','M3 10l9-7 9 7M5 9v11h14V9'),
  ],
  'Clientes' => [
    $link('customers.index','Clientes','M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21v-1a7 7 0 0114 0v1'),
    $link('pets.index','Pets','M12 21s-7-4.5-7-11a7 7 0 0114 0c0 6.5-7 11-7 11z'),
    $link('leads.index','CRM / Leads','M3 8l7-5 7 5v8a2 2 0 01-2 2H5a2 2 0 01-2-2z'),
  ],
  'Catálogo e equipe' => [
    $link('services.index','Serviços','M14 5l7 7-9 9H5v-7z'),
    $link('professionals.index','Equipe','M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z'),
    $link('commissions.index','Comissões','M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6'),
    $link('packages.index','Pacotes e planos','M21 8l-9-5-9 5v8l9 5 9-5zM3 8l9 5 9-5M12 13v8'),
    $link('loyalty.index','Fidelidade','M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z'),
  ],
  'Vendas e estoque' => [
    $link('pos.index','PDV','M4 7h16M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7M9 11h6'),
    $link('products.index','Produtos','M20 7l-8-4-8 4v10l8 4 8-4z'),
    $link('inventory.index','Estoque','M3 3v18h18M8 17V9m5 8V5m5 12v-6'),
    $link('suppliers.index','Fornecedores','M8 7h12M8 12h12M8 17h12M3 7h.01M3 12h.01M3 17h.01'),
    $link('purchases.index','Compras','M6 6h15l-1.5 9h-12zM6 6L5 3H2'),
  ],
  'Financeiro' => [
    $link('payments.index','Pagamentos','M2 7a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2zM2 10h20'),
    $link('cash.index','Caixa','M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z'),
    $link('financial.index','Financeiro','M3 17l6-6 4 4 8-8M15 7h6v6'),
    $link('reports.index','Relatórios','M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z'),
  ],
  'Sistema' => [
    $link('settings.index','Configurações','M12 15a3 3 0 100-6 3 3 0 000 6zM19 12a7 7 0 01-.1 1.2l2 1.6-2 3.4-2.4-1a7 7 0 01-2 1.2L14 20h-4l-.5-2.6a7 7 0 01-2-1.2l-2.4 1-2-3.4 2-1.6A7 7 0 015 12a7 7 0 01.1-1.2l-2-1.6 2-3.4 2.4 1a7 7 0 012-1.2L10 3h4l.5 2.6a7 7 0 012 1.2l2.4-1 2 3.4-2 1.6c.06.4.1.8.1 1.2z'),
  ],
];
$storeName = auth()->check() ? (optional(auth()->user()->currentBusiness)->name ?? config('app.name','PetCare')) : config('app.name','PetCare');
@endphp
<aside class="hidden lg:flex w-72 shrink-0 flex-col bg-white border-r border-slate-200 fixed inset-y-0 overflow-y-auto z-40">
  <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
    <div class="w-10 h-10 rounded-xl bg-primary-600 grid place-items-center text-white font-extrabold text-lg">P</div>
    <div class="min-w-0"><div class="font-extrabold tracking-tight text-slate-900 leading-tight">PetCare</div>
    <div class="text-xs text-slate-500 truncate">{{ $storeName }}</div></div>
  </a>
  <nav class="p-3 pb-8">
    @foreach($groups as $section => $items)
      <div class="sidebar-section">{{ $section }}</div>
      @foreach($items as $it)
        <a href="{{ Route::has($it['route']) ? route($it['route']) : '#' }}" class="sidebar-link {{ $it['active']?'active':'' }}">
          <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $it['icon'] }}"/></svg>
          {{ $it['label'] }}
        </a>
      @endforeach
    @endforeach
  </nav>
</aside>
{{-- mobile drawer --}}
<div x-show="sidebar" class="fixed inset-0 z-50 lg:hidden" style="display:none">
  <div class="absolute inset-0 bg-slate-900/40" @click="sidebar=false"></div>
  <div class="absolute left-0 top-0 bottom-0 w-72 bg-white shadow-pop p-3 overflow-y-auto">
    <div class="flex items-center justify-between px-2 py-3">
      <span class="font-extrabold">PetCare</span>
      <button class="btn-ghost !px-3" @click="sidebar=false">✕</button>
    </div>
    @foreach($groups as $section => $items)
      <div class="sidebar-section">{{ $section }}</div>
      @foreach($items as $it)
        <a href="{{ Route::has($it['route']) ? route($it['route']) : '#' }}" class="sidebar-link {{ $it['active']?'active':'' }}">{{ $it['label'] }}</a>
      @endforeach
    @endforeach
  </div>
</div>
