<?php

namespace App\Repositories\User;

use App\Helpers\ModelSelectHelper;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function search(array $data): LengthAwarePaginator
    {
        $perPage = Arr::pull($data,'per_page', 50);
        //TODO: select
        return $this
            ->model
            ->query()
            ->paginate($perPage);
    }
}
