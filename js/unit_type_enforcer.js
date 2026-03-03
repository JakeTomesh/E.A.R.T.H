"use strict";

document.addEventListener('DOMContentLoaded', () =>{
    const emissionSelect = document.getElementById('emission_type_select');
    const unitTypeSelect = document.getElementById('unit_type_select');

    if(!emissionSelect || !unitTypeSelect){
        return;
    }

    const unitTypeOptions = Array.from(unitTypeSelect.querySelectorAll('option')).filter(option => option.value !== '');

    //disable unit type select until an emission type is selected
    unitTypeOptions.forEach(option => {
        option.hidden = true;
        option.disabled = true;
    });

    function filterUnitOptions(){
      
        const selectedEmissionOption = emissionSelect.selectedOptions[0];
        const allowedBaseId = selectedEmissionOption?.getAttribute('data-base-unit-type-id');

        unitTypeSelect.disabled = !allowedBaseId;
        //reset unit type select to placeholder
        unitTypeSelect.value = '';

        //if no emission type selected, disable all unit type options
        if(!allowedBaseId){
            unitTypeOptions.forEach(option => {
                option.hidden = true;
                option.disabled = true;
            });
            return;
        }

        unitTypeOptions.forEach(option => {
            const match =  option.getAttribute('data-base-unit-type-id') === allowedBaseId;
            option.hidden = !match;
            option.disabled = !match;
        });
    }

    emissionSelect.addEventListener('change', filterUnitOptions);
    filterUnitOptions();
});