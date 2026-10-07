<div class="flex gap-3 overflow-x-auto pb-4">
 @foreach($cols as $key=>$label)
 @php($tone = ['pending'=>'bg-amber-100 text-amber-700','confirmed'=>'bg-sky-100 text-sky-700','checked_in'=>'bg-primary-100 text-primary-700','in_service'=>'bg-violet-100 text-violet-700','ready'=>'bg-emerald-100 text-emerald-700','completed'=>'bg-slate-200 text-slate-600'][$key] ?? 'bg-slate-100 text-slate-600')
 <div class="kanban-col">
  <div class="flex items-center gap-2 mb-1"><span class="w-2.5 h-2.5 rounded-full {{ $tone }} !w-2.5"></span><span class="font-bold text-sm text-slate-800">{{ $label }}</span></div>
  <div class="text-xs text-slate-400 mb-3">{{ count($cards[$key]) }} {{ count($cards[$key])==1?'pet':'pets' }}</div>
  <div class="space-y-2">
  @foreach($cards[$key] as $a)
   <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm hover:shadow-card transition">
    <div class="flex items-center gap-2.5">
     <span class="avatar">{{ strtoupper(substr($a->pet->name ?? '?',0,1)) }}</span>
     <div class="min-w-0"><div class="font-bold text-sm text-slate-900 truncate">{{ $a->pet->name }}</div><div class="text-[11px] text-slate-400">{{ $a->service->name??$a->type }} · {{ optional($a->scheduled_at)->format('H:i') ?? '—' }}</div></div>
    </div>
    <div class="text-[11px] text-slate-400 mt-1.5">{{ $a->professional->name??'Sem profissional' }} · {{ $a->customer->name ?? '' }}</div>
    <div class="flex gap-1 mt-2 flex-wrap">@foreach(['checked_in'=>'Check-in','in_service'=>'Atender','ready'=>'Pronto','completed'=>'Concluir'] as $t=>$l)@if($t!==$key)<button wire:click="move({{ $a->id }},'{{ $t }}')" class="text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-primary-600 hover:text-white transition">{{ $l }}</button>@endif@endforeach</div>
   </div>
  @endforeach
  @if(!count($cards[$key]))<div class="text-xs text-slate-300 text-center py-8 border border-dashed border-slate-200 rounded-xl">Nenhum pet nesta etapa</div>@endif
  </div>
 </div>
 @endforeach
</div>
