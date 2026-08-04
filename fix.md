# Hallmark (Cobalt) Fix List — JARSIPLUS 2026

## Legend

- `🔴 CRITICAL` → Still uses MobileKit klasik (`form-group boxed`, `form-control`, `btn btn-primary`). Layout probably broken.
- `🟡 MIXED` → Mostly Cobalt but has old pattern remnants (`text-muted`, `c-ink`, `ion-icon`, `jp-card__title`, `jp-card__text`).
- `🟢 COMPLIANT` → Cobalt clean.

---

## Batch 1: 🔴 CRITICAL — MobileKit Klasik (8 files)

Still uses `form-group boxed`, `form-control`, `btn btn-primary` — must be rewritten to `jp-field`, `jp-input`, `jp-btn--accent`.

| # | File | Old Patterns |
|---|---|---|
| 1 | `Modules/Template/Resources/views/permohonan/indikator/modal.blade.php` | `form-group basic`, `btn btn-primary btn-block btn-lg`, `form-control` |
| 2 | `Modules/Template/Resources/views/permohonan/indikator/file/create.blade.php` | `form-group`, `btn btn-primary btn-block` |
| 3 | `Modules/Template/Resources/views/permohonan/indikator/file/index.blade.php` | `btn btn-text-secondary`, `text-muted` |
| 4 | `Modules/Template/Resources/views/permohonan/indikator/file/form.blade.php` | `form-group boxed`, `form-control`, `text-muted` |
| 5 | `Modules/Template/Resources/views/permohonan/pembahasan/modal/validasi.blade.php` | `form-group boxed`, `form-control`, `btn btn-primary btn-block` |
| 6 | `Modules/Template/Resources/views/permohonan/pembahasan/modal/perbaikan.blade.php` | `form-group boxed`, `form-control`, `btn btn-primary btn-block` |
| 7 | `Modules/Template/Resources/views/settings/index.blade.php` | `jp-btn--secondary`, `text-muted`, `jp-text-sm` |
| 8 | `Modules/Template/Resources/views/settings/profile/password.blade.php` | `text-muted` |

**Fix:** Replace `form-group boxed` → `jp-field`, `form-control` → `jp-input`, `btn btn-primary` → `jp-btn jp-btn--accent`, `<label class="label">` → `<label class="jp-label">`.

---

## Batch 2: 🟡 Icon Migration — ion-icon / iconify → SVG sprite (16 files)

Replace `<ion-icon name="...">` and `<iconify-icon icon="...">` with `<svg><use href="{{ asset('img/icons/sprite.svg#icon-...') }}"></use></svg>`.

| # | File | Old Icon |
|---|---|---|
| 1 | `components/icon.blade.php` | `iconify-icon` |
| 2 | `components/accordion-item.blade.php` | `ion-icon` |
| 3 | `layouts/master.blade.php` | `iconify` (CDN script) |
| 4 | `roles/pemohon.blade.php` | `ion-icon` |
| 5 | `roles/tksd.blade.php` | `ion-icon` |
| 6 | `permohonan/show.blade.php` | `ion-icon` |
| 7 | `permohonan/detail.blade.php` | `ion-icon` |
| 8 | `permohonan/index.blade.php` | `ion-icon` |
| 9 | `permohonan/riwayat.blade.php` | `ion-icon` |
| 10 | `permohonan/finish.blade.php` | `ion-icon` |
| 11 | `permohonan/indikator/index.blade.php` | `ion-icon` |
| 12 | `permohonan/indikator/file/index.blade.php` | `ion-icon` |
| 13 | `permohonan/pembahasan/chat.blade.php` | `ion-icon` |
| 14 | `permohonan/pembahasan/index.blade.php` | `ion-icon` |
| 15 | `permohonan/penjadwalan/index.blade.php` | `ion-icon` |
| 16 | `kecamatan/show.blade.php` | `ion-icon` |

**Fix:** `ion-icon name="add"` → `<svg width="20" height="20"><use href="{{ asset('img/icons/sprite.svg#icon-add') }}"></use></svg>`. Remove @iconify/ionicons CDN from master.blade.php.

---

## Batch 3: 🟡 CSS Variable Rename — c-ink → c-text (28 files)

Replace `var(--c-ink)` → `var(--c-text)` and `var(--c-ink-subtle)` → `var(--c-text-muted)`.

| # | File | Occurrences |
|---|---|---|
| 1 | `index.blade.php` | 2 |
| 2 | `statistik/index.blade.php` | 4 |
| 3 | `informasi.blade.php` | 2 |
| 4 | `faq/index.blade.php` | 2 |
| 5 | `auth/login.blade.php` | 1 |
| 6 | `maintenance.blade.php` | 1 |
| 7 | `layouts/master.blade.php` | 1 |
| 8 | `roles/null.blade.php` | 1 |
| 9 | `roles/pemohon.blade.php` | 1 |
| 10 | `roles/tksd.blade.php` | 1 |
| 11 | `permohonan/index.blade.php` | 2 |
| 12 | `permohonan/show.blade.php` | 2 |
| 13 | `permohonan/detail.blade.php` | 2 |
| 14 | `permohonan/create.blade.php` | 2 |
| 15 | `permohonan/riwayat.blade.php` | 2 |
| 16 | `permohonan/finish.blade.php` | 2 |
| 17 | `permohonan/indikator/index.blade.php` | 2 |
| 18 | `permohonan/indikator/file/create.blade.php` | 2 |
| 19 | `permohonan/indikator/file/index.blade.php` | 2 |
| 20 | `permohonan/pembahasan/chat.blade.php` | 2 |
| 21 | `permohonan/pembahasan/index.blade.php` | 2 |
| 22 | `permohonan/penjadwalan/index.blade.php` | 2 |
| 23 | `partials/juri-komentar.blade.php` | 1 |
| 24 | `partials/juri-komentar-modal.blade.php` | 1 |
| 25 | `settings/profile/index.blade.php` | 1 |
| 26 | `settings/corporate/index.blade.php` | 1 |
| 27 | `settings/index.blade.php` | 1 |
| 28 | `kecamatan/show.blade.php` | 1 |

**Fix:** `var(--c-ink)` → `var(--c-text)`, `var(--c-ink-subtle)` → `var(--c-text-muted)`, `var(--shadow-hover)` → hapus.

---

## Batch 4: 🟡 Utility Cleanup — text-muted → style (34 files)

Replace class `text-muted` with inline `style="color:var(--c-text-muted)"` or use Cobalt token.

| # | File | # Occurrences |
|---|---|---|
| 1 | `auth/login.blade.php` | 1 |
| 2 | `faq/index.blade.php` | 2 |
| 3 | `informasi.blade.php` | 2 |
| 4 | `layouts/partials/header.blade.php` | 1 |
| 5 | `maintenance.blade.php` | 1 |
| 6 | `roles/null.blade.php` | 1 |
| 7 | `roles/pemohon.blade.php` | 2 |
| 8 | `roles/tksd.blade.php` | 1 |
| 9 | `permohonan/index.blade.php` | 2 |
| 10 | `permohonan/detail.blade.php` | 2 |
| 11 | `permohonan/finish.blade.php` | 1 |
| 12 | `permohonan/show.blade.php` | 1 |
| 13 | `permohonan/create.blade.php` | 1 |
| 14 | `permohonan/riwayat.blade.php` | 2 |
| 15 | `permohonan/indikator/index.blade.php` | 2 |
| 16 | `permohonan/indikator/file/create.blade.php` | 1 |
| 17 | `permohonan/indikator/file/index.blade.php` | 2 |
| 18 | `permohonan/pembahasan/index.blade.php` | 1 |
| 19 | `permohonan/pembahasan/chat.blade.php` | 1 |
| 20 | `permohonan/pembahasan/chat-dialog.blade.php` | 1 |
| 21 | `permohonan/pembahasan/dialog.blade.php` | 1 |
| 22 | `permohonan/penjadwalan/index.blade.php` | 1 |
| 23 | `partials/juri-komentar.blade.php` | 2 |
| 24 | `partials/juri-komentar-modal.blade.php` | 2 |
| 25 | `settings/index.blade.php` | 2 |
| 26 | `settings/profile/index.blade.php` | 1 |
| 27 | `settings/profile/password.blade.php` | 1 |
| 28 | `settings/corporate/index.blade.php` | 1 |
| 29 | `statistik/index.blade.php` | 1 |
| 30 | `kecamatan/show.blade.php` | 3 |
| 31 | `components/file-drop.blade.php` | 1 |
| 32 | `index.blade.php` | 1 |

**Fix:** `class="text-muted"` → `style="color:var(--c-text-muted)"`. Remove any CSS rule for `.text-muted`.

---

## Batch 5: 🟡 Old Card Classes — jp-card__title / jp-card__text (15+ files)

These classes don't exist in Cobalt CSS. Replace with inline heading/paragraph or remove.

| # | File | Old Class |
|---|---|---|
| 1 | `roles/null.blade.php` | `jp-card__title`, `jp-card__text` |
| 2 | `roles/pemohon.blade.php` | `jp-card__title`, `jp-card__text` |
| 3 | `roles/tksd.blade.php` | `jp-card__title` |
| 4 | `permohonan/show.blade.php` | `jp-card__title` |
| 5 | `permohonan/detail.blade.php` | `jp-card__title` |
| 6 | `permohonan/create.blade.php` | `jp-card__title`, `jp-card__text` |
| 7 | `permohonan/index.blade.php` | `jp-card__title`, `jp-card__text` |
| 8 | `permohonan/riwayat.blade.php` | `jp-card__title` |
| 9 | `permohonan/finish.blade.php` | `jp-card__title` |
| 10 | `informasi.blade.php` | `jp-card__title`, `jp-card__text` |
| 11 | `faq/index.blade.php` | `jp-card__title` |
| 12 | `index.blade.php` | `jp-card__title`, `jp-card__text` |
| 13 | `permohonan/indikator/file/form.blade.php` | `jp-card__title` |
| 14 | `permohonan/indikator/index.blade.php` | `jp-card__title` |
| 15 | `partials/juri-komentar.blade.php` | `jp-card__title` |
| 16 | `settings/profile/index.blade.php` | `jp-card__text` |

**Fix:** `jp-card__title` → `<h3 style="font-size:var(--t-lg);font-weight:700;color:var(--c-text)">`. `jp-card__text` → `<p style="color:var(--c-text-secondary);font-size:var(--t-sm)">`.

---

## Batch 6: 🟢 Optional Cleanup — Other Inconsistencies

| # | File | Issue |
|---|---|---|
| 1 | `components/accordion-item.blade.php` | Component exists separately — already have `components/accordion.blade.php` |
| 2 | `public_html/css/old-custom.css` | 153KB file — not loaded by any view. Safe to delete. |
| 3 | `Modules/Template/Resources/views/kecamatan/show.blade.php` | `text-muted` + `ion-icon` |

---

## Out of Scope (Admin/Nue/Epanel)

~174 files across `resources/views/`, `Modules/{Faq,Formulir,Pemohon,Wilayah,Core}/`, `packages/nue*` — all use **Bootstrap 5 + HS Space** template. Different design system entirely. Would need full rewrite if Cobalt applied.

---

## Execution Order

1. **Batch 1** (8 files) — Layout broken, highest priority
2. **Batch 3** (28 files) — `sed -i '' 's/var(--c-ink)/var(--c-text)/g'` bulk rename
3. **Batch 4** (32 files) — `text-muted` replacement (can automate partially)
4. **Batch 2** (16 files) — Icon migration
5. **Batch 5** (16 files) — Card class cleanup
6. Verify with `php artisan view:clear` then test incognito
