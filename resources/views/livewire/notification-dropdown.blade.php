<x-dropdown><x-slot name="trigger"><button class="btn-ghost !px-3 !rounded-full relative"><svg class="w-[18px] h-[18px] text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4-5.7V5a2 2 0 10-4 0v.3A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>@if($unread)<span class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 text-[11px] font-bold text-white rounded-full bg-red-500 grid place-items-center">{{ $unread }}</span>@endif</button></x-slot>
 <div class="p-1.5 max-h-80 overflow-auto min-w-[280px]">
  <div class="px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Notificações</div>
  @forelse($notes as $n)<div class="px-3 py-2.5 hover:bg-slate-50 rounded-xl text-sm"><div class="font-semibold text-slate-800">{{ $n->data['title']??'Notificação' }}</div><div class="text-slate-400 text-xs mt-0.5">{{ $n->data['body']??'' }}</div></div>
  @empty<div class="p-6 text-sm text-slate-400 text-center">Tudo em dia.<br><span class="text-xs">Nenhuma notificação nova.</span></div>@endforelse
  @if(count($notes))<button wire:click="readAll" class="w-full text-center text-xs font-semibold text-primary-600 hover:bg-primary-50 rounded-xl py-2 mt-1">Marcar todas como lidas</button>@endif
 </div></x-dropdown>
