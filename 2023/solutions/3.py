from input import lines
from math import prod

inval = [list(x) for x in lines('3')]

ids = []
stars = {}

for r, row in enumerate(inval):
    progress = ''
    start = 0
    for i, char in enumerate(row):
        if not char.isnumeric() and len(progress) > 0:
            ids.append((progress, r, start))
            progress = ''

        if char.isnumeric():
            if len(progress) == 0:
                start = i
            progress = progress + char

        if char == '*':
            stars[(r, i)] = []

    if len(progress) > 0:
        ids.append((progress, r, start))
        progress = ''

valid_parts = []

for part, row, start in ids:
    same_row = inval[row]
    before = same_row[start-1] if start != 0 else '.'

    if before == '*':
        stars[(row, start-1)].append(int(part))

    after = same_row[start+len(part)] if start+len(part) < len(same_row) else '.'

    if after == '*':
        stars[(row, start+len(part))].append(int(part))

    def find_above_below(row_search):
        search = inval[row_search]
        start_search = start-1 if start != 0 else start
        stop_search = (start+len(part)+1) if start < len(search) else start+len(part)
        search_range = search[start_search:stop_search]

        for c, char in enumerate(search_range):
            if char == '*':
                stars[(row_search, start_search+c)].append(int(part))

        return search_range

    above = find_above_below(row-1) if row > 0 else []
    below = find_above_below(row+1) if row < len(inval)-1 else []

    adjacent = [before, after] + above + below
    no_dots = list(filter(lambda p: p != '.' and not p.isnumeric(), adjacent))

#    print('Part {}'.format(part))
#    print(no_dots)

    if len(no_dots) > 0:
        valid_parts.append(int(part))

print(sum(valid_parts))

gear_ratios = []
for s in stars.values():
    if len(s) == 2:
        gear_ratios.append(prod(s))

print(sum(gear_ratios))
