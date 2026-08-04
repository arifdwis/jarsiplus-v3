# Panel Admin — Standardization & Audit

## Layout

| File | Description |
|------|-------------|
| `resources/views/layouts/app.blade.php` | Main admin shell — HS Space (BS5) via CDN + Tom Select |
| `resources/views/layouts/blank.blade.php` | Minimal shell — HS Space v2 + CDN (already synced) |
| `resources/views/layouts/breadcrumb.blade.php` | Breadcrumb partial |
| `resources/views/layouts/datatable/header.blade.php` | Datatable toolbar & title |
| `resources/views/layouts/datatable/footer.blade.php` | Pagination & entries |
| `resources/views/layouts/empty.blade.php` | Empty state |
| `packages/nue/resources/views/partials/breadcrumb.blade.php` | Alias breadcrumb (identical output) |
| `packages/nue/resources/views/partials/datatable/script.blade.php` | JS datatable config |

## Admin Views (53 total)

All extend `layouts.app`. All use `solar:*` iconify icons. No `bi-*`, `fa-*`, or `font-icon-*` remaining.

| View | Path | Pattern |
|------|------|---------|
| **Core** (18) | `PermohonanFile/*` | index + create/edit + show |
| | `Pembahasan/*` | index + create/edit |
| | `Validasi/*` | index + form |
| | `Laman/*` | index + form |
| | `Slider/*` | index + form |
| | `Penjadwalan/*` | index + form |
| | `LogPermohonan/*` | index |
| | `Persetujuan/*` | form |
| | `File/*` | form |
| **Formulir** (19) | `Permohonan/*` | index + show + form |
| | `Kategori/*` | index + form |
| | `Kategori/Urusan/*` | index + form |
| | `Indikator/*` | index + form |
| | `Indikator/Parameter/*` | index + form |
| | `Penilaian/*` | index + form |
| | `Arsip/*` | index + show |
| | `BuktiDukung/*` | index |
| | `File/*` | form |
| | `Beimbai/*` | index + form |
| **Pemohon** (6) | `Pemohon/*` | index + show + create/edit + form |
| **Wilayah** (4) | `Provinsi/*` | index + form |
| | `Kota/*` | index + form |
| **Faq** (3) | `Faq/*` | index + form |
| **Template** (3) | `Role/*` | tksd + pemohon + null |

## Card Patterns

| Section | Pattern | Count |
|---------|---------|-------|
| Index (datatable) | `card card-bordered shadow-none rounded-0` | 16 |
| Create/Edit | `card rounded-0 shadow-0 border-top-0` + `card-header rounded-0 bg-white p-2` | all form views |
| Show/Detail | `card card-bordered rounded-1 mb-3` | Core/PermohonanFile/show |

## Breadcrumb (minor inconsistency — 21 vs 20)

| Source | Count |
|--------|-------|
| `layouts.breadcrumb` | 21 |
| `nue::partials.breadcrumb` | 20 |

Both render identically. Mixed usage is cosmetic, not functional.

## Forms — Uniform

All form views follow:
- `card-body bg-light pb-10` with `min-height:calc(100vh - 163px)`
- Labels: `col-sm-2` / `col-sm-3 col-form-label`
- Inputs: `col-sm-9` / `col-sm-8`
- Bottom bar: `position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3`
- Buttons: `btn btn-primary` (save), `btn btn-ghost-light` (back/reset)
- Select: `class="js-select form-select" data-nue-tom-select-options`
- File input: `class="js-file-attachment form-control"`
- Checkbox: `class="form-check-input"`
- Textarea (tinymce): `class="tinymce"` via `core::layouts.components.tinymce`

## Empty State

- Merged to single `layouts.empty` (deleted duplicate `nue::partials.empty` + Core empties)
- All index views now include `@include('layouts.empty')` when datatable is empty

## Deleted Dead Code

### Module Hello World pages (nwidart scaffold — route-less)
- `Modules/Core/Resources/views/index.blade.php`
- `Modules/Faq/Resources/views/index.blade.php`
- `Modules/Formulir/Resources/views/index.blade.php`
- `Modules/Pemohon/Resources/views/index.blade.php`
- `Modules/Wilayah/Resources/views/index.blade.php`

### Module bare master layouts (orphaned after migration to `layouts.app`)
- `Modules/Core/Resources/views/layouts/master.blade.php`
- `Modules/Faq/Resources/views/layouts/master.blade.php`
- `Modules/Formulir/Resources/views/layouts/master.blade.php`
- `Modules/Pemohon/Resources/views/layouts/master.blade.php`
- `Modules/Wilayah/Resources/views/layouts/master.blade.php`
- `Modules/Core/Resources/views/layouts/partials/` (empty dir + analytics/)
- `Modules/Faq/Resources/views/layouts/` (empty dir)
- `Modules/Formulir/Resources/views/layouts/` (empty dir)
- `Modules/Pemohon/Resources/views/layouts/` (empty dir)
- `Modules/Wilayah/Resources/views/layouts/` (empty dir)

### Old Enterwind E-Panel (Core module, superseded by Nue)
- `Modules/Core/Resources/views/layouts/master.blade.php`
- `Modules/Core/Resources/views/layouts/header.blade.php`
- `Modules/Core/Resources/views/layouts/footer.blade.php`
- `Modules/Core/Resources/views/layouts/header-menu.blade.php`
- `Modules/Core/Resources/views/layouts/partials/sidebar.blade.php`

### Duplicate empty states
- `nue::partials.empty` (replaced by `layouts.empty`)
- Various `empti`/`empties`/`empty` orphan files

### Icons — Legacy Cleanup
- All `bi-*` → `solar:*` iconify across 33+ views + 2 partial templates
- No `data-toggle`, `font-icon-*`, `fa-*`, `href="#"` remaining

### Datatable Header/Footer Standardization
- `nue::partials.datatable.header/footer` → `layouts.datatable.header/footer` (Core/LogPermohonan)
- Nue vendor copy still exists but no Module view references it

## Preserved (Active)
- `Modules/Template/Resources/views/index.blade.php` — public homepage (Cobalt design)
- `Modules/Template/Resources/views/layouts/master.blade.php` — frontend layout (Cobalt)
- `Modules/Core/Resources/views/layouts/components/tinymce.blade.php` — used by laman form

## Summary

| Category | Before | After |
|----------|--------|-------|
| Unique layouts | 5 (app + 4 module masters) | 2 (app + template frontend) |
| Icon libraries | bi-* + iconify | iconify (solar:* only) |
| Empty state templates | 4 | 1 |
| Dead files | 15+ | 0 |
| bi-* references | 33+ views | 0 |
