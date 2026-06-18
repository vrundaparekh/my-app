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
                    This interactive AI Assistant provides <strong>general educational information only</strong> regarding common symptoms, drugs, and wellness queries. It does not provide medical diagnoses, treatment options, or clinical prescriptions, and <strong>does not replace professional medical advice</strong>, diagnosis, or treatment from qualified healthcare practitioners.
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4 text-center">
           <div class="card border-0 shadow-sm overflow-hidden text-center p-5 bg-white">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-user-md text-success fs-1"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Voice Assistant Companion</h3>
                <p class="text-muted small px-3">
                    Click the widget button below to initiate a real-time, bidirectional voice call regarding drugs, common symptoms, or generic medical information.
                </p>
            </div>

            <div class="d-flex justify-content-center py-3">
                <elevenlabs-convai agent-id="agent_2501kvd17s2ffaht8nkmvaqk4w4m"></elevenlabs-convai><script src="https://unpkg.com/@elevenlabs/convai-widget-embed" async type="text/javascript"></script>
            </div>

            <div class="border-top pt-4 mt-4 text-start">
                <h6 class="small fw-bold text-secondary mb-2">Suggested things to ask:</h6>
                <ul class="text-muted small ps-3 mb-0">
                    <li>"What are the common side effects of Paracetamol?" </li>
                    <li>"What causes a mild tension headache?" </li>
                    <li>"How many hours of sleep does an adult need daily?" </li>
                </ul>
            </div>
        </div>
        </div>
    </div>
</div>
<?= $this->section('scripts') ?>
<script src="https://elevenlabs.io/convai-widget/index.js" async></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>