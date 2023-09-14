<h1 align="center">
    <img alt="Paradise Sessions" title="Paradise Sessions" src=".github/logo.png" width="300" />
</h1>

<p align="center">
    <a href="#installation">Installation</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="#technologies">Technologies</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="#using">Using</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="#tests">Tests</a>
</p>

<p align="center">
   <img src="https://img.shields.io/badge/php-%5E8.1-green?style=for-the-badge" alt="Version" />
   <img src="https://img.shields.io/badge/version-1.0-red?style=for-the-badge" alt="PHP Version" />
   <img src="https://img.shields.io/badge/license-MIT-blue?style=for-the-badge" alt="License" />
</p>

## Project

##### Simple class for zip code query in the [ViaCEP](https://viacep.com.br/) public API.

Classe simples para consulta de CEP na api publica do [ViaCEP](https://viacep.com.br/).

## Installation

###### By [Composer](https://getcomposer.org/)

Via [Composer](https://getcomposer.org/)

```shell
composer require paradisesessions/cep
```

## Technologies

-   [PHP 8.1](https://www.php.net/downloads.php#v8.1.18)
-   [Pest | PHP testing framework](https://pestphp.com/)

## Using

###### Example of use for a simple query.

Exemplo de uso para uma simples consulta.

```php
$cep = new \ParadiseSessions\Cep\Cep();
if (!$cep->consult('04538133')) {
    echo $cep->fail()->getMessage();
}

print_r($cep->data());

echo $cep->format();
```

###### \*you can pass the formatted zip code and it will work.

Pode passar o CEP formatado que funcionará.

## Tests

###### Test class with [Pest](https://pestphp.com/).

Testes na classe realizados com [Pest](https://pestphp.com/).

```shell
composer test
```
