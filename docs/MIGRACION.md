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

## Importación de datos (`php artisan legacy:import`)

Lee la base antigua por la conexión `legacy` (`DB_LEGACY_*` en `.env`) y escribe en la nueva conservando los ids. Pasos (`--only=a,b` para ejecutar solo algunos; `--steps` los lista):

| Paso | Qué copia |
|---|---|
| `users` | Editores con su contraseña actual. |
| `catalogues` | Idiomas, tipos de archivo y de director, categorías, clases, niveles, master awards, líneas. |
| `ministries` | Ministerios (posición = id antiguo). |
| `countries` | Países; el enlace a la unión se resuelve en una segunda pasada. |
| `directory` | Directores y oficinas (se omite la fila si falta el país o el ministerio). |
| `resources` | Recursos, pivotes, archivos. `destacado` pasa a `featured`. |
| `honors` | Honores y PDFs; nivel, clase y master award inexistentes pasan a null. |
| `events` | Eventos y todo su árbol, más las filas de `media`. |
| `pages` | Módulos → secciones según `app/Legacy/ModuleMap.php`; atributo `amicus` → página AMiCUS. |

Rutas de archivos: lo que estaba en `public/images` o `public/video` pasa a `storage/app/public/legacy/...`; lo que estaba en `storage/app/public` conserva su ruta. Con `--files=/ruta/al/sitio/antiguo` (o `LEGACY_FILES_PATH`) los ficheros se copian; sin ella solo se reescriben las rutas y el resumen final lista lo que falta.

## Imágenes de diseño que no van en git

Las vistas referencian 153 imágenes de `public/images`; 133 (9 MB) están en el repositorio. Estas 20 superan 600 KB y hay que copiarlas del sitio antiguo al desplegar (`rsync -a antiguo/public/images/ nuevo/public/images/` añade las que falten sin tocar las demás):

```
video/CABECERA-WEB-Viralgen-WHAT WE DO.mp4
video/CABECERA-WEB-Viralgen-WHAT WE DO.webm
images/IG.jpg
images/ministries/yung/SYL18-Final-HIGHres.pdf
images/ministries/maps/symbols/1.png
images/ministries/maps/symbols/2.png
images/ministries/insignias/squirrels/1.png
images/ministries/insignias/patchfinder/excursionista.png
images/ministries/insignias/patchfinder/rastreador.png
images/resources/adventures/a2.jpg
images/resources/manuals/Busy-Bee-banner.png
images/resources/manuals/Sunbeam-banner.png
images/resources/manuals/Helping-Hands-banner.png
images/resources/manuals/Little-Lamb-banner.png
images/resources/manuals/Builder-banner.png
images/resources/manuals/Early-Bird-banner.png
images/event_2_v2.webp
images/jed-villejo-bEcC0nyIp2g-unsplash.png
images/shared_room.png
images/priscilla-du-preez-nF8xhLMmg0c-unsplash.png
```
