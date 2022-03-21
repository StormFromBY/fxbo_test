<?php

namespace app\components;
use app\interfaces\RatesInterface;
use SimpleXMLElement;
use yii\base\Exception;

class Ecb implements RatesInterface {

    private $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
    public $sourceCurrency;
    public $currency;

    public function __construct(Currency $currency, $sourceCurrency = "EUR"){
        $this->sourceCurrency = $sourceCurrency;
        $this->currency = $currency;
    }

    public function import(){
        try {
            $file = file_get_contents($this->url);

            $xml = new SimpleXMLElement($file);
            #$time = (string)$xml->Cube->Cube->attributes()->time;

            foreach ($xml->Cube->Cube->Cube as $currency){
                if((string)$currency->attributes()->currency && (float)$currency->attributes()->rate){
                    $this->currency->list[$this->sourceCurrency][(string)$currency->attributes()->currency] = (float)$currency->attributes()->rate;
                }
            }
        }catch (Exception $exception){
            echo "ECB parse Error" . PHP_EOL .$exception;
        }
    }

}