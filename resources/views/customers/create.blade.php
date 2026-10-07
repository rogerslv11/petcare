<x-layouts.app title="Novo cliente">
<div class="card-pad max-w-3xl">
  <div class="section-title text-lg">Novo cliente</div><div class="section-hint">Cadastre o tutor — os pets são vinculados em seguida.</div>
  <form method="POST" action="{{ route('customers.index') }}" class="grid md:grid-cols-2 gap-4 mt-5" onsubmit="return false;">
    @csrf
    <div class="md:col-span-2"><label class="label">Nome completo *</label><input name="name" required class="input" placeholder="Ex: Maria Silva"/></div>
    <div><label class="label">Celular / WhatsApp *</label><input name="phone" required class="input" placeholder="(11) 99999-9999"/></div>
    <div><label class="label">E-mail</label><input type="email" name="email" class="input" placeholder="maria@email.com"/></div>
    <div><label class="label">CPF</label><input name="document" class="input" placeholder="000.000.000-00"/></div>
    <div><label class="label">Data de nascimento</label><input type="date" name="birth_date" class="input"/></div>
    <div><label class="label">Endereço</label><input name="address" class="input" placeholder="Rua, número, bairro"/></div>
    <div class="grid grid-cols-3 gap-3">
      <div><label class="label">Cidade</label><input name="city" class="input"/></div>
      <div><label class="label">UF</label><input name="state" class="input" maxlength="2"/></div>
      <div><label class="label">CEP</label><input name="zip" class="input"/></div>
    </div>
    <div class="md:col-span-2"><label class="label">Observações</label><textarea name="notes" class="input" rows="2" placeholder="Preferências, restrições, como conheceu a loja…"></textarea></div>
    <div class="md:col-span-2 flex gap-2"><a href="{{ route('customers.index') }}" class="btn-ghost">Cancelar</a><button class="btn-primary">Salvar cliente</button></div>
  </form>
</div>
</x-layouts.app>
