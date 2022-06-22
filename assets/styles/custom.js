// Change color of backgound if value > 0 (green) and < 0 (red)


// Select all elements with class "balance-result"
// let results = document.querySelectorAll('.balance-result');

// Colorise le resultat final 
// for (let i = 0; i < results.length; i++) {
//     const result = results[i];
//     const value = result.innerHTML;
//     // parse value to float and delete symbol $
//     const valueFloat = parseFloat(value.replace('$', ''));
//     // console.log(result);
//     // console.log(valueFloat);
//     if (valueFloat > 0) {
//         result.classList.add('green');
//     } else if (valueFloat < 0) {
//         result.classList.add('red');
//     }
// }

// Generate a line with the total of element in table displayed in the page

// let allTables = document.querySelectorAll('.trades');
// console.log(allTables);
// // get id from each table and add it to the array
// let tablesId = [];
// for (let i = 0; i < allTables.length; i++) {
//     const table = allTables[i];
//     tablesId.push(table.id);
// }
// // console.log(tablesId);

// // calcul total of each table in addition to the total of all  fields
// let total = [];
// for (let i = 0; i < tablesId.length; i++) {


//     const tableId = tablesId[i];
//     const table = document.getElementById(tableId);
//     let totalTable = 0;
//     let totalSell = 0;
//     let totalBuy = 0;
//     // get all rows of the table
//     let rows = table.querySelectorAll('tr.tr-body');
//     /// get dataset.orderMount of each row with a select of the good td
//     // Make assoc array agregate by action (buy or sell)
//     let assocArray = [];
//     for (let i = 0; i < rows.length; i++) {
//         const row = rows[i];
//         const dataAction = row.querySelector('td.td-action').dataset.action;
//         const orderMount = row.querySelector('td.td-mount').dataset.mount;
//         // console.log(orderMount);
//         assocArray.push({
//             action: dataAction,
//             mount: orderMount
//         });
//     }
//     // addition of all the value with same action of the assoc array
//     for (let i = 0; i < assocArray.length; i++) {
//         const element = assocArray[i];
//         // console.log(element.action);
//         // console.log(element.mount);
//         if (element.action == 1) {
//             totalTable += parseFloat(element.mount);
//             totalSell += parseFloat(element.mount);
//         } else if (element.action == 2) {
//             totalTable -= parseFloat(element.mount);
//             totalBuy += parseFloat(element.mount);
//         }
//     }

//     // display result in footer of the table
//     const footer = table.querySelector('.tfoot');
//     footer.querySelector('td>.balance').innerHTML = totalTable.toFixed(2) + "$";
//     footer.querySelector('td>.total-buy').innerHTML = totalBuy.toFixed(2) + "$";
//     footer.querySelector('td>.total-sell').innerHTML = totalSell.toFixed(2) + "$";
// }
// console.log(total);