<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function index()
    {
        try {
            $leaves = Leave::with('user')->orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $leaves,
                'message' => 'Success get data'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving data',
            ], 500);
        }
    }

    public function store(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                /** 
                 * Start Date
                 * 
                 * @example 2025-02-04
                 */
                'start_date' => 'required|date',
                /** 
                 * End Date
                 * 
                 * @example 2025-02-05
                 */
                'end_date' => 'required|date|after_or_equal:start_date',
                /** 
                 * Reason
                 * 
                 * @example Test API LEAVE
                 */
                'reason' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], 422);
            }

            $leave = Leave::create([
                'user_id' => Auth::id(),
                'start_date' => $req->start_date,
                'end_date' => $req->end_date,
                'reason' => $req->reason,
                'status' => 'pending',
            ]);

            $leave->load('user');
            return response()->json([
                'success' => true,
                'data' => $leave,
                'message' => 'Success creating leave request'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Error Creating Leave Request',
            ], 500);
        }
    }
}
