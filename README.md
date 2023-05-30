# PromptClasses
ChatGpt reusable objects

## Installation
```shell
composer require angelxmoreno/prompt-classes
```

## Getting started
First thing you will need to get started is an OpenAI api key. 

### Getting an OpenAI Api Key
To get started, visit the official OpenAI platform website. If you're new, create an account using simple steps. Next, sign in using your OpenAI account email and password, or use your Google/Microsoft account.
Once logged in, you'll find your name and profile icon on the top-right corner of the OpenAI platform homepage.
To obtain an API Key, click on your name in the top-right corner for a dropdown menu, and select "View API keys."
On the resulting page, find the "Create new secret key" option in the center. If you don't have an API key, click this button to generate one. Remember to save the API key immediately, as you won't be able to retrieve it once the window closes.

### Simple Hello Prompt
1. Create a PromptClass

    ```php
    <?php
    
    declare(strict_types=1);
    
    namespace YourNamespace\Prompts;
    
    use PromptClasses\Core\AbstractPrompt;
    
    class HelloPrompt extends AbstractPrompt
    {
        public string $promptTpl = 'Say "Hello {{name}}. Good {{time_of_day}}"';
        public array $promptParams = ['name', 'time_of_day'];
    }
    ```

2. Instantiate and send
    ```php
    $helloPrompt = new HelloPrompt($openaiApiKey);
    $response = $helloPrompt->send('John', 'Morning');
    // returns `Hello John. Good Morning`
    ````
    The order of params is the order of the `$promptParams` array. This means that if you change the `$promptParams` for
    the `HelloPrompt` class to `['time_of_day','name'];`, you would have to call `->send()` like so:
    ```php
    $response = $helloPrompt->send('Morning', 'John');
    // still returns `Hello John. Good Morning`
    ```
### SEO Meta DescriptionPrompt
1. Create a PromptClass

    ```php
    <?php
    
    declare(strict_types=1);
    
    namespace YourNamespace\Prompts;
    
    use PromptClasses\Core\AbstractPrompt;
    
    class MetaDescriptionPrompt extends AbstractPrompt
    {
        public string $promptTpl = 'Write a meta description no longer than 160 characters including spaces for a product page with the title "{{title}}"';
        public array $promptParams = ['title'];
    }
    ```

2. Instantiate and send
    ```php
    $metaDescriptionPrompt = new MetaDescriptionPrompt($openaiApiKey);
    $response = $metaDescriptionPrompt->send('Supernatural Dean Winchester That was Scary Vintage Sunset T-Shirt');
    // returns `Get the Supernatural Dean Winchester 'That was Scary' Vintage Sunset T-Shirt. Show your love for the hit TV show with this iconic design.`
    ````
   
## Configuration
Under the hood the library uses [orhanerday/open-ai](https://github.com/orhanerday/open-ai).
The default configuration for the calls to OpenAI Chat Completions are:

| Name         | Current Value | Info                                                                                                                                                                                  |
|--------------|---------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| model        | gpt-3.5-turbo | ID of the model to use. See [Model overview](https://platform.openai.com/docs/models/models) for descriptions of them.                                                                |
| temperature  | 1             | What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.  |

To discover more options available take a look at the official documentation for the [chat completions endpoint](https://platform.openai.com/docs/api-reference/chat/create).
Values can be updated for your PromptClass by extending the `$openaiParams` property of the `AbstractPrompt` class like so:
```php
    <?php
    
    declare(strict_types=1);
    
    namespace YourNamespace\Prompts;
    
    use PromptClasses\Core\AbstractPrompt;
    
    class MetaDescriptionPrompt extends AbstractPrompt
    {
        public string $promptTpl = 'Write a meta description no longer than 160 characters including spaces for a product page with the title "{{title}}"';
        public array $promptParams = ['title'];
        
        protected array $openaiParams = [
            'model' => 'gpt-3.5-turbo',
            'temperature' => 0.2,
            'frequency_penalty' => 1.8
        ];
    }
```

## Requirements
PHP 7.4+

## Support
For bugs and feature requests, please use the [issues](https://github.com/angelxmoreno/PromptClasses/issues) section of this repository.

# License
Licensed under the MIT License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.