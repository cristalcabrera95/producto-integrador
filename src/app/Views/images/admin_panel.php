<style>
    .admin-panel-container {
        animation: fadeIn 0.3s;
        padding: 2rem;
    }

    .panel-header {
        background: linear-gradient(135deg, var(--color-blue-dark) 0%, var(--color-blue-medium) 100%);
        color: white;
        padding: var(--spacing-2xl);
        border-radius: var(--radius-lg);
        margin-bottom: var(--spacing-xl);
    }

    .panel-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 var(--spacing-sm) 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .panel-subtitle {
        margin: 0;
        opacity: 0.9;
        font-size: 1.125rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        padding: var(--spacing-lg);
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
        transition: all 0.15s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
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

    .filters-section {
        background: white;
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--spacing-lg);
        border: 1px solid var(--color-border);
    }

    .filters-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 var(--spacing-md) 0;
        color: var(--color-blue-dark);
    }

    .filters-row {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
        align-items: end;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        display: block;
        margin-bottom: var(--spacing-sm);
        font-weight: 600;
        color: var(--color-text);
        font-size: 0.875rem;
    }

    .filter-select {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        font-size: 1rem;
    }

    .images-table-container {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--color-border);
    }

    .images-table {
        width: 100%;
        border-collapse: collapse;
    }

    .images-table thead {
        background: var(--color-blue-dark);
    }

    .images-table th {
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .images-table td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--color-border);
        color: var(--color-text);
    }

    .images-table tbody tr:hover {
        background: var(--color-bg);
    }

    .image-thumb {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.15s;
    }

    .image-thumb:hover {
        transform: scale(1.1);
    }

    .user-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        background: var(--color-bg);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
    }

    .empty-state {
        text-align: center;
        padding: var(--spacing-2xl);
        color: var(--color-text-light);
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        color: var(--color-border);
        margin-bottom: var(--spacing-md);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-lg);
        animation: fadeIn 0.15s;
    }

    .modal-content {
        background: white;
        border-radius: var(--radius-lg);
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--color-border);
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--color-text-light);
        padding: var(--spacing-sm);
        border-radius: var(--radius-md);
        transition: all 0.15s;
    }

    .modal-close:hover {
        background: var(--color-bg);
        color: var(--color-text);
    }

    .modal-body {
        padding: var(--spacing-lg);
    }

    @media (max-width: 768px) {
        .filters-row {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .images-table {
            font-size: 0.875rem;
        }

        .images-table th,
        .images-table td {
            padding: var(--spacing-sm);
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

<div class="admin-panel-container">
    <!-- Header del Panel -->
    <div class="panel-header card">
        <h1 class="panel-title">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M12 1v6m0 6v6"></path>
                <path d="M1 12h6m6 0h6"></path>
            </svg>
            Panel de Administración de Imágenes
        </h1>
        <p class="panel-subtitle">Gestión global de todas las imágenes del sistema</p>
    </div>

    <!-- Estadísticas Globales -->
    <div class="stats-grid">
        <div class="stat-card card">
            <div class="stat-icon stat-icon-primary">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= $stats['total_images'] ?></h3>
                <p class="stat-label">Total de Imágenes</p>
            </div>
        </div>

        <div class="stat-card card">
            <div class="stat-icon stat-icon-success">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= $stats['total_users'] ?></h3>
                <p class="stat-label">Usuarios con Imágenes</p>
            </div>
        </div>

        <div class="stat-card card">
            <div class="stat-icon stat-icon-warning">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?= $stats['categories'] ?></h3>
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
                <h3 class="stat-value"><?= number_format($stats['total_size'] / 1024 / 1024, 1) ?> MB</h3>
                <p class="stat-label">Almacenamiento Total</p>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <h3 class="filters-title">Filtrar Imágenes</h3>
        <form method="get" action="<?= base_url('/images/admin-panel') ?>">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Usuario:</label>
                    <select name="user_id" class="filter-select">
                        <option value="">Todos los usuarios</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= (isset($_GET['user_id']) && $_GET['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                <?= esc($user['name']) ?> (<?= esc($user['login']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Ordenar por:</label>
                    <select name="order" class="filter-select">
                        <option value="recent" <?= (!isset($_GET['order']) || $_GET['order'] == 'recent') ? 'selected' : '' ?>>Más recientes</option>
                        <option value="oldest" <?= (isset($_GET['order']) && $_GET['order'] == 'oldest') ? 'selected' : '' ?>>Más antiguas</option>
                        <option value="largest" <?= (isset($_GET['order']) && $_GET['order'] == 'largest') ? 'selected' : '' ?>>Mayor tamaño</option>
                        <option value="smallest" <?= (isset($_GET['order']) && $_GET['order'] == 'smallest') ? 'selected' : '' ?>>Menor tamaño</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Botones de Acción -->
    <div style="margin-bottom: var(--spacing-lg); display: flex; gap: var(--spacing-sm);">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <!-- Tabla de Imágenes -->
    <div class="images-table-container">
        <table class="images-table">
            <thead>
            <tr>
                <th>Preview</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Categoría</th>
                <th>Tamaño</th>
                <th>Dimensiones</th>
                <th>Fecha</th>
                <th style="text-align: center;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($images)): ?>
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <p>No hay imágenes en el sistema</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($images as $image): ?>
                    <?php
                    // Buscar el usuario dueño de la imagen
                    $imageUser = null;
                    foreach ($users as $u) {
                        if ($u['id'] == $image['user_id']) {
                            $imageUser = $u;
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td>
                            <img
                                src="<?= base_url($image['file_path']) ?>"
                                alt="<?= esc($image['original_name']) ?>"
                                class="image-thumb"
                                onclick="openImageModal(<?= htmlspecialchars(json_encode($image)) ?>, <?= htmlspecialchars(json_encode($imageUser)) ?>)"
                            >
                        </td>
                        <td>
                            <strong><?= esc($image['original_name']) ?></strong>
                        </td>
                        <td>
                            <?php if ($imageUser): ?>
                                <div class="user-badge">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <?= esc($imageUser['name']) ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">Usuario eliminado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-primary"><?= esc($image['category']) ?></span>
                        </td>
                        <td><?= number_format($image['file_size'] / 1024, 1) ?> KB</td>
                        <td><?= $image['width'] ?> × <?= $image['height'] ?>px</td>
                        <td><?= date('d/m/Y H:i', strtotime($image['uploaded_at'])) ?></td>
                        <td style="text-align: center;">
                            <a
                                href="<?= base_url('/images/delete/' . $image['id']) ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta imagen de <?= $imageUser ? esc($imageUser['name']) : 'usuario desconocido' ?>?')"
                            >
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Vista de Imagen -->
<div id="image-modal" class="modal">
    <div class="modal-content card">
        <div class="modal-header">
            <h2 class="modal-title" id="modal-image-title"></h2>
            <button class="modal-close" onclick="document.getElementById('image-modal').style.display='none'">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <img id="modal-image-preview" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: var(--radius-md);">
            <div id="modal-image-info" style="margin-top: var(--spacing-lg);"></div>
        </div>
    </div>
</div>

<script>
    function openImageModal(image, user) {
        const modal = document.getElementById('image-modal');
        const title = document.getElementById('modal-image-title');
        const preview = document.getElementById('modal-image-preview');
        const info = document.getElementById('modal-image-info');

        title.textContent = image.original_name;
        preview.src = '<?= base_url() ?>/' + image.file_path;
        preview.alt = image.original_name;

        const userName = user ? user.name : 'Usuario desconocido';
        const userLogin = user ? user.login : 'N/A';

        info.innerHTML = `
        <div style="display: grid; gap: var(--spacing-md);">
            <div class="card" style="padding: var(--spacing-md); background: var(--color-bg);">
                <strong>Propietario:</strong> ${userName} (@${userLogin})
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-sm);">
                <div><strong>Categoría:</strong> <span class="badge badge-primary">${image.category}</span></div>
                <div><strong>Tamaño:</strong> ${(image.file_size / 1024).toFixed(1)} KB</div>
                <div><strong>Dimensiones:</strong> ${image.width} × ${image.height}px</div>
                <div><strong>Formato:</strong> ${image.mime_type}</div>
            </div>
            ${image.description ? `<div><strong>Descripción:</strong> ${image.description}</div>` : ''}
            <div class="text-muted text-sm">
                Subida el: ${new Date(image.uploaded_at).toLocaleString('es-ES')}
            </div>
        </div>
    `;

        modal.style.display = 'flex';
    }

    // Cerrar modal al hacer click fuera
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('image-modal').style.display = 'none';
        }
    });
</script>