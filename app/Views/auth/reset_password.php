<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>Update Password<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Choose New Password</h4>
            </div>
            <div class="card-body p-4" id="resetCardBody">
                
                <div id="alertContainer" class="d-none alert border-0 small py-2 mb-3"></div>

                <form id="resetForm" action="<?= base_url('reset-password/' . $token) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-dark w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    // 1. Initialize frontend highlight validation rules
    $("#resetForm").validate({
        rules: {
            password: { required: true, minlength: 6 },
            confirm_password: { required: true, equalTo: "#password" }
        },
        messages: {
            confirm_password: { equalTo: "Passwords do not match." }
        },
        errorElement: 'span',
        errorClass: 'text-danger small d-block mt-1',
        highlight: function(element) { $(element).addClass('is-invalid'); },
        unhighlight: function(element) { $(element).removeClass('is-invalid'); }
    });

    // 2. Securely catch submission and prevent full-page routing behavior
    $('#resetForm').on('submit', function(e) {
        e.preventDefault(); // MANDATORY: Completely blocks page changing redirects

        // Check validation status
        if (!$(this).valid()) {
            return false;
        }

        $('#submitBtn').attr('disabled', true);
        $('#alertContainer').addClass('d-none').removeClass('alert-danger alert-success');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alertContainer').removeClass('d-none').addClass('alert-success')
                        .html('<i class="fa-solid fa-circle-check me-2"></i>' + response.message);
                    
                    $('#resetForm').fadeOut(300, function() {
                        $('#resetCardBody').append('<div class="text-center mt-3"><a href="<?= base_url("login") ?>" class="btn btn-primary px-4 fw-bold">Go to Login Screen</a></div>');
                    });
                } else {
                    // This catches the "Passwords do not match" message from your controller and puts it in the pink box!
                    $('#alertContainer').removeClass('d-none').addClass('alert-danger')
                        .html('<i class="fa-solid fa-triangle-exclamation me-2"></i>' + response.message);
                    $('#submitBtn').attr('disabled', false);
                }
            },
            error: function() {
                $('#alertContainer').removeClass('d-none').addClass('alert-danger')
                    .html('<i class="fa-solid fa-triangle-exclamation me-2"></i>An internal processing error occurred.');
                $('#submitBtn').attr('disabled', false);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>