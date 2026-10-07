<x-layouts.app title="Serviços">
@php($rows = \App\Models\Service::with('category')->orderBy('name')->get())
@php($cats = \App\Models\ServiceCategory::orderBy('name')->get())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $rows->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Serviços</div><div class="text-2xl font-extrabold text-slate-900">{{ $rows->where('status','active')->count() }} ativos</div></div></div>
  <div class="stat"><div class="stat-ic bg-slate-100 text-slate-600 font-bold">{{ $cats->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Categorias</div><div class="text-2xl font-extrabold text-slate-900">{{ $cats->count() }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Ticket médio</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($rows->avg('price') ?? 0, 0, ',', '.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-amber-50 text-amber-700 font-bold">%</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Comissão média</div><div class="text-2xl font-extrabold text-slate-900">{{ number_format($rows->avg('commission_pct') ?? 0, 0) }}%</div></div></div>
</div>
<div class="table-wrap">
  <div class="p-4 flex flex-col md:flex-row md:items-center gap-2 border-b border-slate-100">
    <div><div class="section-title">Catálogo de serviços</div><div class="section-hint">Banho, tosa, veterinário, creche e hospedagem</div></div>
    <div class="flex-1"></div>
    <a href="{{ route('appointments.create') }}" class="btn-primary btn-sm">Agendar serviço</a>
  </div>
  <div class="overflow-x-auto"><table class="w-full">
    <thead><tr><th class="th">Serviço</th><th class="th">Categoria</th><th class="th">Duração</th><th class="th">Preço</th><th class="th">Comissão</th><th class="th">Status</th></tr></thead>
    <tbody>
    @forelse($rows as $s)
      <tr class="row-hover">
        <td class="td"><div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($s->name,0,1)) }}</span><span class="font-semibold text-slate-900">{{ $s->name }}</span></div></td>
        <td class="td text-slate-500">{{ $s->category->name ?? '—' }}</td>
        <td class="td text-slate-500">{{ $s->duration_min ? $s->duration_min.' min' : '—' }}</td>
        <td class="td font-bold text-slate-900">R$ {{ number_format($s->price, 2, ',', '.') }}</td>
        <td class="td text-slate-500">{{ $s->commission_pct ? $s->commission_pct.'%' : '—' }}</td>
        <td class="td"><x-status-badge :value="$s->status"/></td>
      </tr>
    @empty
      <tr><td colspan="6" class="td"><x-empty-state title="Nenhum serviço cadastrado" hint="Cadastre banho, tosa e demais serviços do catálogo."/></td></tr>
    @endforelse
    </tbody>
  </table></div>
</div>
</x-layouts.app>
