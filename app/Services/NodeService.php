<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\FamilyRepository;
use App\Repositories\NodeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class NodeService
{
    protected NodeRepository $nodeRepository;
    protected FamilyRepository $familyRepository;
    protected UserRepository $userRepository;

    public function __construct(NodeRepository $nodeRepository, FamilyRepository $familyRepository, UserRepository $userRepository)
    {
        $this->nodeRepository = $nodeRepository;
        $this->familyRepository = $familyRepository;
        $this->userRepository = $userRepository;
    }

    public function makeDefaultNode(?User $user = null)
    {
        $family = $this->familyRepository->create([
            'name' => 'Default'
        ]);

        $this->userRepository->update($user->id, [
            'family_ids' => array_merge($user->family_ids ?? [], [$family->id])
        ]);
        $defaultNode = [
            'family_id' => $family->id,
            'label' => 'Me',
        ];
        $this->nodeRepository->create($defaultNode);
        return $defaultNode;
    }
}
