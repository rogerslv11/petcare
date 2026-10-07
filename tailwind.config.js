import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
export default {
  content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php','./storage/framework/views/*.php','./resources/views/**/*.blade.php','./app/Livewire/**/*.php'],
  theme: { extend: {
    fontFamily: { sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans] },
    colors: { primary: {50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#2563eb',600:'#1d4ed8',700:'#1e40af',800:'#1e3a8a',900:'#172554'}, accent:{400:'#2dd4bf',500:'#14b8a6',600:'#0d9488'} },
    boxShadow: { card: '0 1px 2px rgba(16,24,40,.06), 0 1px 3px rgba(16,24,40,.1)', pop: '0 12px 32px rgba(16,24,40,.14)' },
  }},
  plugins: [forms],
};
