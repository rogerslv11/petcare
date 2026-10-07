<div class="max-w-xl mx-auto space-y-4">
 <div class="card p-6 text-center bg-gradient-to-br from-primary-600/20 to-primary-400/10"><div class="text-4xl"></div><h2 class="font-extrabold text-xl mt-1">Olá, {{ explode(' ', $cust->name??auth()->user()->name)[0] }}!</h2>
 @if($next)<div class="text-sm text-slate-500 mt-1">Próximo: <b class="text-white">{{ $next->service->name??$next->type }}</b> em {{ $next->scheduled_at->format('d/m H:i') }}</div>@else<div class="text-sm text-slate-500">Nenhum agendamento futuro — que tal agendar um banho? 🛁</div>@endif
 <a href="{{ route('booking.show') }}" class="btn-primary mt-3">Agendar serviço</a></div>
 <div class="grid grid-cols-2 gap-3">@foreach($pets as $p)<div class="card p-4"><div class="text-3xl">🐶</div><div class="font-bold">{{ $p->name }}</div><div class="text-xs text-slate-500">{{ $p->breed->name??'SRD' }} · {{ $p->age }}</div></div>@endforeach</div></div>
