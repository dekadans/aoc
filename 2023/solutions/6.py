from input import lines
import re
from math import prod

digits = re.compile('\\d+')

times, distances = map(lambda r: list(map(int, digits.findall(r))), lines('6'))

record_options = []

for i, time in enumerate(times):
    distance = distances[i]
    count_options = 0
    time_pressed = 0

    while True:
        time_pressed = time_pressed + 1
        result = time_pressed * (time - time_pressed)
        if result > distance:
            count_options = count_options + 1
        elif count_options > 0:
            record_options.append(count_options)
            break

print(prod(record_options))