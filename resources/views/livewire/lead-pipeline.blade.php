<div class="flex gap-3 overflow-x-auto pb-4">
@foreach($stages as $k=>$label)
 <div class="kanban-col">
  <div class="flex items-center justify-between mb-1"><span class="font-bold text-sm text-slate-800">{{ $label }}</span><span class="text-[11px] font-bold text-slate-400 bg-slate-100 rounded-full px-2 py-0.5">{{ count($cards[$k]) }}</span></div>
  <div class="space-y-2 mt-2">
  @forelse($cards[$k] as $l)
   <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm">
    <b class="text-sm text-slate-900">{{ $l->name }}</b>
    <div class="text-[11px] text-slate-400 mt-0.5">{{ $l->phone ?? '—' }}{{ $l->interest ? ' · '.$l->interest : '' }}</div>
    @if($l->next_contact_at)<div class="text-[11px] text-amber-600 font-semibold mt-1">Retornar em {{ optional($l->next_contact_at)->format('d/m') }}</div>@endif
   </div>
  @empty
   <div class="text-xs text-slate-300 text-center py-6 border border-dashed border-slate-200 rounded-xl">Nenhum lead</div>
  @endforelse
  </div>
 </div>
@endforeach
</div>
