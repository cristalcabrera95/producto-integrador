<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeIn 0.3s;
        padding: 10px;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--color-blue-dark) 0%, var(--color-blue-medium) 100%);
        color: white;
        padding: var(--spacing-2xl);
        border-radius: var(--radius-lg);
        margin-bottom: var(--spacing-xl);
        display: flex;
        align-items: center;
        gap: var(--spacing-xl);
    }

    .profile-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-full);
        background: var(--color-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-blue-dark);
        font-weight: 700;
        font-size: 3rem;
        flex-shrink: 0;
        box-shadow: var(--shadow-lg);
        border: 4px solid rgba(255, 255, 255, 0.2);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 var(--spacing-sm) 0;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        padding: var(--spacing-xs) var(--spacing-md);
        background: rgba(240, 168, 24, 0.2);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-gold);
        margin-bottom: var(--spacing-sm);
    }

    .profile-meta {
        opacity: 0.9;
        font-size: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        background: white;
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        transition: all 0.15s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-primary {
        background: rgba(48, 72, 120, 0.1);
        color: var(--color-blue-medium);
    }

    .stat-icon-success {
        background: rgba(72, 187, 120, 0.1);
        color: var(--color-success);
    }

    .stat-icon-warning {
        background: rgba(240, 168, 24, 0.1);
        color: var(--color-gold);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--color-blue-dark);
    }

    .stat-label {
        margin: 0;
        color: var(--color-text-light);
        font-size: 0.875rem;
    }

    .profile-section {
        background: white;
        padding: var(--spacing-xl);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        margin-bottom: var(--spacing-lg);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-md);
        border-bottom: 2px solid var(--color-bg);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .info-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: var(--spacing-md) var(--spacing-xl);
    }

    .info-label {
        font-weight: 600;
        color: var(--color-text);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .info-value {
        color: var(--color-text-light);
    }

    .actions-section {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
        }

        .info-label {
            font-weight: 700;
        }
    }
</style>

<?php if (isset($success)): ?>
    <div class="alert alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <?= $success ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-error">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <?= $error ?>
    </div>
<?php endif; ?>

<div class="profile-container">
    <!-- Header del Perfil -->
    <div class="profile-header card">
        <div class="profile-avatar-large">
            <?php if(isset($user['avatar']) && $user['avatar']): ?>
                <img src="<?= base_url($user['avatar']) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius-full);">
            <?php else: ?>
                <span><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
            <?php endif; ?>
        </div>
        <div class="profile-info">
            <h1 class="profile-name"><?= esc($user['name']) ?></h1>
            <div class="profile-role">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <?php if($user['role'] === 'admin'): ?>
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6m0 6v6"></path>
                    <?php else: ?>
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    <?php endif; ?>
                </svg>
                <?= $user['role'] === 'admin' ? 'Administrador' : 'Usuario Regular' ?>
            </div>
            <p class="profile-meta">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <?= esc($user['email']) ?>
            </p>
        </div>
    </div>

    <!-- Estadísticas del Usuario -->
    <?php
    $imageModel = new \App\Models\ImageModel();
    $userId = session()->get('userId');
    $imageStats = $imageModel->getUserImageStats($userId);
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= $imageStats['total'] ?></h3>
                <p class="stat-label">Mis Imágenes</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= $imageStats['categories'] ?></h3>
                <p class="stat-label">Categorías</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= number_format($imageStats['total_size'] / 1024 / 1024, 1) ?> MB</h3>
                <p class="stat-label">Almacenado</p>
            </div>
        </div>
    </div>

    <!-- Información Personal -->
    <div class="profile-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Información Personal
            </h2>
            <a href="<?= base_url('/users/edit/' . $user['id']) ?>" class="btn btn-primary btn-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Editar Perfil
            </a>
        </div>

        <div class="info-grid">
            <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Nombre Completo:
            </span>
            <span class="info-value"><?= esc($user['name']) ?></span>

            <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                Email:
            </span>
            <span class="info-value"><?= esc($user['email']) ?></span>

            <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Usuario:
            </span>
            <span class="info-value">
                <code style="background: var(--color-bg); padding: var(--spacing-xs) var(--spacing-sm); border-radius: var(--radius-sm); font-family: 'Courier New', monospace;">
                    <?= esc($user['login']) ?>
                </code>
            </span>

            <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6"></path>
                </svg>
                Rol:
            </span>
            <span class="info-value">
                <span class="badge <?= $user['role'] === 'admin' ? 'badge-warning' : 'badge-primary' ?>">
                    <?= $user['role'] === 'admin' ? 'Administrador' : 'Usuario Regular' ?>
                </span>
            </span>

            <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Miembro desde:
            </span>
            <span class="info-value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>

            <?php if(isset($user['updated_at'])): ?>
                <span class="info-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Última actualización:
            </span>
                <span class="info-value"><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="profile-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6M5.93 5.93l4.24 4.24m5.66 5.66l4.24 4.24M2 12h6m6 0h6M5.93 18.07l4.24-4.24m5.66-5.66l4.24-4.24"></path>
                </svg>
                Acciones Rápidas
            </h2>
        </div>

        <div class="actions-section">
            <a href="<?= base_url('/images') ?>" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                Mi Galería
            </a>

            <a href="<?= base_url('/users/edit/' . $user['id']) ?>" class="btn btn-secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Editar Perfil
            </a>

            <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Ir al Dashboard
            </a>

            <?php if($user['role'] === 'admin'): ?>
                <a href="<?= base_url('/users/list') ?>" class="btn btn-warning">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Gestionar Usuarios
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Actividad Reciente (si hay imágenes) -->
    <?php if(!empty($imageStats['recent'])): ?>
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    Imágenes Recientes
                </h2>
                <a href="<?= base_url('/images') ?>" class="btn btn-ghost btn-sm">
                    Ver todas →
                </a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: var(--spacing-md);">
                <?php foreach(array_slice($imageStats['recent'], 0, 5) as $image): ?>
                    <div style="position: relative; overflow: hidden; border-radius: var(--radius-md); aspect-ratio: 1;">
                        <img
                            src="<?= base_url($image['file_path']) ?>"
                            alt="<?= esc($image['original_name']) ?>"
                            style="width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'"
                            onclick="window.location.href='<?= base_url('/images') ?>'"
                        >
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: var(--spacing-sm); font-size: 0.75rem;">
                            <?= esc($image['category']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>