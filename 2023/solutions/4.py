from input import lines
import re
from math import floor

find_nr = re.compile('\\d+')

inval = lines('4')
score = 0
count = {}


def increment_count(g, v=1):
    if g in count:
        count[g] = count[g] + v
    else:
        count[g] = v

    return count[g]


for game in inval:
    game_part, table_part = game.split(':')
    win_row, hand_row = table_part.split('|')

    game_number = int(find_nr.findall(game_part).pop())
    winners = set(map(int, find_nr.findall(win_row)))
    hand = set(map(int, find_nr.findall(hand_row)))

    result = len(winners.intersection(hand))

    score = score + floor(2 ** (result - 1))

    cards = increment_count(game_number)
    for i in range(game_number, game_number+result):
        increment_count(i+1, cards)

print(score)
print(sum(count.values()))
