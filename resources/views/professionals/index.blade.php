<x-layouts.app title="Equipe">
@php($rows = \App\Models\Professional::orderBy('name')->get())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $rows->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Profissionais</div><div class="text-2xl font-extrabold text-slate-900">{{ $rows->where('status','active')->count() }} ativos</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Comissões pendentes</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format(\App\Models\Commission::where('status','pending')->sum('amount'), 2, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">%</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Comissão média</div><div class="text-2xl font-extrabold text-slate-900">{{ number_format($rows->avg('commission_pct') ?? 0, 0) }}%</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">◷</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Atend. hoje</div><div class="text-2xl font-extrabold text-slate-900">{{ \App\Models\Appointment::whereDate('scheduled_at', today())->count() }}</div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 flex flex-col md:flex-row md:items-center gap-2 border-b border-slate-100">
    <div><div class="section-title">Equipe</div><div class="section-hint">Banhistas, tosadores, veterinários e recepção</div></div>
    <div class="flex-1"></div>
    <a href="{{ route('commissions.index') }}" class="btn-ghost btn-sm">Ver comissões</a>
  </div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Profissional</th><th class="th">Função</th><th class="th">Contato</th><th class="th">Comissão</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $p)
      <tr class="row-hover">
        <td class="td"><div class="flex items-center gap-3"><span class="avatar">{{ strtoupper(substr($p->name,0,1)) }}</span><span class="font-semibold text-slate-900">{{ $p->name }}</span></div></td>
        <td class="td text-slate-500 capitalize">{{ str_replace('_',' ',$p->role ?? '—') }}</td>
        <td class="td text-slate-500">{{ $p->phone ?? $p->email ?? '—' }}</td>
        <td class="td text-slate-500">{{ $p->commission_pct ? $p->commission_pct.'%' : '—' }}</td>
        <td class="td"><x-status-badge :value="$p->status ?? 'active'"/></td>
      </tr>
    @empty
      <tr><td colspan="5" class="td"><x-empty-state title="Nenhum profissional cadastrado" hint="Cadastre a equipe para vincular agendamentos e comissões."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
</div>
</x-layouts.app>
