from input import lines
import sys
import re

### Incomplete solution!

r = re.compile('^#+')
r2 = re.compile('^[#?]+')

sys.setrecursionlimit(100)

g_found = 0

def magic(s, p, g, found):
    print(s, p, g)
    if len(s) == 0 and len(g) == 0:
        print('found!')
        global g_found
        g_found += 1
        return 1
    elif len(s) == 0 and len(g) > 0:
        return 0
    elif len(s) < sum(g):
        return 0
    elif len(g) == 0 and set(s) != {'.'}:
        return 0


    if len(g) > 0:
        test_length = g[0]
        test_string = ''.join(s[:test_length])
        test_chars = set(test_string)

        test_all = ''.join(s)
        first_broken = r.findall(test_all)
        first_broken = first_broken.pop() if len(first_broken) > 0 else ''

        first_options = r2.findall(test_all)
        first_options = first_options.pop() if len(first_options) > 0 else '????????????????????????????????????????'

        if len(first_broken) > test_length:
            s = []
        elif len(first_options) < test_length:
            print('ooop22', first_options)
            s = []
        elif test_chars == {'#'} and (len(s) == test_length or s[test_length] != '#'):
            s = s[test_length:]
            g = g[1:]
            p = 0
            if len(s) > 0 and s[0] == '?':
                s[0] = '.'
        elif '.' in test_chars and len(g) == 1 and len(s) < test_length:
            s = []

    if len(s) == 0:
        found += magic(s, p, g, found)
    elif s[p] == '#':
        found += magic(s, p+1, g, found)
    elif s[p] == '?':
        s[p] = '.'
        found += magic(s, p, g, found)
        s[p] = '#'
        found += magic(s, p, g, found)
    else:
        found += magic(s[1:], 0, g, found)

    return found


for status, groups in [row.split(' ') for row in lines('12')]:
    status = list(status)
    groups = [int(i) for i in groups.split(',')]

    print(magic(status, 0, groups, 0))
    print(g_found)
