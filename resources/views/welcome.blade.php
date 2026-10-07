<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>PetCare · Gestão para petshop</title><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">@vite(['resources/css/app.css'])</head>
<body class="bg-slate-100 text-slate-800" style="font-family:Inter,system-ui">
<div class="min-h-screen flex flex-col">
 <header class="bg-white border-b border-slate-200"><div class="max-w-6xl mx-auto px-6 py-4 flex items-center gap-3">
   <div class="w-10 h-10 rounded-xl bg-primary-600 grid place-items-center text-white font-extrabold">P</div>
   <div><div class="font-extrabold text-slate-900">PetCare</div><div class="text-xs text-slate-500">Gestão para petshop · banho · creche · hotel</div></div>
   <div class="flex-1"></div>
   <a href="/login" class="btn-ghost">Entrar</a>
   <a href="/register" class="btn-primary">Criar conta</a>
 </div></header>
 <main class="flex-1 max-w-6xl mx-auto px-6 py-14 w-full">
  <div class="grid lg:grid-cols-2 gap-10 items-center">
   <div>
    <span class="badge-blue">Sistema interno da loja</span>
    <h1 class="text-4xl md:text-5xl font-extrabold mt-4 tracking-tight text-slate-900">A operação do seu petshop em um só lugar.</h1>
    <p class="text-slate-500 mt-4 max-w-lg">Agenda, check-in e check-out, banho & tosa, creche e hospedagem, clientes e pets, equipe e comissões, produtos e estoque, PDV, caixa e financeiro.</p>
    <div class="flex gap-3 mt-8 flex-wrap">
      <a href="/login" class="btn-primary !px-6 !py-3">Acessar o sistema</a>
      <a href="{{ route('booking.show') }}" class="btn-ghost !px-6 !py-3">Página de agendamento</a>
    </div>
    <div class="flex gap-6 mt-8 text-sm text-slate-500">
      <div><b class="block text-slate-900 text-lg">1</b>loja · sem mensalidade SaaS</div>
      <div><b class="block text-slate-900 text-lg">14</b>módulos operacionais</div>
      <div><b class="block text-slate-900 text-lg">PT-BR</b>pronto para recepção</div>
    </div>
   </div>
   <div class="grid grid-cols-2 gap-3">
    @foreach([['Agenda e quadro','Check-in/out, faltas e atrasos'],['Banho & tosa','Ficha, comportamento e produtos'],['Creche e hotel','Diárias, alimentação e medicação'],['PDV e financeiro','Pacotes, fidelidade, caixa']] as [$t,$d])
     <div class="card p-5"><div class="font-bold text-slate-900 text-sm">{{ $t }}</div><div class="text-sm text-slate-500 mt-1">{{ $d }}</div></div>
    @endforeach
    <div class="col-span-2 card p-5 flex items-center justify-between"><div class="text-sm"><b>Demonstração</b><div class="text-slate-500">Entre com 1 clique para explorar.</div></div><a href="{{ route('login.demo') }}" class="btn-primary">Testar demo</a></div>
   </div>
  </div>
 </main>
 <footer class="text-center text-xs text-slate-400 pb-8">PetCare · sistema de gestão para petshop</footer>
</div></body></html>
