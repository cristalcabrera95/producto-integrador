<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

/**
 * Controlador de Usuarios
 *
 * Gestiona autenticación y CRUD de usuarios con control de roles
 */
class User extends Controller
{
    protected UserModel $userModel;
    protected mixed $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    /**
     * Verifica autenticación
     */
    private function checkAuth(): bool
    {
        return $this->session->get('isLoggedIn') === true;
    }

    /**
     * Verifica si es administrador
     */
    private function checkAdmin(): bool
    {
        return $this->checkAuth() && $this->session->get('userRole') === 'admin';
    }

    /**
     * Login de usuario
     */
    public function login()
    {
        helper(['form', 'url']);

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyUser($login, $password);

        if ($user) {
            $this->session->set([
                'userId' => $user['id'],
                'userName' => $user['name'],
                'userLogin' => $user['login'],
                'userEmail' => $user['email'],
                'userRole' => $user['role'],
                'userAvatar' => $user['avatar'] ?? null,
                'isLoggedIn' => true
            ]);

            setcookie("user_name", $user['name'], time() + 3600, "/");

            return redirect()->to('/dashboard');
        } else {
            $this->session->setFlashdata('error', 'Credenciales incorrectas');
            return redirect()->to('/');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->destroy();
        setcookie("user_name", "", time() - 3600, "/");
        return redirect()->to('/');
    }

    /**
     * Lista de usuarios (solo admin)
     */
    public function list()
    {
        if (!$this->checkAdmin()) {
            $this->session->setFlashdata('error', 'Acceso denegado. Solo administradores.');
            return redirect()->to('/dashboard');
        }

        $users = $this->userModel->getAllUsers();
        $stats = $this->userModel->getUserStats();

        $data = [
            'users' => $users,
            'stats' => $stats,
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('users/list', $data)
            . view('layouts/footer');
    }

    /**
     * Formulario crear usuario (solo admin)
     */
    public function create()
    {
        if (!$this->checkAdmin()) {
            $this->session->setFlashdata('error', 'Acceso denegado');
            return redirect()->to('/dashboard');
        }

        $data = [
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('users/create', $data)
            . view('layouts/footer');
    }

    /**
     * Guardar nuevo usuario (solo admin)
     */
    public function store()
    {
        if (!$this->checkAdmin()) {
            return redirect()->to('/dashboard');
        }

        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'login' => 'required|min_length[3]|max_length[20]|alpha_numeric',
            'password' => 'required|min_length[5]',
            'role' => 'in_list[user,admin]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $this->session->setFlashdata('error', 'Datos inválidos');
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'login' => $this->request->getPost('login'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role') ?? 'user'
        ];

        if ($this->userModel->createUser($data)) {
            $this->session->setFlashdata('success', 'Usuario creado exitosamente');
            return redirect()->to('/users/list');
        } else {
            $this->session->setFlashdata('error', 'El usuario o email ya existe');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Formulario editar usuario (solo admin o propio usuario)
     */
    public function edit($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        // Solo admin o el propio usuario puede editar
        if (!$this->checkAdmin() && $this->session->get('userId') != $id) {
            $this->session->setFlashdata('error', 'No tienes permiso para editar este usuario');
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $this->session->setFlashdata('error', 'Usuario no encontrado');
            return redirect()->to('/users/list');
        }

        $data = [
            'user' => $user,
            'canEditRole' => $this->checkAdmin(),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('users/edit', $data)
            . view('layouts/footer');
    }

    /**
     * Actualizar usuario
     */
    public function update($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        // Verificar permisos
        if (!$this->checkAdmin() && $this->session->get('userId') != $id) {
            $this->session->setFlashdata('error', 'Sin permisos');
            return redirect()->to('/dashboard');
        }

        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'login' => 'required|min_length[3]|max_length[20]|alpha_numeric'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[5]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            $this->session->setFlashdata('error', 'Datos inválidos');
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'login' => $this->request->getPost('login')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        // Solo admin puede cambiar roles
        if ($this->checkAdmin()) {
            $data['role'] = $this->request->getPost('role') ?? 'user';
        }

        if ($this->userModel->updateUser($id, $data)) {
            // Actualizar sesión si el usuario editó su propio perfil
            if ($this->session->get('userId') == $id) {
                $this->session->set([
                    'userName' => $data['name'],
                    'userLogin' => $data['login'],
                    'userEmail' => $data['email']
                ]);
            }

            $this->session->setFlashdata('success', 'Usuario actualizado');

            if ($this->checkAdmin()) {
                return redirect()->to('/users/list');
            } else {
                return redirect()->to('/dashboard');
            }
        } else {
            $this->session->setFlashdata('error', 'Error al actualizar');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Eliminar usuario (solo admin)
     */
    public function delete($id)
    {
        if (!$this->checkAdmin()) {
            $this->session->setFlashdata('error', 'Sin permisos');
            return redirect()->to('/dashboard');
        }

        // No permitir eliminar el propio usuario
        if ($this->session->get('userId') == $id) {
            $this->session->setFlashdata('error', 'No puedes eliminar tu propio usuario');
            return redirect()->to('/users/list');
        }

        if ($this->userModel->deleteUser($id)) {
            $this->session->setFlashdata('success', 'Usuario eliminado');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar');
        }

        return redirect()->to('/users/list');
    }

    /**
     * Perfil de usuario
     */
    public function profile()
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        $userId = $this->session->get('userId');
        $user = $this->userModel->getUserById($userId);

        $data = [
            'user' => $user,
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('users/profile', $data)
            . view('layouts/footer');
    }
}
