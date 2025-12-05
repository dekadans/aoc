from input import lines

readings = map(
    lambda h: [int(i) for i in h.split(' ')],
    lines('9')
)


def get_edges(seq):
    if set(seq) == {0}:
        return 0, 0

    differences = [j-i for i, j in zip(seq[:-1], seq[1:])]
    first, last = get_edges(differences)
    return seq[0] - first, seq[-1] + last


extrapolations = [get_edges(r) for r in readings]
after = sum([i[1] for i in extrapolations])
before = sum([i[0] for i in extrapolations])

print('Part 1: {}'.format(after))
print('Part 2: {}'.format(before))

