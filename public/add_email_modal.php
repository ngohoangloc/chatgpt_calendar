<!-- Modal để thêm người dùng vào vai trò -->
<div class="modal fade" id="addUserToRoleModal" tabindex="-1" aria-labelledby="addUserToRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserToRoleModalLabel">Thêm Email vào Vai Trò</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserToRoleForm">
                    <input type="text" class="form-control" id="role_id" name="role_id" hidden>
                    <div class="form-group">
                        <label for="role">Vai Trò</label>
                        <input type="text" class="form-control" id="role" name="role" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email người dùng</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Thêm Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>