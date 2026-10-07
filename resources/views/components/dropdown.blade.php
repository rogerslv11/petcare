<div class="relative" x-data="{open:false}"><div @click="open=!open">{{ $trigger }}</div>
<div x-show="open" @click.away="open=false" x-transition class="absolute right-0 mt-2 w-60 bg-white border border-slate-200 rounded-xl shadow-pop p-1.5 z-50">{{ $slot }}</div></div>
