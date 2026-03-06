"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const emissionSelect = document.getElementById("emission_type_select");
    const unitTypeSelect = document.getElementById("unit_type_select");

    if (!emissionSelect || !unitTypeSelect) {
        return;
    }

    const allUnitTypeOptions = Array.from(unitTypeSelect.querySelectorAll("option"))
        .filter(option => option.value !== "");

    const placeholderOption = unitTypeSelect.querySelector("option[value='']");

    const emissionUnitRules = {
        1: ["kWh", "MWh", "Wh"],    // electricity - grid
        2: ["kWh", "MWh", "Wh"],    // electricity - renewable
        3: ["therm", "MMBtu"],      // natural gas
        4: ["L", "gal"],            // diesel
        5: ["kg", "lb"],            // refrigerant
        6: ["L", "gal", "m3"],      // water usage
        7: ["kg", "lb"],            // waste - electronic
        8: ["kg", "lb"]             // waste landfill
    };

    function resetUnitTypeSelect() {
        unitTypeSelect.innerHTML = "";
        if (placeholderOption) {
            unitTypeSelect.appendChild(placeholderOption.cloneNode(true));
        }
        unitTypeSelect.value = "";
    }

    function filterUnitOptions() {
        const selectedEmissionOption = emissionSelect.selectedOptions[0];
        const allowedBaseId = selectedEmissionOption?.getAttribute("data-base-unit-type-id");
        const emissionId = emissionSelect.value;

        resetUnitTypeSelect();

        if (!allowedBaseId || !emissionId) {
            unitTypeSelect.disabled = true;
            return;
        }

        const allowedUnitCodes = emissionUnitRules[emissionId] || [];

        const matchingOptions = allUnitTypeOptions.filter(option => {
            const baseIdMatch =
                option.getAttribute("data-base-unit-type-id") === allowedBaseId;

            const unitCode = option.getAttribute("data-unit-code");
            const codeMatch = allowedUnitCodes.includes(unitCode);

            return baseIdMatch && codeMatch;
        });

        matchingOptions.forEach(option => {
            unitTypeSelect.appendChild(option.cloneNode(true));
        });

        unitTypeSelect.disabled = matchingOptions.length === 0;
    }

    emissionSelect.addEventListener("change", filterUnitOptions);
    filterUnitOptions();
});