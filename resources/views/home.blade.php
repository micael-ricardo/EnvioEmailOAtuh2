@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <input id="OptionGmail" type="radio" value="1" class="btn-check" name="emailProvider" checked>
        <label class="btn btn-secondary" for="OptionGmail"><i class="bi bi-google"></i> Gmail</label>

        <input id="Option" type="radio" value="2" class="btn-check" name="emailProvider">
        <label class="btn btn-secondary" for="Option"><i class="bi bi-microsoft"></i> Outlook</label>
    </div>
    <div id="gmail" style="display:none">

        <!-- Documentação da Configuração da API do Gmail -->
        <div id="documentation" class="mt-4">
            <h2>Configurando a autenticação OAuth 2.0 do Gmail</h2>
            <ol>
                <li>Faça login na sua conta do Gmail.</li>
                <li>Acesse o link: <a href="https://cloud.google.com/" target="_blank">https://cloud.google.com/</a>.</li>
                <li>Clique em "Começar".</li>
                <li>Preencha os dados necessários.</li>
                <li>Dê um nome ao seu novo projeto e clique em "Criar".</li>
                <li>Procure por "Gmail API" e ative a API.</li>
                <li>Clique em "Tela de permissão OAuth" -> "Externo" -> "Criar".</li>
                <li>Preencha o nome do seu aplicativo, o e-mail de suporte do usuário e os dados de contato do
                    desenvolvedor. Em seguida, clique em "Salvar e Continuar".</li>
                <li>Vá para "Credenciais" -> "Criar credenciais" -> "ID do cliente OAuth" -> "Tipo de aplicativo" ->
                    "Aplicativo da web".</li>
                <li>Preencha o nome do aplicativo e as URIs de redirecionamento autorizadas, como:
                    "http://127.0.0.1:8000/get-token" -> "Criar".</li>
            </ol>
            <p>Agora, copie o "ID do cliente" e a "Chave secreta do cliente" fornecidos pela API do Gmail.</p>
        </div>

        <form id="form-gmail" method="POST">
            @csrf
            <div class="row" class="mb-3">
                <div class="form-group col-md-3">
                    <label for="email">E-mail:<span class="text-danger">*</span></label>
                    <input type="text" autocomplete="off" class="form-control" name="email" id="email">
                </div>

                <div class="form-group col-md-3">
                    <label for="clienteId">Cliente Id:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clienteId" id="clienteId">
                </div>
                <div class="form-group col-md-3">
                    <label for="clienteSecret">Cliente Secret:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clienteSecret" id="clienteSecret">
                </div>
            </div>
        </form>


        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            <h3>Gerar token e enviar email</h3>
        </div>

        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm flex justify-between">
            <form action="{{ route('gerar.token') }}" method="post" class="mr-2">
                @csrf
                <button type="submit" id="gerar-token"
                    class="cursor p-2 px-6 bg-gray-900 text-gray-600 font-semibold">Gerar Token</button>
            </form>
            @if (session()->has('token'))
                <form action="{{ route('send.email') }}" method="post">
                    @csrf
                    <input type="hidden" name="oauth_token" value="{{ session()->get('token') }}">
                    <button id="envio" value="1" type="submit"
                        class="cursor p-2 px-6 bg-gray-100 text-gray-700 font-semibold">Send Email</button>
                </form>
            @endif
        </div>
    </div>

    <div id="outlookForm" style="display: none;">
        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            <h3>Gerar token e enviar email</h3>
        </div>

        <form id="form-microsoft" method="POST">
            @csrf
            <div class="row" class="mb-3">
                <div class="form-group col-md-3">
                    <label for="email">E-mail:<span class="text-danger">*</span></label>
                    <input type="text" autocomplete="off" class="form-control" name="email" id="email">
                </div>

                <div class="form-group col-md-3">
                    <label for="clienteId">Cliente Id:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clienteId" id="clienteId">
                </div>
                <div class="form-group col-md-3">
                    <label for="clienteSecret">Cliente Secret:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clienteSecret" id="clienteSecret">
                </div>
                <div class="form-group col-md-3">
                    <label for="clienteTenant">Cliente Tenant:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clienteTenant" id="clienteTenant">
                </div>
            </div>
        </form>

        {{-- <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm flex justify-between">
            <form action="{{ route('gerar.token') }}" method="post" class="mr-2">
                @csrf
                <button type="submit" class="cursor p-2 px-6 bg-gray-900 text-gray-600 font-semibold">Gerar
                    Token</button>
            </form>

            @if (session()->has('token'))
                <form action="{{ route('send') }}" method="post">
                    @csrf
                    <input type="hidden" name="oauth_token" value="{{ session()->get('token') }}">
                    <button type="submit" class="cursor p-2 px-6 bg-gray-100 text-gray-700 font-semibold">Send
                        Email</button>
                </form>
            @endif
        </div> --}}
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
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script>

        $(document).ready(function() {

            if ($("input[name='emailProvider']:checked").val() == 1) {
                $('#gmail').show();
            } else {
                $('#outlookForm').show();
            }

            $('input[type="radio"][name="emailProvider"]').on('change', function() {
                if ($(this).val() == '2') {
                    $('#outlookForm').show();
                    $('#gmail').hide();
                } else {
                    $('#gmail').show();
                    $('#outlookForm').hide();
                }
            });
        });
    </script>
@endsection
