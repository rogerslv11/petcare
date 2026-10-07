<div class="relative w-full md:w-96" x-data="{open:true}">
 <input wire:model.live.debounce.300ms="q" placeholder="Buscar clientes, pets, serviços… (Ctrl+K)" class="input !bg-white !rounded-full !pl-4 shadow-sm"/>
 @if($q && count($results))
 <div class="absolute mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-pop p-2 z-50 overflow-hidden">
  @foreach($results['customers']??[] as $c)<div class="px-3 py-2 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2.5 cursor-pointer"><span class="avatar-sm">{{ strtoupper(substr($c['name'],0,1)) }}</span><span class="font-medium text-slate-800">{{ $c['name'] }}</span><span class="text-slate-400 text-xs">{{ $c['phone'] }}</span></div>@endforeach
  @foreach($results['pets']??[] as $p)<div class="px-3 py-2 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2.5 cursor-pointer"><span class="avatar-sm">{{ strtoupper(substr($p['name'],0,1)) }}</span><span class="font-medium text-slate-800">{{ $p['name'] }}</span></div>@endforeach
  @foreach($results['services']??[] as $s)<div class="px-3 py-2 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2.5 cursor-pointer"><span class="avatar-sm">S</span><span class="font-medium text-slate-800">{{ $s['name'] }}</span></div>@endforeach
 </div>
 @endif
</div>
