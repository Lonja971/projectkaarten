<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        return response()->json([
            User::query()->orderBy('id', 'asc')->paginate(env('PAGINATION_LIMIT'))
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['identifier'] = strtolower($data['identifier']);
        if ($data['role_id'] != env("TEACHER_ROLE_ID") || empty($data['email'])) {
            $data['email'] = $data['identifier'] . env("STUDENT_EMAIL_DOMAIN");
        }
        $password = Str::random(12);
        $data['password'] = Hash::make($password);

        $user = new UserResource(User::create($data));
        $api_key = ApiKey::setApiKeyForUser($user->id);

        return ApiResponse::successWithMessage(
            'Gebruiker is succesvol aangemaakt',
            array_merge($user->toArray(request()), ['api_key' => $api_key->api_key]),
        );
    }

    public function show(Request $request, string $id)
    {
        $column = $request->query('column');
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::notFound();
        }

        if ($column) {
            if (!$user[$column]) {
                return ApiResponse::notFound();
            }

            return response()->json([
                'data' => $user[$column]
            ], 201);
            return ApiResponse::successWithoutMessage(
                $user[$column]
            );
        }

        return response()->json([
            'data' => new UserResource($user)
        ], 201);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();

        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }
        if (isset($data['identifier'])) {
            $data['identifier'] = strtolower($data['identifier']);
        }

        $user = User::find($id);

        if (!$user) {
            return ApiResponse::notFound();
        }

        if (empty($data)) {
            return ApiResponse::noDataToUpdate();
        }

        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($user->$key !== $value) {
                $unchanged = false;
                break;
            }
        }

        if ($unchanged) {
            return ApiResponse::noChangesDetected();
        }

        $user->update($data);

        return ApiResponse::successWithMessage(
            'Gebruiker succesvol bijgewerkt',
            new UserResource($user)
        );
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::notFound();
        }
        $user->delete();

        return ApiResponse::successWithMessage(
            'Gebruiker succesvol verwijderd'
        );
    }

    public function search(Request $request)
    {
        $column = $request->query('column');
        $value = $request->query('value');

        if (!$column || !$value) {
            $missingParams = [];
            if (!$column) {
                $missingParams[] = 'column';
            }
            if (!$value) {
                $missingParams[] = 'value';
            }
            return ApiResponse::errorWithMessage('Ontbrekende zoekparameters ('. implode(', ', $missingParams) . ')', null, 400);
        }

        $users = User::where($column, 'LIKE', "%$value%")->get();

        $users_id = [];
        foreach ($users as $user) {
            $users_id[] = $user['id'];
        };

        if ($users_id) {
            return ApiResponse::successWithoutMessage(
                $users_id
            );
        } else {
            return ApiResponse::notFound();
        }
    }
}
