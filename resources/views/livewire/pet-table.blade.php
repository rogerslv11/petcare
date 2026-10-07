<div class="table-wrap">
 <div class="toolbar !border-0 !shadow-none">
  <input wire:model.live.debounce.300ms="search" placeholder="Buscar pet por nome…" class="input md:!w-80"/>
  <div class="flex-1"></div><a href="{{ route('pets.create') }}" class="btn-primary btn-sm">Novo pet</a>
 </div>
 <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 p-4">
 @forelse($rows as $p)
  <a href="{{ route('pets.show',$p) }}" class="border border-slate-200 rounded-2xl p-4 flex gap-3 hover:border-primary-300 hover:shadow-card transition bg-white">
   <span class="avatar-lg !w-14 !h-14 !text-xl">{{ strtoupper(substr($p->name,0,1)) }}</span>
   <span class="min-w-0 flex-1"><span class="flex items-center gap-2"><b class="text-slate-900 truncate">{{ $p->name }}</b><span class="text-[11px] text-slate-400 whitespace-nowrap">{{ $p->age }}</span></span>
   <span class="block text-xs text-slate-500 truncate mt-0.5">{{ $p->breed->name??'SRD' }} · {{ $p->customer->name??'' }}</span>
   <span class="block mt-1.5"><x-status-badge :value="$p->status"/></span></span>
  </a>
 @empty
  <div class="md:col-span-2 xl:col-span-3"><x-empty-state title="Nenhum pet encontrado" hint="Ajuste a busca ou cadastre um novo pet."/></div>
 @endforelse
 </div>
 <div class="p-4">{{ $rows->links() }}</div>
</div>
