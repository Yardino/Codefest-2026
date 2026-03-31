<div class="container mx-auto p-0">
    <div class="card bg-base-100 shadow-2xl border-t-4 border-primary max-w-4xl mx-auto mt-0">
        <div class="card-body pt-6">
                <h2 class="card-title text-2xl text-center justify-center mb-6">CRUD Management</h2>

                <!-- Add New Button -->
                <div class="flex justify-end items-center gap-2 mb-4">
                    <button class="btn btn-primary btn-md" onclick="openModal()">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                        Add New Item
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTable">
                            <!-- Sample data - replace with dynamic content -->
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>2024-01-15</td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-sm btn-outline btn-info" onclick="editItem(1)">
                                            <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="m18.5 2.5 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></g></svg>
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-error" onclick="deleteItem(1)">
                                            <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></g></svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>2024-01-20</td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-sm btn-outline btn-info" onclick="editItem(2)">
                                            <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="m18.5 2.5 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></g></svg>
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-error" onclick="deleteItem(2)">
                                            <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></g></svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="crudModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modalTitle">Add New Item</h3>
            <form id="crudForm" class="space-y-4 mt-4">
                <input type="hidden" id="itemId" name="id">

                <div>
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" id="itemName" name="name" class="input input-primary w-full" required>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" id="itemEmail" name="email" class="input input-primary w-full" required>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select id="itemStatus" name="status" class="select select-primary w-full">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Confirm Delete</h3>
            <p class="py-4">Are you sure you want to delete this item? This action cannot be undone.</p>
            <div class="modal-action">
                <button class="btn" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn btn-error" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;

        function openModal(itemId = null) {
            const modal = document.getElementById('crudModal');
            const form = document.getElementById('crudForm');
            const title = document.getElementById('modalTitle');

            if (itemId) {
                title.textContent = 'Edit Item';
                // TODO: Load item data from server
                // For now, just set the ID
                document.getElementById('itemId').value = itemId;
            } else {
                title.textContent = 'Add New Item';
                form.reset();
            }

            modal.classList.add('modal-open');
        }

        function closeModal() {
            const modal = document.getElementById('crudModal');
            modal.classList.remove('modal-open');
        }

        function editItem(id) {
            openModal(id);
            // TODO: Fetch item data and populate form
        }

        function deleteItem(id) {
            currentDeleteId = id;
            const modal = document.getElementById('deleteModal');
            modal.classList.add('modal-open');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('modal-open');
            currentDeleteId = null;
        }

        function confirmDelete() {
            if (currentDeleteId) {
                // TODO: Send delete request to server
                console.log('Deleting item:', currentDeleteId);

                // Remove from table (temporary)
                const row = document.querySelector(`tr[data-id="${currentDeleteId}"]`);
                if (row) row.remove();

                closeDeleteModal();
            }
        }

        // Form submission
        document.getElementById('crudForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            // TODO: Send data to server
            console.log('Saving item:', data);

            // Close modal
            closeModal();

            // TODO: Refresh table data
        });

        // Close modals when clicking outside
        document.getElementById('crudModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
