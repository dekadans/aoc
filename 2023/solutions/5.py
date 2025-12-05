from input import load
import re

digits = re.compile('\\d+')
data = load('5').split('\n\n')

seeds = list(map(int, digits.findall(data.pop(0))))
data = map(
    lambda m: list(map(
        lambda n: list(map(int, digits.findall(n))),
        m[1:]
    )),
    map(
        lambda m: m.splitlines(),
        data
    )
)

data = list(data)
locations = []

for seed in seeds:
    dest = seed
    for maps in data:
        for m in maps:
            source_start = m[1]
            dest_start = m[0]
            r = m[2]
            if source_start <= dest < (source_start+r):
                dest = dest_start + (dest - source_start)
                break

    locations.append(dest)

print(min(locations))

lowest = -1
seeds_grouped = list(zip(seeds[::2],seeds[1::2]))

r_data = list(reversed(data))

while True:
    lowest = lowest + 1
    dest = lowest
    for maps in r_data:
        for m in maps:
            source_start = m[0]
            dest_start = m[1]
            r = m[2]
            if source_start <= dest < (source_start+r):
                dest = dest_start + (dest - source_start)
                break

    for seed_start, seed_range in seeds_grouped:
        if seed_start <= dest < (seed_start+seed_range):
            print(dest, lowest)
            exit(1)