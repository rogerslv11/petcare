<div class="table-wrap">
 <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row md:items-center gap-2">
  <div><div class="section-title">Comissões</div><div class="section-hint">Calculadas sobre serviços concluídos</div></div>
  <div class="flex-1"></div>
  <span class="badge-amber">Pendente: R$ {{ number_format($rows->where('status','pending')->sum('amount'),2,',','.') }}</span>
 </div>
 <div class="overflow-x-auto"><table class="w-full">
  <thead><tr><th class="th">Profissional</th><th class="th">Referência</th><th class="th">Base</th><th class="th">Comissão</th><th class="th">Status</th><th class="th"></th></tr></thead>
  <tbody>
  @forelse($rows as $c)
   <tr class="row-hover">
    <td class="td"><div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($c->professional->name ?? '?',0,1)) }}</span><b class="text-slate-900">{{ $c->professional->name ?? '—' }}</b></div></td>
    <td class="td text-slate-400 text-xs font-mono">atend. #{{ $c->appointment_id ?? '—' }}</td>
    <td class="td text-slate-500">{{ $c->pct }}%</td>
    <td class="td font-extrabold text-slate-900">R$ {{ number_format($c->amount,2,',','.') }}</td>
    <td class="td"><x-status-badge :value="$c->status"/></td>
    <td class="td text-right">@if($c->status==='pending')<button wire:click="pay({{ $c->id }})" class="btn-primary btn-sm">Pagar</button>@endif</td>
   </tr>
  @empty
   <tr><td colspan="6" class="td"><x-empty-state title="Sem comissões" hint="Comissões são geradas ao concluir atendimentos."/></td></tr>
  @endforelse
  </tbody>
 </table></div>
 <div class="p-4">{{ $rows->links() }}</div>
</div>
