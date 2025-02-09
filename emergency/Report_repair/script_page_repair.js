document.addEventListener('DOMContentLoaded', function() {
    const repairTableBody = document.getElementById('repair-table-body');
    const repairs = JSON.parse(localStorage.getItem('repairs')) || [];

    repairs.forEach(repair => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${repair.date}</td>
            <td>${repair.license}</td>
            <td>${repair.category}</td>
            <td>${repair.device}</td>
            <td>${repair.reason}</td>
            <td>${repair.driver}</td>
            <td>${repair.status}</td>
        `;
        repairTableBody.appendChild(row);
    });
});

