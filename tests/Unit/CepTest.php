<?php

/** Dependencies */
use ParadiseSessions\Cep\Cep;

test('tests whether the zip code is valid', function () {
    $cep = new Cep();
    $test = $cep->consult('12345-678');
    expect($test)->not->toBeTrue();
    expect($cep->fail()->getCode())->toBe(200);

    $test = $cep->consult('123123123123123123');
    expect($cep->fail()->getCode())->toBe(400);
});

test('tests a valid zip code', function () {
    $cep = new Cep();
    $test = $cep->consult('04538133');
    expect($test)->toBeTrue();
    expect($cep->format())->toBe('04538-133');

    expect($cep->data())->toMatchObject([
        'cep' => '04538133',
        'city' => 'Itaim Bibi',
        'locality' => 'São Paulo',
    ]);
});
