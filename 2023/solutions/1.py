from input import lines

inval = lines('1')
val = [filter(str.isnumeric, x) for x in inval]

values = []

for row in val:
    r = list(row)
    first = r[0]
    last = r[-1]
    values.append(int(first + last))

print(sum(values))
###

translate = [
    ('one', '1'),
    ('two', '2'),
    ('three', '3'),
    ('four', '4'),
    ('five', '5'),
    ('six', '6'),
    ('seven', '7'),
    ('eight', '8'),
    ('nine', '9')
]


corrected = []


def find_num(line: str, reverse = False):
    found = []
    for t in translate:
        if reverse:
            i = line.rfind(t[0])
        else:
            i = line.find(t[0])
        if i > -1:
            found.append((i, t))

    if len(found) > 0:
        result = sorted(found)

        if reverse:
            result = list(reversed(result))
            alpha, numeric = result[0][1]
            line = numeric.join(l.rsplit(alpha, 1))
        else:
            alpha, numeric = result[0][1]
            line = numeric.join(l.split(alpha, 1))

    line = list(filter(str.isnumeric, list(line)))
    if reverse:
        return line[-1]
    else:
        return line[0]


values = []

for l in inval:
    first = find_num(l)
    last = find_num(l, True)
    values.append(int(first + last))

#print(values)

print(sum(values))
