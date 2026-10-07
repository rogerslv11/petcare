<div class="grid lg:grid-cols-5 gap-4">
 <div class="card-pad lg:col-span-2">
  <div class="section-title">Pets prontos <span class="text-slate-400 font-normal">({{ count($ready) }})</span></div><div class="section-hint">Concluídos no kanban, aguardando pagamento</div>
  <div class="mt-3 space-y-2">
  @forelse($ready as $a)
   <button wire:click="select({{ $a->id }})" class="w-full text-left border rounded-xl p-3 transition flex items-center gap-3 {{ ($appt?->id)==$a->id ? 'border-primary-500 bg-primary-50' : 'border-slate-200 hover:border-primary-300 bg-white' }}">
    <span class="avatar">{{ strtoupper(substr($a->pet->name ?? '?',0,1)) }}</span>
    <span class="flex-1 min-w-0"><b class="text-slate-900">{{ $a->pet->name }}</b><div class="text-xs text-slate-400 truncate">{{ $a->customer->name }} · {{ $a->service->name ?? '' }}</div></span>
    <span class="text-sm text-primary-700 font-extrabold whitespace-nowrap">R$ {{ number_format($a->price,2,',','.') }}</span>
   </button>
  @empty
   <x-empty-state title="Nenhum pet pronto" hint="Conclua atendimentos no Kanban."/>
  @endforelse
  </div>
 </div>
 <div class="card-pad lg:col-span-3 h-fit lg:sticky lg:top-20">
  @if($appt)
   <div class="section-hint">Check-out</div>
   <h3 class="text-xl font-extrabold text-slate-900">{{ $appt->pet->name }} <span class="text-sm font-normal text-slate-400">· {{ $appt->service->name??'' }}</span></h3>
   <div class="text-sm text-slate-500 mt-0.5">Tutor: <b class="text-slate-700">{{ $appt->customer->name }}</b></div>
   <div class="text-4xl font-extrabold text-slate-900 mt-4">R$ {{ number_format($appt->price,2,',','.') }}</div>
   <div class="grid md:grid-cols-2 gap-3 mt-4">
    <div><label class="label">Forma de pagamento</label>
     <select wire:model="method" class="input"><option value="pix">PIX</option><option value="cash">Dinheiro</option><option value="credit_card">Cartão de crédito</option><option value="debit_card">Cartão de débito</option></select></div>
    <div><label class="label">Notificação</label><div class="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5">O tutor será avisado pelo WhatsApp automaticamente.</div></div>
   </div>
   <button wire:click="finish" class="btn-primary w-full justify-center mt-4 !py-3">Finalizar e notificar tutor</button>
  @else
   <x-empty-state title="Selecione um pet" hint="Escolha um pet pronto ao lado para receber o pagamento."/>
  @endif
 </div>
</div>
