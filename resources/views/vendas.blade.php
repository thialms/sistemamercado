@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-[#181f2a] py-0 relative">

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-between px-4 pt-8">
        <a href="{{ route('home') }}">
            <button class="bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-white font-jost">Nova Venda</h2>
        <a href="">
            {{-- Add pagina para ter a pesquisa e leitura de codigo de barras para add os produtos no carrinho --}}
            <button class="bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-3xl shadow-md transition">
                <span>+</span>
            </button>
        </a>
    </div>

    <div class="w-full max-w-xl bg-[#232b3b] rounded-3xl shadow-lg p-6 mb-6 flex flex-col gap-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-lg font-bold text-cyan-400 font-jost">Itens no Carrinho</span>
            <span class="text-sm text-gray-400 font-jost">#0001</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left font-jost">
                <thead>
                    <tr class="border-b border-blue-900">
                        <th class="py-2 px-2 w-16 font-bold text-cyan-400 text-base">Item</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base">Descrição</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Fazer implementacao para os dados virem do back --}}
                    <tr class="border-b border-blue-900 hover:bg-blue-950/30 transition">
                        <td class="py-2 px-2 align-top font-bold text-blue-300">001</td>
                        <td class="py-2 px-2">
                            <div class="font-semibold text-white">Achoc Toddy 200g</div>
                            <div class="text-xs text-gray-400">1723787444321</div>
                            <div class="text-xs text-gray-500">1 x 8,99</div>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400">8,99</td>
                    </tr>
                    <tr class="border-b border-blue-900 hover:bg-blue-950/30 transition">
                        <td class="py-2 px-2 align-top font-bold text-blue-300">002</td>
                        <td class="py-2 px-2">
                            <div class="font-semibold text-white">Leite Italac 1L Integral</div>
                            <div class="text-xs text-gray-400">8563789874025</div>
                            <div class="text-xs text-gray-500">3 x 5,99</div>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400">17,97</td>
                    </tr>
                    <tr class="hover:bg-blue-950/30 transition">
                        <td class="py-2 px-2 align-top font-bold text-blue-300">003</td>
                        <td class="py-2 px-2">
                            <div class="font-semibold text-white">Refrigerante Coca Cola 2L</div>
                            <div class="text-xs text-gray-400">4358945808645</div>
                            <div class="text-xs text-gray-500">1 x 15,75</div>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400">15,75</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full max-w-xl flex items-center justify-between bg-blue-800 px-8 py-6 rounded-3xl shadow-lg mb-8">
        <span class="text-white text-2xl font-bold font-jost">TOTAL</span>
        <span class="bg-[#232b3b] rounded-3xl w-60 px-6 py-2 text-white text-3xl font-bold font-jost flex justify-end shadow">{{ number_format(42.71, 2, ',', '.') }}</span>
    </div>

    <div class="w-full max-w-xl flex justify-end">
        <button class="bg-blue-900 hover:bg-blue-600 text-white font-bold px-8 py-3 rounded-full text-xl shadow transition">
            Finalizar Compra
        </button>
    </div>
</div>
@endsection