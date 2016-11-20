<?php namespace AppBundle\Client;

use AppBundle\Exception\RequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

class Http
{
    protected $client;

    /**
     * Http constructor.
     * @param array $guzzle
     */
    public function __construct(array $guzzle)
    {
        $this->client = new Client([
            'timeout'         => $guzzle['timeout'],
            'connect_timeout' => $guzzle['connect_timeout'],
            'redirect_allow' => true,
            'cookies' => true
        ]);
    }

    /**
     * @param Request $request
     * @param array $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws RequestException
     */
    public function send(Request $request, $data = [])
    {
        try {
            $response = $this->client->send($request, $data);
        } catch (ClientException $e) {
            throw new RequestException($request->getUri() . ' ' . $e->getMessage());
        } catch (ServerException $e) {
            throw new RequestException($request->getUri() . ' ' . json_encode($data) . ' ' . $e->getResponse()->getBody()->getContents());
        } catch (\Exception $e) {
            throw new RequestException($request->getUri() . ' ' . json_encode($data) . ' ' . $e->getMessage());
        }

        return $response;
    }
}