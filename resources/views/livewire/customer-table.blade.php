<div class="table-wrap">
 <div class="toolbar !border-0 !shadow-none">
  <input wire:model.live.debounce.300ms="search" placeholder="Buscar cliente por nome, telefone…" class="input md:!w-80"/>
  <select wire:model.live="status" class="input md:!w-48"><option value="">Todos os status</option><option value="active">Ativos</option><option value="inactive">Inativos</option></select>
  <div class="flex-1"></div><a href="{{ route('customers.create') }}" class="btn-primary btn-sm">Novo cliente</a>
 </div>
 <div class="overflow-x-auto"><table class="w-full">
  <thead><tr><th class="th">Cliente</th><th class="th">Contato</th><th class="th">Pets</th><th class="th">Pontos</th><th class="th">Status</th><th class="th"></th></tr></thead>
  <tbody>
  @forelse($rows as $c)
   <tr class="row-hover">
    <td class="td"><div class="flex items-center gap-3"><span class="avatar">{{ strtoupper(substr($c->name,0,1)) }}</span><a class="font-semibold text-slate-900 hover:text-primary-600" href="{{ route('customers.show',$c) }}">{{ $c->name }}</a></div></td>
    <td class="td"><div class="text-slate-600 text-sm">{{ $c->phone }}</div><div class="text-xs text-slate-400">{{ $c->email }}</div></td>
    <td class="td"><span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">{{ $c->pets_count }}</span></td>
    <td class="td"><span class="font-bold text-amber-600 text-sm">{{ $c->loyalty_points }} pts</span></td>
    <td class="td"><x-status-badge :value="$c->status"/></td>
    <td class="td text-right"><a href="{{ route('customers.show',$c) }}" class="btn-ghost btn-sm">Abrir</a></td>
   </tr>
  @empty
   <tr><td colspan="6" class="td"><x-empty-state title="Nenhum cliente encontrado" hint="Ajuste a busca ou cadastre um novo cliente."/></td></tr>
  @endforelse
  </tbody>
 </table></div>
 <div class="p-4">{{ $rows->links() }}</div>
</div>
