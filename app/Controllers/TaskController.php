<?php

namespace ScandiWebTest\Controllers;

use PDOException;
use Sukonovs\Http\Request;
use Sukonovs\Http\Response;
use ScandiWebTest\Task\Task;
use Sukonovs\Http\Controller;
use Sukonovs\Pagination\ArrayPaginator;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var ArrayPaginator
     */
    private $paginator;

    /**
     * Class constructor
     *
     * @param Request $request
     * @param Task $task
     * @param Response $response
     * @param ArrayPaginator $paginator
     */
    public function __construct(
        Request $request,
        Task $task,
        Response $response,
        ArrayPaginator $paginator
    ) {
        $this->request = $request;
        $this->task = $task;
        $this->response = $response;
        $this->paginator = $paginator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $tasks = $this->task->orderBy('id', 'desc')->get();

        $content = $this->paginator->make($tasks);

        return $this->response->ok($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store()
    {
        try {
            $task = $this->task->create($this->request->all());
        } catch(PDOException $e) {

            return $this->response->internalError();
        }

        return $this->response->ok($task);
    }
}
