<div class="login-container">
    <div class="login-card card">
        <div class="login-header">
            <svg class="login-logo" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <h1 class="login-title">Sistema de Gestión</h1>
            <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/user/login') ?>" method="post" class="login-form">
            <div class="form-group">
                <label for="login" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Usuario o Email
                </label>
                <input
                        type="text"
                        name="login"
                        id="login"
                        class="form-control"
                        placeholder="Ingresa tu usuario o email"
                        required
                        autofocus
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
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
                        placeholder="Ingresa tu contraseña"
                        required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                Iniciar Sesión
            </button>
        </form>

        <div class="login-demo">
            <p class="text-muted text-sm text-center mb-md">Usuarios de demostración:</p>
            <div class="demo-users">
                <div class="demo-user">
                    <span class="badge badge-warning">Admin</span>
                    <code>admin / 12345</code>
                </div>
                <div class="demo-user">
                    <span class="badge badge-primary">Usuario</span>
                    <code>user / abcde</code>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-xl);
        background: linear-gradient(135deg, var(--color-blue-dark) 0%, var(--color-blue-medium) 50%, var(--color-blue-light) 100%);
    }

    .login-card {
        width: 100%;
        max-width: 450px;
        padding: var(--spacing-2xl);
        animation: slideIn var(--transition-base);
    }

    .login-header {
        text-align: center;
        margin-bottom: var(--spacing-xl);
    }

    .login-logo {
        color: var(--color-blue-medium);
        margin-bottom: var(--spacing-md);
    }

    .login-title {
        font-size: var(--font-size-3xl);
        color: var(--color-blue-dark);
        margin: 0 0 var(--spacing-sm) 0;
        font-weight: 700;
    }

    .login-subtitle {
        color: var(--color-text-light);
        margin: 0;
    }

    .login-form .form-label {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .login-demo {
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-xl);
        border-top: 1px solid var(--color-border);
    }

    .demo-users {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .demo-user {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--color-bg);
        border-radius: var(--radius-md);
    }

    .demo-user code {
        font-size: var(--font-size-sm);
        color: var(--color-text);
        background: white;
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--radius-sm);
    }
</style>
