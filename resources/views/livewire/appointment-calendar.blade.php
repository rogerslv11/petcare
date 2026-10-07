<div class="space-y-4">
 <div class="toolbar">
  <input type="date" wire:model.live="date" class="input md:!w-44"/>
  <div class="flex gap-1 bg-slate-100 rounded-xl p-1">@foreach(['day'=>'Dia','week'=>'Semana'] as $k=>$v)<button wire:click="$set('view','{{ $k }}')" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $view===$k?'bg-white text-slate-900 shadow-sm':'text-slate-500 hover:text-slate-700' }}">{{ $v }}</button>@endforeach</div>
  <select wire:model.live="pro" class="input md:!w-56"><option value="">Todos os profissionais</option>@foreach($pros as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select>
  <div class="flex-1"></div><a href="{{ route('appointments.create') }}" class="btn-primary btn-sm">Novo agendamento</a>
 </div>
 <div class="table-wrap"><div class="overflow-x-auto"><table class="w-full">
  <thead><tr><th class="th">Horário</th><th class="th">Pet / Tutor</th><th class="th">Serviço</th><th class="th">Profissional</th><th class="th">Status</th></tr></thead>
  <tbody>
  @forelse($rows as $a)
   <tr class="row-hover">
    <td class="td font-mono text-xs font-bold text-slate-700 whitespace-nowrap">{{ optional($a->scheduled_at)->format('d/m H:i') ?? '—' }}</td>
    <td class="td"><div class="flex items-center gap-2.5"><span class="avatar-sm">{{ strtoupper(substr($a->pet->name ?? '?',0,1)) }}</span><span><b class="text-slate-900">{{ $a->pet->name??'' }}</b><div class="text-xs text-slate-400">{{ $a->customer->name??'' }}</div></span></div></td>
    <td class="td text-slate-600">{{ $a->service->name??$a->type }}</td>
    <td class="td text-slate-500">{{ $a->professional->name??'—' }}</td>
    <td class="td"><x-status-badge :value="$a->status instanceof \App\Enums\AppointmentStatus ? $a->status->value : $a->status"/></td>
   </tr>
  @empty
   <tr><td colspan="5" class="td"><x-empty-state title="Agenda livre" hint="Nenhum agendamento para este período."/></td></tr>
  @endforelse
  </tbody>
 </table></div></div>
</div>
