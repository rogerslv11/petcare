<x-layouts.app title="Novo pet">
<div class="card-pad max-w-2xl">
  <h1 class="page-title">Novo pet</h1>
  <p class="page-subtitle">Cadastre o pet vinculado a um cliente.</p>
  <form method="POST" action="{{ route('pets.index') }}" class="grid md:grid-cols-2 gap-4 mt-5" onsubmit="return false;">
    @csrf
    <div><label class="label">Nome *</label><input name="name" required class="input" placeholder="Ex: Rex"/></div>
    <div><label class="label">Cliente *</label><select name="customer_id" class="input">@foreach(\App\Models\Customer::limit(200)->get() as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
    <div><label class="label">Espécie</label><select name="species_id" class="input">@foreach(\App\Models\PetSpecies::all() as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
    <div><label class="label">Sexo</label><select name="sex" class="input"><option value="M">Macho</option><option value="F">Fêmea</option></select></div>
    <div><label class="label">Porte</label><select name="size" class="input"><option>Pequeno</option><option>Médio</option><option>Grande</option></select></div>
    <div><label class="label">Nascimento</label><input type="date" name="birth_date" class="input"/></div>
    <div class="md:col-span-2"><label class="label">Observações</label><textarea name="notes" class="input" rows="2"></textarea></div>
    <div class="md:col-span-2 flex gap-2"><a href="{{ route('pets.index') }}" class="btn-ghost">Voltar</a><span class="btn-primary opacity-60">Cadastro pelo atendimento (em breve salvamento direto)</span></div>
  </form>
  <p class="text-xs text-slate-400 mt-4">Dica: o fluxo principal é Cliente → Pets → Agendar. Use a agenda para vincular serviços.</p>
</div>
</x-layouts.app>
