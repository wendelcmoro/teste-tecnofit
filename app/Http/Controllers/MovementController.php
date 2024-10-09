<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Movement;
use App\Models\PersonalRecord;

use DB;

class MovementController extends Controller
{
   /**
     * @OA\Get(
     *     path="/api/movements",
     *     summary="Show a list of movements",
     *     tags={"Movements"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="movements",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(
     *                          property="movement",
     *                          type="object",
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              description="Movement ID"
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="Movement name"
     *                          ),
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
    public function getMovements(Request $request) {
      return response()->json(
        [
          'success' => true,
          'movements' => Movement::all(),
        ],
        200
      );
    }

     /**
     * @OA\Get(
     *     path="/api/ranking",
     *     summary="Show the ranking by movement",
     *     tags={"Ranking"},
     *     @OA\Parameter(
     *         name="movement_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Movement ID",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="movement", 
     *                 type="string",
     *                 description="Movement Name"
     *             ),
     *             @OA\Property(
     *                 property="ranking",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(
     *                          property="ranking",
     *                          type="object",
     *                          @OA\Property(
     *                              property="user",
     *                              type="string",
     *                              description="User name"
     *                          ),
     *                          @OA\Property(
     *                              property="record",
     *                              type="float",
     *                              description="User greatest record"
     *                          ),
     *                          @OA\Property(
     *                              property="date",
     *                              type="datetime",
     *                              description="User greatest record date"
     *                          ),
     *                          @OA\Property(
     *                              property="position",
     *                              type="integer",
     *                              description="User record position"
     *                          ),
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
     *         response=422,
     *         description="Unprocessable Content",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function getMovementRanking(Request $request) {
      $validator = Validator::make($request->all(), [
          'movement_id' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $movement_id = $request->movement_id;
      $ranking = PersonalRecord::select('personal_record.*')
                                ->join(DB::raw('(SELECT user_id, MAX(value) as max_value FROM personal_record WHERE movement_id = ' . (int) $movement_id . ' GROUP BY user_id) as max_records'), function ($join) {
                                    $join->on('personal_record.user_id', '=', 'max_records.user_id')
                                        ->on('personal_record.value', '=', 'max_records.max_value');
                                })
                                ->where('personal_record.movement_id', $movement_id)
                                ->with('user')
                                ->orderByDesc('personal_record.value')
                                ->get();

      $position = 0;
      $lastMax = 0;
      $lastPosition = 0;
      foreach($ranking as $item) {
        if ($item->value == $lastMax) {
          $item->position = $lastPosition;
        } else {
          $item->position = ++$position;
        }
        $lastMax = $item->value;
        $lastPosition = $item->position;
      }

      return response()->json([
          'success' => true,
          'movement' => Movement::find($request->movement_id)->name,
          'ranking' => $ranking->map(function ($record) {
              return [
                  'user' => $record->user->name,
                  'record' => $record->value,
                  'date' => $record->date,
                  'position' => $record->position,
              ];
          })
      ]);
    }
}