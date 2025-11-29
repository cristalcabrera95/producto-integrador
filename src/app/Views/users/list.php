<style>
    .users-container {
        animation: fadeIn 0.3s;
        padding: 2rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-xl);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .stats-banner {
        background: linear-gradient(135deg, var(--color-blue-dark) 0%, var(--color-blue-medium) 100%);
        color: white;
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
        margin-bottom: var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stats-item {
        text-align: center;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-gold);
    }

    .stats-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .actions-bar {
        display: flex;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .table-container {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--color-border);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: var(--color-blue-dark);
    }

    .table th {
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--color-border);
        color: var(--color-text);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: var(--color-bg);
    }

    .user-name {
        font-weight: 600;
        color: var(--color-blue-dark);
    }

    .user-login {
        font-family: 'Courier New', monospace;
        background: var(--color-bg);
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        color: var(--color-blue-medium);
    }

    .user-role-badge {
        display: inline-flex;
        align-items: center;
        padding: var(--spacing-xs) var(--spacing-sm);
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin {
        background: rgba(240, 168, 24, 0.1);
        color: var(--color-gold);
    }

    .role-user {
        background: rgba(48, 72, 120, 0.1);
        color: var(--color-blue-medium);
    }

    .actions-cell {
        display: flex;
        gap: var(--spacing-sm);
        justify-content: center;
        align-items: center;
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

    .info-box {
        margin-top: var(--spacing-xl);
        padding: var(--spacing-lg);
        background: var(--color-bg);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--color-blue-medium);
    }

    .info-box p {
        margin: 0;
        color: var(--color-text);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-md);
        }

        .stats-banner {
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .actions-cell {
            flex-direction: column;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: var(--spacing-sm);
        }
    }
</style>

<div class="users-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Gestión de Usuarios
        </h1>
    </div>

    <!-- Mensajes de feedback -->
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

    <!-- Stats Banner -->
    <?php if(isset($stats)): ?>
        <div class="stats-banner">
            <div class="stats-item">
                <div class="stats-number"><?= $stats['total'] ?></div>
                <div class="stats-label">Total Usuarios</div>
            </div>
            <div class="stats-item">
                <div class="stats-number"><?= $stats['admins'] ?></div>
                <div class="stats-label">Administradores</div>
            </div>
            <div class="stats-item">
                <div class="stats-number"><?= $stats['regular_users'] ?></div>
                <div class="stats-label">Usuarios Regulares</div>
            </div>
            <div class="stats-item">
                <div class="stats-number"><?= $stats['active'] ?></div>
                <div class="stats-label">Activos</div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Actions Bar -->
    <div class="actions-bar">
        <a href="<?= base_url('/users/create') ?>" class="btn btn-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"></path>
            </svg>
            Crear Nuevo Usuario
        </a>
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <!-- Tabla de usuarios -->
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Fecha Creación</th>
                <th style="text-align: center;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <p>No hay usuarios registrados</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td>
                            <span class="user-name"><?= esc($user['name']) ?></span>
                        </td>
                        <td><?= esc($user['email']) ?></td>
                        <td>
                            <code class="user-login"><?= esc($user['login']) ?></code>
                        </td>
                        <td>
                                <span class="user-role-badge <?= $user['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                                    <?= $user['role'] === 'admin' ? 'Admin' : 'Usuario' ?>
                                </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                        <td>
                            <div class="actions-cell">
                                <a
                                        href="<?= base_url('/users/edit/' . $user['id']) ?>"
                                        class="btn btn-primary btn-sm"
                                        title="Editar usuario"
                                >
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Editar
                                </a>

                                <?php if (session()->get('userId') != $user['id']): ?>
                                    <a
                                            href="<?= base_url('/users/delete/' . $user['id']) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar a <?= esc($user['name']) ?>?')"
                                            title="Eliminar usuario"
                                    >
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Eliminar
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted text-sm">(Tu cuenta)</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Información adicional -->
    <div class="info-box">
        <p>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <strong>Información:</strong>
            Total de usuarios registrados: <strong><?= count($users) ?></strong>
            <?php if(isset($stats)): ?>
                | Administradores: <strong><?= $stats['admins'] ?></strong>
                | Usuarios regulares: <strong><?= $stats['regular_users'] ?></strong>
            <?php endif; ?>
        </p>
    </div>
</div>