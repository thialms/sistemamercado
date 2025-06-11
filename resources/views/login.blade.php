@extends('master')

@section('content')

@vite('resources/css/app.css')

{{-- Add um switch para trocar o tema? --}}
{{-- Implementar o banco de dados para fazer a verificacao do login de maneira correta --}}

<div class="flex flex-col items-center justify-center min-h-screen py-6 sm:py-12 lg:py-24 dark:bg-[#030e1a]">

    <div class="mb-8 text-center font-semibold cursor-default">
        <p class="text-4xl font-jost font-bold leading-none dark:text-white">Mercado do</p>
        <p class="text-5xl font-jost font-bold text-blue-800 -mt-2">Fernando</p>
    </div>

    @if(auth()->check())

    @else

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-jost">Sucesso!</strong>
            <span class="block sm:inline font-jost">{{ session('success') }}</span>
        </div>
        
    @endif

    @error('error')
        <span>{{$message}}</span>
    @enderror

    <form action="{{ route('login.store') }}" method="POST" class="w-full max-w-xs flex flex-col gap-6">
        @csrf
        <div class="relative mt-2">
            <label for="email" class="px-5 text-base font-jost dark:text-white">Usuário</label>
            <input type="text" id="user" name="email" required
                class="w-full dark:bg-gray-300 px-4 py-2 border border-blue-800 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-800 text-base font-jost" />
        </div>
        <div class="relative mt-2">
            <label for="password" class="px-5 text-base font-jost dark:text-white">Senha</label>
            <input type="password" id="password" name="password" required
                class="w-full dark:bg-gray-300 px-4 py-2 border border-blue-800 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-800 text-base font-jost" />
                @error('password')
                <span class="text-red-500 text-sm font-jost">{{ $message }}</span>
                @enderror
        </div>
        <button type="submit"
            class="w-full py-3 mt-2 rounded-full bg-blue-800 text-white text-lg font-bold font-jost transition hover:bg-blue-900 cursor-pointer">Login</button>
    </form>

    <div class="mt-6 text-center">
        <span class="text-base font-jost dark:text-white">Esqueceu a senha? </span>
        <a href="#" class="text-base font-jost text-blue-800 font-semibold hover:underline">Clique aqui</a>
    </div>
</div>

    @endif

@endsection