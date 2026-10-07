<div class="grid md:grid-cols-2 xl:grid-cols-4 gap-3">
@foreach($cols as $k=>$list)
 <div class="kanban-col !w-auto">
  <div class="flex items-center justify-between mb-1"><span class="font-bold text-sm text-slate-800 capitalize">{{ str_replace('_',' ',$k) }}</span><span class="text-[11px] font-bold text-slate-400 bg-slate-100 rounded-full px-2 py-0.5">{{ count($list) }}</span></div>
  <div class="space-y-2 mt-2">
  @forelse($list as $g)
   <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm">
    <div class="flex items-center gap-2"><span class="avatar-sm">{{ strtoupper(substr($g->pet->name??'?',0,1)) }}</span><b class="text-sm text-slate-900">{{ $g->pet->name??'' }}</b></div>
    <div class="text-[11px] text-slate-400 mt-1">{{ $g->type }} · {{ $g->behavior??'sem obs.' }}</div>
    @if($g->products_used)<div class="text-[11px] text-slate-500 mt-1 truncate">Produtos: {{ is_array($g->products_used) ? implode(', ', $g->products_used) : $g->products_used }}</div>@endif
   </div>
  @empty
   <div class="text-xs text-slate-300 text-center py-6 border border-dashed border-slate-200 rounded-xl">Vazio</div>
  @endforelse
  </div>
 </div>
@endforeach
</div>
