<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $valid = $request->validate([
                'title' => 'required|string'
            ]);

            $valid['owner'] = auth()->user()->uuid;

            $tasks = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7Il9pZCI6IjYzN2NkZjFmNGE2YzM2MTczMTMzYjM1YiIsImVtYWlsIjoic2h5cHJpbmNlMUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IiQyYSQwOCRGUi5zTE9CZzBOdTBLUjBZMS9vNm1PdEUzWHY0T1lhMU5RSGhWNEdaaktOQ1Ztc0czOWo0aSIsIl9fdiI6MH0sImlhdCI6MTY2OTEzMzYxMSwiZXhwIjoxNjY5MjIwMDExfQ.yiFUMGjBcq93TB2tOo5zzfCqbnYL92dzddQ0JvqN_qc"
            ])->post(env('NODE_SERVER') . '/todos/create', $valid);

            if ($tasks->successful()) {
                return back()->with('success', 'Task Created!');
            }

            return back()->with('warning', 'Could not create task');
        } catch (\Exception $e) {
            return back()->with('warning', $e->getMessage());
        }

    }

    public function edit($taskId)
    {
        $task = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Authorization" => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7Il9pZCI6IjYzN2NkZjFmNGE2YzM2MTczMTMzYjM1YiIsImVtYWlsIjoic2h5cHJpbmNlMUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IiQyYSQwOCRGUi5zTE9CZzBOdTBLUjBZMS9vNm1PdEUzWHY0T1lhMU5RSGhWNEdaaktOQ1Ztc0czOWo0aSIsIl9fdiI6MH0sImlhdCI6MTY2OTEzMzYxMSwiZXhwIjoxNjY5MjIwMDExfQ.yiFUMGjBcq93TB2tOo5zzfCqbnYL92dzddQ0JvqN_qc"
        ])->get(env('NODE_SERVER') . '/todos/todo/'.$taskId);

        if ($task->successful()) {
            return response()->json($task->json()['data'],200);
        }

        return response()->json([],400);

    }

    public function update(Request $request, $taskId)
    {
        try {
            $task = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7Il9pZCI6IjYzN2NkZjFmNGE2YzM2MTczMTMzYjM1YiIsImVtYWlsIjoic2h5cHJpbmNlMUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IiQyYSQwOCRGUi5zTE9CZzBOdTBLUjBZMS9vNm1PdEUzWHY0T1lhMU5RSGhWNEdaaktOQ1Ztc0czOWo0aSIsIl9fdiI6MH0sImlhdCI6MTY2OTEzMzYxMSwiZXhwIjoxNjY5MjIwMDExfQ.yiFUMGjBcq93TB2tOo5zzfCqbnYL92dzddQ0JvqN_qc"
            ])->put(env('NODE_SERVER') . '/todos/edit/' . $taskId,[
                'title' => $request->title
            ]);

            if ($task->successful()) {
                return back()->with('success', 'Task Updated!');
            }

            return back()->with('warning', 'Could not update task');
        } catch (\Exception $e) {
            return back()->with('warning', $e->getMessage());
        }

    }

    public function destroy($taskId)
    {
        try {
            $task = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7Il9pZCI6IjYzN2NkZjFmNGE2YzM2MTczMTMzYjM1YiIsImVtYWlsIjoic2h5cHJpbmNlMUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IiQyYSQwOCRGUi5zTE9CZzBOdTBLUjBZMS9vNm1PdEUzWHY0T1lhMU5RSGhWNEdaaktOQ1Ztc0czOWo0aSIsIl9fdiI6MH0sImlhdCI6MTY2OTEzMzYxMSwiZXhwIjoxNjY5MjIwMDExfQ.yiFUMGjBcq93TB2tOo5zzfCqbnYL92dzddQ0JvqN_qc"
            ])->delete(env('NODE_SERVER') . '/todos/delete/' . $taskId);

            if ($task->successful()) {
                return back()->with('success', 'Task Deleted!');
            }

            return back()->with('warning', 'Could not delete task');
        } catch (\Exception $e) {
            return back()->with('warning', $e->getMessage());
        }
    }
}
