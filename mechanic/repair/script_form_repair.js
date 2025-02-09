document.addEventListener('DOMContentLoaded', () => {
    const dateField = document.getElementById('currentDate');
    const noteField = document.getElementById('note');
    const reasonField = document.getElementById('reason');
    const categoryField = document.getElementById('category');
    const deviceField = document.getElementById('device');
    const cancelButton = document.getElementById('cancel-button');
    const levelField = document.getElementById('level');
    const numberField = document.getElementById('number');

    const getCurrentDate = () => {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    dateField.value = getCurrentDate();
    noteField.disabled = true;

    reasonField.addEventListener('change', () => {
        if (reasonField.value === 'other') {
            noteField.disabled = false;
        } else {
            noteField.disabled = true;
            noteField.value = '';
        }
    });

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

    categoryField.addEventListener('change', () => {
        const category = categoryField.value;
        let deviceOptions = '';
        let reasonOptions = '';

        if (category === 'รถพยาบาล') {
            deviceOptions = `
                <option value="เครื่องยนต์">เครื่องยนต์</option>
                <option value="ยาง">ยาง</option>
                <option value="เบรก">เบรก</option>
            `;
            reasonOptions = `
                <option value="ชำรุด">ชำรุด</option>
                <option value="หมดอายุ">หมดอายุ</option>
                <option value="other">อื่นๆ</option>
            `;
        } else if (category === 'อุปกรณ์ทางการแพทย์') {
            deviceOptions = `
                <option value="AED">AED</option>
                <option value="เตียง">เตียง</option>
                <option value="เครื่องช่วยหายใจ">เครื่องช่วยหายใจ</option>
                <option value="เฝือกลม">เฝือกลม</option>
                <option value="ถังออกซิเจน">ถังออกซิเจน</option>
                <option value="อุปกรณ์ปฐมพยาบาล">อุปกรณ์ปฐมพยาบาล</option>
            `;
            reasonOptions = `
                <option value="ชำรุด">ชำรุด</option>
                <option value="หมดอายุ">หมดอายุ</option>
                <option value="other">อื่นๆ</option>
            `;
        }

        deviceField.innerHTML = `<option value="" disabled selected>ระบุอุปกรณ์</option>${deviceOptions}`;
        reasonField.innerHTML = `<option value="" disabled selected>สาเหตุ</option>${reasonOptions}`;
    });

    cancelButton.addEventListener('click', () => {
        window.location.href = 'repair.html';
    });
});

document.querySelector('.save-button').addEventListener('click', function(event) {
    event.preventDefault(); // ป้องกันการ submit form

    const date = document.getElementById('currentDate').value;
    const license = document.getElementById('license').value;
    const category = document.getElementById('category').value;
    const device = document.getElementById('device').value;
    let reason = document.getElementById('reason').value;
    const note = document.getElementById('note').value;
    const driver = document.getElementById('reporter').value;

    if (reason === 'other' && note) {
        reason = `อื่นๆ: ${note}`;
    }

    if (!date || !license || !category || !device || !reason || !driver) {
        alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
        return;
    }

    const repairData = {
        date,
        license,
        category,
        device,
        reason,
        driver
    };

    let repairs = JSON.parse(localStorage.getItem('repairs')) || [];
    repairs.push(repairData);
    localStorage.setItem('repairs', JSON.stringify(repairs));

    window.location.href = 'repair.html';
});