<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Agendar horário · {{ config('app.name','PetCare') }}</title><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">@vite(['resources/css/app.css'])</head>
<body class="bg-slate-100 text-slate-800" style="font-family:Inter,system-ui"><div class="max-w-lg mx-auto p-6">
<div class="text-center"><div class="inline-grid place-items-center w-12 h-12 rounded-2xl bg-primary-600 text-white font-extrabold text-xl">P</div>
<h1 class="font-extrabold text-2xl mt-3 text-slate-900">Agende o horário do seu pet</h1>
<p class="text-sm text-slate-500">{{ config('app.name','PetCare') }} · escolha serviço, data e horário</p></div>
<div class="card p-5 mt-6 space-y-3">
<label class="label">Serviço</label>
<select class="input"><option>Banho — R$ 60</option><option>Tosa Completa — R$ 110</option><option>Creche (diária) — R$ 70</option><option>Hospedagem (diária) — R$ 90</option></select>
<label class="label">Data</label>
<input type="date" class="input"/>
<label class="label">Horários disponíveis</label>
<div class="flex flex-wrap gap-2"><span class="px-3 py-1.5 rounded-lg bg-primary-600 text-white text-sm font-bold">09:00</span><span class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-sm">10:30</span><span class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-sm">14:00</span></div>
<label class="label">Seu nome e WhatsApp</label>
<input class="input" placeholder="Nome"/><input class="input" placeholder="(00) 90000-0000"/>
<button class="btn-primary w-full !py-3">Confirmar agendamento</button>
<p class="text-xs text-slate-400 text-center">A recepção confirma pelo WhatsApp.</p>
</div></div></body></html>
