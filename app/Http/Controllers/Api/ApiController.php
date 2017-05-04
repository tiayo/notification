<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get()
    {
        var_dump($this->request->user()->toArray());
    }

    public function post()
    {
        var_dump($this->request->all());
    }
}