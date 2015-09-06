<?php namespace Sukonovs\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * Response object
 *
 * @author Roberts Sukonovs <roberts@efumo.lv>
 * @package Sukonovs\Http
 */
class Response
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Class constructor
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Ok response
     *
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    public function ok($content = '', $headers = []) {

        return $this->respond('200', $content, $headers);
    }

    /**
     * Internal error response
     *
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    public function internalError($content = '', $headers = []) {

        return $this->respond('500', $content, $headers);
    }

    /**
     * Not found response
     *
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    public function notFound($content = '', $headers = [])
    {
        return $this->respond('404', $content, $headers);
    }

    /**
     * Not allowed response
     *
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    public function notAllowed($content = '', $headers = [])
    {
        return $this->respond('405', $content, $headers);
    }

    /**
     * Forbidden response
     *
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    public function forbidden($content = '', $headers = [])
    {
        return $this->respond('403', $content, $headers);
    }

    /**
     * Respond with appropriate response
     *
     * @param string $code
     * @param string $content
     * @param array $headers
     * @return JsonResponse|BaseResponse
     */
    private function respond($code, $content = '', $headers = [])
    {
        return $this->request->ajax()
            ? new JsonResponse($content, $code, $headers)
            : new BaseResponse($content, $code, $headers);
    }
}