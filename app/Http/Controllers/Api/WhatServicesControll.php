<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\orderTracking;
use Exception;
use Illuminate\Http\Request;

class WhatServicesControll extends Controller
{
    public function getNewMessages(Request $request)
    {

        try {
            $data = orderTracking::where('whats_sent', 0)->get();
            return response()->json(
                [
                    'status' => true,
                    'data' => $data
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status'=> false,
                    'messages'=> 'some thing went worng',
                ]
            );
        }


        // ->with(['user' => function ($query) {
        //     $query->select('id', 'username');
        // }])
    }

    public function SetMessageSent(Request $request)
    {

        try {
            $validator =  validator($request->all(), [
                'traking_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            $Traking = orderTracking::findOrFail($request->traking_id);
            $Traking->whats_sent = 1;
            $Traking->save();

            return response([
                'status' => true,
                'data' => $Traking,
            ]);
        } catch (\Throwable $th) {

            return response([
                'status' => false,
                'messages' => 'smoe thing went wrong',
            ]);
        }
    }
}
