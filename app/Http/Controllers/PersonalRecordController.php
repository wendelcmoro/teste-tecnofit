<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\PersonalRecord;

class PersonalRecordController extends Controller
{
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