<?php

test('avoid dd, dump, ray, ds, sleep')
    ->expect(['dump', 'var_dump', 'dd', 'ray', 'ds', 'sleep'])
    ->not->toBeUsed();
