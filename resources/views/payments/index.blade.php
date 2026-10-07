<x-layouts.app title="Pagamentos">
@php($rows = \App\Models\Payment::with('customer')->latest()->paginate(15))
@php($pending = \App\Models\Payment::where('status','pending')->sum('amount'))
@php($today = \App\Models\Payment::where('status','paid')->whereDate('paid_at', today())->sum('amount'))
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Recebido hoje</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($today, 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">A receber</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($pending, 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ \App\Models\Payment::where('status','paid')->whereMonth('paid_at', now()->month)->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Pagtos no mês</div><div class="text-2xl font-extrabold text-slate-900">{{ \App\Models\Payment::where('status','paid')->whereMonth('paid_at', now()->month)->count() }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">→</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold"><a class="text-primary-600" href="{{ route('checkout.index') }}">Abrir check-out →</a></div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 border-b border-slate-100"><div class="section-title">Pagamentos</div><div class="section-hint">Histórico de cobranças e recebimentos</div></div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Cliente</th><th class="th">Método</th><th class="th">Vencimento</th><th class="th">Valor</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $pay)
      <tr class="row-hover">
        <td class="td font-semibold text-slate-900">{{ $pay->customer->name ?? 'Consumidor final' }}</td>
        <td class="td text-slate-500 uppercase text-xs font-semibold">{{ str_replace('_',' ',$pay->method) }}</td>
        <td class="td text-slate-500">{{ optional($pay->due_date)->format('d/m/Y') ?? optional($pay->paid_at)->format('d/m/Y') ?? '—' }}</td>
        <td class="td font-bold text-slate-900">R$ {{ number_format($pay->amount, 2, ',', '.') }}</td>
        <td class="td"><x-status-badge :value="$pay->status"/></td>
      </tr>
    @empty
      <tr><td colspan="5" class="td"><x-empty-state title="Nenhum pagamento registrado" hint="Vendas do PDV e check-outs geram pagamentos aqui."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
  <div class="p-4">{{ $rows->links() }}</div>
</div>
</x-layouts.app>
