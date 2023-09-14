<?php

/** Namespace */
namespace ParadiseSessions\Cep;

/** Dependencies */
use CurlHandle;
use Exception;
use stdClass;

/**
 * Cep.php
 * @package ParadiseSessions
 * @version 1.0
 * @author Matheus Bastos <matsince1993@yahoo.com>
 */
class Cep
{
    /** @var string */
    private string $base_uri = 'https://viacep.com.br/ws/%s/json';

    /** @var CurlHandle */
    private CurlHandle $curl;

    /** @var null|object */
    private null|object $data = null;

    /** @var Exception */
    private Exception $fail;

    /**
     * @param string $base_uri
     * @return void
     */
    public function setBaseUri(string $base_uri): void
    {
        $this->base_uri = $base_uri;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->data->$name ?? null;
    }

    /**
     * @return null|object
     */
    public function data(): null|object
    {
        return $this->data;
    }

    /**
     * @return Exception
     */
    public function fail(): Exception
    {
        return $this->fail;
    }

    /**
     * @return void
     */
    private function init(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $this->curl = $curl;
    }

    /**
     * @param string $cep
     * @return bool
     */
    public function consult(string $cep): bool
    {
        try {
            $endpoint = sprintf($this->base_uri, $this->clear($cep));
            $this->init();

            curl_setopt($this->curl, CURLOPT_URL, $endpoint);
            $response = curl_exec($this->curl);
            $http_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
            curl_close($this->curl);

            $body = json_decode($response);

            if ($http_code != 200 || isset($body->erro)) {
                throw new Exception("Bad request! Verify CEP [{$cep}] and try again.", $http_code);
            }

            $data = new stdClass();
            $data->cep = $this->clear($body->cep);
            $data->address = $body->logradouro ?? null;
            $data->complement = $body->complemento ?? null;
            $data->city = $body->bairro ?? null;
            $data->locality = $body->localidade ?? null;
            $data->state = $body->uf ?? null;
            $data->ddd = $body->ddd ?? null;
            $data->ibge_code = $body->ibge ?? null;
            $data->municipal_code = $body->siafi ?? null;
            $data->gia = $body->gia ?? null;

            $this->data = $data;

            return true;
        } catch (Exception $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @return string
     */
    public function format(): false|string
    {
        if (isset($this->cep)) {
            return false;
        }

        $result = substr($this->cep, 0, 5) . '-';
        $result .= substr($this->cep, 5, 9);

        return $result;
    }

    /**
     * @return string
     */
    public function completeAddress(): string
    {
        return "{$this->address} {$this->complement}, {$this->city} - {$this->state}";
    }

    /**
     * @param string $cep
     * @return string
     */
    private function clear(string $cep): string
    {
        $cep = filter_var($cep);
        return preg_replace('/[^0-9]/', '', $cep);
    }
}
