<?php

namespace App\Repositories;

use App\Models\Edge;
use Illuminate\Database\Eloquent\Collection;

class EdgeRepository extends RepositoryBase
{
    public function __construct(Edge $edge)
    {
        parent::__construct($edge);
    }

    /**
     * Get edges by family tree ID
     */
    public function getByFamilyTree(int $familyTreeId): Collection
    {
        return $this->model->where('family_tree_id', $familyTreeId)->get();
    }

    /**
     * Get edges connected to a specific node
     */
    public function getByNodeIds(int|array|Collection $nodeIds): Collection
    {
        $nodeId = is_array($nodeIds) ? $nodeIds : [$nodeIds];
        return $this
            ->model
            ->whereIn('source', $nodeId)
            ->orWhereIn('target', $nodeId)
            ->get();
    }

    /**
     * Delete edges connected to a node
     */
    public function deleteByNode(int $nodeId): int
    {
        return $this
            ->model
            ->where('source', $nodeId)
            ->orWhere('target', $nodeId)
            ->delete();
    }

    /**
     * Create edge between two nodes
     */
    public function createEdge(int $source, int $target, int $familyTreeId, string $type = 'default'): Edge
    {
        return $this->create([
            'source' => $source,
            'target' => $target,
            'family_tree_id' => $familyTreeId,
            'type' => $type,
        ]);
    }
}
