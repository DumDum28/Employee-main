// ฟังก์ชันกรองข้อมูลในตาราง
function filterTable() {
    const filterDate = document.getElementById("filter-date").value;
    const filterStatus = document.getElementById("filter-status").value;

    const rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
        const rowDate = row.cells[0].textContent.trim();
        const rowStatus = row.cells[7].querySelector("select").value.trim();

        // ตรวจสอบเงื่อนไขการกรอง
        const matchDate = !filterDate || rowDate === filterDate;
        const matchStatus = !filterStatus || rowStatus === filterStatus;

        // แสดงหรือซ่อนแถวตามเงื่อนไข
        row.style.display = matchDate && matchStatus ? "" : "none";
    });
}
function addRepair() {
    window.location.href = 'from_repair.html';
}

// ฟังก์ชันบันทึกข้อมูล
function saveRepair() {
    const rows = document.querySelectorAll("tbody tr");
    const updatedData = [];

    rows.forEach(row => {
        const rowData = {
            dateReceived: row.cells[0].textContent.trim(),
            license: row.cells[1].textContent.trim(),
            repairType: row.cells[2].textContent.trim(),
            equipment: row.cells[3].textContent.trim(),
            reason: row.cells[4].textContent.trim(),
            dueDate: row.cells[5].querySelector("input").value,
            reporter: row.cells[6].textContent.trim(),
            status: row.cells[7].querySelector("select").value
        };
        updatedData.push(rowData);
    });

    console.log("ข้อมูลที่บันทึก:", updatedData);
    alert("ข้อมูลถูกบันทึกเรียบร้อยแล้ว!");

    // คุณสามารถส่ง `updatedData` ไปยัง Backend ด้วย Fetch API ได้ เช่น:
    // fetch('/api/save', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify(updatedData)
    // }).then(response => response.json())
    //   .then(result => console.log(result))
    //   .catch(error => console.error('Error:', error));
}
