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

No seu projeto Laravel:

1. Execute o comando `composer require phpmailer/phpmailer` para instalar a biblioteca PHPMailer.
2. Execute o comando `composer require league/oauth2-google` para instalar a biblioteca OAuth2 do Google.
3. No arquivo `.env`, insira as seguintes variáveis de ambiente:
   ```
   GMAIL_API_CLIENT_ID=ID do cliente(Dados que voce copiou)
   GMAIL_API_CLIENT_SECRET=Chave secreta do cliente(Dados que voce copiou)
   ```
4. No arquivo `web.php`, adicione as rotas e lógica necessárias para a autenticação com o Gmail.

Lembre-se de voltar à página da API e publicar o seu aplicativo na "Tela de permissão" após concluir as etapas acima.



## Criar API de autenticação 2.0 do Outlook
