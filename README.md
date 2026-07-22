<p align="center">
  <img src="https://via.placeholder.com/1200x600.png?text=Voidpet+Garden+-+Manager" alt="Voidpet Garden Manager Banner" width="800">
</p>

<h1 align="center">🪴 Voidpet Garden: Ultimate Collection Manager</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-red?style=for-the-badge&logo=laravel" alt="Laravel 13">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.0-blue?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

<p align="center">
  <strong>A professional collection manager for Voidpets.</strong><br />
  Track stats, log NPC favorite foods, checklist your plant's vivid forms, and protect your fabled finds with an elegant dark interface.
</p>

---

## 📑 Table of Contents
- [✨ Core Features](#-core-features)
- [🚀 Tech Stack](#-tech-stack)
- [🛠️ Installation](#️-installation)
- [🏗️ Database Architecture](#️-database-architecture)
- [🐛 Known Issues & Solutions](#-known-issues--solutions)
- [🤝 Contributing](#-contributing)

---

## ✨ Core Features

<table width="100%">
  <tr>
    <td width="50%">
      <b>🐾 Pet Collection & Stats</b><br />
      Track 55+ species. Separate management for Bonus Stats (Intensity/Clarity) and Battle Stats. Safe Lock protection available.
    </td>
    <td width="50%">
      <b>👥 NPC Food Tracking</b><br />
      Keep a log of Gift (+) and Throw (-) values for every food given to NPCs. Dynamic dictionary with TomSelect.
    </td>
  </tr>
  <tr>
    <td width="50%">
      <b>🪴 Plant Vivid Forms</b><br />
      Visual checklist grouped by Box Element. Keep track of which Vivid Forms you have unlocked for every single plant species.
    </td>
    <td width="50%">
      <b>🔍 Live Search & Filter</b><br />
      Lightning-fast local searching. Filter pets by element or rarity. Search within specific plant forms instantly.
    </td>
  </tr>
  <tr>
    <td width="50%">
      <b>👯 Duplicate Pet Detector</b><br />
      Automatically groups pets that share the exact same Species + Vivid Form combination. Visually separates each group and sorts them by Total Bonus Stat (highest first) so you can immediately identify which duplicate to keep or release.
    </td>
    <td width="50%">
      <b>📋 Pet Checklist</b><br />
      Keep track of which pets you still need to collect across all species and vivid form combinations.
    </td>
  </tr>
  <tr>
    <td width="50%">
      <b>🔄 Auto-Sync New Species</b><br />
      Fetches and extracts the latest Voidpet Dex data directly from the game's compiled JavaScript bundles. Handles both numeric and TypeScript Enum element mappings flawlessly.
    </td>
    <td width="50%">
      <b>✨ Modern Architecture</b><br />
      Maintains performance by keeping the core list synced without manual database intervention.
    </td>
  </tr>
</table>

---

## 🚀 Tech Stack

- **Backend:** Laravel 13 (PHP 8.4+)
- **Frontend:** HTML5, Tailwind CSS, Vanilla JS
- **Plugins:** TomSelect (Searchable Multi-select dropdowns)
- **Database:** MySQL (default), scalable to PostgreSQL

---

## 🛠️ Installation

### 1. Clone & Install
```bash
git clone https://github.com/YourUsername/voidpet-garden-petlist.git
cd voidpet-garden-petlist
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Initialization

> [!IMPORTANT]
> This step is crucial to populate the master Species and Vivid Form lists!

```bash
php artisan migrate:fresh --seed
```

### 4. Build Assets & Serve (Optional / Development)

If you need to compile Tailwind or other assets (Node.js required):
```bash
npm install
npm run dev
```

Run the application:
```bash
php artisan serve
```

---

## 🏗️ Database Architecture

<details>
<summary><b>View Schema Details</b></summary>

This project uses an optimized relational approach to keep queries extremely fast:

- **`UserPets`**: Connects to `Species` and `VividForms`. Holds stats, names, stage and lock status.
- **`People` & `Foods`**: Connected via Many-to-Many pivot table `person_food` keeping track of gift and throw integers.
- **`Plants`**: Connects to the master `VividForms` table via `plant_vivid_form` pivot to establish "Owned" status.

</details>

---

## 🐛 Known Issues & Solutions

### `storage/logs/laravel.log` — Permission Denied (Windows)

**Symptom:** `UnexpectedValueException` — The stream or file `.../storage/logs/laravel.log` could not be opened in append mode: Failed to open stream: Permission denied.

**Cause:** On Windows, the PHP process (run via `php artisan serve`) may not have write permission to the `storage/` directory, especially after cloning the repo or if the file was created by a different user/process.

**Solution:** Run the following command once in PowerShell (as Administrator if needed):

```powershell
icacls "D:\path\to\voidpet_garden_petlist\storage" /grant Everyone:(OI)(CI)F /T
```

Replace `D:\path\to\voidpet_garden_petlist` with your actual project path. This grants full write access recursively to the entire `storage/` folder.

---

### `Undefined variable $pets` on `/pets/duplicates` page

**Symptom:** `ErrorException` — Undefined variable `$pets` (View: `resources/views/pets/duplicates.blade.php`).

**Cause:** The `duplicates()` method in `UserPetController` was only passing `$duplicates` (a grouped collection) to the view, but the blade template iterated over `$pets` — a flat list. This mismatch was left over after a view refactor that removed the filter section but did not update the variable name in the loop.

**Solution:** Updated `UserPetController@duplicates` to also pass `$pets` as a flattened, sorted collection:

```php
// Flat list of all duplicate pets, sorted by total_bonus_stat descending
$pets = $duplicates->flatten()->sortByDesc('total_bonus_stat')->values();

return view('pets.duplicates', compact('duplicates', 'pets'));
```

---

---

### Namespace declaration statement has to be the very first statement

**Symptom:** FatalError when hitting /species/sync.
**Cause:** Saving PHP files using PowerShell with default UTF-8 adds a hidden Byte Order Mark (BOM) \xEF\xBB\xBF at the beginning of the file, which PHP interprets as output before the <?php tag.
**Solution:** Re-save the file using .NET classes or an IDE configured to use UTF-8 without BOM.

<p align="center">
Made with ❤️ for the Voidpet Community<br />
<i>This is a fan-made project and is not officially affiliated with Voidpet.</i>
</p>

