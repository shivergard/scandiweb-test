<?php

namespace ScandiWebTest\Http\Controllers;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('app');
    }
}
