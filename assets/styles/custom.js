// Select all th and td in table

// let table = document.querySelector('#wallet-table');

// let thtd = table.querySelectorAll('th, td');

// // add class align-middle to all th and td
// thtd.forEach(function(item) {
//     item.classList.add('align-middle');
// });

// // add class align-center to all th and td
// thtd.forEach(function(item) {
//     item.classList.add('text-center');
// });

// alert('Hello World');
// Colorise the variation of the table Set text red and green color for positive and negative variation
let variation = document.querySelectorAll('.color-variation');
console.log(variation);

// Check the value of all selected elements and colorise the table each minute
variation.forEach(function(item) {

    let value = item.innerHTML.slice(0, -1);
    // Transform string in number and colorise the table
    if (value >= 0) {
        item.style.color = '#1cf000';
    } else if (value < 0) {
        item.style.color = '#f00000';
    }

});