<div class="grid lg:grid-cols-2 gap-4">
 <div class="card-pad">
  <div class="section-title">Buscar agendamento</div><div class="section-hint">Digite o nome do tutor ou do pet</div>
  <div class="flex gap-2 mt-3"><input wire:model="q" wire:keydown.enter="search" placeholder="Ex: Maria, Rex…" class="input"/><button wire:click="search" class="btn-primary shrink-0">Buscar</button></div>
  @if(count($found))
  <div class="mt-3 space-y-2">
   @foreach($found as $a)
   <div class="border border-slate-200 rounded-xl p-3 flex justify-between items-center gap-3">
    <div class="flex items-center gap-3 min-w-0"><span class="avatar">{{ strtoupper(substr($a->pet->name ?? '?',0,1)) }}</span>
     <div class="min-w-0"><b class="text-slate-900">{{ $a->pet->name }}</b><div class="text-xs text-slate-400 truncate">{{ $a->customer->name }} · {{ $a->service->name??'' }} · {{ optional($a->scheduled_at)->format('H:i') ?? '' }}</div></div></div>
    <button wire:click="checkin({{ $a->id }})" class="btn-primary btn-sm shrink-0">Check-in</button>
   </div>
   @endforeach
  </div>
  @endif
 </div>
 <div class="card-pad">
  <div class="flex items-center"><div><div class="section-title">Aguardando hoje</div><div class="section-hint">{{ count($today) }} agendamentos</div></div></div>
  <div class="mt-3 space-y-2">
  @forelse($today as $a)
   <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex justify-between items-center gap-3">
    <div class="flex items-center gap-3 min-w-0"><span class="text-xs font-mono font-bold text-slate-500 bg-white border border-slate-200 rounded-lg px-2 py-1">{{ optional($a->scheduled_at)->format('H:i') ?? '—' }}</span>
     <div class="min-w-0"><b class="text-slate-900">{{ $a->pet->name }}</b><div class="text-xs text-slate-400 truncate">{{ $a->service->name??$a->type }}</div></div></div>
    <button wire:click="checkin({{ $a->id }})" class="btn-ghost btn-sm shrink-0">Dar entrada</button>
   </div>
  @empty
   <x-empty-state title="Nada aguardando" hint="Todos os pets de hoje já fizeram check-in."/>
  @endforelse
  </div>
 </div>
</div>
