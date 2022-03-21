<p align="center">
    <h1 align="center">Тестовое задание FXBO</h1>
    <br>
</p>

Установка
------------

Клонировать проект

~~~
git clone https://github.com/StormFromBY/fxbo_test.git .
~~~

Запустить composer, чтобы подтянул все зависимости

~~~
composer install
~~~

### Конвертация

Для того, чтобы выполнить конвертацию нужно перейти в корень проекта и выполнить команду:
~~~
./yii currency/convert --sum=10 --from=EUR --to=USD
~~~
