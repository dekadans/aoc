from input import lines
import re
from math import lcm

extract = re.compile('([1-9A-Z]+)')

inval = lines('8')
instructions = list(inval[0])
nodes = {col[0]: (col[1], col[2]) for col in [extract.findall(rows) for rows in inval[2:]]}


def get_next(i, current):
    i = instructions[i % len(instructions)]
    left, right = nodes.get(current)
    return left if i == 'L' else right


# Part 1

pos = 'AAA'
step = 0

while True:
    pos = get_next(step, pos)
    step += 1
    if pos == 'ZZZ':
        break

print(step)

# Part 2

paths = filter(lambda m: m[-1] == 'A', nodes.keys())
results = []

for pos in paths:
    step = 0
    while True:
        pos = get_next(step, pos)
        step += 1
        if pos[-1] == 'Z':
            break

    results.append(step)

print(lcm(*results))
