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
3. **Páginas** (hecho): plantillas con secciones y campos etiquetados, editor en una sola pantalla con EN/ES lado a lado.
4. **Eventos** (hecho): ficha única con programa, talleres, ponentes, salas, galería y descargas.
5. **Sitio público** (hecho): vistas portadas del sitio anterior sobre Tailwind 4 y Livewire 4, lógica unificada por ministerio.
6. **Importación** (hecho): comando `legacy:import` que copia la base de datos y los ficheros del sitio anterior.

## Importar el sitio anterior

1. Rellena `DB_LEGACY_*` en `.env` con la base de datos antigua (solo lectura) y, si está en el mismo servidor, `LEGACY_FILES_PATH` con la carpeta raíz del proyecto antiguo (la que contiene `public/` y `storage/`).
2. `php artisan migrate --force` y `php artisan db:seed --force` (catálogos, ministerios y páginas vacías).
3. `php artisan legacy:import --fresh` copia tablas, reescribe rutas de archivos y convierte los módulos antiguos en secciones de página. Se puede repetir: conserva los ids y actualiza en lugar de duplicar.
4. Copia a `public/images` las imágenes de diseño grandes que no van en git (lista en `docs/MIGRACION.md`).
5. Entra en `/admin`, revisa Páginas → Ajustes del sitio, Inicio y cada ministerio, y publica.

Para probar sin la base de datos real, `tests/Fixtures/legacy/` contiene el esquema antiguo y el contenido inicial de las páginas.
