<?php
session_start();
$settings = require(__DIR__ . "/../settings.php");
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$db = get_db();
$setting_class = get_setting_class($db);
$role_class = get_role_class($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN TRỊ VIÊN | CHAT GPT</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>

    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        .main-body {
            padding: 15px;
        }

        .nav-link {
            color: #4a5568;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*="col-"] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .setting-block {
            margin-bottom: 20px;
        }

        .setting h4 {
            margin: 10px 0;
        }

        .meta-row {
            margin-bottom: 10px;
        }

        .meta-row input {
            width: 200px;
            margin-right: 10px;
        }

    </style>
</head>



<body>
    <div class="container">
        <div class="row gutters-sm">
            <div class="col-md-4 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column nav-pills nav-gap-y-1">
                            <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>Vai trò
                            </a>
                            <a href="#account" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>Setting
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                    </svg></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="profile">
                            <h6>QUẢN LÝ VAI TRÒ</h6>
                            <hr>
                            <form>
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" aria-describedby="fullNameHelp" placeholder="Enter your fullname" value="Kenneth Valdez">
                                    <small id="fullNameHelp" class="form-text text-muted">Your name may appear around here where you are mentioned. You can change or remove it at any time.</small>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Your Bio</label>
                                    <textarea class="form-control autosize" id="bio" placeholder="Write something about you" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;">A front-end developer that focus more on user interface design, a web interface wizard, a connector of awesomeness.</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" class="form-control" id="url" placeholder="Enter your website address" value="http://benije.ke/pozzivkij">
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="Enter your location" value="Bay Area, San Francisco, CA">
                                </div>
                                <div class="form-group small text-muted">
                                    All of the fields on this page are optional and can be deleted at any time, and by filling them out, you're giving us consent to share this data wherever your user profile appears.
                                </div>
                                <button type="button" class="btn btn-primary">Update Profile</button>
                                <button type="reset" class="btn btn-light">Reset Changes</button>
                            </form>
                        </div>
                        <div class="tab-pane" id="account">
                            <form method="POST" action="save_settings.php">
                                <?php
                                $settings = $setting_class->get_settings();
                                foreach ($settings as &$setting) {
                                    $setting['meta'] = $setting_class->get_meta($setting['id']);
                                    $setting['role_name'] = $role_class->get_name($setting['role_id']);
                                }
                                foreach ($settings as $setting): ?>
                                    <div class="setting-block">
                                        <h6><?php echo $setting['role_name'] ?></h6>
                                        <hr>
                                        <div class="setting">
                                            <h6><?php echo htmlspecialchars($setting['title']); ?></h6>
                                            <div class="meta-fields">
                                                <?php foreach ($setting['meta'] as $meta): ?>
                                                    <div class="meta-row input-group">
                                                        <button type="button" class="btn btn-sm mr-3" style="height: 35px;"><u>Xóa</u></button>
                                                        <input class="form-control" type="text" name="meta[<?php echo $setting['id']; ?>][<?php echo $meta['setting_key']; ?>][key]" value="<?php echo htmlspecialchars($meta['setting_key']); ?>" placeholder="Setting Key">
                                                        <textarea class="form-control" name="meta[<?php echo $setting['id']; ?>][<?php echo $meta['setting_key']; ?>][value]" placeholder="Value"><?php echo htmlspecialchars($meta['value']); ?></textarea>
                                                    </div>
                                                    <button type="button" class="btn btn-sm add-meta"><u>+ Thêm meta</u></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <div>
                                    <button type="submit" class="btn btn-primary save-button">Lưu lại</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Add new meta input when the "Add Meta" button is clicked
            const addMetaButtons = document.querySelectorAll('.add-meta');

            addMetaButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const settingId = this.getAttribute('data-setting-id');
                    const metaRow = document.createElement('div');
                    metaRow.classList.add('meta-row');

                    const newMetaInput = `
                    <input type="text" name="meta[${settingId}][new][key]" placeholder="Setting Key">
                    <input type="text" name="meta[${settingId}][new][value]" placeholder="Value">
                    <button type="button" class="remove-meta">-</button>
                `;
                    metaRow.innerHTML = newMetaInput;

                    // Append new meta row to the setting meta fields
                    const metaFields = document.querySelector(`.meta-fields[data-setting-id="${settingId}"]`);
                    metaFields.appendChild(metaRow);

                    // Add functionality to remove meta row
                    const removeButton = metaRow.querySelector('.remove-meta');
                    removeButton.addEventListener('click', function() {
                        metaRow.remove();
                    });
                });
            });
        });
    </script>

</body>

</html>