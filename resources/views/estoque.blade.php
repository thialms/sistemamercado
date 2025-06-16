{{-- filepath: c:\Users\thiia\Downloads\mercado\mercado\resources\views\estoque.blade.php --}}
@extends ('master')

@section('content')

@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-white dark:bg-[#181f2a] py-0 relative">

    <div class="flex items-center w-full max-w-xl mx-auto mb-6 justify-between px-4 pt-8 relative">
        <a href="{{ route('home') }}">
            <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <h2 class="text-2xl font-bold text-blue-900 dark:text-white font-jost text-center flex-1">Controle de Estoque</h2>
        <div style="width:3rem"></div>
        <button onclick="openAddProductModal()" class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition" title="Adicionar Produto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>

    {{-- Pesquisa de Produtos --}}
    <div class="w-full max-w-xl p-6 flex flex-col gap-6">
        <form action="{{ route('estoque') }}" method="GET" class="w-full flex items-center">
            <div class="flex flex-1">
                <input
                    type="text"
                    name="query"
                    value="{{ old('query', $query ?? '') }}"
                    placeholder="Pesquisar produtos..."
                    class="flex-1 px-4 py-2 rounded-l-full bg-gray-100 dark:bg-gray-800 border border-blue-600 text-blue-900 dark:text-white focus:outline-none"
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
            <div class="flex items-center justify-center mb-2">
            <span class="text-lg font-bold text-cyan-400 font-jost">Produtos em Estoque</span>
            </div>
            <div class="overflow-x-auto">
            <table class="w-full text-left font-jost">
                <thead>
<tr class="border-b border-blue-900">
    <th class="py-2 px-2 font-bold text-cyan-400 text-base">Descrição</th>
    <th class="py-2 px-2 font-bold text-cyan-400 text-base text-center w-32">Qtd Estoque</th>
    <th class="py-2 px-2 font-bold text-cyan-400 text-base text-right">Preço</th>
</tr>
</thead>
<tbody>
@foreach($produtos as $produto)
<tr class="border-b border-blue-900 hover:bg-blue-100 dark:hover:bg-blue-950/30 transition cursor-pointer"
    onclick="openEditProductModal('{{ addslashes($produto->nome) }}', {{ $produto->estoque_atual }}, {{ $produto->preco_venda }}, {{ $produto->id }}, '{{ addslashes($produto->codigo_barras) }}')">
    <td class="py-2 px-2 align-top font-semibold text-blue-900 dark:text-white">
        {{ $produto->nome }}
        @if($produto->codigo_barras)
            <div class="text-xs text-gray-500 dark:text-gray-400 font-normal mt-1">
                Código de Barras: {{ $produto->codigo_barras }}
            </div>
        @endif
    </td>
    <td class="py-2 px-2 text-center align-middle text-blue-900 dark:text-white">{{ $produto->estoque_atual }}</td>
    <td class="py-2 px-2 text-right font-bold text-cyan-400">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
</tr>
@endforeach
</tbody>
            </table>
            </div>
        </div>

        {{-- Modal de edição de produto --}}
        <div id="edit-product-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
            <div class="relative w-full max-w-lg bg-gray-100 dark:bg-[#232b3b] rounded-3xl shadow-lg p-8 flex flex-col gap-6">
            <button onclick="closeEditProductModal()" class="absolute top-4 right-4 bg-blue-900 hover:bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center shadow transition text-2xl">&times;</button>
            <h2 class="text-2xl font-bold text-blue-900 dark:text-white font-jost text-center mb-4">Editar Produto</h2>
            <div>
                <ul class="flex border-b mb-4" id="editProductTabs">
                <li class="mr-4">
                    <button class="tab-btn font-bold px-4 py-2 text-blue-900 dark:text-white border-b-2 border-blue-900" onclick="showEditTab('info')">Informações</button>
                </li>
                <li class="mr-4">
                    <button class="tab-btn font-bold px-4 py-2 text-blue-900 dark:text-white" onclick="showEditTab('saida')">Controle de Saída</button>
                </li>
                <li>
                    <button class="tab-btn font-bold px-4 py-2 text-blue-900 dark:text-white" onclick="showEditTab('historico')">Histórico de Preços</button>
                </li>
                </ul>
                <div id="editTab-info" class="edit-tab">
    <form id="edit-product-form" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editId">

        <label for="editDescricao" class="font-semibold text-blue-900 dark:text-white">Nome do Produto</label>
        <input type="text" name="nome" id="editDescricao" placeholder="Descrição" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">

        <label for="editQuantidade" class="font-semibold text-blue-900 dark:text-white">Quantidade em Estoque</label>
        <input type="number" name="estoque_atual" id="editQuantidade" placeholder="Quantidade" min="0" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">

        <label for="editPreco" class="font-semibold text-blue-900 dark:text-white">Preço de Venda</label>
        <input type="number" name="preco_venda" id="editPreco" placeholder="Preço" min="0" step="0.01" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">

        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeEditProductModal()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold px-6 py-2 rounded-full transition">Cancelar</button>
            <button type="submit" class="bg-blue-900 hover:bg-blue-600 text-white font-bold px-6 py-2 rounded-full transition">Salvar</button>
        </div>
    </form>
</div>
                <div id="editTab-saida" class="edit-tab hidden">
                {{-- Aqui vai o controle de saída do produto --}}
                <div class="text-blue-900 dark:text-white">
                    <p class="mb-2 font-semibold">Controle de Saída</p>
                    <ul class="list-disc ml-6 text-sm">
                    <li>05/06/2024 - 2 unidades vendidas</li>
                    <li>04/06/2024 - 1 unidade vendida</li>
                    {{-- Exemplo, substitua por dados reais --}}
                    </ul>
                </div>
                </div>
                <div id="editTab-historico" class="edit-tab hidden">
                {{-- Aqui vai o histórico de preços --}}
                <div class="text-blue-900 dark:text-white">
                    <p class="mb-2 font-semibold">Histórico de Preços</p>
                    <ul class="list-disc ml-6 text-sm">
                    <li>R$ 5,99 - 01/06/2024</li>
                    <li>R$ 5,49 - 15/05/2024</li>
                    {{-- Exemplo, substitua por dados reais --}}
                    </ul>
                </div>
                </div>
            </div>
            </div>
        </div>
        <script>
        function openEditProductModal(nome, quantidade, preco, id, codigo_barras = '') {
            document.getElementById('editDescricao').value = nome;
            document.getElementById('editQuantidade').value = quantidade;
            document.getElementById('editPreco').value = preco;
            document.getElementById('editId').value = id;
            document.getElementById('edit-product-form').action = `/produtos/${id}`;
            document.getElementById('edit-product-modal').classList.remove('hidden');
            showEditTab('info');
        }
        function closeEditProductModal() {
            document.getElementById('edit-product-modal').classList.add('hidden');
        }
        function showEditTab(tab) {
            document.querySelectorAll('.edit-tab').forEach(el => el.classList.add('hidden'));
            document.getElementById('editTab-' + tab).classList.remove('hidden');
            document.querySelectorAll('#editProductTabs .tab-btn').forEach(btn => btn.classList.remove('border-blue-900', 'border-b-2'));
            document.querySelector(`#editProductTabs .tab-btn[onclick="showEditTab('${tab}')"]`).classList.add('border-blue-900', 'border-b-2');
        }
        document.getElementById('edit-product-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const id = document.getElementById('editId').value;
    const data = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'PUT'
        },
        body: data
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (e) {
            const text = await res.text();
            alert('Erro inesperado: ' + text);
            throw e;
        }
        return data;
    })
    .then(response => {
        if (response.success) {
            closeEditProductModal();
            location.reload();
        } else if(response.errors) {
            alert('Erro: ' + Object.values(response.errors).join('\n'));
        } else {
            alert('Erro ao atualizar produto!');
        }
    })
    .catch((err) => {
        alert('Erro ao atualizar produto!');
        console.error(err);
    });
});
        </script>
    </div>
</div>
<script>
function incrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    qtdSpan.textContent = parseInt(qtdSpan.textContent) + 1;
}
function decrementQtd(btn) {
    const qtdSpan = btn.parentElement.querySelector('.qtd');
    if (parseInt(qtdSpan.textContent) > 0) {
        qtdSpan.textContent = parseInt(qtdSpan.textContent) - 1;
    }
}
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

{{-- Modal de adicionar produto --}}
<div id="add-product-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="relative w-full max-w-lg bg-gray-100 dark:bg-[#232b3b] rounded-3xl shadow-lg p-8 flex flex-col gap-6">
        <button onclick="closeAddProductModal()" class="cursor-pointer absolute top-4 right-4 bg-blue-900 hover:bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center shadow transition text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-blue-900 dark:text-white font-jost text-center mb-4">Adicionar Produto</h2>
        <form id="add-product-form" action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <input type="text" name="nome" placeholder="Nome do produto" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <input type="text" name="marca" placeholder="Marca" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <input type="text" name="codigo_barras" placeholder="Código de Barras" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <input type="number" name="quantidade" placeholder="Quantidade" min="0" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <input type="number" name="preco" placeholder="Preço" min="0" step="0.01" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <input type="number" name="custo" placeholder="Custo" min="0" step="0.01" required class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-blue-900 dark:text-white focus:outline-none">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddProductModal()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold px-6 py-2 rounded-full transition cursor-pointer">Cancelar</button>
                <button type="submit" class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white font-bold px-6 py-2 rounded-full transition">Adicionar</button>
            </div>
        </form>
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

// Modal de adicionar produto
function openAddProductModal() {
    document.getElementById('add-product-modal').classList.remove('hidden');
}
function closeAddProductModal() {
    document.getElementById('add-product-modal').classList.add('hidden');
}
</script>
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-2">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="bg-red-100 text-red-800 p-2 rounded mb-2">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
@endsection