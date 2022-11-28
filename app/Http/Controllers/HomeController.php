<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tasks = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Authorization" => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7Il9pZCI6IjYzN2NkZjFmNGE2YzM2MTczMTMzYjM1YiIsImVtYWlsIjoic2h5cHJpbmNlMUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IiQyYSQwOCRGUi5zTE9CZzBOdTBLUjBZMS9vNm1PdEUzWHY0T1lhMU5RSGhWNEdaaktOQ1Ztc0czOWo0aSIsIl9fdiI6MH0sImlhdCI6MTY2OTYyNzAwMywiZXhwIjoxNjY5NzEzNDAzfQ.0wNpavQJl1eRWOk2gmqxAwgiMNLLXEwl3_jZnAOpP1s"
        ])->get(env('NODE_SERVER').'/todos?owner='.auth()->user()->uuid.'');

        if ($tasks->successful()) {
            return view('home',['tasks' => $tasks->json()['data']]);
        }

        return view('home', ['tasks' => []]);
    }
}
