@extends('layouts.app')

@section('content')
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <h3>Gerar token e enviar email</h3>
    </div>
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm flex justify-between">
        <form action="{{ route('auth.outlook') }}" method="post" class="mr-2">
            @csrf
            <button type="submit" class="cursor p-2 px-6 bg-gray-900 text-gray-600 font-semibold">Gerar Token</button>
        </form>

        @if (session()->has('token'))
            <form action="{{ route('send') }}" method="post">
                @csrf
                <input type="hidden" name="oauth_token" value="{{ session()->get('token') }}">
                <button type="submit" class="cursor p-2 px-6 bg-gray-100 text-gray-700 font-semibold">Send Email</button>
            </form>
        @endif
    </div>
    @if (session()->has('error') || session()->has('token'))
        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            <h4 style="margin-bottom: 5px;">Token</h4>
            @if (session()->has('error'))
                <p class="font-semibold">{{ session()->get('error') }}</p>
            @endif

            @if (session()->has('token'))
                <p class="font-semibold" style="font-size: 10px; margin: 0px;">{{ session()->get('token') }}</p>
            @endif
        </div>
    @endif

    @if (session()->has('success'))
        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            <p class="font-semibold">{{ session()->get('success') }}</p>
        </div>
    @endif
@endsection
