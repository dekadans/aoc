from enum import Enum
from collections import Counter
from input import lines

strength = list(reversed(['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2', 'J']))


class HandType(Enum):
    FIVE = 6
    FOUR = 5
    HOUSE = 4
    THREE = 3
    TWOPAIR = 2
    PAIR = 1
    HIGH = 0


def identify(hand_list) -> HandType:
    c = Counter(hand_list)
    jokers = c.get('J', 0)
    del c['J']

    hand_sort = sorted(c.values(), reverse=True)
    most_common = hand_sort[0] if len(hand_sort) > 0 else 0

    if (most_common + jokers) == 5:
        return HandType.FIVE
    elif (most_common + jokers) == 4:
        return HandType.FOUR
    elif sum(hand_sort[0:2]) + jokers == 5:
        return HandType.HOUSE
    elif (most_common + jokers) == 3:
        return HandType.THREE
    elif most_common == 2 and (hand_sort[1] + jokers) == 2:
        return HandType.TWOPAIR
    elif (most_common + jokers) == 2:
        return HandType.PAIR
    else:
        return HandType.HIGH


def sort_by_hand(h) -> list[int]:
    hand_list = list(h[0])
    hand_type = identify(hand_list)
    strength_by_card_pos = list(map(strength.index, hand_list))

    return [hand_type.value] + strength_by_card_pos


hands = map(
    lambda h: h.split(' '),
    lines('7')
)

sorted_hands = sorted(hands, key=sort_by_hand)

result = 0

for i, hand in enumerate(sorted_hands):
    bid = hand[1]
    result += (i+1) * int(bid)

print(result)