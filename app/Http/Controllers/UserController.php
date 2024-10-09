<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Show a list of users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(
     *                          property="user",
     *                          type="object",
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              description="User ID"
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="User name"
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