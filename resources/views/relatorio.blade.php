{{-- filepath: resources/views/relatorio.blade.php --}}
@extends('master')

@section('content')
@vite('resources/css/app.css')

<div class="flex flex-col items-center min-h-screen bg-white dark:bg-[#181f2a] py-0 relative">
    <div class="w-full max-w-4xl p-6 flex flex-col gap-6">
        <div class="flex items-center w-full mb-6 justify-center px-4 pt-8 relative">
            <a href="{{ route('home') }}" class="absolute left-4">
                <button class="cursor-pointer bg-blue-900 hover:bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </a>
            <h2 class="text-2xl font-bold text-blue-900 dark:text-white font-jost text-center flex-1">Relatório de Vendas</h2>
        </div>
        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-3xl shadow-lg p-6 mb-6 flex flex-col gap-4">
            <table class="w-full text-left font-jost">
                <thead>
                    <tr class="border-b border-blue-900">
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base">#</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base">Data</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base">Usuário</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base text-right">Total</th>
                        <th class="py-2 px-2 font-bold text-cyan-400 text-base">Itens</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendas as $venda)
                    <tr class="border-b border-blue-900 hover:bg-blue-100 dark:hover:bg-blue-950/30 transition cursor-pointer"
                        onclick='abrirModalVenda({{ $venda->id }}, "{{ $venda->created_at->format('d/m/Y H:i') }}", "{{ $venda->usuario->name ?? 'N/A' }}", "{{ number_format($venda->total, 2, ',', '.') }}", {!! json_encode($venda->itens->map(function($item) {
        return [
            'produto_id' => $item->produto_id,
            'quantidade' => $item->quantidade,
            'produto' => $item->produto ? ['nome' => $item->produto->nome] : null,
        ];
    })) !!})'>
                        <td class="py-2 px-2 align-top font-bold text-blue-300">{{ str_pad($venda->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-2 px-2 text-blue-900 dark:text-white">{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-2 px-2 text-blue-900 dark:text-white">{{ $venda->usuario->name ?? 'N/A' }}</td>
                        <td class="py-2 px-2 text-right font-bold text-cyan-400">R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                        <td class="py-2 px-2">
                            <ul class="text-xs text-gray-700 dark:text-gray-300">
                                @foreach($venda->itens as $item)
                                    <li>
                                        <span class="font-semibold">{{ $item->produto->nome ?? 'Produto #'.$item->produto_id }}</span>
                                        <span class="ml-2">Qtd: {{ $item->quantidade }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de detalhes da venda -->
<div id="modal-venda" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 w-full max-w-lg relative">
        <button onclick="closeVendaModal()" class="absolute top-2 right-2 text-gray-400 hover:text-red-600 text-2xl font-bold">&times;</button>
        <h3 class="text-xl font-bold mb-4 text-blue-900 dark:text-white" id="modal-venda-titulo">Detalhes da Venda</h3>
        <div id="modal-venda-conteudo" class="text-blue-900 dark:text-white"></div>
    </div>
</div>

<script>
function abrirModalVenda(id, data, usuario, total, itens) {
    let html = `
        <div class="mb-2"><b>Venda #${String(id).padStart(3, '0')}</b></div>
        <div class="mb-2">Data: <span class="font-semibold">${data}</span></div>
        <div class="mb-2">Usuário: <span class="font-semibold">${usuario}</span></div>
        <div class="mb-2">Total: <span class="font-semibold text-cyan-600">R$ ${total}</span></div>
        <div class="mt-4 mb-2 font-bold">Produtos:</div>
        <ul class="list-disc ml-6">
    `;
    itens.forEach(item => {
        html += `<li>${item.produto?.nome ?? 'Produto #'+item.produto_id} <span class="ml-2 text-xs text-gray-500">Qtd: ${item.quantidade}</span></li>`;
    });
    html += '</ul>';
    document.getElementById('modal-venda-titulo').textContent = `Detalhes da Venda #${String(id).padStart(3, '0')}`;
    document.getElementById('modal-venda-conteudo').innerHTML = html;
    document.getElementById('modal-venda').classList.remove('hidden');
}
function closeVendaModal() {
    document.getElementById('modal-venda').classList.add('hidden');
}
</script>
@endsection