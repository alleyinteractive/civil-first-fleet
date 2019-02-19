<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
# Civil CMS

- [Project Overview](#project-overview)
- [Branch Workflow](#branch-workflow)
- [New Environment Setup](#new-environment-setup)
  - [WordPress Environment](#wordpress-environment)
  - [Front-end Codebase](#front-end-codebase)
  - [Back-end Codebase](#back-end-codebase)
  - [Database](#database)
  - [Admin Area](#admin-area)
    - [Plugins to Activate](#plugins-to-activate)
    - [Pages/Posts to Add](#pagesposts-to-add)
    - [Menus to Assign](#menus-to-assign)
- [Theme Specific](#theme-specific)
- [Docs](#docs)

## Directory Specific READMEs

- [client](./client/README.md)
- [client configuration](./client/config/README.md)
- [components](./components/README.md)
    - [Images](./components/image/README.md)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Branch Workflow

The purpose of this section is to answer any questions that a newly onboarded devs might have about the branching workflow. The information provided here should be clear and concise. Perhaps a numbered list providing the preferred steps of deployment accompanied by a brief note of clarification.

# New Environment Setup

After reading this section, a newly onboarded dev should have a 100% functional theme to work with. Overall goal here is to be able to get any new instance of `apm install <package>` off the ground without hitches.

## WordPress Environment

This repo can serve as the `wp-content` directory of a WordPress installation. Varying Vagrant Vagrants (VVV) is recommended as a WP environment for development.

- Set up VVV according to <https://varyingvagrantvagrants.org/docs/en-US/installation/>. Once it's installed and running, you should be able to visit <http://vvv.test> to see information about your environment.
- You can use the default `wordpress-develop` VVV comes with, available at <http://src.wordpress-develop.test>. By default, this installation is located at `[vagrant-dir]/www/wordpress-develop/`
- Navigate to `[vagrant-dir]/www/wordpress-develop/public_html/src/`, delete or rename `wp-content`, and then install the repo in its place (`git clone --recursive git@github.com:alleyinteractive/civil-first-fleet.git wp-content`)
- You should then be able to log in at <http://src.wordpress-develop.test/wp-admin/> (default credentials `admin`/`password`) and, for instance, select the Civil theme from Appearance > Themes.

## Front-end Codebase

Get the front-end off the ground locally with:

* `npm install`

*NOTE*: The front end lead should freeze all node package versions when setting up a new build. The FE lead should also be responsible for vetting, implementing and informing team members of any package updates over the course of a project.

Update this section with any other important FE/FE-tool chain related information.

## Back-end Codebase

Update this section with any other important back-end codebase related information.

Any code manipulations, function call suppressions, etc should all be fixed in the code base to the fullest extent possible. This section is dedicated to addressing any hitches in the codebase, but avoiding them is always better.

## Database

Is the `apm` database up to date? If not, get it there. Should it be necessary, any idiosyncratic information regarding the database should be explained here.

## Admin Area

Update this section with any other important Admin area actions that need to occur before having a fully set up new environment. (Add or delete subsections below as needed.)

### Plugins to Activate

What (if any) plugins need to be activated for this theme to function? You should show the plugins both listed and unlisted in `inc/plugins.php`.

### Pages/Posts to Add

Are any posts or pages necessary to create before having a fully functional install?

### Menus to Assign

Are any menus necessary to assign/create that aren't provided in the DB?

# Theme Specific

This section may contain information that is important to know that will vary from theme to theme. For example, rewrite rules, CPT use-cases, large scale features, any tricky or unorthodox code that occurs in `inc/` might be explained here, as well as any other theme aspects that you might deem important information to share with a new dev to the project.

# Docs

_NOTE:_ You must manually run the doctoc task (from the repo root, run `grunt doctoc`) when editing this README file, which is excluded from the watch to avoid triggering redundant watch tasks.

&copy; Alley Interactive
