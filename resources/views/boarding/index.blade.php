<x-layouts.app title="Hospedagem">
@php($rows = \App\Models\BoardingRecord::with(['pet','customer'])->whereIn('status',['reserved','checked_in'])->orderBy('check_in')->paginate(15))
@php($inHouse = \App\Models\BoardingRecord::where('status','checked_in')->count())
@php($upcoming = \App\Models\BoardingRecord::where('status','reserved')->count())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">{{ $inHouse }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Hospedados agora</div><div class="text-2xl font-extrabold text-slate-900">pets</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">{{ $upcoming }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Reservas futuras</div><div class="text-2xl font-extrabold text-slate-900">estadias</div></div></div>
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Receita período</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($rows->sum('price'), 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">→</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold"><a class="text-primary-600" href="{{ route('appointments.create') }}">Nova reserva →</a></div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 border-b border-slate-100"><div class="section-title">Estadias ativas e reservadas</div><div class="section-hint">Check-in, check-out, alimentação e medicação</div></div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Pet</th><th class="th">Tutor</th><th class="th">Canil/Unid.</th><th class="th">Entrada</th><th class="th">Saída</th><th class="th">Diária</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $b)
      <tr class="row-hover">
        <td class="td"><div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($b->pet->name ?? '?',0,1)) }}</span><span class="font-semibold text-slate-900">{{ $b->pet->name ?? '—' }}</span></div></td>
        <td class="td text-slate-500">{{ $b->customer->name ?? '—' }}</td>
        <td class="td text-slate-500">{{ $b->unit ?? '—' }}</td>
        <td class="td text-slate-600 text-xs">{{ optional($b->check_in)->format('d/m H:i') ?? '—' }}</td>
        <td class="td text-slate-600 text-xs">{{ optional($b->check_out)->format('d/m H:i') ?? '—' }}</td>
        <td class="td font-bold text-slate-900">R$ {{ number_format($b->price ?? 0, 2, ',', '.') }}</td>
        <td class="td"><x-status-badge :value="$b->status"/></td>
      </tr>
    @empty
      <tr><td colspan="7" class="td"><x-empty-state title="Nenhuma estadia ativa" hint="Reservas de hospedagem aparecem aqui."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
  <div class="p-4">{{ $rows->links() }}</div>
</div>
</x-layouts.app>
