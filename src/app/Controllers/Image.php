<?php
namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

/**
 * Controlador de Imágenes
 *
 * Gestiona galería personal de cada usuario con permisos
 */
class Image extends Controller
{
    protected ImageModel $imageModel;
    protected UserModel $userModel;
    protected mixed $session;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
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
    private function isAdmin(): bool
    {
        return $this->session->get('userRole') === 'admin';
    }

    /**
     * Galería personal del usuario
     */
    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        $userId = $this->session->get('userId');
        $isAdmin = $this->isAdmin();

        // Admin puede ver todas las imágenes, usuario solo las suyas
        if ($isAdmin && $this->request->getGet('user_id')) {
            $viewUserId = $this->request->getGet('user_id');
            $images = $this->imageModel->getUserImages($viewUserId);
            $viewingOtherUser = true;
        } else {
            $images = $this->imageModel->getUserImages($userId);
            $viewingOtherUser = false;
        }

        $categories = $this->imageModel->getUserCategories($userId);
        $stats = $this->imageModel->getUserImageStats($userId);

        // Filtro de categoría
        $categoryFilter = $this->request->getGet('category');
        if ($categoryFilter) {
            $images = array_filter($images, fn($img) => $img['category'] === $categoryFilter);
        }

        $data = [
            'images' => $images,
            'categories' => $categories,
            'stats' => $stats,
            'categoryFilter' => $categoryFilter,
            'isAdmin' => $isAdmin,
            'viewingOtherUser' => $viewingOtherUser,
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('images/gallery', $data)
            . view('layouts/footer');
    }

    /**
     * Subir nueva imagen
     */
    public function upload()
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        $file = $this->request->getFile('image');

        if (!$file || !$file->isValid()) {
            $this->session->setFlashdata('error', 'Archivo inválido o no seleccionado');
            return redirect()->to('/images');
        }

        $userId = $this->session->get('userId');
        $category = $this->request->getPost('category') ?: 'general';
        $description = $this->request->getPost('description') ?: '';

        $fileData = [
            'name' => $file->getName(),
            'type' => $file->getMimeType(),
            'tmp_name' => $file->getTempName(),
            'size' => $file->getSize()
        ];

        $result = $this->imageModel->saveImage($fileData, $userId, $category, $description);

        if ($result) {
            $this->session->setFlashdata('success', 'Imagen subida exitosamente');
        } else {
            $this->session->setFlashdata('error', 'Error al subir. Verifica formato (JPG/PNG/GIF/WEBP) y tamaño (máx 10MB)');
        }

        return redirect()->to('/images');
    }

    /**
     * Eliminar imagen
     */
    public function delete($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        $userId = $this->session->get('userId');
        $isAdmin = $this->isAdmin();

        if ($this->imageModel->deleteImage($id, $userId, $isAdmin)) {
            $this->session->setFlashdata('success', 'Imagen eliminada');
        } else {
            $this->session->setFlashdata('error', 'No se pudo eliminar la imagen o no tienes permisos');
        }

        return redirect()->to('/images');
    }

    /**
     * Actualizar metadata de imagen
     */
    public function updateMetadata()
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autenticado']);
        }

        $id = $this->request->getPost('id');
        $category = $this->request->getPost('category');
        $description = $this->request->getPost('description');

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID requerido']);
        }

        $userId = $this->session->get('userId');
        $isAdmin = $this->isAdmin();

        $data = [];
        if ($category) $data['category'] = $category;
        if ($description !== null) $data['description'] = $description;

        if ($this->imageModel->updateImageMetadata($id, $userId, $data, $isAdmin)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Actualizado']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error o sin permisos']);
        }
    }

    /**
     * Vista de imagen individual
     */
    public function view($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/');
        }

        $image = $this->imageModel->getImageById($id);

        if (!$image) {
            $this->session->setFlashdata('error', 'Imagen no encontrada');
            return redirect()->to('/images');
        }

        $userId = $this->session->get('userId');
        $isAdmin = $this->isAdmin();

        // Verificar permisos
        if (!$isAdmin && $image['user_id'] != $userId) {
            $this->session->setFlashdata('error', 'No tienes permiso para ver esta imagen');
            return redirect()->to('/images');
        }

        $data = [
            'image' => $image,
            'isAdmin' => $isAdmin,
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('images/view', $data)
            . view('layouts/footer');
    }

    /**
     * Panel administrativo de imágenes (solo admin)
     */
    public function adminPanel()
    {
        if (!$this->isAdmin()) {
            $this->session->setFlashdata('error', 'Acceso denegado');
            return redirect()->to('/dashboard');
        }

        $allImages = $this->imageModel->getAllImages();
        $globalStats = $this->imageModel->getGlobalStats();
        $users = $this->userModel->getAllUsers();

        $data = [
            'images' => $allImages,
            'stats' => $globalStats,
            'users' => $users,
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        return view('layouts/header', $data)
            . view('images/admin_panel', $data)
            . view('layouts/footer');
    }
}
