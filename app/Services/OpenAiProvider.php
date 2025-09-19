<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAiProvider
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'https://api.groq.com/openai/v1';
        $this->apiKey = config('services.groq.key');

    }

    public function chat(array $messages, int $maxTokens = 512, float $temperature = 0.7): string
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/chat/completions", [
                'model' => 'llama-3.1-8b-instant',
                'messages' => $messages,
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
            ]);

        if ($response->failed()) {
            throw new \Exception('Groq API error: ' . $response->body());
        }

        return $response->json('choices.0.message.content') ?? '';
    }
}
