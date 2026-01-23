<?php

namespace App\Repositories;

use App\Models\Node;
use Illuminate\Database\Eloquent\Collection;

class NodeRepository extends RepositoryBase
{
    public function __construct(Node $node)
    {
        parent::__construct($node);
    }

    /**
     * Get nodes by family tree ID
     */
    public function getByFamilyIds(int|array|Collection $familyIds): Collection
    {
        $familyId = is_array($familyIds) ? $familyIds : [$familyIds];
        return $this->model->whereIn('family_id', $familyId)->get();
    }

    /**
     * Get root nodes (nodes without parent)
     */
    public function getRootNodes(int $familyTreeId): Collection
    {
        return $this
            ->model
            ->where('family_tree_id', $familyTreeId)
            ->whereNull('parent_id')
            ->get();
    }

    /**
     * Get children of a node
     */
    public function getChildren(int $nodeId): Collection
    {
        return $this->model->where('parent_id', $nodeId)->get();
    }

    /**
     * Update node position
     */
    public function updatePosition(int $id, float $x, float $y): bool
    {
        return $this->update($id, ['x' => $x, 'y' => $y]);
    }
}
