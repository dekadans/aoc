from input import lines
import re
from math import prod

inval = lines('2')

test = {
    'red': 12,
    'green': 13,
    'blue': 14
}

find_game = re.compile('Game (\\d+)')
find_sets = re.compile('(?:\\d+ [a-z]+(?:, )?)+')

valid = []
powers = []

for l in inval:
    game = int(find_game.findall(l).pop())
    sets = find_sets.findall(l)

    set_conf = [list(map(lambda x: x.strip().split(' '), x.split(','))) for x in sets]

    game_conf = {}

    ok = True
    for set_val in set_conf:
        for combo in set_val:
            val = int(combo[0])
            color = combo[1]
            if test.get(color) < val:
                ok = False

            if game_conf.get(color, 0) < val:
                game_conf[color] = val

    powers.append(prod(game_conf.values()))
    if ok:
        valid.append(game)

print(sum(valid))
print(sum(powers))