<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use \App\Services\Service;
use Illuminate\Support\Facades\Log;

class UserService extends Service
{
    public function __construct(readonly UserRepository $userRepository)
    {
        parent::__construct();
    }

    public function updateRoles(array $data, User $user): ?User
    {
        try {
            $result = $user->syncRoles($data['roles_names']);
            if($result){
                return $user->load('roles');
            }
        }catch (\Throwable $throwable){
            Log::error(__METHOD__.' '.$throwable->getMessage());
        }

        return null;
    }

    public function search(array $data)
    {

        $userData = $this->userRepository->search($data);
        return $userData;
    }

    public static function update(array $data, User $user): User
    {
        $roles_name = $data['roles_names'];
        unset($data['roles_names']);

        if(empty($data['password'])) {
            unset($data['password']);
        }

        if(!empty($data['uuid'])) {

            $user->update(['uuid' =>  $data['uuid'] ]);

        }
        unset($data['uuid']);
        $user->assignRole($roles_name);
        $user->update($data);
        return $user;
    }
}
