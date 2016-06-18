<?php
namespace Codex\Addon\Jira;

class Jira
{
    /** @var Api\Api */
    protected $api;

    /**
     * connect method
     * @return \GuzzleHttp\Client
     */
    public function connect()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://projects.radic.nl/rest/api/2',
            'auth'     => [ config('codex-jira.username'), config('codex-jira.password') ],
        ]);

        $r = $client->get('myself');
        return $client;
    }


}