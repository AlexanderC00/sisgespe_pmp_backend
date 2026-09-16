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
git clone https://github.com/AlexanderC00/sisgespe_pmp_backend.git
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

### 6. Ejecutar Migraciones y Seeders Iniciales
Crea las tablas en la base de datos y puebla los datos iniciales de prueba (Usuarios Administrador/Cliente, Producto Chocho e Inventario inicial):

```bash
php artisan migrate --seed
```

### 7. Iniciar el Servidor Local
Levanta el servidor local de desarrollo de Laravel:

```bash
php artisan serve
```

La API estará accesible en `http://127.0.0.1:8000`.

---

## 🌐 Endpoints de la API y Seguridad (RBAC & Sanctum)

Todas las rutas excepto el registro e inicio de sesión requieren Token Bearer (`auth:sanctum`). Además, las operaciones de modificación del catálogo e inventario están protegidas con el middleware de rol `admin`.

### 👤 Módulo `user` (`/api/user`)
- `POST /api/user/register`: Registro público de usuarios (`name`, `email`, `password`, `rol`).
- `POST /api/user/login`: Autenticación pública. Retorna el token Sanctum `Bearer`.
- `POST /api/user/logout` *(Sanctum)*: Cierre de sesión y revocación del token.

### 🥦 Módulo `producto` (`/api/producto`)
- `GET /api/producto` *(Sanctum)*: Catálogo de productos con su stock disponible.
- `POST /api/producto` *(Sanctum + Admin)*: Crear nuevo producto en catálogo.
- `DELETE /api/producto/{id}` *(Sanctum + Admin)*: Eliminar producto. **Regla de negocio:** Se bloquea si tiene stock activo (>0) o pedidos asociados.

### 📦 Módulo `inventario` (`/api/inventario`)
- `GET /api/inventario` *(Sanctum + Admin)*: Consulta de existencias por producto.
- `PUT /api/inventario/{id}` *(Sanctum + Admin)*: Actualizar stock (`cantidad_disponible`) y fecha de ingreso.

### 🛒 Módulo `pedido` (`/api/pedido`)
- `POST /api/pedido` *(Sanctum)*: Crear pedido. Valida y descuenta automáticamente el stock.
- `GET /api/pedido` *(Sanctum)*: Aislamiento por usuario (los clientes solo ven sus propios pedidos; administradores ven todos).
- `DELETE /api/pedido/{id}` *(Sanctum)*: Eliminar/cancelar pedido propio y restaurar stock.

---

## 🎯 Alcance del MVP y Justificación Académica

Este MVP inicial se diseñó enfocado en demostrar el dominio de los pilares fundamentales de **Laravel 12**:

1. **Seguridad y Control de Acceso Basado en Roles (RBAC):** Middleware personalizado `EnsureIsAdmin` combinado con Sanctum Tokens y aislamiento de visibilidad de datos.
2. **Integridad de Datos y Transacciones Atómicas:** Operaciones relacionales en bloque (`DB::transaction`), restricciones `ON DELETE` e inmutabilidad de precios históricos.
3. **Arquitectura Limpia:** Separación de responsabilidades con **Form Requests** para validación, **API Resources** para formateo de respuestas JSON y **Controladores** limpios.

---

## 📚 Documentación Técnica

- 🗄️ [**Documentación de la Base de Datos (Modelos, ERD y Tablas)**](docs/database/README.md): Detalla la estructura del modelo entidad-relación, restricciones y relaciones Eloquent.
