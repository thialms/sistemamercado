@extends('master')

@section('content')

@vite('resources/css/app.css')

{{-- Testar essa funcionalidade, acredito q esteja funcionadno, porem preciso testar com mobile --}}

<div class="flex flex-col items-center min-h-screen bg-[#181f2a] py-0 relative">

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-between px-4 pt-8">
        <a href="{{ route('addProdutoCarrinho') }}">
            <button class="bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-white font-jost text-center flex-1">Leitor de Código de Barras</h2>
        <div class="w-12"></div>
    </div>

    <div class="w-full max-w-xl bg-[#232b3b] rounded-3xl shadow-lg p-6 flex flex-col items-center gap-6">
        <div class="w-full flex flex-col items-center">
            <div id="interactive" class="rounded-2xl overflow-hidden border-4 border-blue-900 shadow-lg bg-black w-full max-w-md aspect-video"></div>
            <div class="mt-6 text-center">
                <span class="block text-lg text-cyan-400 font-semibold font-jost mb-1">Código detectado:</span>
                <span id="barcode-result" class="text-2xl text-white font-bold font-mono tracking-widest bg-blue-900 px-4 py-2 rounded-lg shadow"></span>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <span class="text-gray-400 text-sm">Aponte a câmera para o código de barras do produto</span>
        </div>
    </div>
</div>

<script src="https://unpkg.com/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#interactive'),
                    constraints: {
                        facingMode: "environment",
                        width: 640,
                        height: 480
                    }
                },
                decoder: {
                    readers: ["ean_reader", "code_128_reader"]
                }
            }, function (err) {
                if (err) {
                    console.error("Erro ao iniciar Quagga:", err);
                    return;
                }
                Quagga.start();
            });

            Quagga.onDetected(function (result) {
                let code = result.codeResult.code;
                document.getElementById('barcode-result').textContent = code;
                // logica do back para adicionar o produto ao carrinho
            });
        } else {
            alert("Acesso à câmera não suportado.");
        }
    });
</script>
@endsection