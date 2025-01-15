<div class="modal fade" id="createSettingModal" tabindex="-1" role="dialog" aria-labelledby="createSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSettingModalLabel">Tạo mới Custom Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createSettingForm">
                    <!-- Dòng 1: Input Title -->
                    <div class="form-group">
                        <label for="settingTitle">Tiêu đề <span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="settingTitle" name="title" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Vai trò <span class="form-required">*</span></label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">-- Chọn vai trò --</option>
                            <option value="1">Admin</option>
                            <option value="2">Giáo viên</option>
                            <option value="3">Phụ huynh</option>
                            <option value="4">Học sinh</option>
                        </select>
                    </div>

                    <!-- Dòng 2: Dropdown và Input Content -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="settingType">Role <span class="form-required">*</span></label>
                            <select class="form-control" id="settingType" name="type" required>
                                <option value="system">System</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="settingContent1">Content <span class="form-required">*</span></label>
                            <input type="text" class="form-control" id="settingContent1" name="content1" placeholder="Enter content" required>
                        </div>
                    </div>

                    <!-- Dòng 3: Input Content -->
                    <div class="form-group">
                        <label for="settingContent2">Content <span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="settingContent2" name="content2" placeholder="Enter additional content" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="saveSetting()">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
    function saveSetting() {
        const form = document.getElementById('createSettingForm');
        const formData = new FormData(form);

        fetch('save_setting.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Setting saved successfully!");
                    location.reload();
                } else {
                    alert("Failed to save setting: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Error saving setting:", error);
                alert("An error occurred while saving the setting.");
            });
    }
</script>