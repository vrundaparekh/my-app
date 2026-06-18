<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>My Profile Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm text-center p-4">
            <div class="card-body">
                <img src="<?= base_url('uploads/profile_pics/' . ($user['profile_pic'] ?: 'default.png')) ?>" 
                     class="rounded-circle mb-3 border shadow-sm" 
                     width="130" 
                     height="130" 
                     style="object-fit: cover;">
                
                <h4 class="fw-bold mb-1"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h4>
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3"><?= esc($user['role_name']) ?></span>
                
                <hr>
                
                <div class="text-start small text-muted mt-3">
                    <p class="mb-2"><i class="fa-solid fa-envelope me-2 text-secondary"></i><?= esc($user['email']) ?></p>
                    <p class="mb-2"><i class="fa-solid fa-cake-candles me-2 text-secondary"></i>DOB: <?= esc($user['dob'] ?: 'N/A') ?></p>
                    <p class="mb-0"><i class="fa-solid fa-venus-mars me-2 text-secondary"></i>Gender: <?= ucfirst(esc($user['gender'] ?: 'N/A')) ?></p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-3 mt-3">
            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-house me-2 text-primary"></i>Contact Address</h6>
            <p class="text-muted small mb-0 bg-light p-2 rounded border-start border-3 border-primary">
                <?= esc($user['address'] ?: 'No address added to your profile card yet.') ?>
            </p>
        </div>
    </div>

    <div class="col-md-8">
        <div class="alert alert-warning border-0 shadow-sm d-flex p-3 mb-4">
            <div class="fs-4 me-3 text-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-1">AI Consultation Disclaimer</h6>
                <p class="mb-0 small text-dark" style="font-size: 0.8rem;">
                    This conversational voice assistant provides health reference guidelines only. It does not replace professional medical diagnosis or clinical treatment.
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4 text-center">
            <div class="py-4">
                <div class="bg-light p-3 rounded-circle d-inline-block mb-3">
                    <i class="fa-solid fa-user-doctor text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold">Interactive Voice Health Concierge</h5>
                <p class="text-muted small mb-4">Click the microphone tool button below to stream voice chat diagnostic references directly to the ElevenLabs system agent.</p>
                
                <div class="p-4 bg-light border rounded text-center text-muted border-dashed">
                    <p class="small mb-0">✨ [ElevenLabs Voice Widget Container Interface] ✨</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>