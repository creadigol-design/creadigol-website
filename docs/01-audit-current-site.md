# Audit: creadigol.design (September 2026)

**Score: 48 / 100**

## How this was assessed

Pages were fetched and rendered through the environment's proxy on 16 September 2026
(home, work, six project pages, services, contact, journal), with stylesheets, fonts and
image weights measured directly. Lighthouse could not be run (Google's public PageSpeed
quota was exhausted and the site cannot be loaded in the sandbox's Chrome), so performance
is scored from measured response times and payload rather than a lab score.

## What the site is built with

| | Finding |
| --- | --- |
| Platform | WordPress 6.7.2, Elementor 3.27.5, Hello Elementor theme with child theme, WPML language switcher (English only), Jetpack stats, reCAPTCHA, cookie banner |
| Typefaces | Druk Web Bold (headings, 136px hero and 32px), Supply (mono labels, nav, footer), Poppins (body, weight 300), plus Sawton Bauhaus, N27 and Roboto also loaded: six families |
| Colours | Primary and text #2E2E2E, secondary lime #D1DF5F, accent #DADADA, black and white |
| Home | Lime hero, greyscale image mosaic with hover labels, YouTube autoplay embed, dark "What we do" band, lime "Let us help you build your brand" band, footer with giant Druk wordmark |
| Work | Six projects in a three-column grid: Codi'r To, Self Storage Booker, "Esteddfod" (sic), RaR Rebrand Rondo Media, Pen Petrol, Menai Track and Field Website. A "temp" category tag is visible on one card |
| Case study | Long single column, small body text, lime section labels on white, YouTube embeds, sketch and social imagery, client quote set in Druk, "View more work" |

## Inventory of what is live

| URL | Page | Notes |
| --- | --- | --- |
| `/` | Home — "Creadigol Design \| Branding & Design Studio \| Home" | Positioning: "where Branding meets Motion" |
| `/work/` | "Branding Agency Portfolio \| Work" | Only 3 project pages are indexed |
| `/rar-rebrand-rondo-media/` | Rownd a Rownd rebrand (Rondo Media) | Case study |
| `/pen-petrol-rondo-media/` | Pen Petrol titles & programme graphics S1–2 | Case study |
| `/menaitrackandfieldwebsite/` | Menai Track & Field website | Case study |
| `/branding-design-services/` | Services | Brand strategy & identity, motion, UX/UI & web |
| `/latest/` | Blog | Latest post June 2025 (VEDRI at Aria Studios) |
| `/virtual-production/` | Virtual Production | Now a separate brand (vedrí) |
| `/rnd/` | R&D | Media Cymru seed-funded project |
| `/what-is-brand-up/` | Brand Up | Feb 2024 initiative |
| `/contact-us/` | Contact | "friendly and bilingual team" |
| `/design/5-qualities-of-a-great-graphic-designer/` | Blog post | Category-prefixed URL |
| `/how-to-launch-a-logo/`, `/automation-from-google-docs-...` | Blog posts | Flat URLs |

Also live: `/codir-to/`, `/esteddfod/`, `/self-storage-booker/` (project pages not surfaced by search), and `/category/temp/`.

## Scorecard

| Area | Weight | Score | Why |
| --- | ---: | ---: | --- |
| Positioning & brand clarity | 15 | 8 | "Where branding meets motion" is clear, and the lime, charcoal and Druk identity is distinctive and consistently applied. But the site also sells Virtual Production, R&D and Brand Up, and the name is already inconsistent ("Creadigol Design" vs "Creadigol"). |
| Work & proof | 20 | 9 | Six projects, all real and mostly local. Nothing from BBC Sport, Cwmni Da or Nimble, the names used to sell the studio. No video on the work grid; case study films are YouTube embeds. |
| Copy & content | 10 | 4 | "Motion-lead" for "Motion-led", "Esteddfod" for "Eisteddfod", "rebrand for to celebrate", a "temp" tag on a live card, an H1 that runs the studio name into the headline. Journal last updated June 2025. |
| Information architecture | 10 | 5 | Nine destinations for a small studio. Project pages sit at the root with no /work/ prefix; blog posts mix flat and category URLs; the language switcher offers only English. |
| Visual design & motion craft | 20 | 11 | The identity is strong: Druk at scale, lime against charcoal, mono labels. The layout underneath is stock Elementor: centred hero text, square tiles, uneven whitespace on the case study, small low-contrast body text, and no reel on the home page of a motion studio. |
| Performance & tech | 10 | 3 | Time to first byte 1.5–3.2 s across pages. Home page loads 30 stylesheets (1.3 MB), 23 scripts (0.44 MB), six font families and a YouTube autoplay embed; sampled images across three pages total 6 MB. |
| SEO & findability | 10 | 7 | Indexed and ranking for the name. Titles written for search engines, inconsistent slugs, stray "temp" category pages indexed. |
| Bilingual & accessibility | 5 | 1 | WPML is installed but only English exists. Lime text on white and 300-weight body copy fail contrast. |
| **Total** | **100** | **48** | |

## Top issues, in priority order

1. **Proof gap.** Six case studies, none from the broadcast clients the studio is known for. The homepage promise (BBC Sport, Cwmni Da, Nimble) is not backed by pages. Every new site decision should make adding a case study trivial so this never happens again.
2. **Diluted offer.** Virtual Production now has its own brand (vedrí). The Creadigol site should link to it as a sister studio, not host it. Retire or fold R&D and Brand Up into the Journal.
3. **No bilingual site.** For a studio positioned on Welsh-language work, a `/cy/` mirror of core pages is a differentiator none of the global references have.
4. **Search-engine copy.** Titles, headings and slugs should read like the studio talks.
5. **Stale journal.** Last post is 15 months old. Either commit to a cadence or make the journal a low-volume "Notes" section that does not look abandoned.
6. **Name change.** Rebrand to "Creadigol" means every title, footer, schema.org entry and social handle should be updated in one pass, with 301s for any URL that changes.

## What would move the score

| Change | Estimated gain |
| --- | ---: |
| 10 or more video-led case studies including BBC Sport, Cwmni Da and Nimble | +11 |
| Single clear offer (branding + motion), vedrí as sister link | +6 |
| Welsh/English bilingual routes | +5 |
| Purpose-built front end: static build, two font families, no page builder | +12 |
| Human copy, fixed typos, clean URL structure, redirects | +6 |
