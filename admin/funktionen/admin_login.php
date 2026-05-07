<?php
// Admin-Login Logik
// Hardcoded Admin-Zugangsdaten (in Produktion: aus DB oder .env)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); 
// Passwort: "password" – beim Deployment ersetzen!
// Generieren: password_hash('deinPasswort', PASSWORD_DEFAULT)

function admin_is_logged_in(): bool
{
    return isset($_SESSION['admin']['eingelogt']) && $_SESSION['admin']['eingelogt'] === true;
}

function admin_guard(): void// Zugriffschutz für Admin-seiten, (index.php, aktionen/delete.php) 
{
    if (!admin_is_logged_in()) {
        header('Location: ' . BASE_URL . '/pages/home.php');// ohne admin berechtigung redirect zu Benutzerseite
        exit;
    }
}

function admin_login(string $user, string $pass): bool
{
    if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS)) {
        $_SESSION['admin']['eingelogt'] = true;
        $_SESSION['admin']['name']      = ADMIN_USER;
        return true;
    }
    return false;
}

function admin_logout(): void
{
    unset($_SESSION['admin']);
}