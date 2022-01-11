<?php

namespace App\Http\Controllers\Project;

use App\Models\Like;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Models\History 
     */
    public function index(History $history)
    {
        $likes = $history->chapters()->get();
        return response()->json([
            'likes' => LikeResource::collection($likes),
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
        if ($role == 'reader') {
            $validatedData =  Validator::make($request->all(), [
                'history_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {
                $like = Like::create([
                    'history_id' => $request['history_id'],
                    'user_id' => auth()->user()->id,
                ]);
            }

            return response()->json([
                'history' => $like,
                'success' => true,
                'message' => 'Like successfully added'
            ]);
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
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        return response([
            'like' => new LikeResource($like),
            'message' => 'Retrieved successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        $role = Auth::user()->role;
        if ($role == 'reader') {
            $success = $like->delete();
            return response([
                'success' => $success,
                'message' => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }
}
