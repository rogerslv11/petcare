<div class="space-y-6">
 <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
  <x-stat-card label="Receita hoje" value="R$ {{ number_format($kpis['revenue_today']??0,2,',','.') }}" tone="green" />
  <x-stat-card label="Receita mês" value="R$ {{ number_format($kpis['revenue_month']??0,2,',','.') }}" tone="primary" />
  <x-stat-card label="Agend. hoje" value="{{ $kpis['appt_today']??0 }}" tone="slate" />
  <x-stat-card label="Em atendimento" value="{{ $kpis['pets_waiting']??0 }}" tone="amber" />
  <x-stat-card label="Clientes ativos" value="{{ $kpis['active_customers']??0 }}" tone="slate" />
  <x-stat-card label="Pets" value="{{ $kpis['pets']??0 }}" tone="slate" />
  <x-stat-card label="A receber" value="R$ {{ number_format($kpis['pending_payments']??0,2,',','.') }}" tone="amber" />
  <x-stat-card label="Estoque baixo" value="{{ $kpis['low_stock']??0 }}" tone="red" />
 </div>
 <div class="grid lg:grid-cols-3 gap-4">
  <div class="card p-5 lg:col-span-2"><h3 class="font-bold text-slate-900 mb-1">Receita · últimos 14 dias</h3>
   <p class="text-xs text-slate-500 mb-3">Evolução do faturamento da loja</p>
   <div class="flex items-end gap-1.5 h-36">@foreach($rev['data'] as $v)<div class="flex-1 rounded-t-md bg-primary-500/90" style="height:{{ max(4,($v/max(1,$rev['data']->max()))*100) }}%" title="R$ {{ $v }}"></div>@endforeach</div>
   <div class="flex gap-1.5 mt-2">@foreach($rev['labels'] as $l)<div class="flex-1 text-[10px] text-slate-400 truncate">{{ substr($l,5) }}</div>@endforeach</div>
  </div>
  <div class="card p-5"><h3 class="font-bold text-slate-900 mb-1">Ações rápidas</h3>
   <p class="text-xs text-slate-500 mb-3">Rotina da recepção</p>
   <div class="grid grid-cols-1 gap-2">
    <a href="{{ route('appointments.create') }}" class="btn-primary justify-center">Novo agendamento</a>
    <a href="{{ route('checkin.index') }}" class="btn-ghost justify-center">Abrir check-in</a>
    <a href="{{ route('pos.index') }}" class="btn-ghost justify-center">Abrir PDV</a>
    <a href="{{ route('customers.create') }}" class="btn-ghost justify-center">Cadastrar cliente</a>
   </div></div>
 </div></div>
