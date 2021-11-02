<?php

class Configs{
    /**
     * Utilizado para verificar a validade do objeto, ou seja, se
     * suas configurações foram preenchidas corretamente.
     */
    private bool $valid;

    /**
     * Armazena os dados principais do bot, como a chave de api da Alpha Vantage e
     * o ID do chat, e o token, do telegram.
     */
    private string $apiKey, $chatID, $telegramToken;
    
    /**
     * Inicializa o objeto com os principais dados e valida o carregamento das
     * configurações.
     * As ações são deixadas de fora do construtor. O carregamento das ações
     * deverá ser solicitada pelo bot na criação do objeto "bot".
     */
    public function __construct(){
        $configs = json_decode(file_get_contents(__DIR__."/../config.json"));
        $this->apiKey = $configs->API_KEY;
        $this->chatID = $configs->CHAT_ID;
        $this->telegramToken = $configs->TOKEN_TELEGRAM;
        if($this->apiKey == "" || $this->chatID == "" || $this->telegramToken == ""){
            echo "Erro! Verifique se os dados de 'config.json' estão corretos!\n";
            $this->valid = false;
        }else $this->valid = true;
    }

    /**
     * Retorna a validade do objeto.
     * 
     * @return bool
     */
    public function isValid(){
        return $this->valid;
    }

    /**
     * Função interna para abrir o arquivo "config.json".
     */
    protected function openFile(){
        return json_decode(file_get_contents(__DIR__."/../config.json"));
    }

    /**
     * Função para abrir o vetor de ações em "config.json" e inicializar o objeto
     * com as ações.
     */
    public function getStocks(){
        $configs = $this->openFile();
        if(count($configs->STOCKS)){
            return $configs->STOCKS;
        }else{
            $this->valid = false;
            echo "Erro! Não existe ações registradas no arquivo 'config.json'";
            return false;
        }
    }

    /**
     * Retorna a apiKey da Alpha Vantage
     */
    public function getApiKey(){
        return $this->apiKey;
    }

    /**
     * Retorna o token do Telegram
     */
    public function getTelegramToken(){
        return $this->telegramToken;
    }

    /**
     * Retorna o ID do chat do Telegram
     */
    public function getChatId(){
        return $this->chatID;
    }
}