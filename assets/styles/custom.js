// Select all th and td in table

let table = document.querySelector('#wallet-table');

let thtd = table.querySelectorAll('th, td');

// add class align-middle to all th and td
thtd.forEach(function(item) {
    item.classList.add('align-middle');
});

// add class align-center to all th and td
thtd.forEach(function(item) {
    item.classList.add('text-center');
});