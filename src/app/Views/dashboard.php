<div class="dashboard-container">
    <!-- Hero Section -->
    <div class="dashboard-hero card">
        <div class="hero-content">
            <div class="hero-greeting">
                <h1 class="hero-title">¡Bienvenido, <?= esc($userName ?? session()->get('userName')) ?>!</h1>
                <p class="hero-subtitle">
                    <?php if(session()->get('userRole') === 'admin'): ?>
                        Panel de administración del sistema
                    <?php else: ?>
                        Gestiona tu galería personal de imágenes
                    <?php endif; ?>
                </p>
            </div>
            <div class="hero-avatar">
                <div class="user-avatar-large">
                    <?php if(session()->get('userAvatar')): ?>
                        <img src="<?= base_url(session()->get('userAvatar')) ?>" alt="Avatar">
                    <?php else: ?>
                        <span><?= strtoupper(substr($userName ?? session()->get('userName'), 0, 1)) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <?php
    $imageModel = new \App\Models\ImageModel();
    $userModel = new \App\Models\UserModel();
    $userId = session()->get('userId');
    $isAdmin = session()->get('userRole') === 'admin';

    if ($isAdmin) {
        $imageStats = $imageModel->getGlobalStats();
        $userStats = $userModel->getUserStats();
    } else {
        $imageStats = $imageModel->getUserImageStats($userId);
    }
    ?>

    <div class="stats-grid grid grid-cols-4">
        <?php if($isAdmin): ?>
            <div class="stat-card card">
                <div class="stat-icon stat-icon-primary">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= $userStats['total'] ?></h3>
                    <p class="stat-label">Usuarios Totales</p>
                </div>
            </div>

            <div class="stat-card card">
                <div class="stat-icon stat-icon-success">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= $imageStats['total_images'] ?></h3>
                    <p class="stat-label">Imágenes en Sistema</p>
                </div>
            </div>

            <div class="stat-card card">
                <div class="stat-icon stat-icon-warning">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= $imageStats['categories'] ?></h3>
                    <p class="stat-label">Categorías</p>
                </div>
            </div>

            <div class="stat-card card">
                <div class="stat-icon stat-icon-info">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= number_format($imageStats['total_size'] / 1024 / 1024, 1) ?> MB</h3>
                    <p class="stat-label">Almacenamiento</p>
                </div>
            </div>
        <?php else: ?>
            <div class="stat-card card">
                <div class="stat-icon stat-icon-primary">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

            <div class="stat-card card">
                <div class="stat-icon stat-icon-warning">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= $imageStats['categories'] ?></h3>
                    <p class="stat-label">Categorías</p>
                </div>
            </div>

            <div class="stat-card card">
                <div class="stat-icon stat-icon-info">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?= number_format($imageStats['total_size'] / 1024 / 1024, 1) ?> MB</h3>
                    <p class="stat-label">Espacio Usado</p>
                </div>
            </div>

            <div class="stat-card card stat-card-action" onclick="window.location.href='<?= base_url('/images') ?>'">
                <div class="stat-icon stat-icon-success">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">Subir</h3>
                    <p class="stat-label">Nueva Imagen</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Acciones Rápidas</h2>

        <div class="actions-grid grid grid-cols-3">
            <a href="<?= base_url('/images') ?>" class="action-card card">
                <div class="action-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </div>
                <h3 class="action-title">Mi Galería</h3>
                <p class="action-description">Ver y gestionar mis imágenes</p>
            </a>

            <?php if($isAdmin): ?>
                <a href="<?= base_url('/users/list') ?>" class="action-card card">
                    <div class="action-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="action-title">Gestionar Usuarios</h3>
                    <p class="action-description">Administrar cuentas del sistema</p>
                </a>

                <a href="<?= base_url('/images/admin-panel') ?>" class="action-card card">
                    <div class="action-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6"></path>
                            <path d="M1 12h6m6 0h6"></path>
                        </svg>
                    </div>
                    <h3 class="action-title">Panel Admin</h3>
                    <p class="action-description">Gestión global de imágenes</p>
                </a>
            <?php else: ?>
                <a href="<?= base_url('/user/profile') ?>" class="action-card card">
                    <div class="action-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h3 class="action-title">Mi Perfil</h3>
                    <p class="action-description">Ver y editar mi información</p>
                </a>

                <a href="<?= base_url('/images') ?>" class="action-card card action-card-primary">
                    <div class="action-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"></path>
                        </svg>
                    </div>
                    <h3 class="action-title">Subir Imagen</h3>
                    <p class="action-description">Agregar nuevas imágenes</p>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Activity (solo si hay imágenes recientes) -->
    <?php if(!empty($imageStats['recent'])): ?>
        <div class="recent-activity">
            <h2 class="section-title">Actividad Reciente</h2>

            <div class="activity-list card">
                <?php foreach($imageStats['recent'] as $image): ?>
                    <div class="activity-item">
                        <div class="activity-thumbnail">
                            <img src="<?= base_url($image['file_path']) ?>" alt="<?= esc($image['original_name']) ?>">
                        </div>
                        <div class="activity-details">
                            <h4><?= esc($image['original_name']) ?></h4>
                            <p class="text-muted text-sm">
                                Subida el <?= date('d/m/Y H:i', strtotime($image['uploaded_at'])) ?>
                                • <?= number_format($image['file_size'] / 1024, 1) ?> KB
                            </p>
                        </div>
                        <a href="<?= base_url('/images/view/' . $image['id']) ?>" class="btn btn-sm btn-ghost">Ver</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .dashboard-container {
        animation: fadeIn var(--transition-base);
        padding: 2rem;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, var(--color-blue-dark) 0%, var(--color-blue-medium) 100%);
        color: white;
        padding: var(--spacing-2xl);
        margin-bottom: var(--spacing-xl);
        border: none;
    }

    .hero-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-xl);
    }

    .hero-title {
        font-size: var(--font-size-3xl);
        margin: 0 0 var(--spacing-sm) 0;
        font-weight: 700;
    }

    .hero-subtitle {
        font-size: var(--font-size-lg);
        margin: 0;
        opacity: 0.9;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-full);
        background: var(--color-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-blue-dark);
        font-weight: 700;
        font-size: var(--font-size-3xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .user-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stats-grid {
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        padding: var(--spacing-lg);
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
        transition: all var(--transition-fast);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-card-action {
        cursor: pointer;
    }

    .stat-card-action:hover {
        background: var(--color-blue-dark);
        color: white;
    }

    .stat-card-action:hover .stat-icon {
        background: white;
        color: var(--color-blue-dark);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
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

    .stat-icon-info {
        background: rgba(120, 144, 168, 0.1);
        color: var(--color-blue-light);
    }

    .stat-value {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        margin: 0;
        color: var(--color-blue-dark);
    }

    .stat-label {
        margin: 0;
        color: var(--color-text-light);
        font-size: var(--font-size-sm);
    }

    .section-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0 0 var(--spacing-lg) 0;
    }

    .actions-grid {
        margin-bottom: var(--spacing-xl);
    }

    .action-card {
        text-align: center;
        padding: var(--spacing-xl);
        text-decoration: none;
        color: var(--color-text);
        transition: all var(--transition-base);
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .action-card-primary:hover {
        background: var(--color-blue-medium);
        color: white;
    }

    .action-card-primary:hover .action-icon {
        color: var(--color-gold);
    }

    .action-icon {
        color: var(--color-blue-medium);
        margin-bottom: var(--spacing-md);
        transition: color var(--transition-fast);
    }

    .action-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin: 0 0 var(--spacing-sm) 0;
    }

    .action-description {
        margin: 0;
        color: var(--color-text-light);
        font-size: var(--font-size-sm);
    }

    .activity-list {
        padding: 0;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--color-border);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .activity-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .activity-details {
        flex: 1;
    }

    .activity-details h4 {
        margin: 0 0 var(--spacing-xs) 0;
        font-size: var(--font-size-base);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
        }

        .hero-title {
            font-size: var(--font-size-2xl);
        }
    }
</style>
