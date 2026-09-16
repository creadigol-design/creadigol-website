# Creadigol website

Planning and build repository for the new Creadigol site (formerly Creadigol Design).

## Status

**Planning, awaiting approval.** No site code yet.

| Document | What it is |
| --- | --- |
| [docs/01-audit-current-site.md](docs/01-audit-current-site.md) | Audit and score of creadigol.design as of September 2026 |
| [docs/02-benchmark-studios.md](docs/02-benchmark-studios.md) | How DixonBaxi, Further, Already Been Chewed and others present work |
| [docs/03-new-site-plan.md](docs/03-new-site-plan.md) | Site map, case study content model, stack, migration, build phases |
| [docs/report/creadigol-site-plan.html](docs/report/creadigol-site-plan.html) | The three above as one approval page |
| [design/mockups/](design/mockups/) | Mockup artboards (`*.dc.html`): `build.py` writes Direction A and the full page set, `directions.py` writes Directions B–E, `canvas.json` lays them out |
| [design/previews/](design/previews/) | Rendered PNG of every board and a gallery page |

Mockups for approval (editable canvas): https://claude.ai/artifact/UeqE7JxnmPMJXCfFiPQWgi

`design/previews/` holds rendered PNGs of every board plus `index.html`, a scrolling gallery of them.

## Regenerating the mockups

```
cd design/mockups && python3 build.py && python3 directions.py
```
