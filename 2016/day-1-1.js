var input = 'L4, L3, R1, L4, R2, R2, L1, L2, R1, R1, L3, R5, L2, R5, L4, L3, R2, R2, L5, L1, R4, L1, R3, L3, R5, R2, L5, R2, R1, R1, L5, R1, L3, L2, L5, R4, R4, L2, L1, L1, R1, R1, L185, R4, L1, L1, R5, R1, L1, L3, L2, L1, R2, R2, R2, L1, L1, R4, R5, R53, L1, R1, R78, R3, R4, L1, R5, L1, L4, R3, R3, L3, L3, R191, R4, R1, L4, L1, R3, L1, L2, R3, R2, R4, R5, R5, L3, L5, R2, R3, L1, L1, L3, R1, R4, R1, R3, R4, R4, R4, R5, R2, L5, R1, R2, R5, L3, L4, R1, L5, R1, L4, L3, R5, R5, L3, L4, L4, R2, R2, L5, R3, R1, R2, R5, L5, L3, R4, L5, R5, L3, R1, L1, R4, R4, L3, R2, R5, R1, R2, L1, R4, R1, L3, L3, L5, R2, R5, L1, L4, R3, R3, L3, R2, L5, R1, R3, L3, R2, L1, R4, R3, L4, R5, L2, L2, R5, R1, R2, L4, L4, L5, R3, L4';

//input = 'R2, L3';
//input = 'R2, R2, R2';
//input = 'R5, L5, R5, R3';

input = input.split(', ');

var directions = ['y', 'x', '-y', '-x'];

var position = {x: 0, y: 0};
var direction = 'y';

input.forEach(function (step) {
    var curDirectionIndex = directions.indexOf(direction),
        spaces = parseInt(step.substr(1), 10);

    if (step[0] === 'R') {
        if (curDirectionIndex + 1 >= directions.length) {
            direction = directions[0];
        } else {
            direction = directions[curDirectionIndex + 1];
        }
    } else {
        if (curDirectionIndex - 1 < 0) {
            direction = directions[directions.length - 1];
        } else {
            direction = directions[curDirectionIndex - 1];
        }
    }

    switch (direction) {
        case 'y':
            position.y += spaces;
            break;
        case 'x':
            position.x += spaces;
            break;
        case '-x':
            position.x -= spaces;
            break;
        case '-y':
            position.y -= spaces;
            break;
    }
});

console.log(Math.abs(position.x) + Math.abs(position.y));