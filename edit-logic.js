const editTable = document.querySelector('table#editable-cards-table');
const editDialog = document.querySelector('dialog#edit-card-dialog');

editTable.querySelectorAll('tbody>tr').forEach( row => {
    row.onclick = () => {
        console.log({row});
        // TODO: set values based on selected card
        editDialog.querySelector('legend').innerText = `Editing values for card#${row.cells[0].innerText}`;
        editDialog.querySelector('textarea[name="card-front"]').innerText = row.cells[1].innerText;
        editDialog.querySelector('select[name="card-direction"]').value = row.cells[2].innerText;
        editDialog.querySelector('textarea[name="card-back"]').innerText = row.cells[3].innerText;
        editDialog.querySelector('input[name="card-new-date"]').value = row.cells[4].innerText;

        // TODO: look up how to do properly for date
    }
});
