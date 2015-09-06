<?php

namespace Sukonovs\Http;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Request class
 *
 * @author Roberts Sukonovs <roberts@efumo.lv>
 */
class Request extends BaseRequest
{
    /**
     * Checks if request is ajax
     *
     * @return bool
     */
    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * Get all input from request
     *
     * @return array
     */
    public function all()
    {
        return $this->getInputSource()->all() + $this->query->all();
    }


    /**
     * Get input based on it's source
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected function getInputSource()
    {
        if ($this->isJson()) {

            return $this->json();
        }

        return $this->getMethod() == 'GET' ? $this->query : $this->request;
    }

    /**
     * Check if request is json
     *
     * @return bool
     */
    public function isJson()
    {
        return Str::contains($this->headers->get('CONTENT_TYPE'), '/json');
    }

    /**
     * Get the JSON payload for the request.
     *
     * @return mixed
     */
    public function json()
    {
        if (!isset($this->json)) {
            $this->json = new ParameterBag((array)json_decode($this->getContent(), true));
        }

        return $this->json;
    }
}