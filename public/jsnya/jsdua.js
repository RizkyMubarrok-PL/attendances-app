let subMenu = document.getElementById("subMenu");

function toggleMenu(){
    subMenu.classList.toggle("open-menu")
}

const styleSheet = document.createElement('style');
styleSheet.textContent = `
    input[type="date"] {
        color: #2A8579;
    }
    
    /* Style the calendar icon */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(48%) sepia(13%) saturate(1640%) hue-rotate(130deg) brightness(92%) contrast(87%);
    }
    
    /* Style the date input when focused */
    input[type="date"]:focus {
        border-color: #2A8579;
        box-shadow: 0 0 0 0.2rem rgba(42, 133, 121, 0.25);
    }
`;
document.head.appendChild(styleSheet);

document.addEventListener('DOMContentLoaded', function() {
    // Get all necessary elements
    const filterType = document.getElementById('filterType');
    const inputPerhari = document.getElementById('input-perhari');
    const inputPerbulan = document.getElementById('input-perbulan');
    const inputPersemester = document.getElementById('input-persemester');
    const filterDate = document.getElementById('filterDate');
    const filterMonth = document.getElementById('filterMonth');
    const tableBody = document.querySelector('table tbody');
    const tableHead = document.querySelector('table thead tr');

    // Set today's date
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    const todayString = `${yyyy}-${mm}-${dd}`;
    
    // Set date input to today
    filterDate.value = todayString;
    
    // Set default month to current month
    filterMonth.value = today.getMonth() + 1;

    // Function to hide all filter inputs
    function hideAllInputs() {
        inputPerhari.classList.add('d-none');
        inputPerbulan.classList.add('d-none');
        inputPersemester.classList.add('d-none');
    }

    // Function to update table headers
    function updateTableHeaders(filterValue) {
        if (filterValue === 'perhari') {
            tableHead.innerHTML = `
                <th>No</th>
                <th>Name</th>
                <th>Action</th>
            `;
        } else {
            tableHead.innerHTML = `
                <th>No</th>
                <th>Name</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpha</th>
            `;
        }
    }

    // Function to update table content
    function updateTableContent(filterValue) {
        if (filterValue === 'perhari') {
            tableBody.innerHTML = `
                <tr>
                    <td>1</td>
                    <td>Brian Mubarok Farel</td>
                    <td>
                        <div class="d-flex">
                            <select class="form-select" name="" id="">
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alpha">Alpha</option>
                            </select>
                            <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#popupModal">
                                <i class="fa fa-info-circle"></i>
                                <i class="info-tulisan">info</i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Depa Bintang Yeremi</td>
                    <td>
                        <div class="d-flex">
                            <select class="form-select" name="" id="">
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alpha">Alpha</option>
                            </select>
                            <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#popupModal">
                                <i class="fa fa-info-circle"></i>
                                <i class="info-tulisan">info</i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            // Example data for monthly/semester view
            tableBody.innerHTML = `
                <tr>
                    <td>1</td>
                    <td>Brian Mubarok Farel</td>
                    <td>15</td>
                    <td>2</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Depa Bintang Yeremi</td>
                    <td>16</td>
                    <td>1</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
            `;
        }
    }

    // Function to show appropriate filter input and update table
    function showFilterInput(filterValue) {
        hideAllInputs();
        
        switch(filterValue) {
            case 'perhari':
                inputPerhari.classList.remove('d-none');
                break;
            case 'perbulan':
                inputPerbulan.classList.remove('d-none');
                break;
            case 'persemester':
                inputPersemester.classList.remove('d-none');
                break;
            default:
                inputPerhari.classList.remove('d-none');
        }

        updateTableHeaders(filterValue);
        updateTableContent(filterValue);
    }
    
    // Show default input (perhari) on page load
    showFilterInput('perhari');
    
    // Add event listener for filter type changes
    filterType.addEventListener('change', function(e) {
        showFilterInput(e.target.value);
    });

    // Add event listeners for other filter changes
    filterMonth.addEventListener('change', function() {
        updateTableContent('perbulan');
    });

    filterDate.addEventListener('change', function() {
        updateTableContent('perhari');
    });

    document.getElementById('filterSemester').addEventListener('change', function() {
        updateTableContent('persemester');
    });
});