@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen m-0 bg-white py-0">

    <div class="flex items-center w-full mb-4 justify-between px-4 absolute top-4 left-0 right-0">
        <a href="{{ route('home') }}">
            <button class="bg-blue-800 text-white rounded-full w-10 h-10 flex items-center justify-center text-2xl shadow-md cursor-pointer">
            <span><</span>
            </button>
        </a>
        <button class="bg-blue-800 text-white rounded-full w-10 h-10 flex items-center justify-center text-2xl shadow-md">
            <span>+</span>
        </button>
    </div>

    {{-- Card do produto selecionado --}}
    <div class="w-80 bg-white rounded-2xl shadow-md p-4 mb-4">
        <div class="text-center font-jost">
            <div>Refrigerante Coca Cola 2L</div>
            <div>4358945808645</div>
            <div>Preço Unitário: 15,75</div>
        </div>
    </div>

    {{-- Tabela de itens --}}
    <div class="w-120 bg-white rounded-xl overflow-hidden border border-black mb-4">
        <table class="w-full text-left font-jost">
            <thead>
                <tr class="border-b border-black">
                    <th class="py-2 px-2 w-16 font-bold text-lg">Item</th>
                    <th class="py-2 px-2 font-bold text-lg">Descrição do Produto</th>
                </tr>
            </thead>
            <tbody>
                {{-- Exemplo de itens, substitua pelo loop do seu backend --}}
                <tr class="border-b border-black">
                    <td class="py-2 px-2 align-top font-bold text-lg">001</td>
                    <td class="py-2 px-2">
                        <div>Achoc Toddy 200g</div>
                        <div>1723787444321</div>
                        <div>1 x 8,99 = 8,99</div>
                    </td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-2 px-2 align-top font-bold text-lg">002</td>
                    <td class="py-2 px-2">
                        <div>Leite Italac 1L Integral</div>
                        <div>8563789874025</div>
                        <div>3x 5,99 = 17,97</div>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 px-2 align-top font-bold text-lg">003</td>
                    <td class="py-2 px-2">
                        <div>Refrigerante Coca Cola 2L</div>
                        <div>4358945808645</div>
                        <div>1x 15,75 = 15,75</div>
                    </td>
                </tr>
                {{-- Linhas vazias para completar a tabela visualmente --}}
                <tr>
                    <td class="py-6 px-2"></td>
                    <td class="py-6 px-2"></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Total --}}
    <div class="w-full flex items-center justify-between bg-blue-800 px-6 py-4 mt-auto
    rounded-t-3xl">
        <span class="text-white text-2xl font-bold font-jost">TOTAL</span>
        <span class="bg-white rounded-3xl w-60 px-6 py-2 text-blue-800 text-3xl font-bold font-jost flex justify-end">42,71</span>
    </div>
</div>
@endsection