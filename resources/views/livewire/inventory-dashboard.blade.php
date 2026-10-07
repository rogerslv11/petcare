<div class="space-y-4">
 <div class="grid grid-cols-3 gap-4">
  <div class="stat"><div class="stat-ic bg-primary-50 text-primary-700 font-bold">{{ $total }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Produtos</div><div class="text-2xl font-extrabold text-slate-900">no catálogo</div></div></div>
  <div class="stat"><div class="stat-ic bg-red-50 text-red-700 font-bold">{{ $low }}</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Estoque baixo</div><div class="text-2xl font-extrabold text-slate-900">repor</div></div></div>
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">R$</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Valor em estoque</div><div class="text-2xl font-extrabold text-slate-900">R$ {{ number_format($value,2,',','.') }}</div></div></div>
 </div>
 <div class="toolbar"><input wire:model.live.debounce.300ms="q" placeholder="Buscar produto…" class="input md:!w-80"/><div class="flex-1"></div><a href="{{ route('purchases.index') }}" class="btn-ghost btn-sm">Pedidos de compra</a></div>
 <div class="table-wrap"><div class="overflow-x-auto"><table class="w-full">
  <thead><tr><th class="th">Produto</th><th class="th">Estoque</th><th class="th">Nível</th><th class="th"></th></tr></thead>
  <tbody>
  @forelse($rows as $p)
   @php($pct = $p->min_stock > 0 ? min(100, round($p->stock / ($p->min_stock*2) * 100)) : 100)
   <tr class="row-hover">
    <td class="td"><b class="text-slate-900">{{ $p->name }}</b><div class="text-xs text-slate-400">mínimo: {{ $p->min_stock }} un</div></td>
    <td class="td"><span class="font-extrabold {{ $p->stock <= $p->min_stock ? 'text-red-600' : 'text-slate-900' }}">{{ $p->stock }} un</span></td>
    <td class="td min-w-[140px]"><div class="progress"><div class="progress-bar {{ $p->stock <= $p->min_stock ? '!bg-red-500' : '' }}" style="width:{{ max(4,$pct) }}%"></div></div></td>
    <td class="td text-right whitespace-nowrap"><button wire:click="adjust({{ $p->id }},1,'in')" class="btn-ghost btn-sm">+1</button> <button wire:click="adjust({{ $p->id }},1,'out')" class="btn-ghost btn-sm">−1</button></td>
   </tr>
  @empty
   <tr><td colspan="4" class="td"><x-empty-state title="Nenhum produto" hint="Cadastre produtos para controlar o estoque."/></td></tr>
  @endforelse
  </tbody>
 </table></div><div class="p-4">{{ $rows->links() }}</div></div>
</div>
