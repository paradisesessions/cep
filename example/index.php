<?php

// Autoload
require dirname(__DIR__, 1) . '/vendor/autoload.php';

// Init class
$cep = new \ParadiseSessions\Cep\Cep();

// Verify success consult
if (!$cep->consult('04538-133')) {
    // Or show error
    exit($cep->fail()->getMessage());
}

/** Show data object */
var_dump($cep->data());

/** Make address */
echo "<p>Address: {$cep->completeAddress()}</p>";
/** Show formatted zip code */
echo "<p>Zip code: {$cep->format()}";
