<x-layouts.app title="Fornecedores">
@php($rows = \App\Models\Supplier::orderBy('name')->get())
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $rows->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Fornecedores</div><div class="text-2xl font-extrabold text-slate-900">{{ $rows->count() }} ativos</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">{{ \App\Models\PurchaseOrder::where('status','pending')->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Pedidos pendentes</div><div class="text-2xl font-extrabold text-slate-900">em compras</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">→</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold"><a class="text-primary-600" href="{{ route('purchases.index') }}">Ver compras →</a></div></div></div>
</div>
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
  @forelse($rows as $s)
    <div class="card p-5">
      <div class="flex items-center gap-3"><span class="avatar-lg !w-12 !h-12 !text-base">{{ strtoupper(substr($s->name,0,1)) }}</span>
        <div class="min-w-0"><div class="font-bold text-slate-900 truncate">{{ $s->name }}</div><div class="text-xs text-slate-500">{{ $s->contact ?? $s->email ?? '—' }}</div></div></div>
      <div class="mt-3 space-y-1 text-sm text-slate-500">
        <div>Telefone: <b class="text-slate-700">{{ $s->phone ?? '—' }}</b></div>
        <div>Documento: <b class="text-slate-700">{{ $s->document ?? '—' }}</b></div>
      </div>
      @if($s->notes)<p class="text-xs text-slate-400 mt-2">{{ \Illuminate\Support\Str::limit($s->notes, 90) }}</p>@endif
    </div>
  @empty
    <div class="md:col-span-2 xl:col-span-3"><x-empty-state title="Nenhum fornecedor cadastrado" hint="Cadastre distribuidores de ração e produtos."/></div>
  @endforelse
</div>
</x-layouts.app>
