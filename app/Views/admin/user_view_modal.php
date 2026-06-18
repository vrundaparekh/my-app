<div class="text-center mb-4">
    <img src="<?= base_url('uploads/profile_pics/' . ($user['profile_pic'] ?: 'default.png')) ?>" 
         class="rounded-circle border shadow-sm p-1 mb-2 bg-white" 
         width="120" 
         height="120" 
         style="object-fit: cover;">
    
    <h4 class="fw-bold text-dark mb-1"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h4>
    <span class="badge bg-primary px-3 py-1.5 rounded-pill"><?= esc($user['role_name'] ?? 'User') ?></span>
</div>

<div class="border-top pt-3">
    <div class="row g-3">
        <div class="col-6">
            <label class="text-muted small d-block mb-0">Email Address</label>
            <span class="text-dark fw-medium"><?= esc($user['email']) ?></span>
        </div>
        <div class="col-6">
            <label class="text-muted small d-block mb-0">Account Status</label>
            <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'danger' ?> px-2 py-1">
                <?= ucfirst(esc($user['status'])) ?>
            </span>
        </div>
        
        <div class="col-6">
            <label class="text-muted small d-block mb-0">Date of Birth</label>
            <span class="text-dark fw-medium"><?= esc($user['dob'] ?: 'N/A') ?></span>
        </div>
        <div class="col-6">
            <label class="text-muted small d-block mb-0">Gender</label>
            <span class="text-dark fw-medium"><?= ucfirst(esc($user['gender'] ?: 'N/A')) ?></span>
        </div>

        <div class="col-12">
            <label class="text-muted small d-block mb-0">Contact Address</label>
            <p class="text-dark small bg-light p-2 rounded mb-0 border-start border-3 border-info">
                <?= esc($user['address'] ?: 'No physical address records added yet.') ?>
            </p>
        </div>
    </div>
</div>