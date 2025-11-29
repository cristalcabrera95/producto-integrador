<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de Imágenes
 *
 * Gestiona imágenes asociadas a usuarios con control de permisos
 */
class ImageModel extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'user_id', 'original_name', 'file_name', 'file_path',
        'file_size', 'mime_type', 'width', 'height', 'category', 'description'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'uploaded_at';
    protected $updatedField = 'updated_at';

    private string $jsonFile;
    private string $uploadPath;
    private bool $useDatabase = false;

    public function __construct()
    {
        parent::__construct();
        $this->jsonFile = WRITEPATH . 'data/images.json';
        $this->uploadPath = FCPATH . 'uploads/images/';

        // Intentar usar base de datos
        try {
            $this->db->tableExists($this->table);
            $this->useDatabase = true;
        } catch (\Exception $e) {
            $this->useDatabase = false;
        }

        $this->initializeFile();
    }

    /**
     * Inicializa estructura de archivos
     */
    private function initializeFile(): void
    {
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        if (!file_exists($this->jsonFile)) {
            file_put_contents($this->jsonFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    /**
     * Obtiene imágenes del usuario actual
     */
    public function getUserImages(int $userId): array
    {
        if ($this->useDatabase) {
            return $this->where('user_id', $userId)
                ->orderBy('uploaded_at', 'DESC')
                ->findAll();
        }

        $images = $this->getAllImages();
        return array_filter($images, fn($img) => $img['user_id'] == $userId);
    }

    /**
     * Obtiene todas las imágenes (solo para admin)
     */
    public function getAllImages(): array
    {
        if ($this->useDatabase) {
            return $this->orderBy('uploaded_at', 'DESC')->findAll();
        }

        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $content = file_get_contents($this->jsonFile);
        return json_decode($content, true) ?? [];
    }

    /**
     * Obtiene imágenes por categoría del usuario
     */
    public function getImagesByCategory(int $userId, string $category): array
    {
        if ($this->useDatabase) {
            return $this->where('user_id', $userId)
                ->where('category', $category)
                ->orderBy('uploaded_at', 'DESC')
                ->findAll();
        }

        $images = $this->getUserImages($userId);
        return array_filter($images, fn($img) => $img['category'] === $category);
    }

    /**
     * Obtiene una imagen por ID
     */
    public function getImageById(int $id): ?array
    {
        if ($this->useDatabase) {
            return $this->find($id);
        }

        $images = $this->getAllImages();
        foreach ($images as $image) {
            if ($image['id'] == $id) {
                return $image;
            }
        }
        return null;
    }

    /**
     * Verifica si el usuario tiene permiso sobre la imagen
     */
    public function userHasPermission(int $imageId, int $userId, bool $isAdmin = false): bool
    {
        $image = $this->getImageById($imageId);

        if (!$image) {
            return false;
        }

        // Admin tiene permiso sobre todo
        if ($isAdmin) {
            return true;
        }

        // Usuario solo tiene permiso sobre sus propias imágenes
        return $image['user_id'] == $userId;
    }

    /**
     * Guarda una nueva imagen
     */
    public function saveImage(array $fileData, int $userId, string $category = 'general', string $description = ''): array|false
    {
        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($fileData['type'], $allowedTypes)) {
            return false;
        }

        // Validar tamaño (máx 10MB)
        if ($fileData['size'] > 10 * 1024 * 1024) {
            return false;
        }

        $images = $this->getAllImages();
        $newId = empty($images) ? 1 : max(array_column($images, 'id')) + 1;

        // Generar nombre único
        $extension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $newFileName = 'img_' . $userId . '_' . $newId . '_' . time() . '.' . $extension;
        $filePath = $this->uploadPath . $newFileName;

        // Mover archivo
        if (!move_uploaded_file($fileData['tmp_name'], $filePath)) {
            return false;
        }

        // Obtener dimensiones
        list($width, $height) = getimagesize($filePath);

        $newImage = [
            'id' => $newId,
            'user_id' => $userId,
            'original_name' => $fileData['name'],
            'file_name' => $newFileName,
            'file_path' => 'uploads/images/' . $newFileName,
            'file_size' => $fileData['size'],
            'mime_type' => $fileData['type'],
            'width' => $width,
            'height' => $height,
            'category' => $category,
            'description' => $description,
            'uploaded_at' => date('Y-m-d H:i:s')
        ];

        if ($this->useDatabase) {
            $this->insert($newImage);
            return $newImage;
        }

        $images[] = $newImage;

        if (file_put_contents($this->jsonFile, json_encode($images, JSON_PRETTY_PRINT)) !== false) {
            return $newImage;
        }

        unlink($filePath);
        return false;
    }

    /**
     * Elimina una imagen
     */
    public function deleteImage(int $id, int $userId, bool $isAdmin = false): bool
    {
        // Verificar permisos
        if (!$this->userHasPermission($id, $userId, $isAdmin)) {
            return false;
        }

        $image = $this->getImageById($id);
        if (!$image) {
            return false;
        }

        // Eliminar archivo físico
        $filePath = FCPATH . $image['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($this->useDatabase) {
            return $this->delete($id);
        }

        $images = $this->getAllImages();
        $newImages = array_filter($images, fn($img) => $img['id'] != $id);

        return file_put_contents($this->jsonFile, json_encode(array_values($newImages), JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Actualiza metadatos de imagen
     */
    public function updateImageMetadata(int $id, int $userId, array $data, bool $isAdmin = false): bool
    {
        if (!$this->userHasPermission($id, $userId, $isAdmin)) {
            return false;
        }

        $allowedFields = ['category', 'description'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if ($this->useDatabase) {
            return $this->update($id, $updateData);
        }

        $images = $this->getAllImages();
        $updated = false;

        foreach ($images as $key => $image) {
            if ($image['id'] == $id) {
                $images[$key] = array_merge($image, $updateData);
                $images[$key]['updated_at'] = date('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            return file_put_contents($this->jsonFile, json_encode($images, JSON_PRETTY_PRINT)) !== false;
        }

        return false;
    }

    /**
     * Obtiene categorías del usuario
     */
    public function getUserCategories(int $userId): array
    {
        $images = $this->getUserImages($userId);
        $categories = array_unique(array_column($images, 'category'));
        return array_values($categories);
    }

    /**
     * Obtiene estadísticas de imágenes del usuario
     */
    public function getUserImageStats(int $userId): array
    {
        $images = $this->getUserImages($userId);

        return [
            'total' => count($images),
            'total_size' => array_sum(array_column($images, 'file_size')),
            'categories' => count($this->getUserCategories($userId)),
            'recent' => array_slice($images, 0, 5)
        ];
    }

    /**
     * Obtiene estadísticas globales (solo admin)
     */
    public function getGlobalStats(): array
    {
        $images = $this->getAllImages();

        return [
            'total_images' => count($images),
            'total_size' => array_sum(array_column($images, 'file_size')),
            'total_users' => count(array_unique(array_column($images, 'user_id'))),
            'categories' => count(array_unique(array_column($images, 'category')))
        ];
    }
}
