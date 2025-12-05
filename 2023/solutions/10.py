from input import lines
from enum import Enum
import operator


class Direction(Enum):
    UP = (-1, 0)
    RIGHT = (0, 1)
    DOWN = (1, 0)
    LEFT = (0, -1)

    def opposite(self):
        return {
            Direction.UP: Direction.DOWN,
            Direction.RIGHT: Direction.LEFT,
            Direction.DOWN: Direction.UP,
            Direction.LEFT: Direction.RIGHT
        }.get(self)


pipe_types = {
    '|': [Direction.UP, Direction.DOWN],
    '-': [Direction.LEFT, Direction.RIGHT],
    'L': [Direction.UP, Direction.RIGHT],
    'J': [Direction.UP, Direction.LEFT],
    '7': [Direction.LEFT, Direction.DOWN],
    'F': [Direction.RIGHT, Direction.DOWN],
    '.': []
}

pipe_map = [list(h) for h in lines('10')]


def move(pos: tuple[int, int], direction: Direction):
    return tuple(map(operator.add, pos, direction.value))


def peek(pos) -> str:
    return pipe_map[pos[0]][pos[1]]


start = None

for i, row in enumerate(pipe_map):
    if 'S' in row:
        start = (i, row.index('S'))
        break

current = start
path = {start: [None, None]}
last_move = None
steps = 0

def save(p, d):
    global current, last_move, path, steps
    old = current
    current = p

    path[old][1] = d

    path[current] = [d, None]
    last_move = d
    steps += 1

for i in Direction:
    face = move(current, i)
    if i.opposite() in pipe_types.get(peek(face)):
        save(face, i)
        break

while True:
    pipe = peek(current)
    if pipe == 'S':
        break

    cont = list(filter(
        lambda p: p != last_move.opposite(),
        pipe_types.get(pipe)
    )).pop()

    save(move(current, cont), cont)

furthest = steps // 2
print(furthest)

enclosed = []

for i, row in enumerate(pipe_map):
    winding = 0
    for j, col in enumerate(row):
        pos = (i, j)
        if pos in path:
            op_in, op_out = path.get(pos)
            turn = 0
            if op_in == Direction.UP:
                turn = 1
            elif op_out == Direction.DOWN:
                turn = -1
            winding += turn
        else:
            if winding != 0:
                enclosed.append(pos)

print(len(enclosed))