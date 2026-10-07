<div class="card-pad">
 <div class="section-title">Histórico do pet</div><div class="section-hint">Atendimentos, vacinas e observações</div>
 <div class="mt-4 space-y-0">
 @forelse($appts as $a)
  <div class="flex gap-3 pb-4 last:pb-0">
   <div class="flex flex-col items-center"><span class="w-3 h-3 rounded-full bg-primary-500 shrink-0 mt-1"></span><span class="w-px flex-1 bg-slate-200"></span></div>
   <div class="pb-1"><div class="text-[11px] font-semibold text-slate-400">{{ optional($a->scheduled_at)->format('d/m/Y H:i') ?? '—' }}</div>
   <div class="font-semibold text-sm text-slate-800">{{ $a->service->name??$a->type }} <span class="font-normal text-slate-400">· {{ $a->professional->name??'' }}</span></div>
   @if($a->notes)<div class="text-xs text-slate-500 mt-0.5">{{ $a->notes }}</div>@endif</div>
  </div>
 @empty
 @endforelse
 @foreach($vacc as $v)
  <div class="flex gap-3 pb-4 last:pb-0">
   <div class="flex flex-col items-center"><span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0 mt-1"></span><span class="w-px flex-1 bg-slate-200"></span></div>
   <div class="pb-1"><div class="text-[11px] font-semibold text-slate-400">{{ optional($v->date)->format('d/m/Y') ?? '—' }}</div>
   <div class="text-sm text-slate-800"><b>Vacina:</b> {{ $v->name }} @if($v->next_dose)<span class="badge-amber ml-1">próx. {{ optional($v->next_dose)->format('d/m/Y') }}</span>@endif</div></div>
  </div>
 @endforeach
 @if($appts->isEmpty() && $vacc->isEmpty())
  <x-empty-state title="Sem histórico ainda" hint="Agendamentos e vacinas aparecem nesta linha do tempo."/>
 @endif
 </div>
</div>
