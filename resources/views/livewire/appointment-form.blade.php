<form wire:submit="save" class="card-pad max-w-4xl">
 <div class="section-title text-lg">Novo agendamento</div><div class="section-hint">Siga as etapas: cliente → pet → serviço → profissional → data → confirmar</div>
 <div class="grid md:grid-cols-2 gap-4 mt-5">
  <div><label class="label">1 · Cliente</label><select wire:model.live="customer_id" class="input"><option value="">Selecione o tutor…</option>@foreach($customers as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
  <div><label class="label">2 · Pet</label><select wire:model="pet_id" class="input"><option value="">Selecione o pet…</option>@foreach($pets as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
  <div><label class="label">3 · Serviço</label><select wire:model="service_id" class="input"><option value="">Selecione o serviço…</option>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->name }} · R$ {{ number_format($s->price,2,',','.') }}</option>@endforeach</select></div>
  <div><label class="label">4 · Profissional</label><select wire:model.live="professional_id" class="input"><option value="">A definir…</option>@foreach($pros as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
  <div><label class="label">5 · Data e hora</label><input type="datetime-local" wire:model.live="scheduled_at" class="input"/></div>
  <div><label class="label">Tipo</label><select wire:model="type" class="input"><option value="bath">Banho</option><option value="grooming">Tosa</option><option value="vet">Veterinário</option><option value="daycare">Creche</option><option value="boarding">Hospedagem</option></select></div>
 </div>
 @if(count($freeSlots ?? []))<div class="mt-4"><div class="label">Horários livres do profissional</div><div class="flex flex-wrap gap-2">@foreach($freeSlots as $s)<span class="badge-green">{{ $s }}</span>@endforeach</div></div>@endif
 <div class="mt-4"><label class="label">6 · Observações</label><textarea wire:model="notes" class="input" rows="2" placeholder="Alergias, comportamento, preferências de tosa…"></textarea></div>
 <div class="flex gap-2 mt-5"><a href="{{ route('appointments.index') }}" class="btn-ghost">Cancelar</a><button class="btn-primary">Confirmar agendamento</button></div>
</form>
