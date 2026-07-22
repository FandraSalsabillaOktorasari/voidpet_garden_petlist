# Voidpet Garden UI Overhaul Prompt

## 1. Project Overview
**Name**: Voidpet Garden Tracker
**Stack**: Laravel, Blade Templates, Tailwind CSS (via CDN), Alpine.js (or vanilla JS for interactions), Tom Select (for advanced styling of select dropdowns).
**Theme**: Currently a dark mode theme (`bg-gray-900`, `text-gray-200`) with colorful gradients on the headers.

## 2. Global UI Assets & Shared Layout
The application has a consistent header and navigation bar across its main tracking pages. When designing the new UI, please ensure the following navigation elements are easily accessible and visually cohesive:

- **Header Title**: "Voidpet Garden"
- **Navigation Tabs**:
  1. **Pet Collection**: Route to `/pets`
  2. **NPC Food Tracking** (People): Route to `/people`
  3. **Plant Vivid Forms** (Plants): Route to `/plants`
- **Styling Guidelines**:
  - Maintain a primarily Dark UI (unless requested to switch to light/toggleable).
  - Use custom scrollbars matching the dark theme.
  - Apply soft borders and shadows for depth (e.g., `border-gray-700`, `shadow-sm`).
  - **Tom Select integration**: Provide modern, dark-themed styling overrides for Tom Select dropdowns, hiding native default select styles.

## 3. Screens to Overhaul

### 3.1. Welcome Screen (`resources/views/welcome.blade.php`)
- **Purpose**: Landing page with simple branding.
- **Key Elements**:
  - Login / Register navigation logic based on auth state.
  - Brief introductory text ("Let's get started").
- **UI Instruction**: Make it visually impressive, utilizing the Voidpet aesthetic (mystical, nature, void elements). Include a centralized CTA to log in or register.

### 3.2. Pet Collection Screen (`resources/views/pets/index.blade.php`)
- **Purpose**: Displays the user's collection of Voidpets.
- **Key Elements**:
  - Global Header & Navigation.
  - Total Pets Counter element.
  - A grid or list displaying individual pets.
  - Filters or Search functionalities using Tom Select.
- **UI Instruction**: Create a beautiful pet card layout. Differentiate rarities, elements, or types via color-coding or subtle border glows. Ensure spacing holds up well on mobile devices.

### 3.3. People / NPC Food Tracking Screen (`resources/views/people/index.blade.php` & `modal.blade.php`)
- **Purpose**: Tracks what food items different NPCs (People) like, dislike, or accept.
- **Key Elements**:
  - Global Header & Navigation.
  - Forms laid out in a **Masonry Grid** (Column count changes based on screen width).
  - Multi-select dropdowns (Tom Select) for food categories.
  - A modal component (`modal.blade.php`) for viewing/editing specific NPC details.
- **UI Instruction**: Improve the masonry layout to prevent forms from breaking awkwardly. Ensure Tom Select tags (the selected foods) look like smooth, styled pills/badges. The modal should have a clean overlay and smooth entry animation.

### 3.4. Plant Vivid Forms Screen (`resources/views/plants/index.blade.php`)
- **Purpose**: Tracks different "Vivid Forms" (visual variants) of plants.
- **Key Elements**:
  - Global Header & Navigation.
  - A Masonry Grid displaying different plant types.
  - Custom styled checkboxes indicating which forms have been unlocked/collected.
- **UI Instruction**: Design an engaging checklist. The custom checkboxes should feel satisfying to click (e.g., using transitions, checkmark SVGs, and brand colors like emerald/cyan). Differentiate between locked and unlocked states clearly.

## 4. Technical Constraints for the AI Agent
1. **Maintain Blade Syntax**: Do not convert Blade loops (`@foreach`, `@if`) into React/Vue components. Write raw HTML/Tailwind inside Blade snippets.
2. **Tailwind Classes**: Rely primarily on Tailwind utility classes. If writing custom `<style>` blocks, keep them scoped and organized (like the existing custom scrollbars and TomSelect overrides).
3. **Responsiveness**: All screens must be fully responsive. Use `grid-cols-1 md:grid-cols-2 lg:grid-cols-3` or the existing `column-count` approach for masonry layouts.
4. **Interactive Elements**: Assuming no heavy JS frameworks, design states (hover, focus, active, disabled) purely via Tailwind (e.g., `hover:bg-gray-700`, `focus:ring-2`).

---
*End of Prompt*