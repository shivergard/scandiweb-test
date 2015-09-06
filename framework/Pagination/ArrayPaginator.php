<?php

namespace Sukonovs\Pagination;

use Sukonovs\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Array data paginator
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package Sukonovs\Pagination
 */
class ArrayPaginator
{
    /**
     * Items per page
     *
     * @var int
     */
    private $perPage = 15;

    /**
     * @var Request
     */
    private $request;

    /**
     * Class construtor
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Make paginator
     *
     * @param Collection $collection
     * @return array
     */
    public function make(Collection $collection)
    {
        $page = $this->request->get('page') ?: 1;

        return (new LengthAwarePaginator(
            $this->getPageItems($collection, $page), $collection->count(), 15, $page)
        )->toArray();
    }

    /**
     * Get results for page
     *
     * @param Collection $collection
     * @param $page
     * @return array
     */
    private function getPageItems(Collection $collection, $page)
    {
        return $collection->slice(($page - 1) * $this->perPage, $this->perPage)->all();
    }
}