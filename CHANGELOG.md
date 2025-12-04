# Changelog

All notable changes to this plugin will be documented in this file.

## [Unreleased]
### Added
- Notice border controls (border width, style, radius) in Elementor widget
- Notice icon picker (Elementor ICONS control) for custom icons in notice area
- Button hover styling controls (hover background color, hover text color, transition duration, optional shadow)

### Fixed
- Removed duplicate inline trigger button creation in `assets/js/frontend.js` which caused two "Join Waitlist" buttons to appear

### Notes
- `render()` should serialize the `notice_icon` setting to frontend JSON so the chosen icon is rendered correctly in the notice. If not present, frontend falls back to a default emoji.
