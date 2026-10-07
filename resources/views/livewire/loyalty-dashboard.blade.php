<div class="table-wrap">
 <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row md:items-center gap-2">
  <div><div class="section-title">Fidelidade</div><div class="section-hint">A cada R$ 1 em compras = 1 ponto · 500 pontos = R$ 20 de desconto</div></div>
 </div>
 <div class="overflow-x-auto"><table class="w-full">
  <thead><tr><th class="th">Cliente</th><th class="th">Saldo</th><th class="th">Progresso p/ resgate</th><th class="th"></th></tr></thead>
  <tbody>
  @forelse($rows as $a)
   @php($pct = min(100, round(($a->points/500)*100)))
   <tr class="row-hover">
    <td class="td"><div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($a->customer->name ?? '?',0,1)) }}</span><b class="text-slate-900">{{ $a->customer->name??'' }}</b></div></td>
    <td class="td"><span class="font-extrabold text-amber-600">{{ $a->points }} pts</span></td>
    <td class="td min-w-[160px]"><div class="progress"><div class="progress-bar !bg-amber-400" style="width:{{ $pct }}%"></div></div><div class="text-[11px] text-slate-400 mt-1">{{ $pct }}% de 500 pts</div></td>
    <td class="td text-right">@if($a->points>=500)<button wire:click="redeem({{ $a->id }})" class="btn-primary btn-sm">Resgatar R$ 20</button>@else<span class="text-[11px] text-slate-300 font-semibold">Acumular</span>@endif</td>
   </tr>
  @empty
   <tr><td colspan="4" class="td"><x-empty-state title="Nenhum ponto acumulado" hint="Pontos são gerados automaticamente nas vendas do PDV."/></td></tr>
  @endforelse
  </tbody>
 </table></div>
 <div class="p-4">{{ $rows->links() }}</div>
</div>
