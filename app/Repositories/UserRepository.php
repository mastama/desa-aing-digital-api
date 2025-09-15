<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Query dasar untuk listing user.
     * - Select kolom yang umum dipakai (bisa ditambah sesuai kebutuhan).
     * - Urut terbaru berdasarkan created_at.
     * - Filter pencarian pada name OR email.
     */
    protected function baseQuery(?string $search): Builder
    {
        $q = User::query()
            ->select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
            ->latest('created_at');

        $search = trim((string) $search);
        if ($search !== '') {
            $q->where(function (Builder $qb) use ($search) {
                $qb->where('name',  'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $q;
    }

     /**
     * @inheritDoc
     */
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        // Batasi limit agar tidak terlalu besar (sane default).
        $limit = ($limit !== null && $limit > 0) ? min($limit, 200) : null;

        $query = $this->baseQuery($search);

        if ($limit !== null) {
            $query->limit($limit);
        }

        // $execute=false -> kembalikan Builder (bisa di-chain di luar).
        return $execute ? $query->get() : $query;
    }

    /**
     * @inheritDoc
     */
    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage
    ): LengthAwarePaginator {
        // Default 5, maksimal 10 per halaman.
        $perPage = ($rowPerPage !== null && $rowPerPage > 0) ? min($rowPerPage, 10) : 5;

        // paginate() otomatis menghitung total & halaman.
        $paginator = $this->baseQuery($search)->paginate($perPage);

        // Tambahkan parameter query agar pagination link tetap membawa filter.
        return $paginator->appends([
            'search'     => $search,
            'rowPerPage' => $perPage,
        ]);
    }
}