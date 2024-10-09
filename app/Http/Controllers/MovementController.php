<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Movement;
use App\Models\PersonalRecord;

use DB;

class MovementController extends Controller
{
    public function getMovements(Request $request) {
      return response()->json(
        [
          'success' => true,
          'movements' => Movement::all(),
        ],
        200
      );
    }

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