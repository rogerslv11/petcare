<x-layouts.app title="Configurações">
@php($biz = \App\Models\Business::first())
@php($users = \App\Models\User::orderBy('name')->get())
<div class="grid lg:grid-cols-3 gap-4">
  <div class="card-pad">
    <div class="section-title">Dados da loja</div><div class="section-hint">Exibidos no agendamento público e recibos</div>
    <div class="mt-4 space-y-3">
      <div><label class="label">Nome da loja</label><input class="input" value="{{ $biz->name ?? config('app.name') }}"/></div>
      <div class="grid grid-cols-2 gap-3">
        <div><label class="label">E-mail</label><input class="input" value="{{ $biz->email ?? '' }}"/></div>
        <div><label class="label">Telefone / WhatsApp</label><input class="input" value="{{ $biz->phone ?? '' }}"/></div>
      </div>
      <div><label class="label">Documento (CNPJ)</label><input class="input" value="{{ $biz->document ?? '' }}"/></div>
      <button class="btn-primary">Salvar dados</button>
    </div>
  </div>
  <div class="card-pad">
    <div class="section-title">Horários e operação</div><div class="section-hint">Base para cálculo de disponibilidade</div>
    <div class="mt-4 space-y-3">
      <div class="grid grid-cols-2 gap-3">
        <div><label class="label">Abertura</label><input type="time" class="input" value="08:00"/></div>
        <div><label class="label">Fechamento</label><input type="time" class="input" value="18:00"/></div>
      </div>
      <div><label class="label">Duração padrão do banho (min)</label><input type="number" class="input" value="60"/></div>
      <div><label class="label">Tolerância de atraso (min)</label><input type="number" class="input" value="15"/></div>
      <button class="btn-primary">Salvar operação</button>
    </div>
  </div>
  <div class="space-y-4">
    <div class="card-pad">
      <div class="section-title">Usuários</div><div class="section-hint">{{ $users->count() }} contas de acesso</div>
      <div class="mt-3 space-y-2">
        @foreach($users as $u)
        <div class="flex items-center gap-3"><span class="avatar-sm">{{ strtoupper(substr($u->name,0,1)) }}</span>
          <div class="flex-1 min-w-0"><div class="text-sm font-semibold text-slate-800 truncate">{{ $u->name }}</div><div class="text-xs text-slate-400">{{ $u->email }}</div></div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="card-pad">
      <div class="section-title">Agendamento público</div><div class="section-hint">Link para clientes agendarem sozinhos</div>
      <div class="flex gap-2 mt-3"><input readonly class="input font-mono !text-xs" value="{{ route('booking.show') }}"/><a href="{{ route('booking.show') }}" target="_blank" class="btn-ghost btn-sm shrink-0">Abrir</a></div>
    </div>
  </div>
</div>
</x-layouts.app>
