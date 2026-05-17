# Design System: The Scholarly Curator

## 1. Overview & Creative North Star
This design system is built upon the "Scholarly Curator" creative north star. Moving away from the generic, boxy layouts of standard ed-tech, this system treats the digital interface as a high-end editorial publication. It is an intersection of heritage (Japanese calligraphy and classic serif typography) and modern utility (clean Swiss-inspired layouts and glassmorphism).

The experience is defined by **intentional asymmetry**. We reject the rigid, centered grid in favor of dynamic compositions where content "breathes" through expansive negative space. The goal is to make the user feel they are navigating a private, curated collection of knowledge rather than a cold database.

---

## 2. Colors & Surface Architecture
The palette is rooted in a warm, paper-like foundation that reduces eye strain and evokes the feeling of premium stationery.

### The "No-Line" Rule
To maintain a sophisticated editorial feel, **1px solid borders are strictly prohibited for sectioning.** We define boundaries through tonal shifts rather than lines. A section should be distinguished from its parent by moving one step up or down the surface-container scale.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers. 
- **Base Layer:** `surface` (#f9f9ff) or the warm brand background (#F5F0E8).
- **Secondary Sectioning:** Use `surface_container_low` (#f0f3ff) for large areas like sidebars or secondary content blocks.
- **Content Cards:** Use `surface_container_lowest` (#ffffff) to create a subtle "pop" against the background.
- **Interactive Elements:** Use `surface_container_highest` (#dce2f3) for elements that require immediate attention or active states.

### The "Glass & Gradient" Rule
Flat colors are for utilities; "soul" is for the brand. 
- **Glassmorphism:** Use `surface` colors at 70% opacity with a `20px` backdrop-blur for floating navigation or overlay headers.
- **Signature Textures:** For Hero sections or Primary CTAs, apply a subtle linear gradient from `primary` (#0f5238) to `primary_container` (#2d6a4f) at a 135-degree angle. This adds a "silk-screen" depth to the green.

---

## 3. Typography
The typographic system relies on a high-contrast relationship between a stately serif and a functional sans-serif.

- **Display & Headlines (Newsreader/Playfair Display):** These represent the "Sensei" voice. Use them for lesson titles and major editorial headers. They should be set with slightly tighter letter-spacing (-0.02em) to feel authoritative.
- **Body (Inter):** The "Assistant" voice. Used for instructions, descriptions, and UI labels. It provides high-legibility clarity against the more expressive headers.
- **Japanese (Noto Sans JP):** The "Subject" voice. Set Japanese characters slightly larger (approx 110%) than the surrounding English body text to match visual weight, as Kanji appears denser than Latin characters.

---

## 4. Elevation & Depth
Depth in this system is achieved through light and layering, never through heavy shadows.

- **Tonal Layering:** Instead of a shadow, place a `surface_container_lowest` card on a `surface_container_low` background. This creates a "soft lift" that feels architectural.
- **Ambient Shadows:** For floating elements (like Modals or tooltips), use a multi-layered shadow:
  `box-shadow: 0 10px 30px -10px rgba(21, 28, 39, 0.08);`
  The shadow should be tinted with the `on_surface` color to feel like natural light passing through a physical object.
- **The "Ghost Border":** If a boundary is required for accessibility, use the `outline_variant` token at **15% opacity**. This provides a "suggestion" of a container without breaking the editorial flow.

---

## 5. Components

### Buttons
- **Primary:** Gradient fill (`primary` to `primary_container`), `on_primary` text, and `xl` (0.75rem) roundedness. 
- **Secondary:** Transparent background with a "Ghost Border" (15% `outline_variant`) and `primary` text.
- **Tertiary:** No background or border. Use `primary` text with a subtle underline (2px) offset by 4px.

### Cards & Lists
- **The Forbiddance of Dividers:** Do not use horizontal lines to separate list items. Use 24px–32px of vertical padding and a subtle background shift on hover (`surface_container_high`).
- **Lesson Cards:** Use an asymmetrical layout. Place the Kanji character in a large, low-opacity `display-lg` style in the background, with the English title and progress bar floating on top.

### Levels & Progress Indicators
Level indicators must use the high-contrast semantic tokens:
- **Beginner:** `primary_fixed` base with `on_primary_fixed_variant` text.
- **Intermediate:** `secondary_fixed` base with `on_secondary_fixed_variant` text.
- **Advanced:** `tertiary_fixed` base with `on_tertiary_fixed_variant` text.

### Interactive Inputs
- **Text Fields:** Use a "minimalist desk" style. Only a bottom border (2px) using `outline_variant`. On focus, the border transitions to `primary` and the background shifts to `surface_container_low`.

---

## 6. Do's and Don'ts

### Do
- **Do** use whitespace as a functional tool. If a section feels crowded, increase padding rather than adding a border.
- **Do** mix Japanese and English typography with intentional scale differences to ensure the Kanji feels "heroic."
- **Do** use the `surface_bright` token for "Success" states to keep the palette warm and scholarly.

### Don't
- **Don't** use pure black (#000000) for text. Always use `on_surface` (#151c27) to maintain the premium, ink-on-paper look.
- **Don't** use "Default" shadows or heavy 1px borders. These are the hallmarks of non-premium "template" software.
- **Don't** center-align long blocks of text. Stick to editorial left-alignment to maintain the magazine-inspired rhythm.