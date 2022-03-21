<?php

namespace app\components;
use app\interfaces\RatesInterface;
use yii\base\Exception;

class Coindesk implements RatesInterface {

    private $url = "https://api.coindesk.com/v1/bpi/historical/close.json";
    public $sourceCurrency;
    public $currency;

    public function __construct(Currency $currency, $sourceCurrency = "BTC"){
        $this->sourceCurrency = $sourceCurrency;
        $this->currency = $currency;
    }

    public function import(){
        try {
            $file = json_decode(file_get_contents($this->url), true);

            # Count day valid
            $dayValid = 3;

            if(count($file['bpi'])){
                for ($i = 0; $i < $dayValid; $i++){
                    $date = date('Y-m-d', strtotime("-{$i} day"));

                    if(isset($file['bpi'][$date])){
                        $this->currency->list[$this->sourceCurrency]['USD'] = $file['bpi'][$date];
                        break;
                    }
                }
            }

        }catch (Exception $exception){
            echo "Coindesk parse Error" . PHP_EOL .$exception;
        }
    }

}