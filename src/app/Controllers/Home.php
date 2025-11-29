<?php
namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Controlador Home
 *
 * Maneja páginas principales y dashboard
 */
class Home extends Controller
{
    /**
     * Página de inicio (login)
     */
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $data = ['title' => 'Iniciar Sesión'];
        return view('layouts/header', $data) . view('home') . view('layouts/footer');
    }

    /**
     * Dashboard principal
     */
    public function dashboard(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Dashboard',
            'userName' => $session->get('userName'),
            'userLogin' => $session->get('userLogin')
        ];

        return view('layouts/header', $data) . view('dashboard', $data) . view('layouts/footer');
    }
}
