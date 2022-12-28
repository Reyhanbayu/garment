const selectType = document.querySelector('select#selectType');
const selectSubType = document.querySelector('select#selectSubType');
const tr= document.querySelectorAll('tbody tr');


selectType.addEventListener('change', function() {
    tr.forEach(element => {
        element.classList.add('hidden');
    });

    if (selectSubType.hasAttribute('disabled')) {
        selectSubType.removeAttribute('disabled');
        
    }

    //fetch to subcategory
    fetch(`/api/subcategory/${selectType.value}`)
        .then(response => response.json())
        .then(data => {
            //remove hidden class if class match with data array
            id=data.map(subcategory => subcategory.id);
            console.log(id);
            id.forEach(id => {
                tr.forEach(tr => {
                    if (tr.classList.contains(id)) {
                        tr.classList.remove('hidden');
                    }
                });
            });

            //change options selected
            selectSubType.innerHTML = '';
            const option = document.createElement('option');
            option.value = '0';
            option.textContent = 'Select Subcategory';
            selectSubType.appendChild(option);
            data.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.sub_category_name;
                selectSubType.appendChild(option);
            });

            //subCategory change
            selectSubType.addEventListener('change', function() {
                tr.forEach(element => {
                    element.classList.add('hidden');
                });

                //remove hidden class if class match with data array
                id=selectSubType.value;

                tr.forEach(tr => {
                    if (tr.classList.contains(id)) {
                        tr.classList.remove('hidden');
                    }
                });
            });

            
        });

        

});

const search = document.querySelector('input#search');
search.addEventListener('keyup', function() {
    tr.forEach(element => {
        element.classList.add('hidden');
    });

    let filter = search.value.toUpperCase();
    tr.forEach(tr => {
        let td = tr.getElementsByTagName('td')[1];
        if (td) {
            let textValue = td.textContent || td.innerText;
            if (textValue.toUpperCase().indexOf(filter) > -1) {
                tr.classList.remove('hidden');
            }
        }
    });
});

function sort(nrow) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[nrow];
            y = rows[i + 1].getElementsByTagName("TD")[nrow];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    
}
