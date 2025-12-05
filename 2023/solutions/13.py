from input import load

inval = [m.splitlines() for m in load('13').split('\n\n')]


def candidates(collection):
    cands = []
    for i in range(len(collection[:-1])):
        a = collection[i]
        b = collection[i+1]
        diff_sum = 0

        for j in range(len(a)):
            if a[j] != b[j]:
                diff_sum += 1

        if diff_sum < 2:
            cands.append(i)

    return cands


def confirm(index, collection):
    a = index
    b = index + 1
    diff_sum = 0

    while a >= 0 and b < len(collection):

        for c in range(len(collection[a])):
            if collection[a][c] != collection[b][c]:
                diff_sum += 1

        a -= 1
        b += 1

    return diff_sum == 1

result_1 = 0

for island_map in inval:
    rows = [list(r) for r in island_map]

    columns = []
    for col_index in range(len(rows[0])):
        columns.append([rows[row][col_index] for row in range(len(rows))])

    for r in candidates(rows):
        if confirm(r, rows):
            result_1 += (r+1) * 100

    for c in candidates(columns):
        if confirm(c, columns):
            result_1 += (c+1)

print(result_1)