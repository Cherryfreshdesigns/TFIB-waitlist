TFIB Waitlist Plugin
=====================

This repository contains the TFIB Waitlist WordPress plugin (Elementor widget + frontend assets) extracted from the site codebase and documented for release.

Overview
--------
The plugin provides a waitlist modal and inline widget for WooCommerce products, built as an Elementor widget with configurable styling controls, AJAX submission, and email handling.

This repo snapshot (v2.x) includes the following notable updates implemented in this version:

- Notice border styling (border-width, border-style, border-radius) via Elementor controls
- Notice icon selection (Elementor Icons control) allowing Font Awesome / eicons selection
- Full button hover styling controls (hover background, hover text color, transition duration, optional shadow)
- Fix for duplicate inline trigger button generation

Files of interest
-----------------
- includes/Elementor/WaitlistWidget.php — main Elementor widget with controls and render() method
- assets/js/frontend.js — frontend behavior (modal, inline form, icon rendering)
- assets/css/frontend.css — styles for modal, buttons, notice
- docs/functions.md — documentation for the functions/controls added in this version
- CHANGELOG.md — release notes for this version

Installation (developer)
------------------------
1. Copy the plugin folder to your WordPress site's `wp-content/plugins/` directory.
2. Activate the plugin in WordPress admin > Plugins.
3. Edit a page with Elementor and add the "TFIB Waitlist" widget.

How to create a GitHub repo and push
-----------------------------------
From the plugin folder run:

```bash
cd "/Users/briancherry/Local Sites/tfib/app/public/wp-content/plugins/waitlist"
# initialize and commit (if not already done)
git init
git add .
git commit -m "chore: initial plugin repository with v2 docs"

# Create remote repo on GitHub (web UI) or with gh CLI:
# gh repo create cherryfreshdesigns/TFIB-waitlist --public --source=. --remote=origin --push

# OR if you create remote manually, then:
# git remote add origin git@github.com:cherryfreshdesigns/TFIB-waitlist.git
# git push -u origin main
```

License
-------
This repository includes a permissive MIT license by default (see LICENSE). If you prefer another license, replace the file.

Contributing
------------
See CONTRIBUTING.md for guidelines.
