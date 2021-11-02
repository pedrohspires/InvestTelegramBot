<?php
require_once __DIR__."/resources/config.php";
require_once __DIR__."/resources/api.php";

class App{
    /**
     * Verifica se o objeto é válido, ou seja, se todas as configurações
     * foram feitas corretamente.
     */
    private bool $valid;

    /**
     * Objeto responsável pelo carregamento e tratamento das principais
     * configurações do objeto que estão em "config.json". Sendo elas:
     * token, e o chat ID, do telegram e a chave da api da Alpha Vantage.
     */
    private Configs $configs;

    /**
     * Será responsável por toda a conexão com a api, requisições, validações,
     * tratamento do retorno da api, etc.
     */
    private Api $api;

    /**
     * Objeto com todas as ações que o usuário tem, assim como seus dados.
     */
    private Array $stocks;

    /**
     * Inicializa o objeto com as configurações, api e as ações. Também faz a
     * verificação da validade do objeto (se todas as configurações foram feitas
     * adequadamente).
     */
    public function __construct(){
        $this->configs = new Configs();
        $this->api = new Api($this->configs);
        $this->stocks = $this->configs->getStocks();
        if(!$this->configs->isValid() || !$this->api->isValid()){
            echo "Erro! Verifique as configurações em 'configs.json'\n";
            $this->valid = false;
        }else $this->valid = true;
    }

    /**
     * Retorna a validade do objeto.
     */
    public function isValid(){
        return $this->valid;
    }

    public function init(){
        if($this->isValid()){
            // desenvolver toda a lógica do bot aqui
            $day = (int)date("d", time());
            while(1){
                if(count($this->stocks) > 5){
                    $cont = 0;
                    while(1){
                        $aux = 0;
                        while($aux < 5 && $cont < count($this->stocks))
                            $newStocks[$aux++] = $this->stocks[$cont++];
                        $control = $this->api->sendMessages($newStocks);
                        echo "Aguarde 60s para a próxima requisição!\n";
                        if($cont < count($this->stocks) && $control)
                            sleep(60);
                        else
                            break;;
                        unset($newStocks);
                    }
                }else
                    $this->api->sendMessages($this->configs->getStocks());
                echo "Mensagem enviada!\n";
                $day++;
                time_sleep_until(mktime(9, 0, 0, 11, $day, 2021));
            }
        }else 
            echo "Erro! O objeto não foi instanciado corretamente.";
    }
}