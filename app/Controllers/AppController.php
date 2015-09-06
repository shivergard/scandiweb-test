<?php

namespace ScandiWebTest\Controllers;

use Sukonovs\Http\Controller;
use Sukonovs\Views\View;

class AppController extends Controller
{

    /**
     * Class constructor
     *
     * @param View $view
     */
    public function __construct(View $view) {
        $this->view = $view;
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return $this->view->render('app');
    }
}
