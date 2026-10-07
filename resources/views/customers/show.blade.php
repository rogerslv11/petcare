<x-layouts.app title="{{ $c->name }}">
<div class="grid lg:grid-cols-3 gap-4">
  <div class="card-pad">
    <div class="flex items-center gap-4"><span class="avatar-lg">{{ strtoupper(substr($c->name,0,1)) }}</span>
      <div class="min-w-0"><h1 class="text-xl font-extrabold text-slate-900 truncate">{{ $c->name }}</h1><div class="text-sm text-slate-500">Cliente desde {{ optional($c->created_at)->format('m/Y') ?? '—' }}</div></div></div>
    <div class="mt-4"><x-status-badge :value="$c->status"/></div>
    <div class="divider"></div>
    <dl class="space-y-2 text-sm">
      <div class="flex justify-between"><dt class="text-slate-400">Celular</dt><dd class="font-semibold text-slate-800">{{ $c->phone ?? '—' }}</dd></div>
      <div class="flex justify-between"><dt class="text-slate-400">E-mail</dt><dd class="font-semibold text-slate-800 truncate max-w-[60%]">{{ $c->email ?? '—' }}</dd></div>
      <div class="flex justify-between"><dt class="text-slate-400">Documento</dt><dd class="font-semibold text-slate-800">{{ $c->document ?? '—' }}</dd></div>
      <div class="flex justify-between"><dt class="text-slate-400">Cidade</dt><dd class="font-semibold text-slate-800">{{ trim(($c->city ?? '').' '.($c->state ?? '')) ?: '—' }}</dd></div>
      <div class="flex justify-between"><dt class="text-slate-400">Pontos fidelidade</dt><dd class="font-bold text-amber-600">{{ $c->loyalty_points ?? 0 }} pts</dd></div>
    </dl>
    @if($c->notes)<div class="mt-3 text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-500">{{ $c->notes }}</div>@endif
    <div class="flex gap-2 mt-4"><a href="{{ route('appointments.create') }}" class="btn-primary btn-sm flex-1 justify-center">Agendar</a><a href="{{ route('customers.index') }}" class="btn-ghost btn-sm">Voltar</a></div>
  </div>
  <div class="lg:col-span-2 space-y-4">
    <div class="card-pad">
      <div class="flex items-center"><div><div class="section-title">Pets ({{ $c->pets->count() }})</div><div class="section-hint">Vinculados a este tutor</div></div><div class="flex-1"></div><a href="{{ route('pets.create') }}" class="btn-ghost btn-sm">Novo pet</a></div>
      <div class="grid md:grid-cols-2 gap-3 mt-3">
      @forelse($c->pets as $p)
        <a href="{{ route('pets.show',$p) }}" class="border border-slate-200 rounded-xl p-4 flex gap-3 hover:border-primary-300 hover:shadow-card transition">
          <span class="avatar">{{ strtoupper(substr($p->name,0,1)) }}</span>
          <span><b class="text-slate-900">{{ $p->name }}</b><span class="text-xs text-slate-400"> · {{ $p->age ?? '' }}</span><div class="text-xs text-slate-500">{{ $p->breed->name ?? 'SRD' }} · {{ $p->size ?? '' }}</div><div class="mt-1"><x-status-badge :value="$p->status"/></div></span>
        </a>
      @empty
        <div class="md:col-span-2"><x-empty-state title="Nenhum pet vinculado" hint="Cadastre o primeiro pet deste cliente."/></div>
      @endforelse
      </div>
    </div>
    <div class="table-wrap">
      <div class="p-4 border-b border-slate-100"><div class="section-title">Últimos atendimentos</div></div>
      <div class="overflow-x-auto"><table class="w-full"><thead><tr><th class="th">Data</th><th class="th">Pet</th><th class="th">Serviço</th><th class="th">Valor</th><th class="th">Status</th></tr></thead><tbody>
      @forelse(\App\Models\Appointment::where('customer_id',$c->id)->with(['pet','service'])->latest()->limit(6)->get() as $a)
        <tr class="row-hover"><td class="td text-slate-500 text-xs">{{ optional($a->scheduled_at)->format('d/m/Y H:i') ?? '—' }}</td><td class="td font-semibold">{{ $a->pet->name ?? '—' }}</td><td class="td text-slate-500">{{ $a->service->name ?? $a->type }}</td><td class="td font-bold">R$ {{ number_format($a->price ?? 0,2,',','.') }}</td><td class="td"><x-status-badge :value="$a->status instanceof \App\Enums\AppointmentStatus ? $a->status->value : $a->status"/></td></tr>
      @empty
        <tr><td colspan="5" class="td text-center text-slate-400 text-sm py-6">Sem atendimentos ainda.</td></tr>
      @endforelse
      </tbody></table></div>
    </div>
  </div>
</div>
</x-layouts.app>
