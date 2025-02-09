const results = {};

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('carReportForm');
    const levelField = form.querySelector('#level');
    const numberField = form.querySelector('#number');
    
    form.addEventListener('submit', submitForm);

    levelField.addEventListener('change', () => {
        const level = levelField.value;
        let numberOptions = '';

        if (level === 'ระดับ 1') {
            numberOptions = `
                <option value="กข1234">กข1234</option>
                <option value="คต5678">คต5678</option>
            `;
        } else if (level === 'ระดับ 2') {
            numberOptions = `
                <option value="งง9101">งง9101</option>
                <option value="จช1213">จช1213</option>
            `;    
        } else if (level === 'ระดับ 3') {
            numberOptions = `
                <option value="ฉน1415">ฉน1415</option>
                <option value="ชบ1617">ชบ1617</option>
            `;
        }
        numberField.innerHTML = `<option value="" disabled selected>ระบุทะเบียนรถ</option>${numberOptions}`;
    });
});

function submitForm(event) {
    event.preventDefault(); 
    location.href = 'car_report_success.html'; 
}

function toggleDropdown(name) {
    const radioNo = document.querySelector(`input[name="${name}"][value="no"]`);
    const dropdown = document.getElementById(`${name}-dropdown`);
    const otherField = document.getElementById(`${name}-other`);

    dropdown.disabled = !radioNo.checked;

    if (!radioNo.checked) {
        otherField.disabled = true; 
        otherField.value = "";     
    }

    const selectedValue = document.querySelector(`input[name="${name}"]:checked`).value;
    results[name] = { status: selectedValue, dropdown: dropdown.value, other: otherField.value };
    console.log(results);
}

function updateDropdown(name) {
    const dropdown = document.getElementById(`${name}-dropdown`);
    const otherField = document.getElementById(`${name}-other`);

    if (dropdown.value === "other") {
        otherField.disabled = false;
    } else {
        otherField.disabled = true;
        otherField.value = ""; 
    }

    results[name].dropdown = dropdown.value;
    results[name].other = otherField.value;
    console.log(results);
}

function resetForm() {
    document.getElementById('carReportForm').reset();
}