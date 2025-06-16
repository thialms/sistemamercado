@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-white dark:bg-[#181f2a] py-0 relative">

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-center px-4 pt-8 relative">
        <a href="{{ route('home') }}" class="absolute left-4">
            <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-blue-900 dark:text-white font-jost text-center flex-1">Nova Venda</h2>
    </div>

    {{-- Pesquisa de Produtos --}}
    <div class="w-full max-w-xl p-6 flex flex-col gap-6">
        <form action="" method="GET" class="w-full flex items-center">
            <div class="relative w-full">
                <input
                    type="text"
                    id="search-produto"
                    autocomplete="off"
                    placeholder="Pesquisar produtos..."
                    class="w-full px-4 py-2 rounded-l-full bg-gray-100 dark:bg-gray-800 border border-blue-600 text-blue-900 dark:text-white focus:outline-none"
                >
                <ul id="autocomplete-results" class="absolute z-50 left-0 right-0 bg-white dark:bg-gray-700 border border-blue-600 rounded-b-lg shadow-lg hidden max-h-60 overflow-y-auto"></ul>
            </div>
            <button type="submit" class="cursor-pointer bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-full font-semibold transition flex items-center justify-center -ml-px">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
            <a onclick="openBarcodeModal()" class="ml-4">
                <button
                    type="button"
                    class="cursor-pointer bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full transition flex items-center justify-center"
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

        <div class="w-full max-w-xl bg-gray-100 dark:bg-gray-800 rounded-3xl shadow-lg p-6 mb-6 flex flex-col gap-4">
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
                            <th class="py-2 px-2 font-bold text-cyan-400 text-base text-center w-16">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itens as $index => $item)
                            <tr class="border-b border-blue-900 hover:bg-blue-100 dark:hover:bg-blue-950/30 transition" data-preco="{{ $item['subtotal'] ?? $item->subtotal ?? 0 }}">
                                <td class="py-2 px-2 align-top font-bold text-blue-300">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-2 px-2">
                                    <div class="font-semibold text-blue-900 dark:text-white">{{ $item['nome'] ?? $item->nome ?? '' }}</div>
                                    <div class="text-xs text-gray-400">{{ $item['codigo'] ?? $item->codigo ?? '' }}</div>
                                </td>
                                <td class="py-2 px-2 text-center align-middle">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="decrementQtd(this)">−</button>
                                        <span class="qtd text-lg font-bold w-8 text-center inline-block text-blue-900 dark:text-white">{{ $item['quantidade'] ?? $item->quantidade ?? 1 }}</span>
                                        <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="incrementQtd(this)">+</button>
                                    </div>
                                </td>
                                <td class="py-2 px-2 text-right font-bold text-cyan-400 subtotal">{{ number_format($item['subtotal'] ?? $item->subtotal ?? 0, 2, ',', '.') }}</td>
                                <td class="py-2 px-2 text-center align-middle">
                                    <button type="button" class="remover-produto bg-red-600 hover:bg-red-800 text-white rounded-full w-8 h-8 flex items-center justify-center" title="Remover produto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full max-w-xl flex items-center justify-between bg-blue-800 dark:bg-blue-900 px-8 py-6 rounded-3xl shadow-lg mb-8">
            <span class="text-white text-2xl font-bold font-jost">TOTAL</span>
            <span class="bg-gray-100 dark:bg-gray-800 rounded-3xl w-60 px-6 py-2 text-blue-900 dark:text-white text-3xl font-bold font-jost flex justify-end shadow" id="total-geral">0,00</span>
        </div>

        <div class="w-full max-w-xl flex justify-end">
            <button type="button" id="open-confirm-modal" class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white font-bold px-8 py-3 rounded-full text-xl shadow transition">
                Finalizar Compra
            </button>
        </div>
    </div>
</div>
<script>
function incrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    let qtd = parseInt(qtdSpan.textContent) + 1;
    qtdSpan.textContent = qtd;
    atualizarSubtotal(btn, qtd);
    atualizarTotal();
}
function decrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    let qtd = parseInt(qtdSpan.textContent);
    if (qtd > 1) {
        qtd--;
        qtdSpan.textContent = qtd;
        atualizarSubtotal(btn, qtd);
        atualizarTotal();
    }
}
function atualizarSubtotal(btn, qtd) {
    const row = btn.closest('tr');
    const preco = parseFloat(row.getAttribute('data-preco'));
    const subtotalTd = row.querySelector('.subtotal');
    const subtotal = preco * qtd;
    subtotalTd.textContent = subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}
function atualizarTotal() {
    let total = 0;
    document.querySelectorAll('tr[data-preco]').forEach(row => {
        const qtd = parseInt(row.querySelector('.qtd').textContent);
        const preco = parseFloat(row.getAttribute('data-preco'));
        total += qtd * preco;
    });
    document.getElementById('total-geral').textContent = total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

const searchInput = document.getElementById('search-produto');
const resultsList = document.getElementById('autocomplete-results');
const carrinhoTable = document.querySelector('table tbody');

let timeout = null;

searchInput.addEventListener('input', function() {
    clearTimeout(timeout);
    const query = this.value.trim();
    if (query.length < 2) {
        resultsList.innerHTML = '';
        resultsList.classList.add('hidden');
        return;
    }
    timeout = setTimeout(() => {
        fetch(`/produtos/busca-rapida?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(produtos => {
                if (produtos.length === 0) {
                    resultsList.innerHTML = '<li class="px-4 py-2 text-gray-500">Nenhum produto encontrado</li>';
                } else {
                    resultsList.innerHTML = produtos.map(prod =>
                        `<li class="px-4 py-2 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900"
                            data-id="${prod.id}"
                            data-nome="${prod.nome}"
                            data-preco="${prod.preco_venda}"
                            data-codigo="${prod.codigo_barras || ''}">
                            <span class="font-semibold dark:text-white">${prod.nome}</span>
                            <span class="text-xs text-gray-400 dark:text-white ml-2">${prod.codigo_barras || ''}</span>
                        </li>`
                    ).join('');
                }
                resultsList.classList.remove('hidden');
            });
    }, 250);
});

resultsList.addEventListener('click', function(e) {
    const li = e.target.closest('li[data-id]');
    if (!li) return;
    const id = li.getAttribute('data-id');
    const nome = li.getAttribute('data-nome');
    const preco = parseFloat(li.getAttribute('data-preco')).toFixed(2);
    const codigo = li.getAttribute('data-codigo');

    // Adiciona ao carrinho (tabela)
    const newRow = document.createElement('tr');
    newRow.className = "border-b border-blue-900";
    newRow.setAttribute('data-preco', preco);
    newRow.innerHTML = `
        <td class="py-2 px-2 align-top font-bold text-blue-300">${id}</td>
        <td class="py-2 px-2">
            <div class="font-semibold text-blue-900 dark:text-white">${nome}</div>
            <div class="text-xs text-gray-400">${codigo}</div>
        </td>
        <td class="py-2 px-2 text-center align-middle">
            <div class="flex items-center justify-center gap-2">
                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="decrementQtd(this)">−</button>
                <span class="qtd text-lg font-bold w-8 text-center inline-block text-blue-900 dark:text-white">1</span>
                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="incrementQtd(this)">+</button>
            </div>
        </td>
        <td class="py-2 px-2 text-right font-bold text-cyan-400 subtotal">${preco.replace('.', ',')}</td>
        <td class="py-2 px-2 text-center align-middle">
            <button type="button" class="remover-produto bg-red-600 hover:bg-red-800 text-white rounded-full w-8 h-8 flex items-center justify-center" title="Remover produto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </td>
    `;
    carrinhoTable.appendChild(newRow);

    // Atualiza o total imediatamente após adicionar o produto
    atualizarTotal();

    // Limpa busca
    searchInput.value = '';
    resultsList.innerHTML = '';
    resultsList.classList.add('hidden');
});
document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
        resultsList.classList.add('hidden');
    }
});

// Adiciona evento para remover produto do carrinho
document.addEventListener('click', function(e) {
    if (e.target.closest('.remover-produto')) {
        const row = e.target.closest('tr');
        row.remove();
        atualizarTotal();
    }
});
</script>

{{-- Modal do leitor de código de barras --}}

<div id="barcode-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-40 hidden">
    <div class="relative w-full max-w-xl bg-gray-100/90 dark:bg-[#232b3b]/90 rounded-3xl shadow-lg p-6 flex flex-col items-center gap-6">
        <button onclick="closeBarcodeModal()" class="cursor-pointer absolute top-4 right-4 bg-blue-900 hover:bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center shadow transition text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-black dark:text-white font-jost text-center w-full mb-4">Leitor de Código de Barras</h2>
        <div class="w-full flex flex-col items-center">
            <div id="interactive" class="rounded-2xl overflow-hidden border-4 border-blue-900 shadow-lg bg-black w-full max-w-md aspect-video"></div>
            <div class="mt-6 text-center">
                <span class="block text-lg text-cyan-400 font-semibold font-jost mb-1">Código detectado:</span>
                <span id="barcode-result" class="text-2xl text-white font-bold font-mono tracking-widest bg-blue-900 px-4 py-2 rounded-lg shadow"></span>
                <div id="product-info" class="text-white mt-4 text-center"></div>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <span class="text-black dark:text-gray-400 text-sm">Aponte a câmera para o código de barras do produto</span>
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
                width: 720,
                height: 1281
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

        fetch("/buscar-no-estoque", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            },
            body: JSON.stringify({ codigo_barras: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.erro) {
                document.getElementById("product-info").innerHTML = `<p class="text-red-500">${data.erro}</p>`;
            } else {
                const produto = data.produto;
                // Adiciona ao carrinho (tabela)
                const carrinhoTable = document.querySelector('table tbody');
                // Verifica se já existe o produto no carrinho
                let row = Array.from(carrinhoTable.children).find(tr =>
                    tr.querySelector('td') && tr.querySelector('td').textContent.trim() == produto.id
                );
                if (row) {
                    // Se já existe, incrementa a quantidade
                    const qtdSpan = row.querySelector('.qtd');
                    let qtd = parseInt(qtdSpan.textContent) + 1;
                    qtdSpan.textContent = qtd;
                    atualizarSubtotal(qtdSpan, qtd);
                } else {
                    // Se não existe, adiciona nova linha
                    const newRow = document.createElement('tr');
                    newRow.className = "border-b border-blue-900";
                    newRow.setAttribute('data-preco', produto.preco);
                    newRow.innerHTML = `
                        <td class="py-2 px-2 align-top font-bold text-blue-300">${produto.id}</td>
                        <td class="py-2 px-2">
                            <div class="font-semibold text-blue-900 dark:text-white">${produto.nome}</div>
                            <div class="text-xs text-gray-400">${produto.codigo_barras || ''}</div>
                        </td>
                        <td class="py-2 px-2 text-center align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="decrementQtd(this)">−</button>
                                <span class="qtd text-lg font-bold w-8 text-center inline-block text-blue-900 dark:text-white">1</span>
                                <button type="button" class="cursor-pointer bg-blue-800 text-white rounded-full w-8 h-8 text-2xl flex items-center justify-center" onclick="incrementQtd(this)">+</button>
                            </div>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400 subtotal">${parseFloat(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td class="py-2 px-2 text-center align-middle">
                            <button type="button" class="remover-produto bg-red-600 hover:bg-red-800 text-white rounded-full w-8 h-8 flex items-center justify-center" title="Remover produto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    `;
                    carrinhoTable.appendChild(newRow);
                }
                atualizarTotal();
                closeBarcodeModal();
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

<!-- Modal de Confirmação de Compra -->
<div id="confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg p-8 flex flex-col items-center gap-6 max-w-md w-full">
        <h2 class="text-2xl font-bold text-blue-900 dark:text-white mb-2">Confirmar Finalização</h2>
        <p class="text-lg text-gray-700 dark:text-gray-300 text-center">Deseja realmente finalizar a compra?</p>
        <div class="flex gap-4 mt-4">
            <button id="confirm-btn" class="cursor-pointer bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded-full transition">Sim</button>
            <button id="cancel-btn" class="cursor-pointer bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-2 rounded-full transition">Cancelar</button>
        </div>
    </div>
</div>
<script>
document.getElementById('open-confirm-modal').addEventListener('click', function() {
    document.getElementById('confirm-modal').classList.remove('hidden');
});
document.getElementById('cancel-btn').addEventListener('click', function() {
    document.getElementById('confirm-modal').classList.add('hidden');
});
document.getElementById('confirm-btn').addEventListener('click', function() {
    // Monta os itens do carrinho
    const itens = [];
    document.querySelectorAll('table tbody tr[data-preco]').forEach(row => {
        const id = row.querySelector('td').textContent.trim();
        const nome = row.querySelector('td:nth-child(2) .font-semibold').textContent.trim();
        const codigo = row.querySelector('td:nth-child(2) .text-xs').textContent.trim();
        const qtd = parseInt(row.querySelector('.qtd').textContent);
        itens.push({ id, nome, codigo, quantidade: qtd });
    });

    fetch('/finalizar-compra', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ itens })
    })
    .then(res => res.json())
    .then(data => {
        if (data.sucesso) {
            alert('Compra finalizada com sucesso!');
            window.location.reload();
        } else {
            alert(data.erro || 'Erro ao finalizar compra.');
            // Reabre o modal em caso de erro
            document.getElementById('confirm-modal').classList.remove('hidden');
        }
    })
    .catch(() => {
        alert('Erro ao finalizar compra.');
        // Reabre o modal em caso de erro
        document.getElementById('confirm-modal').classList.remove('hidden');
    })
    .finally(() => {
        // Fecha o modal apenas se a compra foi finalizada com sucesso
        // (não feche aqui, pois pode ser erro)
    });
});
</script>
@endsection