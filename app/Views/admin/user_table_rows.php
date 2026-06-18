<?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <img src="<?= base_url('uploads/profile_pics/' . ($user['profile_pic'] ?: 'default.png')) ?>" class="rounded-circle border shadow-sm" width="45" height="45" style="object-fit: cover;">
            </td>
            <td><span class="font-weight-bold text-dark"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></span></td>
            <td><?= esc($user['email']) ?></td>
            <td><?= esc($user['dob'] ?: 'N/A') ?></td>
            <td><?= ucfirst(esc($user['gender'] ?: 'N/A')) ?></td>
            <td><span class="badge bg-secondary py-1.5 px-2"><?= esc($user['role_name'] ?? 'User') ?></span></td>
            <td>
                <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'warning' ?> py-1.5 px-2">
                    <?= ucfirst(esc($user['status'])) ?>
                </span>
            </td>
            <td class="text-center">
                <div class="btn-group gap-1">
                    <button class="btn btn-sm btn-outline-info view-user-btn" data-id="<?= $user['id'] ?>"><i class="fa-solid fa-eye"></i> View</button>
                    <button class="btn btn-sm btn-outline-warning edit-user-btn" data-id="<?= $user['id'] ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                    
                    <?php if ($user['id'] != session()->get('userId')): ?>
                        <button class="btn btn-sm btn-outline-danger delete-user-btn" data-id="<?= $user['id'] ?>"><i class="fa-solid fa-trash"></i> Delete</button>
                    <?php else: ?>
                        <button class="btn btn-sm btn-outline-secondary disabled" title="Self-deletion blocked" disabled><i class="fa-solid fa-ban"></i> Blocked</button>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="text-center py-5 text-muted">
            <i class="fa-solid fa-folder-open d-block fs-2 mb-2 text-secondary"></i>
            No users matched your system tracking parameters.
        </td>
    </tr>
<?php endif; ?>