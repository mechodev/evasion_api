<?php

namespace App\Http\Controllers\Project;

use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HistoryResource;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $histories = History::all();
        return response()->json([
            'histories' => HistoryResource::collection($histories),
            'success' => true,
            'message' => 'Retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 'author') {
            $validatedData =  Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'chapter' => ['required', 'integer'],
                'category_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $history = History::create([
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'chapter' => $request['chapter'],
                    'category_id' => $request['category_id'],
                    'user_id' => auth()->user()->id,
                ]);

                return response()->json([
                    'history' => $history,
                    'success' => true,
                    'message' => 'History successfully created'
                ]);
            };
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        return response([
            'history' => new HistoryResource($history),
            'message' => 'Retrieved successfully'
        ]);

        /* $history = History::find($history); 
        return response()->json([
            'history' => $history,
            'success' => true,
            'message' => 'Retrieved successfully'
        ]);*/
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        $role = Auth::user()->role;
        if ($role == 'author') {
            $validatedData =  Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'chapter' => ['required', 'integer'],
                'category_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {
                $success = $history->update($request->all());

                return response([
                    'history' => new HistoryResource($history),
                    'success' => $success,
                    'message' => 'Update successfully'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        $role = Auth::user()->role;
        if ($role == 'author') {
            $success = $history->delete();

            return response([
                'success' => $success,
                'message' => 'Deleted'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }
}
