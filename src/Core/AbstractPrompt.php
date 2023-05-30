<?php

/**
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace PromptClasses\Core;

use Cake\Utility\Hash;
use Exception;
use Orhanerday\OpenAi\OpenAi;
use Throwable;
use UnexpectedValueException;

abstract class AbstractPrompt
{
    protected string $openaiApiKey;

    protected ?OpenAi $openaiClient = null;

    protected string $promptTpl = '';
    protected array $promptParams = [];
    protected array $openAIParams = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 1.0,
    ];

    public function __construct(string $openaiApiKey)
    {
        $this->openaiApiKey = $openaiApiKey;
        $this->assertTrueOrThrow(is_string($this->getPromptTpl()), '"$promptTpl" must be a string');
        $this->assertTrueOrThrow(trim($this->getPromptTpl()) <> '', '"$promptTpl" can not be empty');
        $this->assertTrueOrThrow(!empty($this->getPromptParams()), '"$promptParams" can not be empty');
    }


    protected function assertTrueOrThrow(bool $bool, string $message): void
    {
        assert($bool, new UnexpectedValueException($message));
    }

    public function send(...$args): ?string
    {
        $prompt = $this->buildPromptFromArgs($args);
        try {
            return $this->sendToOpenAI($prompt);
        } catch (Throwable $exception) {
            return null;
        }
    }

    protected function getPromptTpl(): string
    {
        return $this->promptTpl;
    }


    protected function getPromptParams(): array
    {
        return $this->promptParams;
    }

    /**
     * @throws Exception
     */
    protected function sendToOpenAI(string $prompt): ?string
    {
        $params = $this->openAIParams;

        $params['messages'] = [
            ['role' => 'user', 'content' => $prompt],
        ];
        $response = $this->callOpenAI($params);

        return Hash::get($response, 'choices.0.message.content');
    }

    /**
     * @throws Exception
     */
    protected function callOpenAI(array $params): array
    {
        $responseJson = $this->getOpenaiClient()->chat($params);
        return json_decode($responseJson, true);
    }

    protected function buildPromptFromArgs(array $args): string
    {
        $params = $this->mergeArgsParams($args);
        $replacements = array_map(fn(string $param) => "{{{$param}}}", $this->getPromptParams());
        return str_replace($replacements, $params, $this->getPromptTpl());
    }

    protected function mergeArgsParams(array $args)
    {
        return array_combine($this->getPromptParams(), $args);
    }

    protected function getOpenaiClient(): ?OpenAi
    {
        if (is_null($this->openaiClient)) {
            $this->openaiClient = new OpenAi($this->openaiApiKey);
        }
        return $this->openaiClient;
    }
}
