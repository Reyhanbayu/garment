const materialContainer = document.querySelector('.materialContainer');
const materialButton = document.getElementById('materialButton');
const totalMaterial = document.getElementById('totalMaterial');

materialButton.addEventListener('click', () => {

    totalMaterial.value = parseInt(totalMaterial.value) + 1;
  const materialForm = document.createElement('div');
  materialForm.classList.add('flex');
    materialForm.innerHTML = `
        <div class="flex flex-col w-1/3">
            <input type="number" name="input_quantity_`+totalMaterial.value+`" id="input_quantity_`+totalMaterial.value+`" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        </div>
        <div class="flex flex-col w-2/3">
            <select name="material_id_`+totalMaterial.value+`" id="material_id_`+totalMaterial.value+`" class="border border-gray-400 rounded-sm p-3 h-12" onchange="inputQuantity(`+totalMaterial.value+`)">
            </select>

        </div> 
    `
    const response = fetch(`/api/material/quantity/1`, {
        method: 'GET',
    }
    ).then(response => response.json());
    response.then(data => {
      let input = document.querySelector('input#input_quantity_'+totalMaterial.value);
      input.value=data;
    })
    materialContainer.appendChild(materialForm);
    const selectMaterial1 = document.querySelector('select#material_id_1');
    const selectMaterial2 = document.querySelector('select#material_id_'+totalMaterial.value);
    selectMaterial2.innerHTML = selectMaterial1.innerHTML;
    
});

function inputQuantity(count){
    let selectMaterial = document.querySelector('select#material_id_'+count);
    let inputMaterial = document.querySelector('input#input_quantity_'+count);


    console.log(selectMaterial.value);
    console.log(inputMaterial)

    const response = fetch(`/api/material/quantity/${selectMaterial.value}`, {
        method: 'GET',
    }
    ).then(response => response.json());
    response.then(data => {
        inputMaterial.value=data
    }
    )
}