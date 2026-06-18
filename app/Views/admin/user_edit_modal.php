
<input type="hidden" name="user_id" value="<?= $user['id'] ?>">

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?= esc($user['first_name']) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?= esc($user['last_name']) ?>" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Account Access Role</label>
        <select name="role_id" class="form-select" required>
            <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
            <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
            <option value="3" <?= $user['role_id'] == 3 ? 'selected' : '' ?>>Staff</option>
            <option value="4" <?= $user['role_id'] == 4 ? 'selected' : '' ?>>Manager</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="<?= esc($user['dob']) ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
            <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label small fw-bold">Contact Address</label>
    <textarea name="address" class="form-control" rows="2"><?= esc($user['address']) ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label small fw-bold">Profile Picture</label>
    <div class="d-flex align-items-center gap-3 bg-light p-2 rounded border">
        <img src="<?= base_url('uploads/profile_pics/' . ($user['profile_pic'] ?: 'default.png')) ?>" 
             class="rounded-circle border shadow-sm" 
             width="60" 
             height="60" 
             style="object-fit: cover;">
        
        <div class="flex-grow-1">
            <input type="file" name="profile_pic" class="form-control form-control-sm" accept="image/*">
            <div class="form-text small text-muted mb-0" style="font-size: 0.75rem;">Leave empty to retain this current image item.</div>
        </div>
    </div>
</div>