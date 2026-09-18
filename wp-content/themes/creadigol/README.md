# Creadigol WordPress theme

A custom theme for creadigol.design, built from the approved "amended B" design. No page
builder. One stylesheet, one script, two self-hosted fonts. Case studies are a **Work** post
type with a project-details form, so adding one is a form, not a page build.

## Install (three clicks)

1. **Appearance > Themes > Add New > Upload Theme**, choose `creadigol.zip`, Install.
2. **Activate.** Activation runs the first-run setup: it creates the Home, Studio, Contact and
   Journal pages, sets the static front page and posts page, builds the Primary and Footer
   menus, seeds the five disciplines, sets pretty permalinks if the site had none, renames
   the site title to "Creadigol", and **switches the holding page on**. Visitors see the
   holding page and showreel; you see the full site while logged in.
3. **Appearance > Creadigol setup**: press **Dry run** under "Migrate the old projects", check
   the list, then **Migrate now**. The old project posts become Work case studies.

The zip built by `tools/package-theme.sh` includes whatever fonts are in `assets/fonts/` at
the time (Druk and Supply from the current site are expected there; the Vulf Sans demo files
are never included). If you ever see 404s on `/work/`, open **Settings > Permalinks** and
press Save once.

## Holding page while you fill the site in

**Customise > Creadigol > Holding page > Show the holding page.** Visitors then see a single
page: the logo, the showreel, one line in each language, the email, and social links.
Logged-in users still see the full site, so you can build behind it. The film defaults to
the current showreel on YouTube and can be any YouTube, Vimeo or MP4 URL. Untick to launch.

## Logo

Drop two SVGs into `assets/img/`: `logo-light.svg` (for charcoal backgrounds: header,
footer, holding page) and `logo-dark.svg` (for light backgrounds). The theme inlines them
and sizes them by height. Without them it falls back to a Customizer custom logo, then to
the site name set in Druk with a lime tally.

## First-run setup (done for you on activation)

Activation does all of this. **Appearance > Creadigol setup > Run first-run setup** repeats it
and only adds what is missing. For reference:

1. **Pages.** Create `Studio` (default template), `Contact` (template: Contact), `Journal`
   (empty; used as the posts page). In **Settings > Reading** set "A static page", front page
   = any page named Home (content is ignored, the home template is driven by the Customizer),
   posts page = Journal.
2. **Menus.** **Appearance > Menus**: a "Primary" menu (Work, Studio, Journal, Contact) and a
   "Footer" menu, one per language if WPML is active. Until a menu is assigned the theme prints
   these four by default, translated on the Welsh side.
3. **Customizer.** **Appearance > Customise > Creadigol**: headline, showreel loop (MP4,
   under 8 MB) and full showreel link, client strip, statement, three services, call to action,
   contact details, social links, vedrí link, redirects. Every default is already filled in, in
   English; the Welsh side has its own defaults until WPML String Translation supplies yours.
4. **Site title** = `Creadigol`. The wordmark is the site title set in Druk with a lime tally.

## Adding a case study

**Work > Add case study.**

1. Title, and the Welsh title if it differs.
2. **Project details** box: client, year, summary in both languages, hero film (MP4 from the
   media library or a Vimeo/YouTube URL), tile loop (short muted MP4), tick "Show on the home
   page" for up to six, client quote, credits (`Role: Name` per line).
3. **Tile image** (featured image, 4:5): the poster for the loop and the fallback everywhere.
4. **Excerpt** = deliverables line ("Identity, idents, end boards, social toolkit, guidelines").
5. **Disciplines**: tick one or more.
6. Body: the editor opens with the case-study template (The ask, video, The idea, image pair,
   The system in motion). Use the **Creadigol case study** patterns for stat rows and quotes.
   Six block types are allowed; nothing else.
7. Publish. It appears on `/work/` immediately and on the home page if featured.

Order on the grid: **Order** field in Page Attributes (lower first), then newest.

## Migrating the old projects

The old site stored projects as posts in categories. **Appearance > Creadigol setup** has a
Dry run and a Migrate now button. With WP-CLI instead:

```
wp creadigol migrate-work --dry-run
wp creadigol migrate-work
```

Posts in `branding, motion, digital, content, ui, web, temp` become Work posts with disciplines
mapped from their categories. Then open each one and fill in Project details and a tile loop.
Either route does the same thing.

## Redirects

Old URLs 301 to their new homes. The map lives in **Customise > Creadigol > Redirects**
(one `old new` pair per line) and is pre-filled for every known old URL. Any old root-level
project URL whose slug still matches a Work post also redirects automatically.

## Bilingual: English site, Cymraeg tab

The site is English by default with an **English | Cymraeg** tab in the header that switches
to a full Welsh version. Every interface string runs through translation functions, and the
theme ships its own Welsh set in `inc/lang-cy.php`, applied whenever the site locale is
Welsh. So the Welsh side works with either translation plugin without a compiled `.mo`:

- **WPML** (already installed): add Welsh as a language, translate pages and Work posts as
  usual. `wpml-config.xml` registers the Work post type, disciplines, the project-details
  fields and the Customizer texts for translation. String Translation can override any
  interface string or Customizer text; untranslated Customizer texts fall back to the Welsh
  defaults in `inc/customizer.php`.
- **Polylang** works the same way; the header tab picks up whichever plugin is active.

Every case study also has *Title (Cymraeg)* and *Crynodeb (Cymraeg)* fields in Project
details. They are used on the Welsh side automatically, so a Welsh tile and summary exist
even before the full case study is translated.

To change any Welsh wording, edit the array in `inc/lang-cy.php` or use WPML String
Translation. The strings shipped were drafted by the build and should be checked by a
Welsh speaker before launch.

## Performance

The theme sends one CSS file, one deferred JS file and two fonts. It removes emoji and
oEmbed scripts and drops jQuery on the front end unless a plugin needs it. To get the full
benefit after switching:

- Deactivate and delete **Elementor**, Elementor Pro and the Hello theme.
- Keep a caching plugin (or host-level caching) and a CDN.
- Serve loops as MP4 (H.264) under 3 MB; the theme lazy-loads them and plays on hover.
- Replace YouTube embeds in case studies with self-hosted MP4 or Vimeo where possible.

## Development

`tools/preview/render.php <template>` renders any template with sample content and no
database, for checking layout. `tools/package-theme.sh` builds `creadigol.zip`.
