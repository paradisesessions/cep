<?php

test('tests whether the zip code is valid', function () {
    $cep = new \ParadiseSessions\Cep\Cep();
    $test = $cep->consult('12345-678');
    expect($test)->not->toBeTrue();
    expect($cep->fail()->getCode())->toBe(200);

    $test = $cep->consult('123123123123123123');
    expect($cep->fail()->getCode())->toBe(400);
});

test('tests a valid zip code', function () {
    $cep = new \ParadiseSessions\Cep\Cep();
    $test = $cep->consult('04538133');
    expect($test)->toBeTrue();
    expect($cep->format())->toBe('04538-133');

    expect($cep->data())->toMatchObject([
        'cep' => '04538133',
        'city' => 'Itaim Bibi',
        'locality' => 'São Paulo',
    ]);
});

test('test show complete address', function () {
    $cep = new \ParadiseSessions\Cep\Cep();
    $cep->consult('04538-133');

    $address = 'Avenida Brigadeiro Faria Lima de 3253 ao fim - lado ímpar, Itaim Bibi - SP';

    expect($cep->completeAddress())->toBe($address);
});
