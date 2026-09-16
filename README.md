# Sistema de Gestión y Pedidos de Productos Mínimamente Procesados (Backend)

Este repositorio contiene la API backend desarrollada en **Laravel 12** para el **Sistema de Gestión y Pedidos de Productos Mínimamente Procesados (SISGESPE PMP)**.

---

## 📌 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu equipo lo siguiente:

- **PHP** >= 8.2
- **Composer** (gestor de dependencias de PHP)
- **Node.js** & **NPM** (para gestión de assets/herramientas)
- **Git**
- Servidor de Base de Datos (MySQL, PostgreSQL o SQLite)

---

## 🚀 Guía de Instalación y Configuración

Sigue estos pasos detallados para clonar la aplicación y poner a funcionar el backend localmente:

### 1. Clonar el Repositorio
Abre tu terminal y ejecuta el comando para clonar este proyecto:

```bash
git clone <URL_DEL_REPOSITORIO>
cd sisgespe_pmp_backend
```

### 2. Instalar Dependencias de PHP
Ejecuta Composer para descargar todos los paquetes y dependencias del framework:

```bash
composer install
```

### 3. Instalar Dependencias de JavaScript
Instala las dependencias necesarias de Node:

```bash
npm install
```

### 4. Configurar el Archivo de Entorno (`.env`)
Crea una copia del archivo de configuración `.env.example` y renómbralo a `.env`:

- **En Linux / macOS / Git Bash:**
  ```bash
  cp .env.example .env
  ```
- **En Windows (CMD / PowerShell):**
  ```powershell
  copy .env.example .env
  ```

Abre el archivo `.env` en tu editor de código y configura las credenciales de tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Generar la Clave de la Aplicación (`APP_KEY`)
Genera la clave de encriptación única de Laravel:

```bash
php artisan key:generate
```

### 6. Ejecutar Migraciones de la Base de Datos
Crea las tablas en la base de datos que configuraste:

```bash
php artisan migrate
```

*(Si se incluyen datos de prueba iniciales, puedes ejecutar también):*
```bash
php artisan db:seed
```

### 7. Iniciar el Servidor Local
Levanta el servidor local de desarrollo de Laravel:

```bash
php artisan serve
```

La aplicación estará accesible por defecto en `http://127.0.0.1:8000`.

---

## 📝 Estado del Proyecto
> ℹ️ **Nota:** Este proyecto se encuentra en etapa inicial de desarrollo. La documentación de la API y las instrucciones de configuración se irán actualizando a medida que se añadan nuevos módulos y funcionalidades.

