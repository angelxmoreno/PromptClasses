<?php

declare(strict_types=1);

namespace PromptClasses\Test\Helpers;

use PromptClasses\Core\AbstractPrompt;

class HelloPrompt extends AbstractPrompt
{
    public string $promptTpl = 'Say "Hello {{name}}. Good {{time_of_day}}"';
    public array $promptParams = ['name', 'time_of_day'];
}
