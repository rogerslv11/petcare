@props(['title'=>'Nada por aqui','hint'=>'','icon'=>null])
<div class="card p-10 text-center"><div class="w-12 h-12 mx-auto rounded-xl bg-slate-100 grid place-items-center text-slate-400 text-xl mb-3">○</div><div class="font-bold text-lg text-slate-900">{{ $title }}</div><div class="text-sm text-slate-500 mt-1">{{ $hint }}</div><div class="mt-4">{{ $slot }}</div></div>
