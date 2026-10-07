<x-layouts.app title="{{ $p->name }}">
<div class="card-pad">
  <div class="flex flex-col md:flex-row md:items-center gap-4">
    <span class="avatar-lg !w-20 !h-20 !text-3xl">{{ strtoupper(substr($p->name,0,1)) }}</span>
    <div class="flex-1 min-w-0">
      <div class="flex flex-wrap items-center gap-2"><h1 class="text-2xl font-extrabold text-slate-900">{{ $p->name }}</h1><x-status-badge :value="$p->status"/><span class="text-sm text-slate-400">{{ $p->age ?? '' }}</span></div>
      <div class="text-sm text-slate-500 mt-0.5">{{ $p->breed->name ?? 'SRD' }} · {{ $p->size ?? '' }} · {{ $p->weight ? $p->weight.' kg' : '' }}@if($p->customer) · Tutor <a class="text-primary-600 font-semibold" href="{{ route('customers.show',$p->customer) }}">{{ $p->customer->name }}</a>@endif</div>
    </div>
    <div class="flex gap-2"><a href="{{ route('appointments.create') }}" class="btn-primary btn-sm">Agendar</a><a href="{{ route('pets.index') }}" class="btn-ghost btn-sm">Voltar</a></div>
  </div>
  @if($p->allergies_summary)<div class="mt-3 text-xs bg-red-50 border border-red-200 text-red-700 rounded-xl px-3 py-2 font-medium">Atenção — alergias: {{ $p->allergies_summary }}</div>@endif
  @if($p->behavior || $p->temperament)<div class="mt-2 text-xs text-slate-500">Comportamento: <b class="text-slate-700">{{ $p->behavior ?? $p->temperament }}</b></div>@endif
</div>
<div class="grid lg:grid-cols-3 gap-4 mt-4">
  <div class="lg:col-span-2"><livewire:pet-timeline :pet="$p" /></div>
  <div class="space-y-4">
    <div class="card-pad">
      <div class="section-title">Saúde</div>
      <div class="mt-3 space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-slate-400">Vacinas registradas</span><b>{{ $p->vaccines->count() ?? \App\Models\Vaccine::where('pet_id',$p->id)->count() }}</b></div>
        <div class="flex justify-between"><span class="text-slate-400">Próx. dose</span><b>{{ optional(\App\Models\Vaccine::where('pet_id',$p->id)->orderBy('next_dose')->first()?->next_dose)->format('d/m/Y') ?? '—' }}</b></div>
        <div class="flex justify-between"><span class="text-slate-400">Microchip</span><b class="font-mono text-xs">{{ $p->microchip ?? '—' }}</b></div>
      </div>
    </div>
    <div class="card-pad">
      <div class="section-title">Atendimentos</div>
      <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ \App\Models\Appointment::where('pet_id',$p->id)->count() }}</div>
      <div class="section-hint">total de visitas</div>
      <a href="{{ route('appointments.create') }}" class="btn-ghost btn-sm w-full justify-center mt-3">Novo agendamento</a>
    </div>
  </div>
</div>
</x-layouts.app>
