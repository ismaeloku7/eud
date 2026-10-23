# Migración desde `sda` (Laravel 9 + Nova 3)

## Decisiones

- Se mantienen los nombres de tabla y columna del esquema antiguo siempre que ha sido posible, para que la importación de datos sea 1:1.
- Las columnas traducibles pasan de `text` a `json`. El contenido ya era JSON generado por spatie/laravel-translatable, así que el valor se copia tal cual.
- Se relaja `NOT NULL` en columnas descriptivas (subtítulos, descripciones, redes sociales). Ningún dato antiguo se pierde por ello.
- Claves foráneas con `cascadeOnDelete` donde el hijo no tiene sentido sin el padre y `nullOnDelete` en catálogos opcionales (nivel, clase, master award, tipo de director, línea).

## Tablas que desaparecen

| Tabla antigua | Qué pasa con ella |
|---|---|
| `teams`, `team_user`, `team_invitations` | Jetstream. No se usaban. |
| `personal_access_tokens` | Sanctum. No había API consumida. |
| `password_resets`, `failed_jobs` | Sustituidas por las tablas estándar de Laravel 13. |
| `modules` | Su contenido se convierte en bloques dentro de `pages.blocks` (fase 3). |
| `attributes` | Contenía la página Amicus como un único JSON. Se convierte en una página de bloques (fase 3). |
| `users.current_team_id`, `profile_photo_path`, `two_factor_*` | Eliminadas. |

## Cambios de nombre

| Antiguo | Nuevo | Motivo |
|---|---|---|
| `resources.destacado` | `resources.featured` | Esquema en inglés. |
| `events.downloads` (columna) | eliminada | Las descargas viven en la tabla `downloads` y en la colección `downloads` de media library. |
| `files.size` (varchar) | `files.size` (entero, bytes) | Permite ordenar y formatear. |
| `pdf_honors.size` (varchar) | entero | Ídem. |
| `countries.image` NOT NULL con default | nullable | La imagen por defecto se resuelve en la vista. |
| `honors.image_secondary` default `/images/Romans-2.png` | nullable | Ídem. |

## Columnas nuevas

| Tabla | Columna | Uso |
|---|---|---|
| `languages` | `code` | Código ISO para enlazar con el idioma de la web. |
| `ministries` | `position` | Orden en menús, sustituye a los IDs fijos en código. |
| `category_honors` | `position` | Orden de categorías, sustituye a `FIELD(id, 10, 13, 11)`. |
| `project_resources` | `position` | Orden de los recursos dentro de una colección. |
| `galleries` | `position` | Orden de imágenes. |
| `pages` | `title`, `blocks`, `seo`, `published` | Páginas por bloques. |

## Correspondencia de modelos

| Antiguo | Nuevo |
|---|---|
| `ProjectResource` (modelo) | relación `Resource::items()` / `Resource::collections()` sobre la misma tabla |
| `RelatedResource` (modelo) | relación `Resource::related()` |
| `Honor::class_honor()` | `Honor::classHonor()` |
| `Honor::master_award()` | `Honor::masterAward()` |
| `Honor::pdf_honor()` | `Honor::pdfs()` |
| `Director::type_director()` | `Director::type()` |
| `File::type_file()` | `File::type()` |
| `Country::offices_generals()` | `Country::office()` |
| `Country::country()` | `Country::parent()` |
| `Page` + `Module` + `Attribute` | `Page` con `blocks` |

## Importación de datos (fase 6)

Un comando artisan leerá la base antigua por una segunda conexión (`DB_LEGACY_*`) y escribirá en la nueva:

1. Catálogos y ministerios (mismos IDs).
2. Países, directores, oficinas.
3. Recursos, pivotes, archivos.
4. Honores y PDFs.
5. Eventos y todo su árbol.
6. Módulos → bloques de página (requiere datos reales para fijar la correspondencia plantilla → bloque).
7. Atributo `amicus` → página de bloques.
8. Ficheros de `storage/app/public` y `public/images` referenciados por las filas anteriores.
