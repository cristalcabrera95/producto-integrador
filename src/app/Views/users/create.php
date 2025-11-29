<style>
    .form-container {
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
        text-align: center;
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0 0 var(--spacing-sm) 0;
        display: flex;
        align-items: center;
        justify-content: center;
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

    .form-control.is-invalid {
        border-color: var(--color-error);
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

    .password-strength {
        margin-top: var(--spacing-sm);
    }

    .strength-bar {
        height: 4px;
        background: var(--color-border);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s;
        width: 0%;
    }

    .strength-weak {
        width: 33%;
        background: var(--color-error);
    }

    .strength-medium {
        width: 66%;
        background: var(--color-gold);
    }

    .strength-strong {
        width: 100%;
        background: var(--color-success);
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h1 class="form-title">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Crear Nuevo Usuario
            </h1>
            <p class="form-subtitle">Completa la información del nuevo usuario</p>
        </div>

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

        <form action="<?= base_url('/users/store') ?>" method="post" id="create-user-form">

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
                        placeholder="Ej: Juan Pérez López"
                        value="<?= old('name') ?>"
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
                        placeholder="Ej: usuario@ejemplo.com"
                        value="<?= old('email') ?>"
                        required
                >
                <span class="form-help">Debe ser un email válido y único</span>
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
                        placeholder="Ej: juanperez"
                        value="<?= old('login') ?>"
                        required
                        minlength="3"
                        maxlength="20"
                        pattern="[a-zA-Z0-9]+"
                >
                <span class="form-help">Solo letras y números, entre 3 y 20 caracteres</span>
            </div>

            <div class="form-group">
                <label for="password" class="form-label required">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Contraseña
                </label>
                <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Mínimo 5 caracteres"
                        required
                        minlength="5"
                >
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                </div>
                <span class="form-help" id="strength-text">Mínimo 5 caracteres</span>
            </div>

            <?php if(session()->get('userRole') === 'admin'): ?>
                <div class="form-group">
                    <label for="role" class="form-label required">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6"></path>
                        </svg>
                        Rol del Usuario
                    </label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="user" selected>Usuario Regular</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <span class="form-help">Los administradores tienen acceso completo al sistema</span>
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Crear Usuario
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

    <div class="info-card">
        <h4>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            Requisitos
        </h4>
        <ul>
            <li>El <strong>email</strong> y el <strong>nombre de usuario</strong> deben ser únicos</li>
            <li>La contraseña se guardará de forma segura (encriptada)</li>
            <li>Todos los campos son obligatorios</li>
            <li>El usuario podrá cambiar su contraseña después</li>
        </ul>
    </div>
</div>

<script>
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const fill = document.getElementById('strength-fill');
        const text = document.getElementById('strength-text');

        let strength = 0;
        if (password.length >= 5) strength++;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        fill.className = 'strength-fill';

        if (strength === 0) {
            text.textContent = 'Mínimo 5 caracteres';
        } else if (strength <= 2) {
            fill.classList.add('strength-weak');
            text.textContent = 'Contraseña débil';
            text.style.color = 'var(--color-error)';
        } else if (strength <= 3) {
            fill.classList.add('strength-medium');
            text.textContent = 'Contraseña media';
            text.style.color = 'var(--color-gold)';
        } else {
            fill.classList.add('strength-strong');
            text.textContent = 'Contraseña fuerte';
            text.style.color = 'var(--color-success)';
        }
    });

    // Form validation
    document.getElementById('create-user-form').addEventListener('submit', function(e) {
        const login = document.getElementById('login').value;

        // Validar que el login solo tenga letras y números
        if (!/^[a-zA-Z0-9]+$/.test(login)) {
            e.preventDefault();
            alert('El nombre de usuario solo puede contener letras y números');
            document.getElementById('login').focus();
        }
    });
</script>