<?php

namespace LeadsHub;

class Hub
{
    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var string
     */
    protected $endpoint = '';

    public function __construct(array $settings = [])
    {
        $this->setApiKey($settings['apiKey'] ?? '');
        $this->setEndpoint($settings['endpoint'] ?? '');
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $data
     * @return mixed
     */
    protected function parse($data)
    {
        return json_decode($data, true);
    }

    protected function post($url, array $data = [])
    {
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($request);
        curl_close($request);

        return $response;
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendLead(array $data)
    {
        $url = $this->getEndpoint() . 'leads';
        $response = $this->post($url, $data);

        return $this->parse($response);
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
