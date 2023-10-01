const editTable = document.querySelector('table#editable-cards-table');
const editDialog = document.querySelector('dialog#edit-card-dialog');

editTable.querySelectorAll('tbody>tr').forEach( row => {
    row.onclick = () => {
        const cardId = row.cells[0].innerText;
        editDialog.querySelector('input[name="id"]').value = cardId;
        editDialog.querySelector('legend').innerText = `Editing values for card#${cardId}`;
        editDialog.querySelector('textarea[name="card-front"]').innerText = row.cells[1].innerText;
        editDialog.querySelector('select[name="card-direction"]').value = row.cells[2].innerText;
        editDialog.querySelector('textarea[name="card-back"]').innerText = row.cells[3].innerText;
        editDialog.querySelector('input[name="card-new-date"]').value = row.cells[4].innerText;

        editDialog.showModal();
    }
});

editDialog.querySelector('.dialog-cancel').onclick = () => editDialog.close();
