<p align="center">
  <img src="https://via.placeholder.com/1200x600.png?text=Voidpet+Garden+-+Manager" alt="Voidpet Garden Manager Banner" width="800">
</p>

<h1 align="center">🪴 Voidpet Garden: Ultimate Collection Manager</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.0-blue?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP Version">
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
</table>

---

## 🚀 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** HTML5, Tailwind CSS, Vanilla JS
- **Plugins:** TomSelect (Searchable Multi-select dropdowns)
- **Database:** SQLite (Default), scalable to MySQL/PostgreSQL

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

<p align="center">
Made with ❤️ for the Voidpet Community<br />
<i>This is a fan-made project and is not officially affiliated with Voidpet.</i>
</p>