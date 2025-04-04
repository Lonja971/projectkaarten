<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index() //   GET | http://127.0.0.1:8000/api/users
    {
        return response()->json([
            User::query()->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function store(StoreUserRequest $request) //   POST | http://127.0.0.1:8000/api/users?full_name={full_name}&identifier={identifier}&role_id={role_id}&email={email}&password={password}
    {
        $data = $request->validated();

        $data['email'] = strtolower($data['email']);
        $data['identifier'] = strtolower($data['identifier']);

        return response()->json([
            'data' => new UserResource(User::create($data)),
        ], 201);
    }

    public function show(Request $request, string $id) //   GET | http://127.0.0.1:8000/api/users/{id}?column={full_name}
    {   
        $column = $request->query('column');
        $user = User::find($id);

        if (!$user){
            return response()->json([
                'error' => 'User Not Found'
            ], 404);
        }

        if ($column){
            if (!$user[$column]){
                return response()->json([
                    'error' => 'User data in field '.$column.' was not found'
                ], 404);
            }
            
            return response()->json([
                'data' => $user[$column]
            ], 201);
        }
        
        return response()->json([
            'data' => new UserResource($user)
        ], 201);
    }

    public function update(UpdateUserRequest $request, string $id) //   PATCH/PUT | http://127.0.0.1:8000/api/users/{id}?full_name={full_name}&email={email}
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
            return response()->json(['error' => 'User with this ID does not exist'], 404);
        }
    
        if (empty($data)) {
            return response()->json(['error' => 'There is no data to update.'], 400);
        }
    
        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($user->$key !== $value) {
                $unchanged = false;
                break;
            }
        }
    
        if ($unchanged) {
            return response()->json(['error' => 'No changes detected'], 200);
        }
    
        $user->update($data);
    
        return response()->json([
            'message' => 'User updated successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    public function destroy(string $id) //   DELETE | http://127.0.0.1:8000/api/users/{id}
    {
        $user = User::find($id);
        if (!$user){
            return response()->json([
                'error' => 'User with this id does not exist'
            ], 404);
        }
        $user->delete();

        return response()->json([
            'data' => true
        ], 201);
    }

    public function search(Request $request) //   GET | http://127.0.0.1:8000/api/users/search?column={full_name}&value={value}
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
            return response()->json(['error' => 'Missing search parameters (' . implode(', ', $missingParams) . ')'], 400);
        }

        $users = User::where($column, 'LIKE', "%$value%")->get();

        $users_id = [];
        foreach ($users as $user) {
            $users_id[] = $user['id'];
        };

        if ($users_id) {
            return response()->json([
                'data' => $users_id
            ], 201);
        } else {
            return response()->json([
                'error' => 'Not found',
                'data' => [
                    'column' => $column,
                    'value' => $value,
                ]
            ], 404);
        }
    }
}
