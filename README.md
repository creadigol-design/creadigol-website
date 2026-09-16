# Creadigol website

Planning and build repository for the new Creadigol site (formerly Creadigol Design).

## Status

**Direction chosen: amended B.** Build reference mockups done; awaiting final confirmation before the Astro build starts. No site code yet.

| Document | What it is |
| --- | --- |
| [docs/01-audit-current-site.md](docs/01-audit-current-site.md) | Audit and score of creadigol.design as of September 2026 (48/100) |
| [docs/audit-evidence/](docs/audit-evidence/) | Renders of the live site used for the audit |
| [docs/02-benchmark-studios.md](docs/02-benchmark-studios.md) | How DixonBaxi, Further, Already Been Chewed and others present work |
| [docs/03-new-site-plan.md](docs/03-new-site-plan.md) | Site map, case study content model, stack, migration, build phases |
| [docs/04-council-review.md](docs/04-council-review.md) | Eight-reviewer ranking of the five directions and the recommendation |
| [docs/report/creadigol-site-plan.html](docs/report/creadigol-site-plan.html) | The three above as one approval page |
| [design/mockups/](design/mockups/) | Mockup artboards (`*.dc.html`): `build.py` writes Direction A and the full page set, `directions.py` writes Directions B–E, `canvas.json` lays them out |
| [design/previews/](design/previews/) | Rendered PNG of every board and a gallery page |

Mockups for approval (editable canvas): https://claude.ai/artifact/UeqE7JxnmPMJXCfFiPQWgi

Gallery of every board as images: https://claude.ai/artifact/HgqRYtzQHE97gEtNncTEJa

`design/previews/` holds the rendered PNGs plus `index.html`, the gallery page. The mockup artboards embed the studio's licensed Druk and Supply webfonts, so the generated `*.dc.html` files and `design/fonts/*.woff2` are git-ignored; see `design/fonts/README.md`.

## Regenerating the mockups

```
cd design/mockups
THEME=A python3 build.py      # Direction A pages
THEME=B python3 build.py      # amended-B inner pages
python3 directions.py         # directions B–E home pages
python3 amendedb.py           # amended-B home, desktop and mobile
```
