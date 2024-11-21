<?php

namespace App\Services;

use Google\Client;
use GuzzleHttp\Client as HttpClient;

class FirebaseService
{
    protected $projectId;
    protected $baseUrl;
    protected $httpClient;
    protected $token;

    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        $this->baseUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/";
        $this->httpClient = new HttpClient();
        $this->token = $this->generateToken();
    }

    private function generateToken()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('firebase/service-account.json'));
        $client->addScope(env('FIREBASE_SCOPE'));
        return $client->fetchAccessTokenWithAssertion()['access_token'];
    }

    public function makeRequest(string $method, string $url, array $data = [])
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ],
        ];

        if (!empty($data)) {
            $options['json'] = $data;
        }

        $response = $this->httpClient->request($method, $this->baseUrl . $url, $options);

        return json_decode($response->getBody(), true);
    }

    public function createDocument(string $collection, array $data)
    {
        return $this->makeRequest('POST', "{$collection}", $data);
    }

    public function getDocuments(string $collection)
    {
        return $this->makeRequest('GET', "{$collection}");
    }

    public function updateDocument(string $collection, string $documentId, array $data)
    {
        return $this->makeRequest('PATCH', "{$collection}/{$documentId}", $data);
    }
    
    public function updateOrCreateDocument(string $collection, string $documentId, array $data)
{
    try {
        // Attempt to update the document
        return $this->updateDocument($collection, $documentId, $data);
    } catch (\Exception $e) {
        // If the document does not exist, create it
        if (str_contains($e->getMessage(), 'NOT_FOUND')) {
            return $this->makeRequest('POST', "{$collection}?documentId={$documentId}", $data);
        }

        // Re-throw other exceptions
        throw $e;
    }
}


    public function deleteDocument(string $collection, string $documentId)
    {
        return $this->makeRequest('DELETE', "{$collection}/{$documentId}");
    }
}
