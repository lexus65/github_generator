<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;


/**
 * Class GitHubService
 * @package AppBundle\Service
 */
class GitHubService
{

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var string
     */
    private $gitHubApiBaseUrl = 'https://api.github.com';

    /**
     * GitHubService constructor.
     */
    public function __construct()
    {
        $this->guzzle = new Client();
    }

    /**
     * @param string $usermane
     * @return bool|\Psr\Http\Message\StreamInterface
     */
    public function getUserByUsername(string $usermane)
    {

        $url = $this->gitHubApiBaseUrl . '/users/' . $usermane;
        $res = $this->guzzle->request('GET', $url);

        if ($res->getStatusCode() == 200)
            return $res->getBody()->getContents();

        return false;
    }

    /**
     * @param string $url
     * @return bool|string
     */
    public function get(string $url)
    {
        $res = $this->guzzle->request('GET', $url);

        if ($res->getStatusCode() == 200)
            return $res->getBody()->getContents();

        return false;
    }

    public function calculateProgrammingLanguages(array $repositories)
    {
        $data = [];
        foreach ($repositories as $repository){
            if(!$repository['language'])
                continue;
            $data[$repository['language']] = $repository['size'];
        }
        return $data;
    }
}