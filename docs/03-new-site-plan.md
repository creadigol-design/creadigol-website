# Plan: the new Creadigol site

Working name: **Creadigol** (dropping "Design"). Domain stays creadigol.design unless a new
domain is chosen; the plan below works either way.

## 1. Goals

1. Make the work the site. Ten or more video-led case studies at launch, with a
   structure that lets the studio add a new one in under 30 minutes without touching code.
2. One clear offer: branding and motion. vedrí linked as the sister studio.
3. Bilingual (Welsh / English) from day one.
4. Fast and crafted: custom type, hover video, page transitions, 90+ Lighthouse.

## 2. Site map

```
/                       Home (EN)            /cy/                Hafan (CY)
/work                   Work index           /cy/gwaith
/work/[slug]            Case study           /cy/gwaith/[slug]
/studio                 Studio (about)       /cy/stiwdio
/journal                Journal (notes)      /cy/dyddiadur
/journal/[slug]         Post                 /cy/dyddiadur/[slug]
/contact                Contact              /cy/cysylltu
```

Removed from the top level: Virtual Production (link to vedrí), R&D and Brand Up (become
Journal posts if still relevant), Services (folded into Home and Studio).

## 3. Case study content model

Every case study is one folder: a Markdown file plus its media. Fields:

| Field | Type | Required |
| --- | --- | --- |
| title / teitl | text (EN, CY) | yes |
| client | text | yes |
| year | number | yes |
| disciplines | multi-select: Branding, Motion, Broadcast, Digital, Campaign | yes |
| sector | select: Broadcast, Sport, Culture, Public, Commercial | no |
| summary / crynodeb | one sentence (EN, CY) | yes |
| hero | video (mp4/webm loop or Vimeo/Stream ID) or image | yes |
| tile | 4:5 loop or still for the grid | yes |
| body | rich text blocks: text, full-bleed video, image, image pair, quote, stat row | yes |
| credits | list of role + name | no |
| featured | boolean (shows on Home) | no |
| order | number | no |

Body blocks are deliberately few. Six block types cover every reference case study we
looked at and keep pages consistent.

## 4. Stack (decided: WordPress, custom theme)

The studio chose to stay on WordPress. The site is a **custom theme** built for the design,
with no page builder. It lives in `wp-content/themes/creadigol/` in this repository.

| Layer | Choice | Why |
| --- | --- | --- |
| Platform | WordPress 6.4+, custom theme, block editor | Familiar admin, existing hosting and WPML, no rebuild of the CMS |
| Case studies | `work` post type + `discipline` taxonomy + a Project details meta box | A case study is a form: client, year, bilingual summary, hero film, tile loop, quote, credits |
| Body content | Block editor limited to six block types, with a pre-filled template and patterns | Every case study follows the same structure |
| Site copy | Customizer panel "Creadigol" | Headlines, showreel, client strip, services, contact details, redirects, all editable without code |
| Front end | One CSS file, one deferred JS file, two self-hosted fonts (Druk, Supply), system sans for body | Six font families down to two; Elementor's 30 stylesheets and 23 scripts gone |
| Video | Self-hosted MP4 loops for tiles (hover to play, lazy loaded); MP4 or Vimeo/YouTube for hero films | No autoplay embeds on the home page |
| Bilingual | WPML (already installed) or Polylang; Welsh title and summary fields on every case study | Language switch in the header picks up whichever plugin is active |
| Forms | Built-in contact handler (nonce, honeypot, wp_mail) | No form plugin |
| Migration | `wp creadigol migrate-work` converts the old project posts; redirect map in the Customizer | Old URLs keep working |

Adding a case study: **Work > Add case study**, fill the form, drop in the loop and the tile
image, tick "Show on the home page", publish. Full steps in the theme README.

## 5. Design direction (see mockups)

**Chosen: amended Direction B**, after the council review (see `04-council-review.md`).
Broadcast personality with three changes: off-white as a third colour (charcoal only for the
reel and the closing call to action), the reel behind the headline with the work pulled up
under it, and the Welsh-first headline pairing with plain bilingual labels. The build
reference set (home, mobile, work, case study, studio, contact, editor) is on the first page
of the mockup canvas and in `design/previews/`.

### The five directions reviewed


Five home-page directions, same content on each so the comparison is fair. **Decided:
lime #D1DF5F and charcoal #2E2E2E stay, so existing brand material carries over. Druk stays
as the headline face** and Supply as the label face; the mockups use the studio's own
webfonts. Body copy drops Poppins for one workhorse sans, cutting the font families loaded
from six to three. The directions differ in layout and personality, not colour.

| | Direction | In one line | Risk |
| --- | --- | --- | --- |
| A | Evolution | Off-white shell, lime accent, video-led work grid | Least change; may read as a refresh |
| B | Broadcast | Charcoal, full-bleed reel, lower-thirds, lime ticker, uppercase Druk | Dark and lime sits close to vedrí |
| C | Swiss grid, Welsh-first | White, visible 12-column grid, CY and EN side by side, work as an index | Colder, less filmic |
| D | Kinetic | Lime, charcoal and grey blocks, rounded media, pill nav | Reads younger than broadcast clients may expect |
| E | Multiview (new) | Home page as a gallery monitor wall of live project feeds, lime caption | Needs real loops from day one |

Shared across all five: hover loops on tiles, scroll reveals from a visible resting state,
page transitions, bilingual eyebrow labels and a CY/EN switch. Direction A is shown carried
through the whole site (mobile, work, case study, studio, contact, editor); the chosen
direction gets the same set.

## 6. Launch content checklist

- 10 case studies. Known candidates: Rownd a Rownd (Rondo Media), Pen Petrol S1–2,
  Menai Track & Field, plus BBC Sport, Cwmni Da and Nimble projects to be written up.
- Showreel (60–90 seconds) for the home hero.
- Studio page: founder story (S4C / BBC Sport background), team, awards (UK StartUp Awards
  2025 finalist, Media Cymru seed fund), sister studio vedrí.
- Welsh translations of all core pages and case study summaries.
- Contact details, social links, legal pages.

## 7. Migration and rebrand

- Keep every existing URL alive with 301 redirects to the new structure
  (for example `/rar-rebrand-rondo-media/` → `/work/rownd-a-rownd`).
- Update name to "Creadigol" in titles, schema.org Organization, Open Graph, footer, and
  social bios in one pass.
- Publish a short Journal post: "Creadigol Design is now Creadigol" (as Further did).

## 8. Build phases (after approval)

| Phase | Scope | Status |
| --- | --- | --- |
| 1 | Theme: Work post type, project details, Customizer, templates, styles, scripts, redirects, contact form, CLI migration | Done, in `wp-content/themes/creadigol/` |
| 2 | Install on staging, fonts in place, menus and pages set, `wp creadigol migrate-work`, remove Elementor | Studio, with the README |
| 3 | Content: six existing case studies filled in with loops; BBC Sport, Cwmni Da and Nimble written up; showreel; Welsh translations | Studio |
| 4 | Performance and accessibility check on staging, then switch the domain | Next session |

## 9. Decisions needed

1. Decided: amended B. Confirm the build reference set.
2. Decided: WordPress custom theme.
3. Domain: stay on creadigol.design or move.
4. Decided: lime and charcoal stay; Druk stays. Open: does the "design" script in the lockup go with the name?
5. Which 10 projects launch, and which have video.
