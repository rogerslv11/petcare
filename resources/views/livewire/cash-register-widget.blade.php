<div class="card-pad">
@if($register)
 <div class="flex flex-wrap items-center gap-2">
  <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
  <span class="font-bold text-slate-900">Caixa aberto</span>
  <span class="text-xs text-slate-400">desde {{ optional($register->opened_at)->format('d/m H:i') }}</span>
  <div class="flex-1"></div>
  <button wire:click="close" class="btn-ghost btn-sm">Fechar caixa</button>
 </div>
 @php($ins = $register->movements()->where('type','in')->sum('amount'))
 @php($outs = $register->movements()->where('type','out')->sum('amount'))
 <div class="grid grid-cols-3 gap-3 mt-4">
  <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-center"><div class="text-[11px] font-semibold text-emerald-600 uppercase">Entradas</div><div class="font-extrabold text-emerald-700">R$ {{ number_format($ins,2,',','.') }}</div></div>
  <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-center"><div class="text-[11px] font-semibold text-red-600 uppercase">Saídas</div><div class="font-extrabold text-red-700">R$ {{ number_format($outs,2,',','.') }}</div></div>
  <div class="bg-primary-50 border border-primary-100 rounded-xl p-3 text-center"><div class="text-[11px] font-semibold text-primary-600 uppercase">Saldo</div><div class="font-extrabold text-primary-800">R$ {{ number_format($ins-$outs,2,',','.') }}</div></div>
 </div>
 <div class="grid md:grid-cols-4 gap-2 mt-4">
  <select wire:model="kind" class="input"><option value="in">Entrada</option><option value="out">Saída</option></select>
  <input type="number" wire:model="amount" class="input" placeholder="Valor (R$)"/>
  <input wire:model="desc" class="input md:col-span-2" placeholder="Descrição do lançamento…"/>
 </div>
 <button wire:click="move" class="btn-primary btn-sm mt-2">Lançar movimentação</button>
 <div class="divider"></div>
 <div class="section-title text-sm">Últimas movimentações</div>
 <div class="mt-2 space-y-1.5">
 @forelse($register->movements()->latest()->limit(8)->get() as $m)
  <div class="text-sm flex justify-between items-center bg-slate-50 border border-slate-100 rounded-lg px-3 py-2"><span class="text-slate-600 truncate">{{ $m->description ?? '—' }} <span class="text-[11px] text-slate-400">{{ optional($m->created_at)->format('H:i') }}</span></span><span class="font-bold whitespace-nowrap {{ $m->type==='in'?'text-emerald-600':'text-red-600' }}">{{ $m->type==='in'?'+':'−' }} R$ {{ number_format($m->amount,2,',','.') }}</span></div>
 @empty
  <div class="text-xs text-slate-400">Sem movimentações neste turno.</div>
 @endforelse
 </div>
@else
 <div class="text-center py-8">
  <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 grid place-items-center text-slate-400 font-extrabold text-xl">R$</div>
  <div class="font-bold text-slate-900 mt-3">Caixa fechado</div>
  <div class="text-sm text-slate-400">Abra o caixa para iniciar as vendas do dia.</div>
  <button wire:click="open" class="btn-primary mt-4">Abrir caixa de hoje</button>
 </div>
@endif
</div>
