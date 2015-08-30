<?php

namespace ScandiWebTest\Http\Controllers;


use Log;
use PDOException;
use ScandiWebTest\Task;
use Illuminate\Http\Request;
use ScandiWebTest\Http\Requests;
use Illuminate\Http\JsonResponse;
use ScandiWebTest\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return Task::orderBy('id', 'desc')->paginate(config('timelog.itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request)
    {
        try {
            $task = Task::create($request->all());
        } catch(PDOException $e) {
            Log::error(
                'Task save failed',
                ['input' => json_encode($request->all()), 'error' => json_encode($e)]
            );

            abort(500);
        }

        return response()->json($task);
    }

}
