<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de Usuarios
 *
 * Gestiona usuarios con sistema de roles (admin/user)
 * Soporta tanto JSON como base de datos
 */
class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'email', 'login', 'password', 'role', 'avatar', 'is_active'];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'login' => 'required|min_length[3]|max_length[20]|alpha_numeric|is_unique[users.login,id,{id}]',
        'password' => 'required|min_length[5]',
        'role' => 'in_list[user,admin]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Este email ya está registrado'
        ],
        'login' => [
            'is_unique' => 'Este usuario ya existe'
        ]
    ];

    private string $jsonFile;
    private bool $useDatabase = false;

    public function __construct()
    {
        parent::__construct();
        $this->jsonFile = WRITEPATH . 'data/users.json';

        // Intentar usar base de datos, si falla usar JSON
        try {
            $this->db->tableExists($this->table);
            $this->useDatabase = true;
        } catch (\Exception $e) {
            $this->useDatabase = false;
            $this->initializeFile();
        }
    }

    /**
     * Inicializa el archivo JSON con usuarios por defecto
     */
    private function initializeFile(): void
    {
        if (!file_exists($this->jsonFile)) {
            $defaultUsers = [
                [
                    'id' => 1,
                    'name' => 'Administrador',
                    'email' => 'admin@example.com',
                    'login' => 'admin',
                    'password' => password_hash('12345', PASSWORD_DEFAULT),
                    'role' => 'admin',
                    'avatar' => null,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'name' => 'Usuario Básico',
                    'email' => 'user@example.com',
                    'login' => 'user',
                    'password' => password_hash('abcde', PASSWORD_DEFAULT),
                    'role' => 'user',
                    'avatar' => null,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];

            file_put_contents($this->jsonFile, json_encode($defaultUsers, JSON_PRETTY_PRINT));
        }
    }

    /**
     * Obtiene todos los usuarios
     */
    public function getAllUsers(): array
    {
        if ($this->useDatabase) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }

        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $content = file_get_contents($this->jsonFile);
        return json_decode($content, true) ?? [];
    }

    /**
     * Obtiene un usuario por ID
     */
    public function getUserById(int $id): ?array
    {
        if ($this->useDatabase) {
            return $this->find($id);
        }

        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Verifica credenciales de usuario
     */
    public function verifyUser(string $login, string $password): ?array
    {
        if ($this->useDatabase) {
            $user = $this->where('login', $login)
                ->orWhere('email', $login)
                ->where('is_active', 1)
                ->first();

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return null;
        }

        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if (($user['login'] === $login || $user['email'] === $login)
                && password_verify($password, $user['password'])
                && $user['is_active'] == 1) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Crea un nuevo usuario
     */
    public function createUser(array $data): bool|int
    {
        // Hash de contraseña
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Asignar rol por defecto
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }

        if ($this->useDatabase) {
            return $this->insert($data);
        }

        $users = $this->getAllUsers();

        // Verificar unicidad
        foreach ($users as $user) {
            if ($user['login'] === $data['login'] || $user['email'] === $data['email']) {
                return false;
            }
        }

        $newId = empty($users) ? 1 : max(array_column($users, 'id')) + 1;

        $newUser = [
            'id' => $newId,
            'name' => $data['name'],
            'email' => $data['email'],
            'login' => $data['login'],
            'password' => $data['password'],
            'role' => $data['role'],
            'avatar' => $data['avatar'] ?? null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $users[] = $newUser;

        return file_put_contents($this->jsonFile, json_encode($users, JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Actualiza un usuario
     */
    public function updateUser(int $id, array $data): bool
    {
        // Hash de contraseña si se proporciona
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        if ($this->useDatabase) {
            return $this->update($id, $data);
        }

        $users = $this->getAllUsers();
        $updated = false;

        foreach ($users as $key => $user) {
            if ($user['id'] == $id) {
                $users[$key] = array_merge($user, $data);
                $users[$key]['updated_at'] = date('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            return file_put_contents($this->jsonFile, json_encode($users, JSON_PRETTY_PRINT)) !== false;
        }

        return false;
    }

    /**
     * Elimina un usuario
     */
    public function deleteUser(int $id): bool
    {
        if ($this->useDatabase) {
            return $this->delete($id);
        }

        $users = $this->getAllUsers();
        $newUsers = array_filter($users, function($user) use ($id) {
            return $user['id'] != $id;
        });

        return file_put_contents($this->jsonFile, json_encode(array_values($newUsers), JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Verifica si el usuario es administrador
     */
    public function isAdmin(int $userId): bool
    {
        $user = $this->getUserById($userId);
        return $user && $user['role'] === 'admin';
    }

    /**
     * Obtiene estadísticas de usuarios
     */
    public function getUserStats(): array
    {
        $users = $this->getAllUsers();

        return [
            'total' => count($users),
            'admins' => count(array_filter($users, fn($u) => $u['role'] === 'admin')),
            'regular_users' => count(array_filter($users, fn($u) => $u['role'] === 'user')),
            'active' => count(array_filter($users, fn($u) => $u['is_active'] == 1))
        ];
    }
}
