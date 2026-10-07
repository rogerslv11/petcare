<header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">
 <div class="flex items-center gap-3 px-4 md:px-8 py-3 max-w-[1280px] mx-auto">
  <button class="lg:hidden btn-ghost !px-3" @click="sidebar=true">☰</button>
  <div class="hidden md:block w-72"><livewire:global-search /></div>
  <div class="flex-1"></div>
  <livewire:notification-dropdown />
  <x-dropdown><x-slot name="trigger"><button class="flex items-center gap-2 btn-ghost !py-1.5"><span class="w-8 h-8 rounded-full bg-primary-600 text-white grid place-items-center text-sm font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</span><span class="hidden md:block text-sm font-medium">{{ auth()->user()->name ?? '' }}</span></button></x-slot>
    <div class="p-2 text-sm min-w-[180px]">
      <a class="block px-3 py-2 hover:bg-slate-100 rounded-lg" href="{{ route('profile.edit') }}">Meu perfil</a>
      <a class="block px-3 py-2 hover:bg-slate-100 rounded-lg" href="{{ route('settings.index') }}">Configurações</a>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full text-left px-3 py-2 hover:bg-slate-100 rounded-lg text-red-600">Sair</button></form>
    </div>
  </x-dropdown>
 </div>
 <div class="md:hidden px-4 pb-3"><livewire:global-search /></div>
</header>
