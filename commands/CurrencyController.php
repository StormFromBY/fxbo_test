<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class CurrencyController extends Controller
{
    public $from;
    public $to;
    public $sum;

    public function options()
    {
        return ['from', 'to', 'sum'];
    }

    public function actionConvert()
    {
        $currency = Yii::$container->get('app\components\Currency');

        $importer = Yii::$container->get('app\components\CurrencyImporter', [
            $currency,
            [
                Yii::$container->get('app\components\Coindesk', [$currency]),
                Yii::$container->get('app\components\Ecb', [$currency])
            ]
        ]);

        // Импортируем курсы валют из всех источников указанных выше
        $importer->import();

        // Приводим все к EUR
        $importer->normalize();

        // Выполняем конвертацию
        echo $currency->getCurrency($this->sum, $this->from, $this->to);
    }
}
