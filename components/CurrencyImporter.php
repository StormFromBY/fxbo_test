<?php

namespace app\components;

use app\interfaces\RatesInterface;

class CurrencyImporter{
    public $list = [];
    public $currency;
    public $sources = [];

    public function __construct(Currency $currency, array $sources){
        $this->currency = $currency;

        foreach ($sources as $source){
            if($source instanceof RatesInterface){
                $this->sources[] = $source;
            }
        }
    }

    public function import(){
        /**
         * @var $source RatesInterface
         */

        foreach ($this->sources as $source){
            $source->import();
        }
    }

    public function normalize(){
        // За основу берем, что ECB у нас будет как данные по-умолчанию
        // Приводим все данные к единому стандарту в валюте EUR
        $normalized = [];

        $normalized = array_merge($normalized, $this->currency->list['EUR']);
        $normalized['EUR'] = 1;

        unset($this->currency->list['EUR']);

        foreach ($this->currency->list as $parentCurrency => $currenciesList){

            // Делаем конвертацию родительской валюты
            foreach ($currenciesList as $currencyName => $currencyRate){
                if(!isset($normalized[$parentCurrency]) && isset($normalized[$currencyName])){
                    $normalized[$parentCurrency] =  number_format($normalized[$currencyName] / $currencyRate, 10);
                }
            }

            // Проверяем есть ли родительская валюта для конвертации дочерних
            if(isset($normalized[$parentCurrency])){
                // Делаем конвертацию дочерних валют
                foreach ($currenciesList as $currencyName => $currencyRate){
                    if(!isset($normalized[$currencyName])){
                        $normalized[$currencyName] = $currencyRate / $normalized[$parentCurrency];
                    }
                }
            }else{
                echo "Нет возможности сконвертировать валюту " . $parentCurrency . ' в EUR.' . PHP_EOL;
            }
        }

        $this->currency->list = $normalized;

    }

}