<?php

namespace App\Http\Controllers\Project;

use App\Models\Chapter;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChapterResource;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Models\History 
     */
    public function index(History $history)
    {
        $chapters = $history->chapters()->get();
        return response()->json([
            'chapters' => ChapterResource::collection($chapters),
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
                'number' => ['required', 'integer'],
                'content' => ['required', 'text'],
                'history_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $chapter = Chapter::create([
                    'number' => $request['number'],
                    'content' => $request['content'],
                    'history_id' => $request['history_id'],
                ]);

                return response()->json([
                    'chapter' => $chapter,
                    'success' => true,
                    'message' => 'Chapter successfully created'
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
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        return response()->json([
            'chapter' => new ChapterResource($chapter),
            'success' => true,
            'message' => 'Retrieved successfully'
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        $role = Auth::user()->role;
        if ($role == 'author') {
            $validatedData =  Validator::make($request->all(), [
                'number' => ['required', 'integer'],
                'content' => ['required', 'text'],
                'history_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {
                $success = $chapter->update($request->all());

                return response([
                    'chapter' => $chapter,
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
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        $role = Auth::user()->role;
        if ($role == 'author') {
            $success = $chapter->delete();

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
