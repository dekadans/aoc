from input import rows_and_cols, flip
from enum import Enum

### Incomplete solution! Only part 1.

class Direction(Enum):
    NORTH = 0
    EAST = 1
    SOUTH = 2
    WEST = 3


def tilt(current, direction):
    if direction == Direction.NORTH or direction == Direction.SOUTH:
        current = flip(current)

    if direction == Direction.SOUTH or direction == Direction.EAST:
        current = list(reversed(current))

    for i, s1 in enumerate(current):
        to = 0

        if direction == Direction.SOUTH or direction == Direction.EAST:
            s1 = list(reversed(s1))

        for j, v in enumerate(s1):
            if v == 'O':
                s1[j] = '.'
                s1[to] = 'O'
                to += 1
            elif v == '#':
                to = j + 1

        if direction == Direction.SOUTH or direction == Direction.EAST:
            s1 = list(reversed(s1))

        current[i] = s1

    if direction == Direction.SOUTH or direction == Direction.EAST:
        current = list(reversed(current))
    if direction == Direction.NORTH or direction == Direction.SOUTH:
        current = flip(current)

    return current


def calc_load(current):
    load = 0
    dimension = len(current)

    for i, row in enumerate(current):
        for j, col in enumerate(row):
            if col == 'O':
                load += dimension - i

    return load


board = rows_and_cols('14')

board1 = tilt(board, Direction.NORTH)
print('Part 1', calc_load(board1))


def run(current):
    order = [Direction.NORTH, Direction.WEST, Direction.SOUTH, Direction.EAST]
    for d in order:
        current = tilt(current, d)

    return current

turn = 0
previous = []
limit = 1000000000


chk = ''
for r in board:
    chk += ''.join(r)
#previous.append(chk)

while turn < 8:
    turn += 1
    board = run(board)

    chk = ''
    for r in board:
        chk += ''.join(r)

    # if chk in previous:
    #     break

    print(turn, calc_load(board))
    previous.append(chk)

print(calc_load(board))

#
# print(turn)
# turn = turn * (limit // turn)
#
# while turn < limit:
#     turn += 1
#     board = run(board)
#
# print(turn)
# print(calc_load(board))