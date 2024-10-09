<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\PersonalRecord;

class PersonalRecordController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/personal-records",
     *     summary="Show a list of personal records",
     *     tags={"Personal Records"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="records",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(
     *                          property="record",
     *                          type="object",
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              description="Personal Record ID"
     *                          ),
     *                          @OA\Property(
     *                              property="user_id",
     *                              type="integer",
     *                              description="Personal Record user_id"
     *                          ),
     *                          @OA\Property(
     *                              property="movement_id",
     *                              type="integer",
     *                              description="Personal Record movement_id"
     *                          ),
     *                          @OA\Property(
     *                              property="value",
     *                              type="float",
     *                              description="Personal Record value"
     *                          ),
     *                          @OA\Property(
     *                              property="date",
     *                              type="datetime",
     *                              description="Personal Record date"
     *                          ),
     *                          @OA\Property(
     *                              property="user",
     *                              type="object",
     *                              description="User",
     *                              @OA\Property(
     *                                property="id",
     *                                type="integer",
     *                                description="User ID"
     *                              ),
     *                              @OA\Property(
     *                                property="name",
     *                                type="string",
     *                                description="User name"
     *                              ),
     *                          ),
     *                          @OA\Property(
     *                              property="movement",
     *                              type="object",
     *                              description="Movement",
     *                              @OA\Property(
     *                                property="id",
     *                                type="integer",
     *                                description="Movement ID"
     *                              ),
     *                              @OA\Property(
     *                                property="name",
     *                                type="string",
     *                                description="Movement name"
     *                              ),
     *                          )
     *                      )
     *                 )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function getPersonalRecords(Request $request) {
      $records = PersonalRecord::with(['user', 'movement'])->get();
      return response()->json(
        [
          'success' => true,
          'records' => $records,
        ],
        200
      );
    }
}