// Change color of backgound if value > 0 (green) and < 0 (red)


// Select all elements with class "balance-result"
let results = document.querySelectorAll('.balance-result');

// console.log(results);

for (let i = 0; i < results.length; i++) {
    const result = results[i];
    const value = result.innerHTML;
    // parse value to float and delete symbol $
    const valueFloat = parseFloat(value.replace('$', ''));
    // console.log(result);
    // console.log(valueFloat);
    if (valueFloat > 0) {
        result.classList.add('green');
    } else if (valueFloat < 0) {
        result.classList.add('red');
    }
}