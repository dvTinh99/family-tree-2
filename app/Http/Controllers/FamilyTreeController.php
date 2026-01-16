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
                'id' => 'g1p1',
                'type' => 'person',
                'label' => 'Gen1 Grandfather',
                'data' => ['name' => 'Gen1 Grandfather'],
            ],
            [
                'id' => 'g1p2',
                'type' => 'person',
                'label' => 'Gen1 Grandmother',
                'data' => ['name' => 'Gen1 Grandmother'],
            ],

            [
                'id' => 'g2p1',
                'type' => 'person',
                'label' => 'Gen2 Father',
                'data' => ['name' => 'Gen2 Father'],
            ],
            [
                'id' => 'g2p2',
                'type' => 'person',
                'label' => 'Gen2 Mother',
                'data' => ['name' => 'Gen2 Mother'],
            ],

            [
                'id' => 'g3p1',
                'type' => 'person',
                'label' => 'Gen3 Child A',
                'data' => ['name' => 'Gen3 Child A'],
            ],
            [
                'id' => 'g3p2',
                'type' => 'person',
                'label' => 'Gen3 Child B',
                'data' => ['name' => 'Gen3 Child B'],
            ],

            [
                'id' => 'g4p1',
                'type' => 'person',
                'label' => 'Gen4 Grandchild A1',
                'data' => ['name' => 'Gen4 Grandchild A1'],
            ],
            [
                'id' => 'g4p2',
                'type' => 'person',
                'label' => 'Gen4 Grandchild A2',
                'data' => ['name' => 'Gen4 Grandchild A2'],
            ],
            [
                'id' => 'g4p3',
                'type' => 'person',
                'label' => 'Gen4 Grandchild B1',
                'data' => ['name' => 'Gen4 Grandchild B1'],
            ],

            [
                'id' => 'g5p1',
                'type' => 'person',
                'label' => 'Gen5 GreatGrandchild A1a',
                'data' => ['name' => 'Gen5 GreatGrandchild A1a'],
            ],
            [
                'id' => 'g5p2',
                'type' => 'person',
                'label' => 'Gen5 GreatGrandchild A1b',
                'data' => ['name' => 'Gen5 GreatGrandchild A1b'],
            ],
        ];

        $edgesInit = [
            // Gen1 spouses
            [
                'id' => 'e_g1_sp',
                'source' => 'g1p1',
                'target' => 'g1p2',
                'type' => 'step',
                'data' => ['relation' => 'spouse'],
            ],

            // Gen1 → Gen2
            [
                'id' => 'e_g1p1_g2p1',
                'source' => 'g1p1',
                'target' => 'g2p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g1p2_g2p1',
                'source' => 'g1p2',
                'target' => 'g2p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g1p1_g2p2',
                'source' => 'g1p1',
                'target' => 'g2p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g1p2_g2p2',
                'source' => 'g1p2',
                'target' => 'g2p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],

            // Gen2 spouses
            [
                'id' => 'e_g2_sp',
                'source' => 'g2p1',
                'target' => 'g2p2',
                'type' => 'step',
                'data' => ['relation' => 'spouse'],
            ],

            // Gen2 → Gen3
            [
                'id' => 'e_g2p1_g3p1',
                'source' => 'g2p1',
                'target' => 'g3p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g2p2_g3p1',
                'source' => 'g2p2',
                'target' => 'g3p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g2p1_g3p2',
                'source' => 'g2p1',
                'target' => 'g3p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g2p2_g3p2',
                'source' => 'g2p2',
                'target' => 'g3p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],

            // Gen3 → Gen4
            [
                'id' => 'e_g3p1_g4p1',
                'source' => 'g3p1',
                'target' => 'g4p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g3p1_g4p2',
                'source' => 'g3p1',
                'target' => 'g4p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g3p2_g4p3',
                'source' => 'g3p2',
                'target' => 'g4p3',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],

            // Gen4 spouses
            [
                'id' => 'e_g4_sp',
                'source' => 'g4p1',
                'target' => 'g4p2',
                'type' => 'step',
                'data' => ['relation' => 'spouse'],
            ],

            // Gen4 → Gen5
            [
                'id' => 'e_g4p1_g5p1',
                'source' => 'g4p1',
                'target' => 'g5p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g4p2_g5p1',
                'source' => 'g4p2',
                'target' => 'g5p1',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g4p1_g5p2',
                'source' => 'g4p1',
                'target' => 'g5p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
            [
                'id' => 'e_g4p2_g5p2',
                'source' => 'g4p2',
                'target' => 'g5p2',
                'type' => 'step',
                'data' => ['relation' => 'parent'],
            ],
        ];


        return response()->json([
            "nodes" => $nodesInit,
            "edges" => $edgesInit
        ]);
    }
}
