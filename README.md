# EUD Youth

Sitio web y panel de administración de los Ministerios Juveniles de la División Intereuropea (EUD).
Reconstrucción del proyecto `ismaeloku7/sda` (Laravel 9 + Nova 3) sobre una base actual.

## Stack

| Componente | Versión |
|---|---|
| PHP | 8.3+ |
| Laravel | 13 |
| Filament (panel de administración, ruta `/admin`) | 5 |
| Livewire | 4 |
| Vite + Tailwind CSS | 8 / 4 |
| spatie/laravel-translatable (campos EN/ES en columnas JSON) | 6 |
| spatie/laravel-medialibrary | 11 |
| mcamara/laravel-localization (rutas públicas por idioma) | 2 |
| Base de datos | MySQL 8 en producción, SQLite en local y tests |

## Puesta en marcha local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite          # o configura MySQL en .env
php artisan migrate --seed
php artisan make:filament-user          # o define ADMIN_EMAIL / ADMIN_PASSWORD antes del seed
npm install && npm run dev
php artisan serve
```

Panel: `http://localhost:8000/admin`.

## Estructura

- `app/Models` — un modelo por tabla. Los campos traducibles se declaran en `$translatable` y se guardan como JSON `{"en": ..., "es": ...}`.
- `app/Filament/Resources` — cada pantalla del panel. Las relaciones se editan dentro de la ficha del registro, no en recursos separados.
- `database/migrations` — esquema consolidado (6 migraciones propias + las de Laravel y media library).
- `database/seeders` — catálogos base (idiomas, tipos de archivo, categorías de honores, ministerios). Sin contraseñas en el repositorio.
- `docs/MIGRACION.md` — correspondencia entre el esquema antiguo y el nuevo, y plan por fases.

## Comandos útiles

```bash
php artisan test            # suite de tests (SQLite en memoria)
vendor/bin/pint             # formato de código
php artisan filament:assets # regenerar assets del panel tras actualizar Filament
```

## Fases del proyecto

1. **Base** (hecha): proyecto, esquema, modelos, panel con usuarios.
2. **Panel relacional** (hecho): recursos, honores, directores, países, oficinas y catálogos, con archivos y PDFs dentro de cada ficha.
3. Páginas por bloques y conversión de los módulos antiguos.
4. Eventos: ficha única con programa, talleres, ponentes, localizaciones, galería y descargas.
5. Frontend público (vistas Blade portadas y unificadas por ministerio).
6. Importación de datos y ficheros desde la base de datos antigua, pruebas y corte.
