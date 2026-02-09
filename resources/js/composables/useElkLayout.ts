import { ref } from "vue";
import ELK from "elkjs/lib/elk.bundled.js";

export function useElkLayout() {
  const isCalculating = ref(false);

  async function layoutGraphElk(
    nodes,
    edges,
    customOptions = {}
  ) {

    isCalculating.value = true;

    try {
      const elk = new ELK();

      // 1️⃣ Tách spouse edges
      const spouseEdges = edges.filter(e => e.data?.relation === "spouse");

      // 2️⃣ Build groups
      const spouseGroups = [];
      const used = new Set();

      console.log('e ne ngoai for', edges);
      spouseEdges.forEach(e => {
        console.log('e ne', e);
        
        const [a, b] = [e.sources[0], e.targets[0]];

        if (used.has(a) || used.has(b)) return;

        const male = nodes.find(n => n.id === a && n.data.gender === "1");
        const female = nodes.find(n => n.id === b && n.data.gender === "2");
        if (male && female) {
          used.add(a);
          used.add(b);

          spouseGroups.push({
            id: `group-${a}-${b}`,
            members: [male, female]
          });
        }
      });
      console.log('e ne end for', edges);

      // 3️⃣ Build graph children:
      const children = [];
      const nodeMap = new Map(nodes.map(n => [n.id, n]));

      console.log('1');
      // a) Add groups first
      spouseGroups.forEach(g => {
        children.push({
          id: g.id,
          children: g.members.map(m => ({
            id: m.id,
            width: m.width || 100,
            height: m.height || 60
          }))
        });

        // Xóa node khỏi nodeMap
        g.members.forEach(m => nodeMap.delete(m.id));
      });
      console.log('2');

      // b) Add remaining
      nodeMap.forEach(n => {
        children.push({
          ...n,
          width: n.width || 100,
          height: n.height || 60
        });
      });

      console.log('3');

      // 4️⃣ Build elk graph
      const graph = {
        id: "root",
        children,
        edges,
        layoutOptions: {
          "elk.algorithm": "layered",
          "elk.direction": "DOWN",
          "elk.spacing.nodeNode": "50",
          ...customOptions
        }
      };

      console.log('4');
      const result = await elk.layout(graph);

      // flatten group children positions
      const nodesWithPositions = [];

      console.log('5');
      result.children.forEach(item => {
        console.log('item', item);
        
        // nếu là group
        if (item.children) {
          item.children.forEach(child => {
            nodesWithPositions.push({
                ... child,
                position: {
                    x: child.x,
                    y: child.y,
                }
            });
          });
        } else {
          nodesWithPositions.push({
                ... item,
                position: {
                    x: item.x,
                    y: item.y,
                }
            });
        }
      });
      console.log('6');

      return { nodes: nodesWithPositions };
    } finally {
      isCalculating.value = false;
    }
  }

  return {
    layoutGraphElk,
    isCalculating
  };
}
