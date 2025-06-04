@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-[#181f2a] py-0 relative">

    {{-- Mudar o visual, nao curti o amarelo no botao de search --}}

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-between px-4 pt-8">
        <a href="{{ route('vendas') }}">
            <button class="bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-white font-jost text-center flex-1">Adicionar Produto</h2>
        <div class="w-12"></div>
    </div>

    <div class="w-full max-w-xl bg-[#232b3b] rounded-3xl shadow-lg p-6 flex flex-col gap-6">
        <form action="" method="GET" class="w-full flex items-center">
            <div class="flex flex-1">
            <input
                type="text"
                name="query"
                placeholder="Pesquisar produtos..."
                class="flex-1 px-4 py-2 rounded-l-full bg-[#181f2a] text-white focus:outline-none"
                required
            >
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-full font-semibold transition flex items-center justify-center -ml-px">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
            </div>
            <a href="{{ route('scan') }}" class="ml-4">
                <button
                    type="button"
                    class="bg-blue-600 hover:bg-blue-800 text-[#181f2a] font-bold py-2 px-4 rounded-full transition flex items-center justify-center"
                    title="Escanear Código de Barras">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="7" width="2" height="10" rx="1" fill="currentColor"/>
                        <rect x="7" y="7" width="2" height="10" rx="1" fill="currentColor"/>
                        <rect x="11" y="7" width="2" height="10" rx="1" fill="currentColor"/>
                        <rect x="15" y="7" width="2" height="10" rx="1" fill="currentColor"/>
                        <rect x="19" y="7" width="2" height="10" rx="1" fill="currentColor"/>
                    </svg>
                </button>
            </a>
        </form>

        <!-- Resultados da Pesquisa -->
        <!-- Deve vir do banco de dados -->

        <div class="mt-4">
            <div class="text-[#00bfff] font-semibold mb-2">Resultados:</div>
            <ul>
                <li class="flex justify-between py-2 border-b border-[#2e3448]">
                    <span class="text-white">Achoc Toddy 200g</span>
                    <div class="flex items-center gap-2">
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold focus:outline-none decrement-btn">-</button>
                        <span class="text-white font-semibold px-2 quantity">1</span>
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold focus:outline-none increment-btn">+</button>
                        <button class="ml-2 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-full text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Adicionar
                        </button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const decrementBtn = document.querySelector('.decrement-btn');
                            const incrementBtn = document.querySelector('.increment-btn');
                            const quantitySpan = document.querySelector('.quantity');
                            let quantity = 1;

                            decrementBtn.addEventListener('click', function () {
                                if (quantity > 1) {
                                    quantity--;
                                    quantitySpan.textContent = quantity;
                                }
                            });

                            incrementBtn.addEventListener('click', function () {
                                quantity++;
                                quantitySpan.textContent = quantity;
                            });
                        });
                    </script>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection