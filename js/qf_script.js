/**
 * Decrease Value Function
 */

function decreaseValue(id, limit) {
    var value = parseInt(document.getElementById(id).value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    if (limit && value <= limit) return;
    value--;
    document.getElementById(id).value = value;
}


/**
 * Increase Value Function
 */

function increaseValue(id, limit) {
    var value = parseInt(document.getElementById(id).value, 10);
    value = isNaN(value) ? 0 : value;
    if (limit && value >= limit) return;
    value++;
    document.getElementById(id).value = value;
}