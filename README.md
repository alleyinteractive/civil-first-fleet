# Civil First Fleet
The Civil First Fleet is an open source WordPress theme designed by Civil and developed by Alley for use by the First Fleet. This is a pre-beta release, and documentation is a work in progress, so proceed at your own caution and discretion.

# Usage
- Download this repo and extract to `/wp-content/themes/civil-first-fleet/`.
- In the `civil-first-fleet/` directory, run `git submodule update --init --recursive` to fetch the submodules.

## Frontend Build
This theme uses NPM to build frontend assets. Build scripts can be found in [package.json](https://github.com/alleyinteractive/civil-first-fleet/blob/master/package.json#L6-L14). To get started, you should `npm install` and `npm run build` from the theme root.

## Required Plugins
There are [four required plugins](https://github.com/alleyinteractive/civil-first-fleet/blob/master/inc/plugins.php#L36-L41) for this theme to work properly. Without them installed and enabled the theme will not work as expected. An admin notice will display when they are not available.

* [Co-Authors Plus](https://github.com/Automattic/Co-Authors-Plus)
* [Fieldmanager](https://github.com/alleyinteractive/wordpress-fieldmanager)
* [FM Zones](https://github.com/alleyinteractive/fm-zones)
* [WP Asset Manager](https://github.com/alleyinteractive/wp-asset-manager)

## Optional Plugins and Integrations

### Civil Publisher
https://github.com/joincivil/civil-publisher-wordpress-plugin

### Edit Flow
https://github.com/Automattic/Edit-Flow

### Parsely
https://github.com/Parsely/wp-parsely

### Pico
https://github.com/PicoNetworks/wordpress-plugin

## Settings
Coming soon.

## Features
* [Sponsors](https://github.com/alleyinteractive/civil-first-fleet/tree/master/components/sponsor) - Create, manage, and deploy sponsorship and underwriting messages without using DFP or other ad software.

