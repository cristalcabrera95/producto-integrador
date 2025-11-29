<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión con galería personal">
    <title><?= $title ?? 'Sistema de Gestión' ?></title>

    <!-- Estilos principales -->
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
</head>
<body>
<!-- Header Navigation -->
<?php if(session()->get('isLoggedIn')): ?>
    <header class="main-header">
        <div class="container header-content">
            <div class="header-brand">
                <svg class="logo-icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <h1 class="brand-title">Sistema de Gestión</h1>
            </div>

            <nav class="main-nav">
                <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Dashboard
                </a>

                <a href="<?= base_url('/images') ?>" class="nav-link <?= strpos(uri_string(), 'images') !== false ? 'active' : '' ?>">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    Mi Galería
                </a>

                <?php if(session()->get('userRole') === 'admin'): ?>
                    <a href="<?= base_url('/users/list') ?>" class="nav-link <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
                        <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Usuarios
                    </a>

                    <a href="<?= base_url('/images/admin-panel') ?>" class="nav-link <?= strpos(uri_string(), 'admin-panel') !== false ? 'active' : '' ?>">
                        <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6m-9-9h6m6 0h6"></path>
                        </svg>
                        Admin Panel
                    </a>
                <?php endif; ?>
            </nav>

            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php if(session()->get('userAvatar')): ?>
                            <img src="<?= base_url(session()->get('userAvatar')) ?>" alt="Avatar">
                        <?php else: ?>
                            <span><?= strtoupper(substr(session()->get('userName'), 0, 1)) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?= esc(session()->get('userName')) ?></span>
                        <span class="user-role <?= session()->get('userRole') ?>"><?= session()->get('userRole') === 'admin' ? 'Administrador' : 'Usuario' ?></span>
                    </div>
                </div>

                <div class="user-actions">
                    <a href="<?= base_url('/user/profile') ?>" class="btn btn-ghost btn-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Perfil
                    </a>
                    <a href="<?= base_url('/user/logout') ?>" class="btn btn-outline btn-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>

<!-- Main Content -->
<main class="main-content <?= session()->get('isLoggedIn') ? 'with-header' : '' ?>">
    <div class="container">
