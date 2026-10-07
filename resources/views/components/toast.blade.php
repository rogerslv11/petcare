<div x-data="{open:false,msg:''}" @notify.window="msg=$event.detail.message;open=true;setTimeout(()=>open=false,3500)"
 class="fixed bottom-6 right-6 z-50" x-show="open" x-transition>
 <div class="bg-slate-900 text-white px-4 py-3 rounded-xl shadow-pop flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-emerald-400"></span><span x-text="msg" class="text-sm"></span></div></div>
