<?php
require_once __DIR__."/config.php";

/**
 * A classe Api será responsável por:
 *   Armazenar as configurações das APIs da Alpha Vantage e do Telegram;
 *   Realizar a conexão entre o bot e as APIs
 *   Validar e tratar as respostas da API
 */
class Api{
    private bool $valid;
    private string $baseURL, $apiKey, $telegramToken, $chatID;

    public function __construct(Configs $configs){
        if($configs->isValid()){
            $this->baseURL = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=";
            $this->apiKey = $configs->getApiKey();
            $this->telegramToken = $configs->getTelegramToken();
            $this->chatID = $configs->getChatId();
            $this->valid = true;
        }else {
            echo "Erro! As configurações não são válidas!";
            $this->valid = false;
        }
    }

    // Funções públicas
    public function isValid(){
        return $this->valid;
    }

    public function sendMessages(Array $stocks){
        if(!$this->isValid()){
            echo "Erro! As configurações são inváliads.";
            return false;
        }

        $currentDate = date("d/m/Y", time()-86400);
        $message = ".....................................................................\n";
        $message = $message."Bom dia, Pedro!\nOlha só os valores das suas ações no dia $currentDate: \n\n";
        foreach($stocks as $stock){
            $temp = $this->getDetails($stock);
            if($temp == false){
                $message = ".....................................................................\n";
                $message = $message."Bom dia, Pedro!\nO dia $currentDate foi um fim de semana ou não teve pregão!\n";
            }
            else 
                $message = $message."Ação: $stock\n".$temp."\n";
        }
        $this->send($message);
        return $temp;
    }


    // Funções auxíliares
    private function makeUrl(string $stock){
        return $this->baseURL . $stock . "&interval=5min&apikey=" . $this->apiKey;
    }

    private function searchDay($response, $currentDate){
        foreach($response as $key => $value){
            if(strcmp($key, "Time Series (Daily)") == 0){
                foreach($value as $dayKey => $days)
                    if(strcmp($dayKey, $currentDate) == 0)
                        return $days;
                    else
                        return false;
            }
        }
    }

    private function responseFilter($response){
        $currentDate = date("Y-m-d", time()-86400);
        // $currentDate = "2021-10-29";
        $detailDay = $this->searchDay($response, $currentDate);
        $message = "";

        if($detailDay != false){
            foreach($detailDay as $key => $day){
                if(strcmp($key, "1. open")==0)
                    $message = $message."Abertura: \tR$".number_format($day, 2, ",", "")."\n";
                if(strcmp($key, "2. high")==0)
                    $message = $message."Máxima: \tR$".number_format($day, 2, ",", "")."\n";
                if(strcmp($key, "3. low")==0)
                    $message = $message."Mínima: \tR$".number_format($day, 2, ",", "")."\n";
                if(strcmp($key, "4. close")==0)
                    $message = $message."Fechamento: \tR$".number_format($day, 2, ",", "")."\n";
            }

            return $message;
        }
        return false;
    }

    private function getDetails(string $stock){
        $query = $this->makeUrl($stock);
        $response = json_decode(file_get_contents($query));
        $details = $this->responseFilter($response);
        if($details != false)
            return $details;
        return false;
    }

    private function send($message){
        $query = "https://api.telegram.org/bot".
                  $this->telegramToken.
                  "/sendMessage?chat_id=".
                  $this->chatID.
                  "&text=".urlencode($message);

        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $query,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}