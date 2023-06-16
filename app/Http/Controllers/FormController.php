<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FormController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = $this->createClient();
    }

    public function form(Request $request): void {
    }

    /**
     * @return Client
     */
    protected function createClient()
    {
        $BASE_URI = 'http://127.0.0.1:8001/calculate';

        return new Client([
            'base_uri'      => $BASE_URI,
            'timeout'       => 30.0,
            'verify'        => false,
            'http_errors'   => false,
            'connect_timeout' => false,
        ]);
    }
}
