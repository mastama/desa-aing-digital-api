<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Support\ResponseHelper;

class UserController extends Controller
{

    /**
     * Inject repository lewat constructor
     */
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {}

    /**
     * Helper untuk punya Request ID (untuk logging)
     */
    private function getRequestId(Request $request): string
    {
        // Pakai X-Request-ID dari client kalau ada, kalau tidak ada generate baru pakai UUID
        return $request->header('X-Request-ID') ?: (string) Str::uuid();
    }

    /**
     * GET /api/users
     * Listing user dengan pencarian & pagination.
     *
     * Query params: ?search=...&per_page=...&all=true&limit=...
     * - ?all=true&limit=...   -> ambil semua (dibatasi limit)
     * - default               -> paginated (?per_page=...)
     */
    public function index(Request $request)
    {
        $rid     = $this->getRequestId($request);
        $search  = $request->query('search');
        $all     = filter_var($request->query('all'), FILTER_VALIDATE_BOOLEAN);
        $limit   = (int) $request->query('limit', 100);
        $perPage = (int) $request->query('per_page', 15);

        Log::info('users.index: incoming', compact('rid','search','all','limit','perPage'));

        try {
            if ($all) {
                // Ambil semua (dibatasi limit)
                $collection = $this->users->getAll($search, $limit ?: 200, true);

                Log::info('users.index: fetched all', ['rid' => $rid, 'count' => $collection->count()]);

                // Pakai Resource agar output seragam
                return ResponseHelper::jsonResponseAll(
                    true,
                    'Fetched all users',
                    UserResource::collection($collection), // <- sudah jadi array saat di-json
                    200,
                    ['mode' => 'all']
                );
            }

            // Paginated
            $paginator = $this->users->getAllPaginated($search, $perPage ?: 15);

            Log::info('users.index: fetched paginated', [
                'rid'          => $rid,
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ]);

            // Ambil item + bungkus Resource, meta pagination akan disusun oleh ResponseHelper
            // Transform tiap item pakai Resource
            $items = UserResource::collection(collect($paginator->items()));

            return ResponseHelper::jsonResponseAll(
                true,
                'Fetched paginated users',
                // kirim paginator ke helper agar meta pagination otomatis
                $items,
                200,
                [
                    // meta pagination dikirim terpisah
                    'mode'         => 'paginated',
                    'current_page' => $paginator->currentPage(),
                    'per_page'     => $paginator->perPage(),
                    'total'        => $paginator->total(),
                    'last_page'    => $paginator->lastPage(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('users.index: failed', ['rid' => $rid, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return ResponseHelper::jsonResponse(false, 'Failed to fetch users', null, 500);
        }
    }

    /**
     * GET /api/users/all/paginated
     * Endpoint opsional jika kamu tetap ingin path terpisah untuk pagination.
     * Sebenarnya index() sudah mendukung ini, tapi ini disediakan agar eksplisit.
     */
    public function getAllPaginated(Request $request)
    {
        // Delegasikan ke index (tanpa mode all)
        $request->merge(['all' => false]);
        return $this->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
