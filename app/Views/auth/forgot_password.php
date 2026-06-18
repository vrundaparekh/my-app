<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>Forgot Password<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Reset Password</h4>
            </div>
            <div class="card-body p-4" id="forgotCardBody">
                <div id="infoText">
                    <p class="text-muted small mb-3">Enter your registered email address below, and we will simulate sending a secure password reset validation link.</p>
                </div>

                <div id="alertContainer" class="d-none alert border-0 small py-2 mb-3"></div>

                <form id="forgotForm" action="<?= base_url('forgot-password') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" id="emailInput" class="form-control" required>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-dark w-100">
                        <span class="spinner-border spinner-border-sm d-none me-2" id="btnSpinner"></span>Send Reset Link
                    </button>
                    <div class="text-center mt-3" id="loginLinkContainer">
                        <p class="small mb-0">Remembered your credentials? <a href="<?= base_url('login') ?>" class="fw-bold text-primary">Login Here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#forgotForm').on('submit', function(e) {
        e.preventDefault(); // Stop standard page reload submission
        
        // UI Loading States
        $('#submitBtn').attr('disabled', true);
        $('#btnSpinner').removeClass('d-none');
        $('#alertContainer').addClass('d-none').removeClass('alert-danger alert-success');

        $.ajax({
            url: '<?= base_url("forgot-password") ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alertContainer').removeClass('d-none').addClass('alert-success')
                        .html('<i class="fa-solid fa-circle-check me-2"></i>' + response.message);
                    $('#forgotForm, #infoText').fadeOut(300);
                } else {
                    $('#alertContainer').removeClass('d-none').addClass('alert-danger')
                        .html('<i class="fa-solid fa-triangle-exclamation me-2"></i>' + response.message);
                    $('#submitBtn').attr('disabled', false);
                    $('#btnSpinner').addClass('d-none');
                }
            },
            error: function() {
                $('#alertContainer').removeClass('d-none').addClass('alert-danger')
                    .html('<i class="fa-solid fa-triangle-exclamation me-2"></i>System processing error. Please try again.');
                $('#submitBtn').attr('disabled', false);
                $('#btnSpinner').addClass('d-none');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>