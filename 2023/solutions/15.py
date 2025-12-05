import re
from input import load

input = load('15').split(',')

def do_hash(s):
    current = 0

    for char in s:
        current += ord(char)
        current *= 17
        current %= 256
    
    return current

print('Part 1:', sum([do_hash(s) for s in input]))


def find_in_box(box, label):
    for i, combo in enumerate(box):
        if combo[0] == label:
            return i
    return None


parse = re.compile('(\\w+)(-|=)(\\d+)?')

boxes = [[] for _ in range(256)]

for inst in input:
    label, operation, focus = parse.match(inst).groups()
    box = do_hash(label)
    index = find_in_box(boxes[box], label)
    
    match operation:
        case '-':
            if index is not None:
                del boxes[box][index]
        case '=':
            if index is not None:
                boxes[box][index][1] = int(focus)
            else:
                boxes[box].append([label, int(focus)])

power = 0

for i, boxset in enumerate(boxes):
    for j, lens in enumerate(boxset):
        power += (i+1) * (j+1) * lens[1]

print('Part 2:', power)