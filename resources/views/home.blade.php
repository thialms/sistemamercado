@extends('master')

@section('content')

@vite('resources/css/app.css')

@if(session('logado'))
    {{-- Conteúdo protegido --}}
@else
    {{-- Redireciona para login --}}
@endif

<div class="flex flex-col items-center justify-center min-h-screen py-6 sm:py-12 lg:py-24 bg-white gap-6">

    <div class="mb-8 text-center font-semibold cursor-default">
        <p class="text-4xl font-jost font-bold leading-none">Mercado do</p>
        <p class="text-5xl font-jost font-bold text-blue-800 -mt-2">Fernando</p>
    </div>

    <a href="{{ route('vendas') }}">
        <button class="w-100 py-12 text-3xl font-bold font-jost bg-blue-200 rounded-3xl shadow-md mb-2 cursor-pointer">Efetuar venda</button>
    </a>
    <button class="w-100 py-12 text-3xl font-bold font-jost bg-blue-400 rounded-3xl shadow-md mb-2 cursor-pointer">Relatório de vendas</button>
    <button class="w-100 py-12 text-3xl font-bold font-jost bg-blue-600 text-white rounded-3xl shadow-md mb-2 cursor-pointer">Lorem</button>
    <button class="w-100 py-12 text-3xl font-bold font-jost bg-blue-800 text-white rounded-3xl shadow-md cursor-pointer">Lorem</button>
</div>

@endsection