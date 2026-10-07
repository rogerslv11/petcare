<x-layouts.app title="Pacotes e planos">
@php($packs = \App\Models\Package::orderBy('name')->get())
@php($plans = \App\Models\SubscriptionPlan::orderBy('price')->get())
@php($activeCredits = \App\Models\PackageCredit::whereColumn('used_credits','<','total_credits')->count())
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $packs->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Pacotes</div><div class="text-2xl font-extrabold text-slate-900">{{ $packs->where('status','active')->count() }} ativos</div></div></div>
  <div class="stat"><div class="stat-ic bg-violet-50 text-violet-700 font-bold">{{ $plans->count() }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Planos recorrentes</div><div class="text-2xl font-extrabold text-slate-900">{{ $plans->where('status','active')->count() }} ativos</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">{{ $activeCredits }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Créditos vigentes</div><div class="text-2xl font-extrabold text-slate-900">clientes</div></div></div>
</div>
<div class="grid lg:grid-cols-2 gap-4">
  <div class="table-wrap">
    <div class="p-4 border-b border-slate-100"><div class="section-title">Pacotes</div><div class="section-hint">Ex: 4 banhos com desconto, válidos por 60 dias</div></div>
    <div class="p-4 space-y-3">
    @forelse($packs as $pk)
      <div class="border border-slate-200 rounded-xl p-4 flex items-center gap-4">
        <span class="avatar-lg !w-12 !h-12 !text-base">{{ strtoupper(substr($pk->name,0,1)) }}</span>
        <div class="flex-1 min-w-0"><div class="font-bold text-slate-900">{{ $pk->name }}</div><div class="text-xs text-slate-500">{{ $pk->validity_days }} dias de validade · <x-status-badge :value="$pk->status ?? 'active'"/></div></div>
        <div class="text-right"><div class="font-extrabold text-slate-900">R$ {{ number_format($pk->price, 2, ',', '.') }}</div></div>
      </div>
    @empty
      <x-empty-state title="Nenhum pacote" hint="Crie pacotes de banhos para fidelizar clientes."/>
    @endforelse
    </div>
  </div>
  <div class="table-wrap">
    <div class="p-4 border-b border-slate-100"><div class="section-title">Planos recorrentes</div><div class="section-hint">Mensalidades de creche, banho e hospedagem</div></div>
    <div class="p-4 space-y-3">
    @forelse($plans as $pl)
      <div class="border border-slate-200 rounded-xl p-4 flex items-center gap-4">
        <span class="avatar-lg !w-12 !h-12 !text-base !bg-violet-600">{{ strtoupper(substr($pl->name,0,1)) }}</span>
        <div class="flex-1 min-w-0"><div class="font-bold text-slate-900">{{ $pl->name }}</div><div class="text-xs text-slate-500 capitalize">{{ $pl->cycle ?? 'mensal' }}</div></div>
        <div class="text-right"><div class="font-extrabold text-slate-900">R$ {{ number_format($pl->price, 2, ',', '.') }}</div><div class="text-[11px] text-slate-400">/mês</div></div>
      </div>
    @empty
      <x-empty-state title="Nenhum plano" hint="Crie planos mensais para receita recorrente."/>
    @endforelse
    </div>
  </div>
</div>
</x-layouts.app>
