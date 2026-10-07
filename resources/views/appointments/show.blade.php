<x-layouts.app title="Agendamento #{{ $a->id }}">
<div class="grid lg:grid-cols-3 gap-4">
  <div class="card-pad lg:col-span-2">
    <div class="flex flex-wrap items-center gap-2"><h1 class="text-xl font-extrabold text-slate-900">Agendamento #{{ $a->id }}</h1><x-status-badge :value="$a->status instanceof \App\Enums\AppointmentStatus ? $a->status->value : $a->status"/></div>
    <div class="text-sm text-slate-500 mt-1">{{ optional($a->scheduled_at)->format('d/m/Y H:i') ?? 'data a definir' }}{{ $a->ends_at ? ' → '.optional($a->ends_at)->format('H:i') : '' }}</div>
    <div class="divider"></div>
    <dl class="grid md:grid-cols-2 gap-3 text-sm">
      <div class="bg-slate-50 rounded-xl p-3"><dt class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold">Pet</dt><dd class="font-bold text-slate-900">{{ $a->pet->name ?? '—' }}</dd></div>
      <div class="bg-slate-50 rounded-xl p-3"><dt class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold">Tutor</dt><dd class="font-bold text-slate-900">{{ $a->customer->name ?? '—' }}</dd></div>
      <div class="bg-slate-50 rounded-xl p-3"><dt class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold">Serviço</dt><dd class="font-bold text-slate-900">{{ $a->service->name ?? $a->type }}</dd></div>
      <div class="bg-slate-50 rounded-xl p-3"><dt class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold">Profissional</dt><dd class="font-bold text-slate-900">{{ $a->professional->name ?? 'A definir' }}</dd></div>
    </dl>
    @if($a->notes)<div class="mt-3 text-sm bg-amber-50 border border-amber-200 rounded-xl p-3 text-amber-800">{{ $a->notes }}</div>@endif
  </div>
  <div class="space-y-4">
    <div class="card-pad text-center">
      <div class="section-hint">Valor do serviço</div>
      <div class="text-3xl font-extrabold text-slate-900 mt-1">R$ {{ number_format($a->price ?? 0, 2, ',', '.') }}</div>
      <div class="grid grid-cols-2 gap-2 mt-4">
        <a href="{{ route('checkin.index') }}" class="btn-primary btn-sm justify-center">Check-in</a>
        <a href="{{ route('checkout.index') }}" class="btn-ghost btn-sm justify-center">Check-out</a>
      </div>
    </div>
    <div class="card-pad">
      <div class="section-title">Histórico de status</div>
      <div class="mt-3 space-y-2">
      @forelse($a->statusHistory()->latest()->limit(6)->get() as $h)
        <div class="text-xs"><span class="text-slate-400">{{ optional($h->created_at)->format('d/m H:i') }}</span> · <b>{{ $h->from_status ?? '—' }}</b> → <b class="text-primary-700">{{ $h->to_status }}</b></div>
      @empty
        <div class="text-xs text-slate-400">Sem movimentações registradas.</div>
      @endforelse
      </div>
    </div>
  </div>
</div>
</x-layouts.app>
