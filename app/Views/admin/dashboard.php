<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>User Management Directory<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="mb-1 text-dark">User Management</h3>
            <p class="text-muted small mb-0">Review, filter, and manage authorized platform registration entries.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fa-solid fa-user-plus me-1"></i> Create New User
            </button>
            <a href="<?= base_url('admin/export/excel') ?>" class="btn btn-outline-success btn-sm px-3"><i class="fa-solid fa-file-excel me-1"></i> Export Excel</a>
            <a href="<?= base_url('admin/export/pdf') ?>" class="btn btn-outline-danger btn-sm px-3"><i class="fa-solid fa-file-pdf me-1"></i> Export PDF</a>
        </div>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-sm-8">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" id="liveSearchInput" class="form-control border-start-0 ps-0" placeholder="Type here to filter records live by name or email account details...">
            </div>
        </div>
        <div class="col-sm-4">
            <select id="liveGenderFilter" class="form-select">
                <option value="">All Genders</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 80px;">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center" style="width: 220px;">Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?= view('admin/user_table_rows', ['users' => $users]) ?>
            </tbody>
        </table>
        <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-center mt-4">
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa-solid fa-user-plus me-2"></i>Register System User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="createUserForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
    <div class="modal-body p-4">
        <div id="createAlert" class="d-none alert alert-danger border-0 small py-2 mb-3"></div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Account Access Role</label>
                <select name="role_id" class="form-select" required>
                    <option value="2" selected>User</option>
                    <option value="3">Staff</option>
                    <option value="4">Manager</option>
                    <option value="1">Admin</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required minlength="6">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Repeat your password" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control" accept="image/*">
            <div class="form-text small text-muted">Upload an avatar image file (Optional).</div>
        </div>
    </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="saveUserBtn" class="btn btn-success">Save User</button>
        </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa-solid fa-id-card me-2"></i> User Profile Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewUserModalBody">
                <div class="text-center py-3">
                    <div class="spinner-border text-info" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fa-solid fa-user-pen me-2"></i>Edit User Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body" id="editUserModalBody">
                    </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="updateUserBtn" class="btn btn-warning fw-medium">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

function filterUsers() 
{
        var keyword = $('#liveSearchInput').val();
        var gender = $('#liveGenderFilter').val();

        $.ajax({
            url: '<?= base_url("admin/users/search") ?>', 
            method: 'POST',
            data: {
                keyword: keyword,
                gender_filter: gender,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function(response) {
                $('#userTableBody').html(response);
            },
            error: function(xhr, status, error) {
            console.error("Live filter sync failure:", error);
            }
        });
    }
    $('#liveSearchInput').on('keyup', filterUsers);
    $('#liveGenderFilter').on('change', filterUsers);

  //save user 
$('#createUserForm').on('submit', function(e) 
    {
        e.preventDefault();
        $('#saveUserBtn').attr('disabled', true);
        $('#createAlert').addClass('d-none');

        $.ajax({
            url: '<?= base_url("admin/users/store") ?>',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'User Registered!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                $('#createUserModal').modal('hide');
                setTimeout(function() {
                    location.reload(); // Instantly displays the brand new user in your grid rows!
                }, 2000);
            } else {
                $('#createAlert').removeClass('d-none').text(response.message);
                $('#saveUserBtn').attr('disabled', false);
            }
        }
        });
    });

   
    $(document).on('click', '.view-user-btn', function() {
        var userId = $(this).data('id');
        $('#viewUserModal').modal('show');
        $('#viewUserModalBody').html('<div class="text-center py-3"><div class="spinner-border text-info" role="status"></div></div>');
        
        $.ajax({
            url: '<?= base_url("admin/users/view") ?>/' + userId,
            method: 'GET',
            success: function(response) {
                $('#viewUserModalBody').html(response);
            }
        });
    });

    $(document).on('click', '.edit-user-btn', function() {
        var userId = $(this).data('id');
        $('#editUserModal').modal('show');
        $('#editUserModalBody').html('<div class="text-center py-3"><div class="spinner-border text-warning" role="status"></div></div>');
        
        $.ajax({
            url: '<?= base_url("admin/users/edit") ?>/' + userId,
            method: 'GET',
            success: function(response) {
                $('#editUserModalBody').html(response);
            },
            error: function() {
                $('#editUserModalBody').html('<div class="alert alert-danger mb-0">Failed to load user edit form.</div>');
            }
        });
    });
//delete
    $(document).on('click', '.delete-user-btn', function() {
        var userId = $(this).data('id');
        var row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete this profile!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/users/delete") ?>/' + userId,
                    method: 'POST',
                    data: { <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            row.fadeOut(350, function() { $(this).remove(); });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'An internal delete processing error occurred.', 'error');
                    }
                });
            }
        });
    });
});
//edit 
$(document).on('submit', '#editUserForm', function(e) {
    e.preventDefault();
    
    var userId = $(this).find('input[name="user_id"]').val();
    $('#updateUserBtn').attr('disabled', true);

    $.ajax({
        url: '<?= base_url("admin/users/update") ?>/' + userId,
        method: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: response.message
                });

                $('#editUserModal').modal('hide');
                setTimeout(function() {
                    location.reload();
                }, 2000);

            } else {
                Swal.fire('Validation Error', response.message, 'error');
                $('#updateUserBtn').attr('disabled', false);
            }
        },
        error: function() {
            Swal.fire('Error', 'An internal processing error occurred.', 'error');
            $('#updateUserBtn').attr('disabled', false);
        }
    });
});
</script>
<?= $this->endSection() ?>