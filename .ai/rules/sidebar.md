---
paths:
  - 'resources/views/layouts/partials/sidebar/**'
---

# Sidebar

## Sidebar: Access Control submenu groups Users/Roles/Permissions
Users, Roles, dan Permissions dikelompokkan di sub-menu "Access Control" (sidebar-menu-access-control.blade.php). Jangan jadikan item flat lagi. Pola: parent collapsible Alpine (x-data accessOpen), auto-open bila route child aktif (routeIs users.*/roles.*/permissions.*), wrapper @canany([manage-users, manage-roles, manage-permissions]), dan tiap child tetap di-gate @can masing-masing. Sub-item memakai komponen x-sidebar.menu-sub-button.

## Sidebar: account actions only in user dropdown, no Settings group in nav
Tidak ada Settings group di nav sidebar lagi. Profile & Settings (General) hanya tersedia di user dropdown (sidebar-footer.blade.php → route users.profile & route settings) bersama Logout. Jangan tambahkan duplikat Profile/General ke sidebar-menu.blade.php.
