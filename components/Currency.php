<?php

namespace app\components;

class Currency{
    public $list = [];
    public $sources = [];

    public function __construct(){}

    public function getCurrency($sum, $currencyFrom, $currencyTo){

        if(isset($this->list[$currencyFrom]) && isset($this->list[$currencyTo])){
            return  "{$sum} {$currencyFrom} = " . number_format($this->list[$currencyTo] / $this->list[$currencyFrom] * $sum, 10). " {$currencyTo}" . PHP_EOL;
        }else{
            if(!isset($this->list[$currencyFrom])){
                return "Валюта {$currencyFrom} недоступна для конвериации. \n";
            }

            if(!isset($this->list[$currencyTo])){
                return "Валюта {$currencyTo} недоступна для конвериации. \n";
            }
        }
    }

}