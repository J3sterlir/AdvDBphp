function enableEdit(rowId) {
            const row = document.getElementById('row-' + rowId);
            if(!row) return;
            // Save current cell values
            const supplierCell = row.querySelector('.cell-supplier');
            const dateCell = row.querySelector('.cell-date');
            const totalCell = row.querySelector('.cell-total');
            const actionsCell = row.querySelector('.cell-actions');

            // Backup original text for cancel
            row.dataset.originalSupplier = supplierCell.textContent;
            row.dataset.originalDate = dateCell.textContent;
            row.dataset.originalTotal = totalCell.textContent;

            // Replace cells with inputs prefilled
            supplierCell.innerHTML = `<input type="text" name="edit_supplier" value="${supplierCell.textContent.trim()}" required form="form-${rowId}"/>`;
            dateCell.innerHTML = `<input type="date" name="edit_receipt_date" value="${dateCell.textContent.trim()}" required form="form-${rowId}"/>`;
            
            let totalValue = totalCell.textContent.trim().replace(/,/g,'');
            totalCell.innerHTML = `<input type="number" name="edit_total" step="0.01" value="${totalValue}" required form="form-${rowId}"/>`;

            // Change actions: Edit/Delete -> Save/Cancel inside form with unique id
            actionsCell.innerHTML = `
                <form method="POST" id="form-${rowId}" class="inline-form" onsubmit="return validateEdit(this);">
                    <input type="hidden" name="edit_id" value="${rowId}">
                    <input type="hidden" name="action" value="edit">
                    <button type="submit" class="save">Save</button>
                    <button type="button" class="cancel" onclick="cancelEdit('${rowId}')">Cancel</button>
                </form>
            `;
        }

        function cancelEdit(rowId) {
            const row = document.getElementById('row-' + rowId);
            if(!row) return;
            const supplierCell = row.querySelector('.cell-supplier');
            const dateCell = row.querySelector('.cell-date');
            const totalCell = row.querySelector('.cell-total');
            const actionsCell = row.querySelector('.cell-actions');

            // Restore original text
            supplierCell.textContent = row.dataset.originalSupplier;
            dateCell.textContent = row.dataset.originalDate;
            totalCell.textContent = parseFloat(row.dataset.originalTotal).toFixed(2);

            // Restore actions cell
            actionsCell.innerHTML = `
            <button class="edit" type="button" onclick="enableEdit('${rowId}')">Edit</button>
            <form method="POST" class="inline-form" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this receipt?');">
                <input type="hidden" name="delete_id" value="${rowId}">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="delete">Delete</button>
            </form>
            `;
        }

        function validateEdit(form) {
            let supplier = form.querySelector('input[name="edit_supplier"]').value.trim();
            let date = form.querySelector('input[name="edit_receipt_date"]').value;
            let total = form.querySelector('input[name="edit_total"]').value.trim();

            if (!supplier) {
                alert('Supplier is required');
                return false;
            }
            if (!date) {
                alert('Date is required');
                return false;
            }
            if (!total || isNaN(total) || Number(total) <= 0) {
                alert('Please enter a valid total amount > 0');
                return false;
            }
            return true; // allow submission
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    contents.forEach(c => c.classList.remove('active'));
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');
                    const target = tab.getAttribute('data-tab');
                    document.getElementById(target).classList.add('active');
                });
            });
        });