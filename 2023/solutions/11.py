from input import rows_and_cols
from itertools import combinations

image = rows_and_cols('11')

expanding_rows = [r[0] for r in enumerate(image) if set(r[1]) == {'.'}]

expanding_columns = []
for col_index in range(len(image[0])):
    column = [image[row][col_index] for row in range(len(image))]
    if set(column) == {'.'}:
        expanding_columns.append(col_index)


def expand_and_calculate(factor):
    galaxies = []
    for i, row in enumerate(image):
        for j, col in enumerate(row):
            if col == '#':
                empty_rows = len([r for r in expanding_rows if r < i])
                empty_cols = len([c for c in expanding_columns if c < j])

                adjusted_row = i - empty_rows + (empty_rows * factor)
                adjusted_col = j - empty_cols + (empty_cols * factor)

                galaxies.append((adjusted_row, adjusted_col))

    distances = 0
    for one, two in combinations(galaxies, 2):
        distances += abs(one[0] - two[0]) + abs(one[1] - two[1])

    return distances


print('Part 1: {}'.format(expand_and_calculate(2)))
print('Part 2: {}'.format(expand_and_calculate(1000000)))
