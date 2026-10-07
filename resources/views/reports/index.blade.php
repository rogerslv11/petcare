<x-layouts.app title="Relatórios">
@php($biz = \App\Support\TenantContext::businessId())
@php($rep = app(\App\Services\ReportService::class))
@php($kpis = $biz ? $rep->kpis($biz) : [])
@php($rev = $biz ? $rep->revenueByDay($biz) : ['labels'=>[],'data'=>[]])
@php($topServices = \App\Models\Appointment::selectRaw('service_id, COUNT(*) as c, SUM(price) as v')->whereNotNull('service_id')->groupBy('service_id')->orderByDesc('c')->limit(5)->with('service')->get())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Receita mês</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($kpis['revenue_month'] ?? 0, 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $kpis['appt_today'] ?? 0 }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Atend. hoje</div><div class="text-2xl font-extrabold text-slate-900">{{ $kpis['appt_today'] ?? 0 }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-violet-50 text-violet-700 font-bold">{{ $kpis['active_customers'] ?? 0 }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Clientes ativos</div><div class="text-2xl font-extrabold text-slate-900">{{ $kpis['active_customers'] ?? 0 }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">{{ $lowStock = $kpis['low_stock'] ?? 0 }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Estoque baixo</div><div class="text-2xl font-extrabold text-slate-900">{{ $lowStock }}</div></div></div>
</div>
<div class="grid lg:grid-cols-3 gap-4">
  <div class="card p-5 lg:col-span-2">
    <div class="section-title">Receita · últimos 14 dias</div><div class="section-hint">Evolução do faturamento</div>
    <div class="flex items-end gap-1.5 h-44 mt-4">@foreach($rev['data'] as $v)<div class="flex-1 rounded-t-md bg-primary-500/90 hover:bg-primary-600 transition" style="height:{{ max(4,($v/max(1,$rev['data']->max()))*100) }}%" title="R$ {{ number_format($v,2,',','.') }}"></div>@endforeach</div>
    <div class="flex gap-1.5 mt-2">@foreach($rev['labels'] as $l)<div class="flex-1 text-[10px] text-slate-400 truncate">{{ substr($l,5) }}</div>@endforeach</div>
  </div>
  <div class="card p-5">
    <div class="section-title">Serviços mais procurados</div><div class="section-hint">Por nº de agendamentos</div>
    <div class="mt-4 space-y-3">
    @forelse($topServices as $t)
      @php($pct = $topServices->max('c') ? round($t->c / $topServices->max('c') * 100) : 0)
      <div><div class="flex justify-between text-sm"><b class="text-slate-800">{{ $t->service->name ?? '—' }}</b><span class="text-slate-500">{{ $t->c }}× · R$ {{ number_format($t->v, 0, ',', '.') }}</span></div>
      <div class="progress mt-1"><div class="progress-bar" style="width:{{ $pct }}%"></div></div></div>
    @empty
      <x-empty-state title="Sem dados ainda" hint="Agendamentos alimentam este ranking."/>
    @endforelse
    </div>
    <div class="divider"></div>
    <div class="grid grid-cols-2 gap-2">
      <a href="{{ route('financial.index') }}" class="btn-ghost btn-sm justify-center">Financeiro</a>
      <a href="{{ route('inventory.index') }}" class="btn-ghost btn-sm justify-center">Estoque</a>
    </div>
  </div>
</div>
</x-layouts.app>
