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
