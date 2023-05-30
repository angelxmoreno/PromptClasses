<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use PromptClasses\Core\AbstractPrompt;
use PromptClasses\Test\Helpers\Fixture;
use PromptClasses\Test\Helpers\HelloPrompt;

describe(AbstractPrompt::class, function () {
    describe('->send', function () {
        it('returns null on failure value', function () {
            $prompter = new HelloPrompt('');

            allow($prompter)
                ->toReceive('sendToOpenAI')
                ->andRun(function () {
                    throw new Exception();
                });

            $response = $prompter->send('Bob', 'Evening');
            expect($response)->toBeNull();
        });

        it('returns expected value', function () {
            $prompter = new HelloPrompt('');

            allow($prompter)
                ->toReceive('callOpenAI')
                ->andReturn(Fixture::load('openaiResponse'));

            $response = $prompter->send('Bob', 'Evening');
            expect($response)->toBe('Hello Bob. Good Evening');
        });
    });
});
