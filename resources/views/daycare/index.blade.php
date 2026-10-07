<x-layouts.app title="Creche">
@php($today = \App\Models\DaycareRecord::with(['pet','customer'])->whereDate('date', today())->latest()->get())
@php($inHouse = $today->where('status','checked_in')->count())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">{{ $inHouse }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Na creche agora</div><div class="text-2xl font-extrabold text-slate-900">pets</div></div></div>
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $today->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Diárias hoje</div><div class="text-2xl font-extrabold text-slate-900">registros</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Receita hoje</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($today->sum('price'), 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">→</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ação</div><div class="text-sm font-bold"><a class="text-primary-600" href="{{ route('checkin.index') }}">Fazer check-in →</a></div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 border-b border-slate-100"><div class="section-title">Creche de hoje · {{ today()->format('d/m/Y') }}</div><div class="section-hint">Entradas, saídas, alimentação e comportamento</div></div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Pet</th><th class="th">Tutor</th><th class="th">Entrada</th><th class="th">Saída</th><th class="th">Alimentação</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($today as $d)
      <tr class="row-hover">
        <td class="td"><div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($d->pet->name ?? '?',0,1)) }}</span><a href="{{ $d->pet ? route('pets.show',$d->pet) : '#' }}" class="font-semibold text-slate-900 hover:text-primary-600">{{ $d->pet->name ?? '—' }}</a></div></td>
        <td class="td text-slate-500">{{ $d->customer->name ?? '—' }}</td>
        <td class="td font-mono text-slate-600">{{ $d->check_in ?? '—' }}</td>
        <td class="td font-mono text-slate-600">{{ $d->check_out ?? '—' }}</td>
        <td class="td text-slate-500 text-xs">{{ \Illuminate\Support\Str::limit($d->feeding ?? '—', 40) }}</td>
        <td class="td"><x-status-badge :value="$d->status"/></td>
      </tr>
    @empty
      <tr><td colspan="6" class="td"><x-empty-state title="Nenhuma diária hoje" hint="Os check-ins de creche aparecem aqui."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
</div>
</x-layouts.app>
