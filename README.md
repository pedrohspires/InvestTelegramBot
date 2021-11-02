# PHInvestNotifyBot
Autor: Pedro Henrique Sousa Pires <br>
Email: pedrohsp2603@gmail.com<br>
Desenvolvedor web full stack

## O que é?
Olá, aqui é o Pedro, sou estudante de Ciências da Computação na Universidade Estadual Vale do Acaraú, no interior do Ceará. Este projeto consiste em um bot que envia notificações sobre os investimentos do usuário, diariamente, para seu telegram.<br><br>

## Concepção do projetos
Como investidor amador e estudante de programação, tive um desejo de receber uma mensagem direta sobre os ativos que tenho, porém não queria uma solução pronta, talvez exista, não pesquisei, mas quis fazer como um desafio.<br><br>

## Como usar?
Para usar o bot na máquina local, basta executar o script "bot.php". Será realizado uma checagem inicial das configurações do arquivo "config.json" e será enviado uma primeira mensagem para o chat escolhido. Logo após, o script ficará em em standby até as 9 horas do próximo dia, quando enviará uma nova mensagem.<br><br>

## Passo a passo para configurar o bot
1. Iniciar uma conversa com o usuário @BotFather no Telegram;
2. Solicitar a criação de um novo bot com o comando: "/newbot";
3. Digite o nome do bot;
4. Digite agora o username do bot;<br>
Obs: o username do bot deve terminar com a palavra "Bot".
5. O BotFather lhe enviará uma mensagem com a API Key do bot que acabamos de criar. Coloque essa informação no campo "TOKEN_TELEGRAM" no arquivo "config.json";<br>
Obs: Guarde esse token/api key em um local seguro, pois quem tiver acesso a ele, terá também a todas as mensagens dos usuários que conversaram com o bot, assim como outras informações. NUNCA SUBA ESSAS INFORMAÇÕES EM REPOSITÓRIOS GIT.
6. Vá ao site da Alpha Vantage: https://www.alphavantage.co/
7. Clique em "Get your free api key today";
8. Preencha os campos corretamente e clique em "Get free api key";
9. Caso tudo tenha ocorrido bem, logo abaixo do botão aparecerá a sua API Key. Coloque essa informação no campo "API_KEY" no arquivo "config.json";
10. Inicie uma conversa com o bot (clicando em start no chat) ou coloque-o em um grupo, e envie qualquer outra mensagem, como "Olá". Servirá para guardar seu chat ID para recuperarmos mais tarde;
11. Agora precisamos do seu chat ID que foi criado ao iniciar a conversa com o bot. Para isso, precisamos de um software ou site para realizar uma requisição HTTP para o bot, por exemplo, o programa Insomnia;
12. Envie a requisição GET HTTP com o seguinte formato:<br>
https://api.telegram.org/bot(token_telegram)/getUpdates<br>
Substituindo (token_telegram) pelo seu token obtido no passo 5. Remova os parênteses também;
13. O retorno da api será um json contendo algumas informações, a que nos interessa é a informação contida em "chat" no campo "id". Pegue essa informação e coloque em "CHAT_ID" em "config.json";
14. Está quase tudo pronto, agora basta preencher o campo "STOCKS" em "config.json" com as suas ações e executar o script.<br><br>

O Script não irá finalizar quando a mensagem for enviada, ele entrará em standby até as 9 horas do próximo dia.<br><br>

## Tecnologias
As seguintes tecnologias serão usadas para o projetos:<br>
* BotFather do Telegram
* PHP 7.4
* APIs do Telegram e da plataforma AlphaVantage
<br><br>

## Principais problemas com o desenvolvimento do bot
1. A ideia inicial do projeto era ser com Whatsapp, porém o mesmo não tinha um serviço de bot para usuários comuns, apenas para empresas;
2. Dificuldades (minhas) em implementar Orientação a Objetos em um problema prático;
3. Mudanças frequentes no plano para se adaptar a limitações técnicas e de meus conhecimentos.<br><br>

## O que ainda falta
* Ainda tenho a ideia de fazer um bot automático, que receba as mensagens de um usuário informando que quer receber detalhes de suas ações, para que possa rodar em um servidor sem necessidade de rodar com os dados de cada usuário no arquivo "config.json".<br>
* Além disso, falta refatorar o código. Há muitas falhas não tratadas e métodos extensos, como o "init()" da classe App, que sozinho tem 26 linhas.<br>
* Outra alteração importante no projeto é a atualização automática das ações, visto que atualmente o bot não se preocupa se novas ações foram adicionadas manualmente no arquivo "config.json".

<br><br><hr>

## Replicar o bot
Caso deseje replicar o bot, realizar suas próprias alterações ou mesmo rodar na sua máquina, sinta-se a vontade. Este projeto está sob a licença GPLv3.