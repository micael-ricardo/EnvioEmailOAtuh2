## Criar API de autenticação 2.0 do Gmail

1. Faça login na sua conta do Gmail.

2. Acesse o link: [https://cloud.google.com/](https://cloud.google.com/?utm_source=google&utm_medium=cpc&utm_campaign=latam-BR-all-pt-dr-BKWS-all-all-trial-e-dr-1605194-LUAC0010101&utm_content=text-ad-none-any-DEV_c-CRE_512285710743-ADGP_Hybrid+%7C+BKWS+-+EXA+%7C+Txt+~+GCP_General-KWID_43700062788251524-kwd-301173107504&utm_term=KW_google%20cloud%20platform-ST_Google+Cloud+Platform&gclid=CjwKCAjwsKqoBhBPEiwALrrqiB2A0ZSyhbm8-dmUFtGEYlnWwbm82sg7RPwf8nEF1X64izIb4qpgpRoCfl8QAvD_BwE&gclsrc=aw.ds)

3. Clique em "Começar".

4. Preencha os dados necessários.

5. Dê um nome ao seu novo projeto e clique em "Criar".

6. Procure por "Gmail API" e ative a API.

7. Clique em "Tela de permissão OAuth" -> "Externo" -> "Criar".
8. Preencha o nome do seu aplicativo, o e-mail de suporte do usuário e os dados de contato do desenvolvedor. Em seguida, clique em "Salvar e Continuar".
9. Vá para "Credenciais" -> "Criar credenciais" -> "ID do cliente OAuth" -> "Tipo de aplicativo" -> "Aplicativo da web".
10. Preencha o nome do aplicativo e as URIs de redirecionamento autorizadas, como: "http://127.0.0.1:8000/get-token" -> "Criar".

Agora, copie o "ID do cliente" e a "Chave secreta do cliente" fornecidos pela API do Gmail.

## Criar API de autenticação 2.0 do Outlook

1. Acesse o portal de desenvolvedores da Microsoft: [https://portal.azure.com].
2. Faça login com sua conta da Microsoft.
3. No menu à esquerda, clique em "Azure Active Directory".
4. Selecione "Registro de aplicativos" e clique em "Novo registro".
5. Dê um nome ao seu aplicativo e selecione o tipo de conta que deseja usar (pessoal, empresarial ou escolar).
6. Na seção "URI de redirecionamento", adicione a URI de redirecionamento do seu aplicativo Laravel, por exemplo: `http://localhost:7000/get-token`.
7. Clique em "Registrar" para criar o aplicativo.
8. Na página de visão geral do aplicativo, anote o ID do aplicativo (Client ID) e o ID do diretório (locatário).
9. Na seção "Configurações", clique em "Adicionar plataforma" e selecione "Aplicativo Web".
10. Adicione a URI de redirecionamento novamente na seção "URI de redirecionamento" e salve as alterações.


## Para testar o do outlook devemos startar o servidor com esse comando: php artisan serve --port=7000 --host=localhost
