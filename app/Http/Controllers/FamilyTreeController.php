<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FamilyTreeController extends Controller
{
    public function index(): JsonResponse
    {
        $nodesInit = [
            [
                'id' => '1',
                'type' => 'person',
                'label' => 'Parent A 22',
                'data' => [
                    'name' => 'Parent A 22',
                ],
            ],
            [
                'id' => '2',
                'type' => 'person',
                'label' => 'Parent B',
                'data' => [
                    'name' => 'Parent B',
                ],
            ],
            [
                'id' => '3',
                'type' => 'person',
                'data' => [],
            ],
            [
                'id' => '4',
                'type' => 'person',
                'data' => [],
            ],
        ];

        $edgesInit = [
            [
                'id' => 'e1',
                'source' => '1',
                'target' => '2',
                'type' => 'step',
                'data' => [
                    'relation' => 'spouse',
                ],
                'sourceHandle' => 'right-source',
                'targetHandle' => 'left-target',
            ],
            [
                'id' => 'e2',
                'source' => '1',
                'target' => '3',
                'type' => 'step',
                'data' => [
                    'relation' => 'parent',
                ],
                'sourceHandle' => 'bottom-source',
                'targetHandle' => 'top-target',
            ],
            [
                'id' => 'e3',
                'source' => '1',
                'target' => '4',
                'type' => 'step',
                'data' => [
                    'relation' => 'parent',
                ],
                'sourceHandle' => 'bottom-source',
                'targetHandle' => 'top-target',
            ],
        ];


        return response()->json([
            "nodes" => $nodesInit,
            "edges" => $edgesInit
        ]);
    }
}
