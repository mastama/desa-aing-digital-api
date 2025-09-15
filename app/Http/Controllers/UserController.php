<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
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
     * - Jika all=true -> ambil semua (dengan optional limit).
     * - Jika tidak, gunakan pagination (per_page default 15).
     */
    public function index(Request $request)
    {
        $rid = $this->getRequestId($request);
        $search = $request->query('search');
        $all = filter_var($request->query('all'), FILTER_VALIDATE_BOOLEAN);
        $limit = (int) $request->query('limit', 100);
        $perPage = (int) $request->query('per_page', 15);
        
        Log::info('users.index: incoming request', compact('rid', 'search', 'all', 'limit', 'perPage'));

        try {
            if ($all) {
                // Ambil semua user, dengan optional limit
                $data = $this->users->getAll($search, $limit ?: 200, true);
                Log::info('users.index: fetched all (limited)', ['rid' => $rid, 'count' => $data->count()]);

                return ResponseHelper::jsonResponse(
                    true, 
                    'Fetched all users', 
                    $data, 
                    200
                );
            }

            // Mode pagination
            $paginator = $this->users->getAllPaginated($search, $perPage ?: 15);
            Log::info('users.index: fetched paginated', [
                'rid' => $rid, 
                'current_page' => $paginator->currentPage(), 
                'per_page' => $paginator->perPage(), 
                'total' => $paginator->total()
            ]);

            return ResponseHelper::jsonResponse(
                true, 
                'Fetched paginated users', 
                $paginator, 
                200
            );
        } catch (\Throwable $e) {
            Log::error('users.index: failed', ['rid' => $rid, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return ResponseHelper::jsonResponse(
                false, 
                'Failed to fetch users', 
                null, 
                500
            );
        }
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
