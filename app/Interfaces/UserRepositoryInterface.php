<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Ambil semua user dengan optional pencarian & limit.
     * Jika $execute = true  -> kembalikan Collection hasil eksekusi query.
     * Jika $execute = false -> kembalikan Builder untuk chaining lanjutan.
     *
     * @return Builder|Collection
     */
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    );

    /**
     * Ambil user dalam bentuk pagination.
     */
    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage
    ): LengthAwarePaginator;
}
