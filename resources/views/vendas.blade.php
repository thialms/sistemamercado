@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-[#181f2a] py-0 relative">

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-center px-4 pt-8 relative">
        <a href="{{ route('home') }}" class="absolute left-4">
            <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-white font-jost text-center flex-1">Nova Venda</h2>
    </div>

    {{-- Pesquisa de Produtos --}}

     <div class="w-full max-w-xl p-6 flex flex-col gap-6">
        <form action="" method="GET" class="w-full flex items-center">
            <div class="flex flex-1">
            <input
                type="text"
                name="query"
                placeholder="Pesquisar produtos..."
                class="flex-1 px-4 py-2 rounded-l-full bg-[#181f2a] border border-blue-600 text-white focus:outline-none"
                required
            >
            <button type="submit" class="cursor-pointer bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-full font-semibold transition flex items-center justify-center -ml-px">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
            </div>
            <a onclick="openBarcodeModal()" class="ml-4">
                <button
                    type="button"
                    class="cursor-pointer bg-blue-600 hover:bg-blue-800 text-[#181f2a] font-bold py-2 px-4 rounded-full transition flex items-center justify-center"
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
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base text-center w-32">Qtd</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-blue-900 hover:bg-blue-950/30 transition">
                        <td class="py-2 px-2 align-top font-bold text-blue-300">001</td>
                        <td class="py-2 px-2">
                            <div class="font-semibold text-white">Achoc Toddy 200g</div>
                            <div class="text-xs text-gray-400">1723787444321</div>
                        </td>
                        <td class="py-2 px-2 text-center align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="decrementQtd(this)">−</button>
                                <span class="qtd text-lg font-bold w-8 text-center inline-block text-white">1</span>
                                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="incrementQtd(this)">+</button>
                            </div>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400">8,99</td>
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
        <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white font-bold px-8 py-3 rounded-full text-xl shadow transition">
            Finalizar Compra
        </button>
    </div>
</div>
<script>
function incrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    qtdSpan.textContent = parseInt(qtdSpan.textContent) + 1;
}
function decrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    if (parseInt(qtdSpan.textContent) > 1) {
        qtdSpan.textContent = parseInt(qtdSpan.textContent) - 1;
    }
}
</script>

{{-- Modal do leitor de código de barras --}}

<div id="barcode-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
    <div class="relative w-full max-w-xl bg-[#232b3b] rounded-3xl shadow-lg p-6 flex flex-col items-center gap-6">
        <button onclick="closeBarcodeModal()" class="cursor-pointer absolute top-4 right-4 bg-blue-900 hover:bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center shadow transition text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-white font-jost text-center w-full mb-4">Leitor de Código de Barras</h2>
        <div class="w-full flex flex-col items-center">
            <div id="interactive" class="rounded-2xl overflow-hidden border-4 border-blue-900 shadow-lg bg-black w-full max-w-md aspect-video"></div>
            <div class="mt-6 text-center">
                <span class="block text-lg text-cyan-400 font-semibold font-jost mb-1">Código detectado:</span>
                <span id="barcode-result" class="text-2xl text-white font-bold font-mono tracking-widest bg-blue-900 px-4 py-2 rounded-lg shadow"></span>
                <div id="product-info" class="text-white mt-4 text-center"></div>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <span class="text-gray-400 text-sm">Aponte a câmera para o código de barras do produto</span>
        </div>
    </div>
</div>
<script src="https://unpkg.com/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>
let quaggaStarted = false;
let processing = false;

function openBarcodeModal() {
    document.getElementById('barcode-modal').classList.remove('hidden');
    startQuagga();
}

function closeBarcodeModal() {
    document.getElementById('barcode-modal').classList.add('hidden');
    stopQuagga();
    document.getElementById('barcode-result').textContent = '';
    document.getElementById('product-info').innerHTML = '';
}

function startQuagga() {
    if (quaggaStarted) return;
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
        quaggaStarted = true;
    });

    Quagga.onDetected(function (result) {
        if (processing) return;
        processing = true;

        let code = result.codeResult.code;
        document.getElementById('barcode-result').textContent = code;

        fetch("/buscar-produto", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            },
            body: JSON.stringify({ codigo: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.erro) {
                document.getElementById("product-info").innerHTML = `<p class="text-red-500">${data.erro}</p>`;
            } else {
                document.getElementById("product-info").innerHTML = `
                    <p><strong>Nome:</strong> ${data.nome}</p>
                    <p><strong>Marca:</strong> ${data.marca}</p>
                    <p><strong>Descrição:</strong> ${data.descricao}</p>
                    ${data.imagem ? `<img src="${data.imagem}" class="mx-auto mt-2 rounded shadow" width="100">` : ''}
                `;
            }
        })
        .catch(err => {
            document.getElementById("product-info").innerHTML = `<p class="text-red-500">Erro na consulta.</p>`;
            console.error(err);
        })
        .finally(() => {
            quaggaStarted = false;
            processing = false;
        });
    });
}

function stopQuagga() {
    if (quaggaStarted) {
        Quagga.stop();
        quaggaStarted = false;
    }
}
</script>
@endsection