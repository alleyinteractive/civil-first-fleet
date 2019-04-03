Sponsors allow you to create, manage, and deploy sponsorship and underwriting messages without using DFP or other ad software.

## Features
* Create and manage sponsors.
* Schedule sponsors to appear on the homepage.
* Schedule sponsors to appear on specific category archives (and posts/articles that have the primary category set appropriately).
* Scheduling tool for displaying sponsors in various contexts.

## Possible Future Features
* Sponsor Page - Each sponsor gets a unique URL like `example.com/sponsors/nike/`.
* Sponsor Archive - A directory or listing of all sponsors.
* Support for Tag Archives - Schedule sponsors for tags the same way categories can.
* Override Sponsor on Posts - Override the primary category sponsor schedule for a specific post/article.

## Setting up a Sponsor
Sponsors can be managed at `yoursite.com/wp-admin/edit.php?post_type=sponsor`. This URL can be accessed from your WordPress dashboard.

![View Sponsor](/components/sponsor/assets/docs/view-sponsors.png)

### Fields
* Title - Name of the sponsor.
* Eyebrow Label - The text above/next to the logo. Defaults to "Supported Today By"
* Link - When your sponsor is clicked, where should the user go?
* Logo - Logo of the sponsor.
* Message - Message from the sponsor.

![Add Sponsor](/components/sponsor/assets/docs/add-sponsor.png)

## Scheduling a Sponsor
Various locations on your site can display a sponsor. These areas can schedule sponsors in advance. You can schedule multiple sponsors, and the site will display the first one either without a schedule, or a schedule with dates indicating it should currently be active.

### Homepage
Sponsor scheduling can be added to any landing page homepage under the Featured Articles -> Settings -> Sponsors.

![Homepage Scheduling](/components/sponsor/assets/docs/homepage-schedule.png)

![Homepage Example](/components/sponsor/assets/docs/homepage-example.png)

### Category
When editing a category, scheduling can be found under the heading "Sponsored Content".

![Category Scheduling](/components/sponsor/assets/docs/category-schedule.png)

![Category Example](/components/sponsor/assets/docs/category-example.png)

### Post/Article
If a post/article has a primary category set, and the category has an active sponsor, it will appear on your post/article.

![Article Example](/components/sponsor/assets/docs/article-example.png)

## Setting up Sponsor Disclaimer
A disclaimer can be set in the Newsroom Settings submenu, yoursite.com/wp-admin/options-general.php?page=newsroom-settings&msg=success

![Disclaimer Settings](/components/sponsor/assets/docs/disclaimer-settings.png)

## Customizing Sponsor Visuals
Your sponsorship areas styles can be modified by writing custom CSS using the WordPress CSS. customizer.
