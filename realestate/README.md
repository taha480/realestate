# AURELIA — Luxury Real Estate & Architectural Construction

A bespoke website for a premium Real Estate and Master Construction company built with clean **HTML5, CSS3, Vanilla JavaScript, and PHP 8+**.

## Tech Stack
- **HTML5**: Semantic tags, accessible landmarks, structured markup.
- **CSS3**: Vanilla design system, custom CSS variables, responsive grids, luxury dark charcoal & champagne gold theme, zero frameworks.
- **Vanilla JavaScript**: Sticky scroll-aware header, accessible mobile drawer navigation, smooth anchor scrolling, IntersectionObserver reveal animations.
- **PHP 8+**: Reusable modular component includes (`header.php`, `footer.php`), ready for Phase 2 MySQL database integration.
- **Zero Node.js / Zero npm dependencies**.

## Project Structure
```text
D:/Website/
├── index.php              # Full 12-section Luxury Home Page
├── about.php              # Company Heritage & Philosophy (Placeholder)
├── services.php           # Construction & Development Services (Placeholder)
├── projects.php           # Architectural Portfolio & Landmarks (Placeholder)
├── properties.php         # Curated Prime Real Estate (Placeholder)
├── contact.php            # Confidential Project Briefing & Consultation Form
├── includes/
│   ├── header.php         # Reusable HTML head, brand logo, navigation & mobile drawer
│   └── footer.php         # Reusable global footer, studio addresses & script tags
├── css/
│   └── style.css          # Master bespoke CSS3 luxury design system
└── js/
    └── main.js            # Vanilla JS navigation, sticky header & interactions
```

## How to Preview the Site Locally

### Option 1: Using PHP's Built-in Development Server (Recommended)
You have PHP installed in XAMPP at `D:\xampp\php\php.exe`. Run the following command in PowerShell:

```powershell
& "D:\xampp\php\php.exe" -S localhost:8000
```
Then open your browser and navigate to:
**`http://localhost:8000`**

### Option 2: Using XAMPP Apache
If you run Apache via the XAMPP Control Panel, you can point Apache's `DocumentRoot` to `D:/Website` or create a VirtualHost pointing to `D:/Website`.
