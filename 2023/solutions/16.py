from input import rows_and_cols
from enum import Enum
import operator

### Incomplete solution! (Only Part 1)

class Direction(Enum):
    UP = (-1, 0)
    RIGHT = (0, 1)
    DOWN = (1, 0)
    LEFT = (0, -1)

    def right_angle(self, mirror):
        if mirror == '/':
            if self == Direction.RIGHT:
                return Direction.UP
            elif self == Direction.DOWN:
                return Direction.LEFT
            elif self == Direction.LEFT:
                return Direction.DOWN
            elif self == Direction.UP:
                return Direction.RIGHT
        elif mirror == '\\':
            if self == Direction.RIGHT:
                return Direction.DOWN
            elif self == Direction.DOWN:
                return Direction.RIGHT
            elif self == Direction.LEFT:
                return Direction.UP
            elif self == Direction.UP:
                return Direction.LEFT


data = rows_and_cols('16')

ray_count = 0

class Ray:
    def __init__(self, position, direction, path=None):
        self.position = position
        self.direction = direction
        self.path = path if path is not None else [position]
        self.ongoing = True
        self.id = 1

    def __repr__(self):
        return 'Ray ' + str(self.id)


    def move(self):
        self.position = tuple(map(operator.add, self.position, self.direction.value))

        # print('Move ray {} to {}'.format(self.id, self.position))

        if not self.is_inside():
            self.ongoing = False
            # print('Outside!')
            return None

        t = self.tile()
        if t == '/' or t == '\\':
            self.direction = self.direction.right_angle(t)
        elif t == '-':
            if self.direction == Direction.UP or self.direction == Direction.DOWN:
                self.direction = Direction.LEFT
                return Ray(self.position, Direction.RIGHT, self.path)
        elif t == '|':
            if self.direction == Direction.LEFT or self.direction == Direction.RIGHT:
                self.direction = Direction.UP
                return Ray(self.position, Direction.DOWN, self.path)

        return None

    def is_inside(self):
        row, col = self.position
        if 0 <= row < len(data) and 0 <= col < len(data[0]):
            return True
        else:
            return False

    def tile(self):
        row, col = self.position
        return data[row][col]


rays = [Ray((0, -1), Direction.RIGHT)]
points = set()

while True:
    for ray in rays:
        if ray.ongoing:
            clone = ray.move()
            if ray.is_inside():
                points.add(ray.position)
            if clone is not None:
                points.add(clone.position)
                clone.id = len(rays) + 1
                rays.append(clone)

    if len(rays) > 100000:
        break

    if len([r for r in rays if r.ongoing]) == 0:
        break

print(len(points))