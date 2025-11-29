</div>
</main>

<footer class="main-footer">
    <div class="container footer-content">
        <div class="footer-info">
            <p>&copy; <?= date('Y') ?> Sistema de Gestión. Todos los derechos reservados.</p>
        </div>

        <?php if(session()->get('isLoggedIn')): ?>
            <div class="footer-links">
                <a href="<?= base_url('/dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('/images') ?>">Galería</a>
                <?php if(session()->get('userRole') === 'admin'): ?>
                    <a href="<?= base_url('/users/list') ?>">Usuarios</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>

<script>
    // Auto-hide alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade-out');
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
</body>
</html>