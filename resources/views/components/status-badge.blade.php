@props(['value'])
@php
$map = [
  'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'ready' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'checked_in' => 'bg-sky-50 text-sky-700 border-sky-200',
  'confirmed' => 'bg-sky-50 text-sky-700 border-sky-200',
  'in_service' => 'bg-violet-50 text-violet-700 border-violet-200',
  'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
  'scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
  'reserved' => 'bg-amber-50 text-amber-700 border-amber-200',
  'waiting' => 'bg-amber-50 text-amber-700 border-amber-200',
  'cancelled' => 'bg-red-50 text-red-700 border-red-200',
  'no_show' => 'bg-red-50 text-red-700 border-red-200',
  'overdue' => 'bg-red-50 text-red-700 border-red-200',
  'expired' => 'bg-red-50 text-red-700 border-red-200',
  'open' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
  'new_lead' => 'bg-primary-50 text-primary-700 border-primary-200',
  'contacted' => 'bg-sky-50 text-sky-700 border-sky-200',
  'scheduled_visit' => 'bg-violet-50 text-violet-700 border-violet-200',
  'converted' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'lost' => 'bg-red-50 text-red-700 border-red-200',
];
$labels = [
  'active'=>'Ativo','inactive'=>'Inativo','paid'=>'Pago','pending'=>'Pendente','completed'=>'Concluído',
  'ready'=>'Pronto','confirmed'=>'Confirmado','checked_in'=>'Check-in','in_service'=>'Em atendimento',
  'scheduled'=>'Agendado','cancelled'=>'Cancelado','no_show'=>'Faltou','open'=>'Aberto','closed'=>'Fechado',
  'new_lead'=>'Novo','contacted'=>'Contatado','scheduled_visit'=>'Visita agendada','converted'=>'Convertido','lost'=>'Perdido',
  'income'=>'Receita','expense'=>'Despesa','in'=>'Entrada','out'=>'Saída','bath'=>'Banho','grooming'=>'Tosa',
  'vet'=>'Veterinário','daycare'=>'Creche','boarding'=>'Hospedagem',
];
$key = strtolower((string) $value);
$cls = $map[$key] ?? 'badge-slate';
$label = $labels[$key] ?? str_replace('_',' ',ucfirst((string) $value));
@endphp
<span class="badge {{ $cls }}">{{ $label }}</span>
