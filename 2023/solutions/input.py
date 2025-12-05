

def load(number):
    with open('../inputs/{}.txt'.format(number)) as data:
        return data.read()


def lines(number):
    return load(number).splitlines()


def rows_and_cols(number):
    return [list(row) for row in lines(number)]


def flip(array):
    columns = []
    for col_index in range(len(array[0])):
        columns.append([array[row][col_index] for row in range(len(array))])
    return columns