<?php

namespace LaraDevs\AuthRemote;

use Illuminate\Contracts\Auth\UserProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;

class RestUserProvider implements UserProvider
{
    protected $uri;
    protected $headers = [
        'Accept' => 'application/json',
    ];
    protected $hash;
    protected $model;
    protected $cache;
    protected $cacheTtl;

    public function __construct(array $config, Hasher $hash, $cache)
    {
        $this->uri = $config['uri'];
        $this->headers = array_merge($this->headers, $config['headers']);
        $this->hash = $hash;
        $this->model = $config['model'];
        $this->cache = $cache;
        $this->cacheTtl = array_key_exists('cache_ttl', $config) ? $config['cache_ttl'] : 10;
    }

    /**
     * @param $credentials
     * @return mixed|null
     */
    public function fetchUsers($credentials)
    {
        $client = new Client([
            'allow_redirects' => false,
            'headers' => $this->headers,
        ]);

        try {
            $response = $client->get(
                $this->uri,
                ['query' => http_build_query($credentials)]
            );
        } catch (ClientException $exception) {
            logger()->critical($exception->getMessage(), $this->headers);

            return null;
        }

        $data = \GuzzleHttp\json_decode($response->getBody(), true);
        $data = array_key_exists('data', $data) ? $data['data'] : $data;
        return new $this->model($data);
    }

    /**
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->fetchUsers(['id' => $identifier]);
    }

    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|void|null
     */
    public function retrieveByToken($identifier, $token)
    {
    }

    /**
     * @param Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->fetchUsers($credentials);
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->hash->check($credentials['password'], $user->getAuthPassword());
    }
}
