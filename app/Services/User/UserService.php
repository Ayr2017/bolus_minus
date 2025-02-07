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
            if ($result) {
                return $user->load('roles');
            }
        } catch (\Throwable $throwable) {
            Log::error(__METHOD__ . ' ' . $throwable->getMessage());
        }

        return null;
    }

    public function search(array $data)
    {
        return $this->userRepository->search($data);
    }

    /**
     * @param mixed $data
     * @return User|null
     */
    public function store(mixed $data): ?User
    {
        try {
            $user = User::query()->create($data);
            if ($user) {
                return $user;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public static function update(User $user, array $validatedData): bool
    {
        return $user->update($validatedData);
    }
}
