<?php

namespace App\Http\Controllers;

use App\Repositories\EdgeRepository;
use App\Repositories\NodeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FamilyTreeController extends Controller
{
    protected $nodeRepository;
    protected $edgeRepository;

    public function __construct(NodeRepository $nodeRepository, EdgeRepository $edgeRepository)
    {
        $this->nodeRepository = $nodeRepository;
        $this->edgeRepository = $edgeRepository;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();
        $familyIds = $user->family_ids;
        Log::info('User family IDs: ' . json_encode($user->family_ids));
        $nodesInit = $this->nodeRepository->getByFamilyIds($familyIds);

        $edgesInit = $this->edgeRepository->getByNodeIds($nodesInit);

        return response()->json([
            'nodes' => $nodesInit,
            'edges' => $edgesInit
        ]);
    }
}
