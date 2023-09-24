const editTable = document.querySelector('table#editable-cards-table');
const editDialog = document.querySelector('dialog#edit-card-dialog');

editTable.querySelectorAll('tbody>tr').forEach( row => {
    row.onclick = () => {
        console.log({row});
        // TODO: set values based on selected card
        editDialog.querySelector('legend').innerText = `Editing values for card#${row.cells[0].innerText}`;
        editDialog.querySelector('textarea[name="card-front"]').innerText = row.cells[1].innerText;
        // TODO: look up how to do properly for dropdown list
        editDialog.querySelector('textarea[name="card-back"]').innerText = row.cells[3].innerText;
        // TODO: look up how to do properly for date
    }
});
