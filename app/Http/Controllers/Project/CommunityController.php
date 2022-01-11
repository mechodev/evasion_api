<?php

namespace App\Http\Controllers\Project;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommunityResource;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 'reader' || $role == 'author') {
            $messages = Community::all();
            return response()->json([
                'allContainsMessages' => CommunityResource::collection($messages),
                'success' => true,
                'message' => 'Retrieved successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
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
        if ($role == 'reader' || $role == 'author') {
            $validatedData =  Validator::make($request->all(), [
                'content' => ['required', 'string'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $message = Community::create([
                    'content' => $request['content'],
                    'user_id' => auth()->user()->id,
                ]);

                return response()->json([
                    'content' => $message,
                    'success' => true,
                    'message' => 'Message successfully posted'
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
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community)
    {
        $role = Auth::user()->role;
        if ($role == 'reader' || $role == 'author') {
            return response([
                'content' => new CommunityResource($community),
                'message' => 'Retrieved successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community)
    {
        $role = Auth::user()->role;
        if ($role == 'reader' || $role == 'author') {
            $validatedData =  Validator::make($request->all(), [
                'content' => ['required', 'string'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $success = $community->update($request->all());

                return response([
                    'upadtedMessage' => new CommunityResource($community),
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
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        $role = Auth::user()->role;
        if ($role == 'reader' || $role == 'author') {
            $success = $community->delete();
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
