@extends('master')

@section('content')

@vite('resources/css/app.css')

@if(session('logado'))
    {{-- Conteúdo protegido --}}
@else
    {{-- Redireciona para login --}}
@endif

<div class="flex flex-col items-center justify-center min-h-screen py-6 sm:py-12 lg:py-24 bg-white">

    <div class="mb-8 text-center font-semibold cursor-default">
        <p class="text-4xl font-jost font-bold leading-none">Mercado do</p>
        <p class="text-5xl font-jost font-bold text-blue-800 -mt-2">Fernando</p>
    </div>

    

@endsection