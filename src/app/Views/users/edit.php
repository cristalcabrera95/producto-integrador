<style>
    .edit-user-container {
        max-width: 700px;
        margin: 0 auto;
        animation: fadeIn 0.3s;
    }

    .form-card {
        background: white;
        padding: var(--spacing-2xl);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
    }

    .form-header {
        margin-bottom: var(--spacing-xl);
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0 0 var(--spacing-sm) 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .form-subtitle {
        color: var(--color-text-light);
        margin: 0;
    }

    .form-group {
        margin-bottom: var(--spacing-lg);
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-sm);
        font-weight: 600;
        color: var(--color-text);
        font-size: 0.875rem;
    }

    .form-label.required::after {
        content: '*';
        color: var(--color-error);
        margin-left: var(--spacing-xs);
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        font-size: 1rem;
        line-height: 1.5;
        color: var(--color-text);
        background-color: white;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        transition: all 0.15s;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--color-blue-medium);
        box-shadow: 0 0 0 3px rgba(48, 72, 120, 0.1);
    }

    .form-control:disabled {
        background-color: var(--color-bg);
        cursor: not-allowed;
        opacity: 0.6;
    }

    .form-help {
        display: block;
        margin-top: var(--spacing-xs);
        font-size: 0.75rem;
        color: var(--color-text-light);
    }

    .form-actions {
        display: flex;
        gap: var(--spacing-md);
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-xl);
        border-top: 1px solid var(--color-border);
    }

    .form-actions .btn {
        flex: 1;
    }

    .info-card {
        margin-top: var(--spacing-xl);
        padding: var(--spacing-lg);
        background: var(--color-bg);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--color-blue-medium);
    }

    .info-card h4 {
        margin: 0 0 var(--spacing-sm) 0;
        color: var(--color-text);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .info-card ul {
        margin: 0;
        padding-left: var(--spacing-lg);
        color: var(--color-text-light);
        line-height: 1.8;
    }

    .user-info-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: var(--spacing-xs) var(--spacing-md);
        margin-bottom: var(--spacing-md);
        background: white;
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border);
    }

    .user-info-label {
        font-weight: 600;
        color: var(--color-text);
    }

    .user-info-value {
        color: var(--color-text-light);
    }

    .password-toggle {
        position: relative;
    }

    .password-toggle-btn {
        position: absolute;
        right: var(--spacing-sm);
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--color-text-light);
        cursor: pointer;
        padding: var(--spacing-xs);
        border-radius: var(--radius-sm);
        transition: all 0.15s;
    }

    .password-toggle-btn:hover {
        color: var(--color-blue-medium);
        background: var(--color-bg);
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="edit-user-container">
    <div class="form-header">
        <h1 class="form-title">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Editar Usuario
        </h1>
        <p class="form-subtitle">Actualiza la información del usuario</p>
    </div>

    <!-- Mensajes de error -->
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

    <!-- Información del usuario -->
    <div class="info-card" style="margin-top: 0; margin-bottom: var(--spacing-xl);">
        <h4>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            Información del Usuario
        </h4>
        <div class="user-info-grid">
            <span class="user-info-label">ID:</span>
            <span class="user-info-value"><?= esc($user['id']) ?></span>

            <span class="user-info-label">Rol:</span>
            <span class="user-info-value">
                <span class="badge <?= $user['role'] === 'admin' ? 'badge-warning' : 'badge-primary' ?>">
                    <?= $user['role'] === 'admin' ? 'Administrador' : 'Usuario' ?>
                </span>
            </span>

            <span class="user-info-label">Fecha de creación:</span>
            <span class="user-info-value"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></span>

            <?php if (isset($user['updated_at'])): ?>
                <span class="user-info-label">Última modificación:</span>
                <span class="user-info-value"><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="form-card">
        <form action="<?= base_url('/users/update/' . $user['id']) ?>" method="post" id="edit-user-form">

            <div class="form-group">
                <label for="name" class="form-label required">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Nombre Completo
                </label>
                <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="<?= esc($user['name']) ?>"
                        required
                        minlength="3"
                        maxlength="50"
                >
                <span class="form-help">Mínimo 3 caracteres, máximo 50</span>
            </div>

            <div class="form-group">
                <label for="email" class="form-label required">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    Correo Electrónico
                </label>
                <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="<?= esc($user['email']) ?>"
                        required
                >
                <span class="form-help">Debe ser un email válido</span>
            </div>

            <div class="form-group">
                <label for="login" class="form-label required">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Nombre de Usuario
                </label>
                <input
                        type="text"
                        name="login"
                        id="login"
                        class="form-control"
                        value="<?= esc($user['login']) ?>"
                        required
                        minlength="3"
                        maxlength="20"
                        pattern="[a-zA-Z0-9]+"
                >
                <span class="form-help">Solo letras y números, entre 3 y 20 caracteres</span>
            </div>

            <?php if(isset($canEditRole) && $canEditRole): ?>
                <div class="form-group">
                    <label for="role" class="form-label required">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6"></path>
                        </svg>
                        Rol del Usuario
                    </label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Usuario Regular</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                    <span class="form-help">Los administradores tienen acceso completo al sistema</span>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="password" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Nueva Contraseña (opcional)
                </label>
                <div class="password-toggle">
                    <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Dejar vacío para mantener la actual"
                            minlength="5"
                            style="padding-right: 40px;"
                    >
                    <button
                            type="button"
                            class="password-toggle-btn"
                            onclick="togglePassword()"
                            title="Mostrar/Ocultar contraseña"
                    >
                        <svg id="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                <span class="form-help">Mínimo 5 caracteres. Dejar vacío para no cambiar la contraseña actual</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Guardar Cambios
                </button>
                <a href="<?= base_url('/users/list') ?>" class="btn btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="info-card">
        <h4>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            Notas Importantes
        </h4>
        <ul>
            <li>Si no ingresas una nueva contraseña, se mantendrá la actual</li>
            <li>La contraseña se guardará de forma segura (encriptada)</li>
            <li>El email y nombre de usuario deben ser únicos en el sistema</li>
            <?php if (session()->get('userId') == $user['id']): ?>
                <li><strong>⚠️ Estás editando tu propia cuenta</strong></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
        }
    }

    // Form validation
    document.getElementById('edit-user-form').addEventListener('submit', function(e) {
        const login = document.getElementById('login').value;

        // Validar que el login solo tenga letras y números
        if (!/^[a-zA-Z0-9]+$/.test(login)) {
            e.preventDefault();
            alert('El nombre de usuario solo puede contener letras y números');
            document.getElementById('login').focus();
        }
    });
</script>