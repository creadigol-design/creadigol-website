# Audit: creadigol.design (September 2026)

**Provisional score: 54 / 100**

## How this was assessed

The site could not be rendered from the build environment (the network policy blocks
creadigol.design, so no screenshots or Lighthouse run were possible). This audit is built
from the site's indexed pages, titles, URL structure, publication dates and copy as
surfaced by search, plus public coverage of the studio. Two categories (visual craft and
performance) are therefore estimates and are flagged as such. Allowing the domain in the
environment's network settings, or sharing screenshots, would let those two be scored
properly.

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

Platform signals: WordPress-style permalinks, default " - Creadigol Design" title suffix on
posts, SEO-plugin style pipe-delimited page titles.

## Scorecard

| Area | Weight | Score | Confidence | Why |
| --- | ---: | ---: | --- | --- |
| Positioning & brand clarity | 15 | 8 | High | "Where branding meets motion" is a clear idea, but the site also sells Virtual Production, R&D and Brand Up. Three offers under one roof dilutes the studio story. Name already inconsistent ("Creadigol Design" vs "Creadigol") across titles. |
| Work & proof | 20 | 8 | High | Three indexed case studies against claims of BBC Sport, Cwmni Da, Rondo and Nimble. For a portfolio-led studio, this is the biggest gap. No evidence of video-led case studies for a motion studio. |
| Copy & content | 10 | 5 | High | Page titles are written for search engines, not people ("Branding Agency Portfolio \| Work \| Creadigol Design"). Blog last updated June 2025. Award news (UK StartUp Awards 2025 finalist) is under-used. |
| Information architecture | 10 | 5 | High | Nine top-level destinations for a small studio. Case studies sit at the root with no `/work/` prefix; blog posts mix flat and category URLs. |
| Visual design & motion craft | 20 | 11 | **Low (not viewed)** | Estimated from platform signals only. A WordPress theme is unlikely to deliver the full-bleed video, custom type and page transitions the reference studios use. To be re-scored with screenshots. |
| Performance & tech | 10 | 5 | **Low (not measured)** | Lighthouse could not be run. WordPress + page builder sites in this sector typically land 40–70 mobile performance. To be re-scored. |
| SEO & findability | 10 | 7 | Medium | Pages are indexed and titled; ranking for "Creadigol" is solid. Titles are over-optimised and URL structure is inconsistent. |
| Bilingual & accessibility | 5 | 1 | High | The studio sells bilingual work, but no Welsh-language pages are indexed (no `/cy/` routes). |
| **Total** | **100** | **54** | | |

## Top issues, in priority order

1. **Proof gap.** Three case studies. The homepage promise (BBC Sport, Cwmni Da, Nimble) is not backed by pages. Every new site decision should make adding a case study trivial so this never happens again.
2. **Diluted offer.** Virtual Production now has its own brand (vedrí). The Creadigol site should link to it as a sister studio, not host it. Retire or fold R&D and Brand Up into the Journal.
3. **No bilingual site.** For a studio positioned on Welsh-language work, a `/cy/` mirror of core pages is a differentiator none of the global references have.
4. **Search-engine copy.** Titles, headings and slugs should read like the studio talks.
5. **Stale journal.** Last post is 15 months old. Either commit to a cadence or make the journal a low-volume "Notes" section that does not look abandoned.
6. **Name change.** Rebrand to "Creadigol" means every title, footer, schema.org entry and social handle should be updated in one pass, with 301s for any URL that changes.

## What would move the score

| Change | Estimated gain |
| --- | ---: |
| 8–12 video-led case studies with a consistent structure | +12 |
| Single clear offer (branding + motion), vedrí as sister link | +6 |
| Welsh/English bilingual routes | +5 |
| Purpose-built front end (fast, custom type, motion) | +10 (once verified) |
| Human copy, clean URL structure, redirects | +5 |
