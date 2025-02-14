# 🍽️ Recetas API

API desarrollada en Laravel 11 para la gestión de recetas, como parte del proceso de aprendizaje en la empresa. Este proyecto utiliza datos generados con Faker y Seeder de Laravel para poblar la base de datos, además de integrar recetas obtenidas de una API pública. Se espera conectar con un proyecto de Angular como parte del proceso de aprendizaje en la empresa.

Este proyecto se desarrolló basándose en el curso de API REST con Laravel de Platzi y otros cursos adicionales que ayudaron a mejorarla. La API es uno de los proyectos finales de una ruta de aprendizaje propuesta por el líder de desarrollos específicos.

## 🚀 Características
- CRUD de recetas con autenticación mediante tokens (Laravel Sanctum).
- Consumo de una API pública de recetas mediante Guzzle.
- Uso de Laravel Telescope para monitoreo.
- Datos estructurados en versiones de API.
- Base de datos MySQL administrada con phpMyAdmin.
- Cuenta con un usuario creado por defecto para facilitar el uso de la API.

## 📌 Tecnologías utilizadas
- **Framework**: Laravel 11
- **Base de datos**: MySQL (phpMyAdmin en desarrollo)
- **Autenticación**: Laravel Sanctum
- **Cliente HTTP**: Guzzle
- **Monitoreo**: Laravel Telescope

## 📦 Instalación

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/tuusuario/nombre-del-repositorio.git
cd nombre-del-repositorio
```

### 2️⃣ Instalar dependencias
```bash
composer install
```

### 3️⃣ Configurar variables de entorno
Copiar el archivo de entorno y configurarlo según tu entorno:
```bash
cp .env.example .env
php artisan key:generate
```

Configura en el archivo `.env` las credenciales de base de datos y de la API pública si es necesario.

### 4️⃣ Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

> **Nota:** Se genera un usuario por defecto con las siguientes credenciales:
> - **Email:** i@admin.com
> - **Contraseña:** password
> - Las contraseñas están cifradas de manera segura con Hash::make.

### 5️⃣ Iniciar el servidor de desarrollo
```bash
php artisan serve
```

## 🛠️ Uso de la API

### 📌 Autenticación
La API requiere autenticación mediante tokens. Para obtener un token, usa el siguiente endpoint:

```http
POST /api/login
```

**Ejemplo de respuesta:**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

Incluye el token en cada solicitud protegida con el encabezado:
```http
Authorization: Bearer {token}
```

### 📌 Endpoints principales

#### 🔹 Versión 1 (CRUD de recetas, categorías y etiquetas)
```http
GET /api/v1/categories
GET /api/v1/categories/{category}
GET /api/v1/tags
GET /api/v1/tags/{tag}
```
CRUD completo de recetas:
```http
GET /api/v1/recipes
POST /api/v1/recipes
GET /api/v1/recipes/{id}
PUT /api/v1/recipes/{id}
DELETE /api/v1/recipes/{id}
```

#### 🔹 Versión 2 (Lista de recetas de usuario)
```http
GET /api/v2/recipes
```

Ejemplo de respuesta:
```json
{
  "data": [
    {
      "id": 116,
      "type": "recipe",
      "attributes": {
        "category": "Postre",
        "author": "Juan Pérez",
        "title": "Tarta de Chocolate",
        "description": "Deliciosa tarta de chocolate casera.",
        "ingredients": "Harina, azúcar, huevos, chocolate...",
        "instructions": "Mezclar ingredientes, hornear a 180°C por 30 min...",
        "image": "recipes/tarta_chocolate.jpg",
        "tags": "Dulce, Chocolate"
      }
    }
  ]
}
```

#### 🔹 Versión 3 (Consumo de API pública de recetas)
```http
GET /api/v3/recipes/dynamic_list
GET /api/v3/recipes
GET /api/v3/recipes/categories
GET /api/v3/recipes/areas
GET /api/v3/recipes/ingredients
```

## 🌐 Consumo de API externa
La API pública de recetas se consume a través de un controlador específico. Los datos obtenidos no se combinan con los datos internos, sino que se entregan tal cual como se reciben. Los endpoints disponibles de la API pública son:

**Listar categorías, áreas e ingredientes:**
- `GET https://www.themealdb.com/api/json/v1/1/list.php?c=list`
- `GET https://www.themealdb.com/api/json/v1/1/list.php?a=list`
- `GET https://www.themealdb.com/api/json/v1/1/list.php?i=list`

**Filtrar por ingrediente, categoría o área:**
- `GET https://www.themealdb.com/api/json/v1/1/filter.php?i=chicken_breast`
- `GET https://www.themealdb.com/api/json/v1/1/filter.php?c=Seafood`
- `GET https://www.themealdb.com/api/json/v1/1/filter.php?a=Canadian`

**Otros endpoints:**
- `GET https://www.themealdb.com/api/json/v1/1/categories.php`
- `GET https://www.themealdb.com/api/json/v1/1/search.php?s=Arrabiata`
- `GET https://www.themealdb.com/api/json/v1/1/search.php?f=a`
- `GET https://www.themealdb.com/api/json/v1/1/lookup.php?i=52772`
- `GET https://www.themealdb.com/api/json/v1/1/random.php`

## 🔥 Próximas mejoras
- Implementación de filtros avanzados para recetas.
- Posibilidad de subir imágenes personalizadas.
- Mejoras en la documentación con Swagger.

## 📝 Licencia
Este proyecto está bajo la Licencia MIT.

## 📞 Contacto
- **Desarrollador:** Daniel Arias
- **Correo:** danielsam707@gmail.com

