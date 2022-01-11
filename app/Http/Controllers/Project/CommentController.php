<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json([
            'comment' => CommentResource::collection($comments),
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
                'content' => ['required', 'string', 'max:255'],
                'history_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $comment = Comment::create([
                    'content' => $request['content'],
                    'history_id' => $request['history_id'],
                    'user_id' => auth()->user()->id,
                ]);

                return response()->json([
                    'history' => $comment,
                    'success' => true,
                    'message' => 'Comment successfully created'
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response([
            'comment' => new CommentResource($comment),
            'message' => 'Created successfully'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $role = Auth::user()->role;
        if ($role == 'reader') {
            $validatedData =  Validator::make($request->all(), [
                'content' => ['required', 'string', 'max:255'],
                'history_id' => ['required', 'integer'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $success = $comment->update($request->all());

                return response([
                    'comment' => new CommentResource($comment),
                    'success' => $success,
                    'message' => 'Update successfully'
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $role = Auth::user()->role;
        if ($role == 'reader') {
            $success = $comment->delete();

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
