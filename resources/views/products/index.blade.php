<x-layouts.app title="Produtos">
@php($rows = \App\Models\Product::with('category')->orderBy('name')->paginate(20))
@php($low = \App\Models\Product::lowStock()->count())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ \App\Models\Product::count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Produtos</div><div class="text-2xl font-extrabold text-slate-900">{{ \App\Models\Product::count() }}</div></div></div></div>
  <div class="stat"><div class="stat-ic bg-red-50 text-red-700 font-bold">{{ $low }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Estoque baixo</div><div class="text-2xl font-extrabold text-slate-900">{{ $low }} itens</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Valor em estoque</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format(\App\Models\Product::selectRaw('SUM(stock * cost) as v')->value('v') ?? 0, 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">◷</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold text-slate-900"><a class="text-primary-600" href="{{ route('inventory.index') }}">Ajustar estoque →</a></div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 flex flex-col md:flex-row md:items-center gap-2 border-b border-slate-100">
    <div><div class="section-title">Catálogo de produtos</div><div class="section-hint">Ração, petiscos, higiene e acessórios</div></div>
    <div class="flex-1"></div>
    <a href="{{ route('pos.index') }}" class="btn-primary btn-sm">Vender no PDV</a>
    <a href="{{ route('purchases.index') }}" class="btn-ghost btn-sm">Compras</a>
  </div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Produto</th><th class="th">Categoria</th><th class="th">SKU</th><th class="th">Preço</th><th class="th">Estoque</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $p)
      <tr class="row-hover">
        <td class="td font-semibold text-slate-900">{{ $p->name }}</td>
        <td class="td text-slate-500">{{ $p->category->name ?? '—' }}</td>
        <td class="td text-slate-400 text-xs font-mono">{{ $p->sku ?? '—' }}</td>
        <td class="td font-bold text-slate-900">R$ {{ number_format($p->price, 2, ',', '.') }}</td>
        <td class="td">@if($p->stock <= $p->min_stock)<span class="badge-red">{{ $p->stock }} un · repor</span>@else<span class="text-slate-600">{{ $p->stock }} un</span>@endif</td>
        <td class="td"><x-status-badge :value="$p->status ?? 'active'"/></td>
      </tr>
    @empty
      <tr><td colspan="6" class="td"><x-empty-state title="Nenhum produto cadastrado" hint="Cadastre rações, petiscos e acessórios para vender no PDV."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
  <div class="p-4">{{ $rows->links() }}</div>
</div>
</x-layouts.app>
