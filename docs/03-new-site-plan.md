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
/journal                Journal (notes)      /cy/dyddlyfr
/journal/[slug]         Post                 /cy/dyddlyfr/[slug]
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

## 4. Stack recommendation

**Astro 5 + Keystatic CMS + Cloudflare Pages.** Chosen over Webflow/Framer because the
studio already runs its sites from GitHub and works with Claude Code, and over WordPress
because performance and craft are the point.

| Layer | Choice | Why |
| --- | --- | --- |
| Framework | Astro (static output, content collections) | Fast by default, Markdown-native, i18n routing built in |
| Editing | Keystatic (GitHub mode) at `/keystatic` | A form-based editor that writes Markdown and images straight to the repo. No database. Works alongside editing files directly or with Claude Code |
| Motion | GSAP or Motion One + View Transitions API | Page transitions and hover loops without a heavy framework |
| Video | Cloudflare Stream (or Vimeo Pro) for case study films; self-hosted short muted loops (<3 MB) for tiles | Adaptive playback, no YouTube chrome |
| Hosting | Cloudflare Pages | Free tier, global CDN, preview URLs per branch, supports the Keystatic admin |
| Forms | Cloudflare Pages Functions → email (Resend) | No third-party form widget |
| Analytics | Plausible or Cloudflare Web Analytics | No cookie banner needed |

Two ways to add a case study, both valid:

1. **Browser:** open `/keystatic`, "New case study", fill the form, drop in media, Save.
   A pull request or direct commit is created; the site rebuilds in about a minute.
2. **Files:** add `src/content/work/<slug>/index.md` and media, push. Same result.

## 5. Design direction (see mockups)

- **Paper & signal.** Cool off-white ground, near-black ink, one signal colour (broadcast
  tally red) used sparingly. Work carries the colour; the shell stays quiet.
- **Type.** Archivo across its width axis: wide-and-heavy for headlines, normal for body.
  IBM Plex Mono for bilingual eyebrows, metadata and captions.
- **Motion.** Tiles play muted loops on hover; headlines and media reveal on scroll from a
  visible resting state; page transitions between work index and case study.
- **Bilingual cues.** Eyebrow labels carry both languages ("Gwaith / Work"); a CY/EN switch
  in the header swaps the whole page.

The palette is a proposal. If Creadigol has existing brand colours and a logo, they
replace it and the layouts stay the same.

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

| Phase | Scope | Duration |
| --- | --- | ---: |
| 1 | Astro scaffold, design tokens, layouts, Keystatic schema, i18n routing | 1 week |
| 2 | Home, Work index, Case study template, Studio, Contact, Journal | 1–2 weeks |
| 3 | Content entry (10 case studies, translations, reel), video pipeline | studio-side, parallel |
| 4 | Motion pass, performance and accessibility audit, redirects, launch | 1 week |

## 9. Decisions needed

1. Approve the direction (mockup A) or pick an alternate (B or C).
2. Confirm the stack (Astro + Keystatic + Cloudflare Pages) or prefer Webflow/Framer.
3. Domain: stay on creadigol.design or move.
4. Do existing brand assets (logo, colours, type) exist to be applied?
5. Which 10 projects launch, and which have video.
