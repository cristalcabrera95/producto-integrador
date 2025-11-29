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

<div class="gallery-container">
    <!-- Header con estadísticas -->
    <div class="gallery-header card">
        <div class="gallery-info">
            <h1 class="page-title">Mi Galería de Imágenes</h1>
            <div class="gallery-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['total'] ?></span>
                    <span class="stat-label">Imágenes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['categories'] ?></span>
                    <span class="stat-label">Categorías</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= number_format($stats['total_size'] / 1024 / 1024, 1) ?>MB</span>
                    <span class="stat-label">Almacenado</span>
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn-lg" onclick="document.getElementById('upload-modal').style.display='flex'">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            Subir Imagen
        </button>
    </div>

    <!-- Filtros -->
    <?php if (!empty($categories)): ?>
        <div class="filters-section card">
            <h3 class="filters-title">Filtrar por categoría:</h3>
            <div class="filters-buttons">
                <a href="<?= base_url('/images') ?>" class="btn btn-sm <?= !$categoryFilter ? 'btn-primary' : 'btn-outline' ?>">
                    Todas
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= base_url('/images?category=' . urlencode($cat)) ?>"
                       class="btn btn-sm <?= $categoryFilter === $cat ? 'btn-primary' : 'btn-outline' ?>">
                        <?= esc($cat) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Galería de imágenes -->
    <?php if (empty($images)): ?>
        <div class="empty-state card">
            <svg class="empty-icon" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            <h2>No hay imágenes</h2>
            <p>Comienza subiendo tu primera imagen a la galería</p>
            <button class="btn btn-primary" onclick="document.getElementById('upload-modal').style.display='flex'">
                Subir Primera Imagen
            </button>
        </div>
    <?php else: ?>
        <div class="images-grid">
            <?php foreach ($images as $image): ?>
                <div class="image-card card">
                    <div class="image-preview" onclick="openImageModal(<?= htmlspecialchars(json_encode($image)) ?>)">
                        <img src="<?= base_url($image['file_path']) ?>"
                             alt="<?= esc($image['original_name']) ?>"
                             loading="lazy">
                        <div class="image-overlay">
                            <button class="overlay-btn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="image-info">
                        <h4 class="image-title" title="<?= esc($image['original_name']) ?>">
                            <?= esc($image['original_name']) ?>
                        </h4>
                        <div class="image-meta">
                            <span class="badge badge-primary"><?= esc($image['category']) ?></span>
                            <span class="text-muted text-sm"><?= $image['width'] ?> × <?= $image['height'] ?>px</span>
                            <span class="text-muted text-sm"><?= number_format($image['file_size'] / 1024, 1) ?>KB</span>
                        </div>
                        <?php if (!empty($image['description'])): ?>
                            <p class="image-description"><?= esc($image['description']) ?></p>
                        <?php endif; ?>
                        <div class="image-actions">
                            <a href="<?= base_url('/images/delete/' . $image['id']) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar esta imagen?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de subida -->
<div id="upload-modal" class="modal">
    <div class="modal-content card">
        <div class="modal-header">
            <h2 class="modal-title">Subir Nueva Imagen</h2>
            <button class="modal-close" onclick="document.getElementById('upload-modal').style.display='none'">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form action="<?= base_url('/images/upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="image" class="form-label">Seleccionar imagen:</label>
                    <div class="file-input">
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp" required>
                        <label for="image" class="file-input-label">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <span>Click para seleccionar archivo</span>
                        </label>
                    </div>
                    <span class="form-help">Formatos: JPG, PNG, GIF, WEBP | Máximo: 10MB</span>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Categoría:</label>
                    <input type="text" name="category" id="category" class="form-control"
                           value="general" list="categories-list" placeholder="Ej: vacaciones, trabajo, etc.">
                    <datalist id="categories-list">
                        <?php foreach ($categories ?? [] as $cat): ?>
                        <option value="<?= esc($cat) ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Descripción (opcional):</label>
                    <textarea name="description" id="description" class="form-textarea" rows="3"
                              placeholder="Añade una descripción a tu imagen"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('upload-modal').style.display='none'">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Subir Imagen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de vista de imagen -->
<div id="image-modal" class="modal">
    <div class="modal-content modal-large card">
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
            <img id="modal-image-preview" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain;">
            <div id="modal-image-info" class="mt-lg"></div>
        </div>
    </div>
</div>

<style>
    .gallery-container {
        animation: fadeIn var(--transition-base);
        padding: 2rem;
    }

    .gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-lg);
    }

    .page-title {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0 0 var(--spacing-md) 0;
    }

    .gallery-stats {
        display: flex;
        gap: var(--spacing-xl);
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-number {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--color-blue-medium);
    }

    .stat-label {
        font-size: var(--font-size-sm);
        color: var(--color-text-light);
    }

    .filters-section {
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }

    .filters-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin: 0 0 var(--spacing-md) 0;
    }

    .filters-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
    }

    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: var(--spacing-lg);
    }

    .image-card {
        overflow: hidden;
        transition: all var(--transition-base);
    }

    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .image-preview {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        cursor: pointer;
        background: var(--color-bg);
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-base);
    }

    .image-card:hover .image-preview img {
        transform: scale(1.05);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--transition-fast);
    }

    .image-preview:hover .image-overlay {
        opacity: 1;
    }

    .overlay-btn {
        background: white;
        color: var(--color-blue-medium);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .overlay-btn:hover {
        transform: scale(1.1);
        background: var(--color-gold);
        color: white;
    }

    .image-info {
        padding: var(--spacing-md);
    }

    .image-title {
        font-size: var(--font-size-base);
        font-weight: 600;
        margin: 0 0 var(--spacing-sm) 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .image-meta {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
        align-items: center;
        margin-bottom: var(--spacing-sm);
    }

    .image-description {
        font-size: var(--font-size-sm);
        color: var(--color-text-light);
        margin: var(--spacing-sm) 0;
        line-height: 1.4;
    }

    .image-actions {
        display: flex;
        gap: var(--spacing-sm);
        margin-top: var(--spacing-md);
    }

    .empty-state {
        text-align: center;
        padding: var(--spacing-2xl) var(--spacing-xl);
    }

    .empty-icon {
        color: var(--color-border);
        margin-bottom: var(--spacing-lg);
    }

    .empty-state h2 {
        color: var(--color-text);
        margin: 0 0 var(--spacing-sm) 0;
    }

    .empty-state p {
        color: var(--color-text-light);
        margin: 0 0 var(--spacing-xl) 0;
    }

    /* Modal estilos */
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
        animation: fadeIn var(--transition-fast);
    }

    .modal-content {
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn var(--transition-base);
    }

    .modal-large {
        max-width: 900px;
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
        font-size: var(--font-size-xl);
        font-weight: 700;
    }

    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--color-text-light);
        padding: var(--spacing-sm);
        border-radius: var(--radius-md);
        transition: all var(--transition-fast);
    }

    .modal-close:hover {
        background: var(--color-bg);
        color: var(--color-text);
    }

    .modal-body {
        padding: var(--spacing-lg);
    }

    .modal-footer {
        padding: var(--spacing-lg);
        border-top: 1px solid var(--color-border);
        display: flex;
        justify-content: flex-end;
        gap: var(--spacing-sm);
    }

    @media (max-width: 768px) {
        .gallery-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-lg);
        }

        .images-grid {
            grid-template-columns: 1fr;
        }

        .modal-content {
            max-width: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<script>
    function openImageModal(image) {
        const modal = document.getElementById('image-modal');
        const title = document.getElementById('modal-image-title');
        const preview = document.getElementById('modal-image-preview');
        const info = document.getElementById('modal-image-info');

        title.textContent = image.original_name;
        preview.src = '<?= base_url() ?>/' + image.file_path;
        preview.alt = image.original_name;

        info.innerHTML = `
        <div class="image-meta">
            <span class="badge badge-primary">${image.category}</span>
            <span class="text-muted">${image.width} × ${image.height}px</span>
            <span class="text-muted">${(image.file_size / 1024).toFixed(1)}KB</span>
        </div>
        ${image.description ? `<p class="mt-md">${image.description}</p>` : ''}
        <p class="text-muted text-sm mt-md">Subida: ${new Date(image.uploaded_at).toLocaleString('es-ES')}</p>
    `;

        modal.style.display = 'flex';
    }

    // Cerrar modal al hacer click fuera
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });

    // Preview de archivo seleccionado
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const label = document.querySelector('.file-input-label span');
            label.textContent = file.name;
        }
    });
</script>
