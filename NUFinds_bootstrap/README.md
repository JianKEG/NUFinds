# NUFinds: School Lost & Found Board

A web application with a separate Student View page and Admin Panel, where Lost and Found staff and guards post found items, only staff upload item photos, and students browse the item board to check if their lost items have been found.

## Setup (XAMPP)
1. Put this folder in `htdocs/NUFinds`, start Apache + MySQL.
2. phpMyAdmin → **Import** `assets/database/NUFinds.sql` (the team schema, unchanged).
3. Select the `NUFinds` database → **Import** `assets/database/NUFinds_sample_data.sql` (users + sample items).
4. Edit `config/constant.php` if your MySQL password isn't empty.
5. Open `http://localhost/NUFinds/` (students) and `http://localhost/NUFinds/admin.php` (staff login).

| Username | Password | Role |
|---|---|---|
| `nu_admin2026` | `123` | Admin (Lost & Found Staff) |
| `nu_staff2026` | `123` | Staff (Utility / Guard) |

## Pages
| Page | Who |
|---|---|
| `index.php` Student View (search + filters, no login) | Everyone |
| `admin.php` Staff login | Admin, Staff |
| `pages/admin/dashboard.php` | Admin, Staff |
| `pages/admin/postItem.php` (Staff: Found only, no photo) | Admin, Staff |
| `pages/admin/foundItems.php` photos, mark claimed, dispose | Admin only |
| `pages/admin/lostReports.php` photos, mark resolved | Admin only |
| `pages/admin/claims.php` claim log | Admin only |

## Folder structure
```
config/    constant.php, connection.php, accessController.php (pages), accessControllerActions.php (actions), photoUpload.php
actions/   login.php, logout.php, student/boardQuery.php, admin/dashboard.php,
           admin/item/(addItem, uploadPhoto)  admin/found/(foundQuery, claimFound, disposeFound)
           admin/lost/(lostQuery, resolveLost)  admin/claim/claimQuery.php
pages/     admin/(dashboard, postItem, foundItems, lostReports, claims).php
includes/  head.php, footer.php, student/header.php, admin/(header, sidebar, footer).php
assets/    js/, images/, uploads/, database/      src/style.css
```

## Developers
1. Abrenilla, Alfonso Gabriel
2. Clarion, Zairiel
3. Gapatan, Jian Kristian
