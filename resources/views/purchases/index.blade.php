<x-layouts.app title="Compras">
@php($rows = \App\Models\PurchaseOrder::with('supplier')->latest()->paginate(15))
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">{{ \App\Models\PurchaseOrder::where('status','pending')->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Pendentes</div><div class="text-2xl font-extrabold text-slate-900">{{ \App\Models\PurchaseOrder::where('status','pending')->count() }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">{{ \App\Models\PurchaseOrder::where('status','received')->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Recebidos</div><div class="text-2xl font-extrabold text-slate-900">{{ \App\Models\PurchaseOrder::where('status','received')->count() }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Total mês</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format(\App\Models\PurchaseOrder::whereMonth('created_at', now()->month)->sum('total'), 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">→</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold"><a class="text-primary-600" href="{{ route('suppliers.index') }}">Fornecedores →</a></div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 border-b border-slate-100"><div class="section-title">Pedidos de compra</div><div class="section-hint">Reposição de estoque junto aos fornecedores</div></div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Pedido</th><th class="th">Fornecedor</th><th class="th">Previsão</th><th class="th">Total</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $o)
      <tr class="row-hover">
        <td class="td font-mono font-bold text-slate-900">#{{ $o->id }}</td>
        <td class="td text-slate-600">{{ $o->supplier->name ?? '—' }}</td>
        <td class="td text-slate-500">{{ optional($o->expected_at)->format('d/m/Y') ?? '—' }}</td>
        <td class="td font-bold text-slate-900">R$ {{ number_format($o->total ?? 0, 2, ',', '.') }}</td>
        <td class="td"><x-status-badge :value="$o->status"/></td>
      </tr>
    @empty
      <tr><td colspan="5" class="td"><x-empty-state title="Nenhum pedido de compra" hint="Os pedidos de reposição aparecem aqui."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
  <div class="p-4">{{ $rows->links() }}</div>
</div>
</x-layouts.app>
