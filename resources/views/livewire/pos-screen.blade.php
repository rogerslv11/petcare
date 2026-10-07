<div class="grid lg:grid-cols-3 gap-4">
 <div class="lg:col-span-2 space-y-4">
  <div class="card-pad">
   <div class="flex gap-2"><input wire:model.live.debounce.300ms="q" placeholder="Buscar produto por nome ou código…" class="input"/><div class="hidden md:block text-xs text-slate-400 self-center whitespace-nowrap">Toque para adicionar</div></div>
   <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-3">
   @forelse($products as $p)
    <button wire:click="addProduct({{ $p->id }})" class="bg-white border border-slate-200 rounded-xl p-3 text-left hover:border-primary-400 hover:shadow-card transition">
     <div class="font-bold text-sm text-slate-900 truncate">{{ $p->name }}</div>
     <div class="text-primary-700 text-sm font-extrabold mt-0.5">R$ {{ number_format($p->price,2,',','.') }}</div>
     <div class="text-[11px] mt-0.5 {{ $p->stock <= $p->min_stock ? 'text-red-500 font-semibold' : 'text-slate-400' }}">estoque: {{ $p->stock }}</div>
    </button>
   @empty
    <div class="col-span-full text-sm text-slate-400 text-center py-4">Nenhum produto encontrado.</div>
   @endforelse
   </div>
   <div class="section-hint mt-4 mb-1">Serviços</div>
   <div class="flex flex-wrap gap-2">@foreach($services as $s)<button wire:click="addService({{ $s->id }})" class="btn-ghost btn-sm">{{ $s->name }} · R$ {{ number_format($s->price,0,',','.') }}</button>@endforeach</div>
  </div>
 </div>
 <div class="card-pad h-fit lg:sticky lg:top-20">
  <div class="flex items-center"><div class="section-title">Venda atual</div><span class="ml-2 text-[11px] font-bold text-slate-400 bg-slate-100 rounded-full px-2 py-0.5">{{ count($cart) }} itens</span></div>
  <select wire:model="customer_id" class="input mt-3"><option value="">Consumidor final</option>@foreach($customers as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
  <div class="mt-3 space-y-1.5 max-h-56 overflow-y-auto">
  @forelse($cart as $i=>$it)
   <div class="flex justify-between items-center text-sm bg-slate-50 border border-slate-100 rounded-lg px-3 py-2"><span class="text-slate-700"><b>{{ $it['qty'] }}×</b> {{ $it['name'] }}</span><span class="whitespace-nowrap font-semibold">R$ {{ number_format($it['qty']*$it['unit_price'],2,',','.') }} <button wire:click="remove({{ $i }})" class="text-red-400 hover:text-red-600 ml-1 font-bold">×</button></span></div>
  @empty
   <div class="text-sm text-slate-400 text-center py-4 border border-dashed border-slate-200 rounded-xl">Carrinho vazio — toque nos produtos.</div>
  @endforelse
  </div>
  <div class="grid grid-cols-2 gap-2 mt-3">
   <input wire:model="coupon" placeholder="Cupom" class="input"/>
   <input type="number" wire:model="discount" placeholder="Desconto R$" class="input"/>
  </div>
  <select wire:model="method" class="input mt-2"><option value="pix">PIX</option><option value="cash">Dinheiro</option><option value="credit_card">Cartão de crédito</option><option value="debit_card">Cartão de débito</option></select>
  <div class="flex justify-between items-end mt-3"><span class="section-hint">Total</span><span class="text-3xl font-extrabold text-slate-900">R$ {{ number_format($this->total,2,',','.') }}</span></div>
  <button wire:click="finish" class="btn-primary w-full justify-center mt-3 !py-3">Finalizar venda</button>
 </div>
</div>
