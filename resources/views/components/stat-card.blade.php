@props(['label','value','icon'=>null,'delta'=>null,'tone'=>'primary'])
@php $tones=['primary'=>'bg-primary-50 text-primary-700','green'=>'bg-emerald-50 text-emerald-700','amber'=>'bg-amber-50 text-amber-700','red'=>'bg-red-50 text-red-700','slate'=>'bg-slate-100 text-slate-600']; @endphp
<div class="stat"><div class="stat-ic {{ $tones[$tone] ?? $tones['primary'] }} font-bold text-lg">@if($icon){{ $icon }}@else•@endif</div>
<div class="min-w-0"><div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold truncate">{{ $label }}</div><div class="text-2xl font-extrabold text-slate-900">{{ $value }}</div>
@if($delta)<div class="text-xs text-emerald-600 font-medium">{{ $delta }}</div>@endif</div></div>
