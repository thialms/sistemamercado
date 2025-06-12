{{-- filepath: c:\Users\thiia\Downloads\mercado\mercado\resources\views\home.blade.php --}}
@extends('master')

@section('content')

@vite('resources/css/app.css')

{{-- Saudação dinâmica --}}
@php
    $hora = intval(now()->format('H'));
    if ($hora >= 4 && $hora < 12) {
        $saudacao = 'Bom dia';
    } elseif ($hora >= 12 && $hora < 18) {
        $saudacao = 'Boa tarde';
    } else {
        $saudacao = 'Boa noite';
    }
@endphp

<div id="appTheme" class="min-h-screen dark:bg-[#030e1a] flex transition-colors duration-300">

    {{-- Adicionar os dashboards para os dados que aparecem --}}

    <aside id="sidebar" class="fixed md:static top-0 left-0 min-h-screen w-90
     bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between py-8 px-6 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <button id="sidebarClose" class="cursor-pointer absolute top-4 right-4 bg-blue-800 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg focus:outline-none md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div>
            <div class="mb-10 text-center mt-4">
                <span class="text-2xl font-bold tracking-tight text-black dark:text-white font-jost block leading-tight">Mercado do</span>
                <span class="text-3xl font-bold text-blue-800 dark:text-blue-400 font-jost block -mt-2">Fernando</span>
            </div>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('relatorio') }}" class="flex items-center gap-3 text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:dark:bg-gray-800 hover:text-blue-800 hover:dark:text-blue-400 rounded-lg px-4 py-2 transition-colors text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19V6M6 19v-4M16 19v-2M21 19V9" />
                            </svg>
                            Histórico de vendas
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:dark:bg-gray-800 hover:text-blue-800 hover:dark:text-blue-400 rounded-lg px-4 py-2 transition-colors text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2M5 9h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm7 4v2m0 0h-2m2 0h2" />
                            </svg>
                            Menu de fiados
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="flex flex-col gap-2 w-full">
            <div class="flex gap-2 mb-4">
                <a href="{{ route('vendas') }}" class="flex-1 flex items-center justify-center gap-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:dark:bg-gray-800 hover:text-blue-800 hover:dark:text-blue-400 rounded-lg px-4 py-2 transition-colors text-lg font-bold bg-blue-100 dark:bg-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 9V7a5 5 0 0110 0v2M5 17h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    Venda
                </a>
                <a href="{{ route('estoque') }}" class="flex-1 flex items-center justify-center gap-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:dark:bg-gray-800 hover:text-blue-800 hover:dark:text-blue-400 rounded-lg px-4 py-2 transition-colors text-lg font-bold bg-blue-100 dark:bg-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4a2 2 0 001-1.73z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.27 6.96L12 12.01l8.73-5.05" />
                    </svg>
                    Estoque
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="cursor-pointer bg-red-900 hover:bg-red-600 text-white font-bold rounded-full px-4 py-2 w-full transition-colors">
                    Finalizar Sessão
                </button>
            </form>
            <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white font-bold rounded-full px-4 py-2 w-full transition-colors mt-2">
                Precisa de Ajuda?
            </button>
        </div>
    </aside>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/30 z-30 hidden md:hidden pointer-events-none transition-opacity duration-300"></div>

    <main class="flex-1 p-4 sm:p-8 space-y-8 overflow-y-auto transition-colors duration-300">
        <div class="flex mb-6 items-center justify-between relative">
            <div class="flex items-center gap-3">
                <button id="sidebarToggle" class="cursor-pointer md:hidden bg-blue-800 text-white rounded-full w-15 h-10 flex items-center justify-center shadow-lg focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="ml-2 text-xl font-bold">
                    <span class="text-blue-400 dark:text-blue-300">{{ $saudacao }},</span>
                    <span class="text-blue-900 dark:text-blue-200"> Fernando</span>
                </span>
            </div>
            <h1 class="text-2xl font-bold text-blue-900 dark:text-blue-200 text-right w-full md:w-auto">Dashboard</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow flex flex-col">
                <span class="text-gray-900 dark:text-gray-300 text-sm">Ganhos do dia</span>
                <span class="text-2xl font-bold text-blue-900 dark:text-blue-200">R$ 354,99 <span class="text-green-500 text-sm">+15%</span></span>
            </div>
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow flex flex-col">
                <span class="text-gray-900 dark:text-gray-300 text-sm">Ganhos do Mês</span>
                <span class="text-2xl font-bold text-blue-900 dark:text-blue-200">R$ 3874,85 <span class="text-green-500 text-sm">+8%</span></span>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow flex flex-col">
                <span class="text-gray-900 dark:text-gray-300 text-sm mb-2">Gráfico Ganhos do Dia</span>
                <canvas id="grafico-dia" height="120"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow flex flex-col">
                <span class="text-gray-900 dark:text-gray-300 text-sm mb-2">Gráfico Ganhos do Mês</span>
                <canvas id="grafico-mes" height="120"></canvas>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        sidebarOverlay.classList.remove('pointer-events-none');
        sidebarOverlay.style.opacity = '1';
        sidebarToggle.classList.add('hidden');
    }
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        sidebarOverlay.classList.add('pointer-events-none');
        sidebarOverlay.style.opacity = '0';
        sidebarToggle.classList.remove('hidden');
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
    sidebarClose.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if(window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            sidebarToggle.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebarToggle.classList.remove('hidden');
        }
    });

    // Gráfico de ganhos do dia (exemplo: ganhos por hora)
    const ctxDia = document.getElementById('grafico-dia').getContext('2d');
    new Chart(ctxDia, {
        type: 'line',
        data: {
            labels: ['08h', '10h', '12h', '14h', '16h', '18h', '20h'],
            datasets: [{
                label: 'Ganhos (R$)',
                data: [30, 50, 80, 60, 90, 110, 70],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Gráfico de ganhos do mês (exemplo: ganhos por dia)
    const ctxMes = document.getElementById('grafico-mes').getContext('2d');
    new Chart(ctxMes, {
        type: 'bar',
        data: {
            labels: ['1', '5', '10', '15', '20', '25', '30'],
            datasets: [{
                label: 'Ganhos (R$)',
                data: [200, 350, 400, 300, 500, 600, 524],
                backgroundColor: '#2563eb'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection