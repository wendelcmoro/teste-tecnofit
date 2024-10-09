<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    public function getUsers(Request $request) {
        return response()->json(
			[
				'success' => true,
				'users' => User::all(),
			],
			200
		);
    }
}