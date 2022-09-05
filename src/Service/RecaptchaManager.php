<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RecaptchaManager
{
    private HttpClientInterface $client;
    public const URL = "https://www.google.com/recaptcha/api/siteverify";
    private $secretKey;

    public function __construct(HttpClientInterface $client, $secretKey)
    {
        $this->client = $client;
        $this->secretKey = $secretKey;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchGoogleInformation(string $responseUser): array
    {
        $response = $this->client->request(
            'GET',
            self::URL . "?secret=" . $this->secretKey . "&response=" . $responseUser
        );

        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}