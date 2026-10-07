<div class="space-y-4">
 <div class="grid md:grid-cols-3 gap-4">
  <div class="stat"><div class="stat-ic bg-emerald-50 text-emerald-700 font-bold">+</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Receitas · mês</div><div class="text-2xl font-extrabold text-emerald-700">R$ {{ number_format($rev,2,',','.') }}</div></div></div>
  <div class="stat"><div class="stat-ic bg-red-50 text-red-700 font-bold">−</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Despesas · mês</div><div class="text-2xl font-extrabold text-red-600">R$ {{ number_format($exp,2,',','.') }}</div></div></div>
  <div class="stat"><div class="stat-ic {{ ($rev-$exp)>=0?'bg-primary-50 text-primary-700':'bg-red-50 text-red-700' }} font-bold">=</div><div><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Resultado</div><div class="text-2xl font-extrabold {{ ($rev-$exp)>=0?'text-slate-900':'text-red-600' }}">R$ {{ number_format($rev-$exp,2,',','.') }}</div></div></div>
 </div>
 <div class="table-wrap">
  <div class="p-4 border-b border-slate-100"><div class="section-title">Últimas movimentações</div><div class="section-hint">Receitas e despesas do período</div></div>
  <div class="overflow-x-auto"><table class="w-full"><tbody>
  @forelse($rows as $r)
   <tr class="row-hover">
    <td class="td"><div class="flex items-center gap-3"><span class="w-9 h-9 rounded-xl grid place-items-center text-sm font-bold {{ $r->type==='income'?'bg-emerald-50 text-emerald-700':'bg-red-50 text-red-700' }}">{{ $r->type==='income'?'+':'−' }}</span><span><b class="text-slate-800">{{ $r->description }}</b><div class="text-xs text-slate-400">{{ $r->category }} · {{ optional($r->date)->format('d/m/Y') ?? '—' }}</div></span></div></td>
    <td class="td text-right font-extrabold whitespace-nowrap {{ $r->type==='income'?'text-emerald-600':'text-red-500' }}">{{ $r->type==='income'?'+':'−' }} R$ {{ number_format($r->amount,2,',','.') }}</td>
   </tr>
  @empty
   <tr><td class="td"><x-empty-state title="Sem movimentações" hint="Lançamentos do caixa aparecem aqui."/></td></tr>
  @endforelse
  </tbody></table></div>
 </div>
</div>
