# The Clements - MultiSite Theme
A lean, performance-focused WordPress theme built for The Clements property network.

## 🚀 Quick Start

### Prerequisites
- Node.js (v12 or higher)
- WordPress MultiSite installation
- Advanced Custom Fields PRO plugin

### Initial Setup

1. Install theme dependencies:
```bash
cd wp-content/themes/theclements
npm install
```

2. Configure local development:
- Open `gulppath.json`
- Update the `domain` value to match your local development URL

### Development Commands

```bash
# Watch for changes and compile
gulp watch

# Watch with live reload
gulp watch-reload
```

## 🏗 Theme Structure

### Gutenberg Blocks
All ACF Gutenberg blocks are organized in the `acf-blocks` directory. Each block contains:
- Block registration
- Frontend template
- Block-specific styling

### Styling
- Main SCSS file: `src/scss/main.scss`
- Add new block styles here
- Compiled to: `assets/css/`

### JavaScript
- Source files: `src/js/scripts/`
- Modular development supported
- Compiled to: `assets/js/`

## 🌐 Adding a New Network Site

### 1. Create the Site
1. Navigate to `Network Admin > Sites > Add New`
2. Fill in site details
3. Click "Add Site"
4. Access new site dashboard

### 2. Theme Setup
1. Go to `Appearance > Themes`
2. Activate "The Clements" theme

### 3. Configure ACF
1. Navigate to `ACF > Field Groups`
2. Sync all field groups
3. Verify sync completion

### 4. Site Configuration
1. Go to `Theme Settings`
2. Configure site-specific settings:
   - Colors
   - Typography
   - Contact information
3. Save changes

### 5. Content Setup
1. Create necessary pages
2. Set up navigation menus
3. Configure widgets if needed

## 📝 Notes
This theme is optimized for performance and maintainability. Keep additions minimal and purposeful.