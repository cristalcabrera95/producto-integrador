# Sistema de Gestión con Galería Personal

Sistema rediseñado con arquitectura MVC (CodeIgniter 4), Producto integrador Rosa Cristal Cabrera flores.

## ✨ Funcionalidades Principales

### Sistema de Roles
1. **Usuario Regular**
    - Galería personal de imágenes
    - Subir/eliminar sus propias imágenes
    - Organizar por categorías
    - Editar su propio perfil

2. **Administrador**
    - Todas las funciones de usuario
    - Gestionar todos los usuarios (crear/editar/eliminar)
    - Ver y eliminar cualquier imagen
    - Estadísticas globales del sistema
    - Panel de administración avanzado

### Galería de Imágenes
- Subida de imágenes (JPG, PNG, GIF, WEBP)
- Tamaño máximo: 10MB
- Categorización personalizada
- Descripciones opcionales
- Visualización en cuadrícula responsive
- Filtrado por categoría

## 📁 Estructura del Proyecto

```
proyecto-rediseno/
├── app/
│   ├── Controllers/
│   │   ├── Home.php          # Dashboard y página principal
│   │   ├── User.php          # Gestión de usuarios y autenticación
│   │   └── Image.php         # Gestión de galería de imágenes
│   ├── Models/
│   │   ├── UserModel.php     # Modelo de usuarios con roles
│   │   └── ImageModel.php    # Modelo de imágenes con permisos
│   └── Views/
│       ├── layouts/
│       │   ├── header.php    # Header con navegación
│       │   └── footer.php    # Footer minimalista
│       ├── home.php          # Página de login
│       ├── dashboard.php     # Dashboard principal
│       ├── users/            # Vistas de gestión de usuarios
│       └── images/           # Vistas de galería
├── public/
│   ├── css/
│   │   └── main.css          # Estilos principales
│   ├── js/
│   │   └── main.js           # JavaScript para interacciones
│   └── uploads/
│       └── images/           # Directorio de imágenes subidas
├── database/
│   └── migrations/           # Scripts SQL de base de datos
└── writable/
    └── data/                 # Almacenamiento JSON (fallback)
        ├── users.json
        └── images.json
```

## 🚀 Instalación

### Requisitos
- PHP 8.0 o superior
- CodeIgniter 4.x
- MySQL 5.7+ o MariaDB 10.2+ (opcional, usa JSON como fallback)
- Composer

### Pasos de Instalación

1. **Abre la terminal en la carpeta**
   ```bash
   # Corre los siguientes comandos
   docker compose build --no-cache
   
   docker compose up -d
   ```

2. **Configurar la base de datos (opcional)**

   Si deseas usar MySQL/MariaDB en lugar de archivos JSON:

   a. Edita `app/Config/Database.php`:
   ```php
   'hostname' => 'localhost',
   'username' => 'tu_usuario',
   'password' => 'tu_password',
   'database' => 'nombre_base_datos',
   ```

   b. Ejecuta las migraciones:
   ```bash
   # Crear la base de datos
   mysql -u root -p -e "CREATE DATABASE nombre_base_datos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   
   # Importar las tablas
   mysql -u usuario -p nombre_base_datos < database/migrations/001_create_users_table.sql
   mysql -u usuario -p nombre_base_datos < database/migrations/002_create_images_table.sql
   ```

3. **Configurar permisos de escritura**
   ```bash
   chmod -R 777 writable/
   chmod -R 777 public/uploads/
   ```
4. **Acceder al sistema**

   Abre tu navegador en: `http://localhost:8080`

## 👤 Usuarios de Prueba

### Administrador
- **Usuario**: `admin`
- **Contraseña**: `12345`
- **Permisos**: Acceso completo al sistema

### Usuario Regular
- **Usuario**: `user`
- **Contraseña**: `abcde`
- **Permisos**: Galería personal solamente


## 🎯 Casos de Uso

### Usuario Regular
1. Inicia sesión con sus credenciales
2. Ve su dashboard con estadísticas personales
3. Accede a "Mi Galería"
4. Sube imágenes con categorías
5. Organiza y visualiza sus imágenes
6. Puede editar su perfil

### Administrador
1. Inicia sesión con credenciales admin
2. Dashboard con estadísticas globales
3. Gestiona usuarios:
    - Crear nuevos usuarios
    - Editar información
    - Asignar roles
    - Eliminar cuentas
4. Panel de administración de imágenes:
    - Ver todas las imágenes del sistema
    - Eliminar contenido inapropiado
    - Estadísticas de uso
