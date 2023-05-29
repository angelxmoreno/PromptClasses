<?php

declare(strict_types=1);

use PromptClasses\Adder;

describe(Adder::class, function () {
    describe('::add', function () {
        it('adds integers', function () {
            expect(Adder::add(1, 2))->toBe(3);
        });
    });
});
