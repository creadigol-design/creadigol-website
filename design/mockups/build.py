#!/usr/bin/env python3
"""Generates the .dc.html artboards for the Creadigol site mockups."""
import os, json
OUT = os.path.dirname(os.path.abspath(__file__))

INK, PAPER, MID, LINE, TALLY = "#2E2E2E", "#F4F5F2", "#6B7076", "#D9DCD6", "#D1DF5F"
FONTCSS = open(os.path.join(OUT, "fonts.css")).read()
TONES = ["#1B1F24", "#2E3A45", "#5B6B7A", "#C8CDC4", "#E7E4D8", "#F2401E", "#3D4A3A", "#8A93A0"]

HEAD = """<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <script src="./support.js"></script>
</head>
<body>
<x-dc>
<helmet>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,62..125,100..900&amp;family=IBM+Plex+Mono:wght@400;500&amp;display=swap">
  <style>
    %(fontcss)s
    body { margin: 0; background: %(bg)s; color: %(fg)s; font-family: Archivo, 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.5; }
    a { color: inherit; text-decoration: none; } a:hover { color: #F2401E; }
    .mono { font-family: Supply, 'IBM Plex Mono', ui-monospace, Menlo, monospace; font-size: 12px; letter-spacing: 0.06em; text-transform: uppercase; line-height: 1.4; }
    .display { font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0; line-height: 0.92; text-wrap: balance; margin: 0; }
    .h2 { font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0; line-height: 1; margin: 0; }
    .wordmark { font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0.01em; text-transform: uppercase; }
    .body-l { font-size: 22px; line-height: 1.4; font-weight: 400; margin: 0; }
    .rule { border-top: 1px solid %(line)s; }
    .hatch { background-image: repeating-linear-gradient(135deg, rgba(255,255,255,0.05) 0 2px, transparent 2px 14px); }
  </style>
</helmet>
"""
FOOT = """</x-dc>
</body>
</html>
"""

def head(bg=PAPER, fg=INK, line=LINE):
    return HEAD % {"bg": bg, "fg": fg, "line": line, "fontcss": FONTCSS}

PLAY = """<svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="36" cy="36" r="35" stroke="#F4F5F2" stroke-width="1.5"></circle><path d="M29 24 L48 36 L29 48 Z" fill="#F4F5F2"></path></svg>"""
ARROW = """<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10 H16 M11 5 L16 10 L11 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>"""
ARROW_BIG = """<svg width="48" height="48" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10 H16 M11 5 L16 10 L11 15" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path></svg>"""
MENU = """<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 7 H21 M3 12 H21 M3 17 H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg>"""
GRID_ICON = """<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="1" width="6.5" height="6.5" stroke="currentColor" stroke-width="1.3"></rect><rect x="10.5" y="1" width="6.5" height="6.5" stroke="currentColor" stroke-width="1.3"></rect><rect x="1" y="10.5" width="6.5" height="6.5" stroke="currentColor" stroke-width="1.3"></rect><rect x="10.5" y="10.5" width="6.5" height="6.5" stroke="currentColor" stroke-width="1.3"></rect></svg>"""
LIST_ICON = """<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 4 H17 M1 9 H17 M1 14 H17" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"></path></svg>"""

def lang_toggle(active="EN", dark=False):
    fg = PAPER if dark else INK; bg = INK if dark else PAPER
    def seg(l):
        on = l == active
        return f'<span style="padding: 8px 12px; background: {fg if on else "transparent"}; color: {bg if on else fg};">{l}</span>'
    return f'<div class="mono" style="display: flex; border: 1px solid {fg}; border-radius: 999px; overflow: hidden;">{seg("EN")}{seg("CY")}</div>'

def nav(dark=False, active=None):
    fg = PAPER if dark else INK; bg = INK if dark else PAPER
    links = ""
    for l in ["Work", "Studio", "Journal", "Contact"]:
        style = f"border-bottom: 2px solid {TALLY}; padding-bottom: 2px;" if l == active else ""
        links += f'<a href="#" style="font-size: 15px; font-weight: 500; {style}">{l}</a>'
    return f"""
<header style="display: flex; align-items: center; justify-content: space-between; padding: 28px 48px; color: {fg};">
  <a href="#" class="wordmark" style="font-size: 28px;">Creadigol</a>
  <nav style="display: flex; gap: 40px;">{links}</nav>
  <div style="display: flex; gap: 12px; align-items: center;">
    {lang_toggle("EN", dark)}
    <a href="#" style="padding: 12px 18px; background: {fg}; color: {bg}; border-radius: 999px; font-weight: 600; font-size: 14px;">Start a project</a>
  </div>
</header>"""

def media(w, h, tone, label, play=False, radius=4, loop=True):
    tag = "LOOP" if loop else "STILL"
    light = tone in ("#C8CDC4", "#E7E4D8")
    fg = INK if light else PAPER
    return f"""
<div class="hatch" style="position: relative; width: {w}; height: {h}px; background: {tone}; border-radius: {radius}px; display: flex; align-items: center; justify-content: center; color: {fg}; overflow: hidden;">
  <div class="mono" style="position: absolute; top: 16px; left: 16px; opacity: 0.75;">[{tag}] {label}</div>
  {PLAY if play else ""}
</div>"""

def tile(w, h, tone, client, title, tags, year="[YEAR]", label=None):
    return f"""
<a href="#" style="display: flex; flex-direction: column; gap: 14px; width: {w};">
  {media("100%", h, tone, label or title)}
  <div style="display: flex; justify-content: space-between; align-items: baseline; gap: 24px;">
    <div style="display: flex; flex-direction: column; gap: 4px;">
      <span class="mono" style="color: {MID};">{client} · {year}</span>
      <span style="font-size: 22px; font-weight: 600; letter-spacing: -0.01em;">{title}</span>
    </div>
    <span class="mono" style="color: {MID}; text-align: right;">{tags}</span>
  </div>
</a>"""

def footer(dark=False):
    fg = PAPER if dark else INK; bg = INK if dark else PAPER; line = "#2A2E33" if dark else LINE
    return f"""
<footer style="padding: 64px 48px 40px; background: {bg}; color: {fg}; display: flex; flex-direction: column; gap: 56px;">
  <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 32px;">
    <div style="display: flex; flex-direction: column; gap: 12px;">
      <span class="wordmark" style="font-size: 28px;">Creadigol</span>
      <span style="color: {MID}; font-size: 15px;">Branding &amp; motion studio<br>Bangor, Gwynedd, Cymru</span>
    </div>
    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 15px;"><span class="mono" style="color: {MID};">Gwefan</span><a href="#">Work</a><a href="#">Studio</a><a href="#">Journal</a><a href="#">Contact</a></div>
    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 15px;"><span class="mono" style="color: {MID};">Dilyn / Follow</span><a href="#">Instagram</a><a href="#">LinkedIn</a><a href="#">Vimeo</a></div>
    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 15px;"><span class="mono" style="color: {MID};">Stiwdio chwaer / Sister studio</span><a href="#" style="display: flex; gap: 8px; align-items: center;">vedrí — virtual production {ARROW}</a></div>
  </div>
  <div class="mono" style="display: flex; justify-content: space-between; color: {MID}; border-top: 1px solid {line}; padding-top: 20px;">
    <span>© 2026 Creadigol</span><span>Cymraeg · Privacy · Accessibility</span>
  </div>
</footer>"""

def eyebrow(cy, en, color=MID):
    return f'<div class="mono" style="display: flex; gap: 20px; color: {color};"><span>{cy}</span><span style="opacity: 0.5;">/</span><span>{en}</span></div>'

# ---------------------------------------------------------------- HOME
def home():
    work_tiles = f"""
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 40px;">
  <div style="display: flex; justify-content: space-between; align-items: baseline;">
    {eyebrow("Gwaith dethol", "Selected work")}
    <a href="#" class="mono" style="display: flex; gap: 8px; align-items: center;">All work {ARROW}</a>
  </div>
  <div style="display: grid; grid-template-columns: 7fr 5fr; gap: 48px; align-items: start;">
    {tile("100%", 520, TONES[0], "Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", label="Rownd a Rownd idents")}
    <div style="padding-top: 120px;">{tile("100%", 400, TONES[3], "Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics", label="Pen Petrol title sequence")}</div>
  </div>
  <div style="display: grid; grid-template-columns: 5fr 7fr; gap: 48px; align-items: start;">
    <div style="padding-top: 80px;">{tile("100%", 400, TONES[2], "Menai Track &amp; Field", "Club website", "Digital · Identity refresh", label="Menai T&amp;F site")}</div>
    {tile("100%", 520, TONES[1], "BBC Sport", "[Project title]", "Motion · Broadcast", label="BBC Sport project")}
  </div>
</section>"""
    services = "".join(f"""
    <div style="display: flex; flex-direction: column; gap: 16px; border-top: 1px solid {LINE}; padding-top: 24px;">
      <h3 class="h2" style="font-size: 32px;">{t}</h3>
      <p style="margin: 0; color: {MID}; font-size: 17px; line-height: 1.5;">{d}</p>
    </div>""" for t, d in [
        ("Brand identity &amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        ("Motion &amp; animation", "Idents, title sequences, programme graphics, social and explainer animation from a sports-broadcast background."),
        ("Digital &amp; web", "Fast, bilingual websites and digital brand tools that carry the identity into every screen."),
    ])
    return head() + nav() + f"""
<section style="padding: 56px 48px 40px; display: flex; flex-direction: column; gap: 44px;">
  <div class="mono" style="display: flex; gap: 28px; color: {MID};"><span>Stiwdio brandio a graffeg symud</span><span>Branding &amp; motion studio</span><span>Bangor, Gogledd Cymru</span><span>Est. 2022</span></div>
  <h1 class="display" style="font-size: 176px;">Brands built<br>to move.</h1>
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px; align-items: end;">
    <p class="body-l" style="font-size: 26px; max-width: 600px;">We design identities with motion at the core, from broadcast idents to whole brand systems. Bilingual, from North Wales, for brands anywhere.</p>
    <div class="mono" style="display: flex; justify-content: flex-end; gap: 12px; align-items: center; color: {MID};">Showreel 2026 · [00:00]</div>
  </div>
</section>
<section style="padding: 0 48px;">{media("100%", 756, INK, "Showreel 2026", play=True)}</section>
{work_tiles}
<section style="margin: 140px 0 0; padding: 120px 48px; background: {INK}; color: {PAPER}; display: flex; flex-direction: column; gap: 48px;">
  {eyebrow("Sut rydyn ni'n gweithio", "How we work", color="#8A93A0")}
  <p class="display" style="font-size: 84px; max-width: 1200px; font-stretch: 112%; font-weight: 700; line-height: 0.98;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
  <p class="body-l" style="max-width: 640px; color: #C8CDC4;">Before a colour or a typeface, we ask how a brand should move: how it enters a screen, how it holds a pause, how it leaves. Everything else follows.</p>
</section>
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 40px;">
  {eyebrow("Gwasanaethau", "What we do")}
  <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px;">{services}</div>
</section>
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 28px;">
  {eyebrow("Wedi gweithio gyda", "Worked with")}
  <div class="h2" style="display: flex; flex-wrap: wrap; gap: 20px 40px; font-size: 40px; color: {INK};"><span>BBC Sport</span><span>Rondo Media</span><span>Cwmni Da</span><span>Nimble</span><span>Menai Track &amp; Field</span></div>
</section>
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 32px;">
  <div style="display: flex; justify-content: space-between; align-items: baseline;">{eyebrow("Dyddiadur", "Journal")}<a href="#" class="mono" style="display: flex; gap: 8px; align-items: center;">All notes {ARROW}</a></div>
  <div style="display: flex; flex-direction: column;">
    <a href="#" style="display: grid; grid-template-columns: 160px 1fr 40px; gap: 32px; align-items: center; padding: 24px 0; border-top: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID};">[DATE]</span><span>Creadigol Design is now Creadigol</span>{ARROW}</a>
    <a href="#" style="display: grid; grid-template-columns: 160px 1fr 40px; gap: 32px; align-items: center; padding: 24px 0; border-top: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID};">Jun 2025</span><span>Behind the scenes: vedrí's first virtual production shoot at Aria Studios</span>{ARROW}</a>
    <a href="#" style="display: grid; grid-template-columns: 160px 1fr 40px; gap: 32px; align-items: center; padding: 24px 0; border-top: 1px solid {LINE}; border-bottom: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID};">2025</span><span>Finalist, UK StartUp Awards 2025: Creative StartUp of the Year, Wales</span>{ARROW}</a>
  </div>
</section>
<section style="padding: 140px 48px 120px; display: flex; flex-direction: column; gap: 40px;">
  {eyebrow("Cysylltu", "Get in touch")}
  <h2 class="display" style="font-size: 120px;">Got a brand that<br>needs to move?</h2>
  <div style="display: flex; gap: 16px; align-items: center;">
    <a href="#" style="padding: 18px 28px; background: {TALLY}; color: {INK}; border-radius: 999px; font-weight: 600; font-size: 17px;">Start a project</a>
    <a href="#" style="font-size: 20px; font-weight: 500; padding: 18px 8px;">[EMAIL]</a>
  </div>
</section>
{footer()}
""" + FOOT

# ---------------------------------------------------------------- HOME MOBILE
def home_mobile():
    def mtile(tone, client, title, tags, label):
        return f"""
<a href="#" style="display: flex; flex-direction: column; gap: 12px;">
  {media("100%", 420, tone, label)}
  <div style="display: flex; flex-direction: column; gap: 4px;">
    <span class="mono" style="color: {MID};">{client}</span>
    <span style="font-size: 20px; font-weight: 600;">{title}</span>
    <span class="mono" style="color: {MID};">{tags}</span>
  </div>
</a>"""
    return head() + f"""
<div style="width: 390px; display: flex; flex-direction: column;">
<header style="display: flex; align-items: center; justify-content: space-between; padding: 20px 20px;">
  <span class="wordmark" style="font-size: 22px;">Creadigol</span>
  <div style="display: flex; gap: 10px; align-items: center;">{lang_toggle()}<span style="display: flex; width: 44px; height: 44px; align-items: center; justify-content: center;">{MENU}</span></div>
</header>
<section style="padding: 32px 20px 24px; display: flex; flex-direction: column; gap: 24px;">
  <div class="mono" style="color: {MID}; display: flex; flex-direction: column; gap: 4px;"><span>Stiwdio brandio a graffeg symud</span><span>Branding &amp; motion · Bangor</span></div>
  <h1 class="display" style="font-size: 68px;">Brands built to move.</h1>
  <p class="body-l" style="font-size: 19px;">We design identities with motion at the core, from broadcast idents to whole brand systems. Bilingual, from North Wales, for brands anywhere.</p>
</section>
<section style="padding: 0 20px;">{media("100%", 197, INK, "Showreel", play=True)}</section>
<section style="padding: 72px 20px 0; display: flex; flex-direction: column; gap: 28px;">
  {eyebrow("Gwaith dethol", "Selected work")}
  {mtile(TONES[0], "Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", "Rownd a Rownd idents")}
  {mtile(TONES[3], "Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics", "Pen Petrol titles")}
  {mtile(TONES[2], "Menai Track &amp; Field", "Club website", "Digital", "Menai T&amp;F site")}
  <a href="#" class="mono" style="display: flex; gap: 8px; align-items: center; padding: 12px 0;">All work {ARROW}</a>
</section>
<section style="margin-top: 72px; padding: 64px 20px; background: {INK}; color: {PAPER}; display: flex; flex-direction: column; gap: 24px;">
  {eyebrow("Sut rydyn ni'n gweithio", "How we work", color="#8A93A0")}
  <p class="display" style="font-size: 38px; font-stretch: 112%; font-weight: 700; line-height: 1.02;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>
<section style="padding: 64px 20px 0; display: flex; flex-direction: column; gap: 24px;">
  {eyebrow("Gwasanaethau", "What we do")}
  <div style="display: flex; flex-direction: column; gap: 20px;">
    <div style="border-top: 1px solid {LINE}; padding-top: 16px;"><h3 class="h2" style="font-size: 24px;">Brand identity &amp; strategy</h3></div>
    <div style="border-top: 1px solid {LINE}; padding-top: 16px;"><h3 class="h2" style="font-size: 24px;">Motion &amp; animation</h3></div>
    <div style="border-top: 1px solid {LINE}; padding-top: 16px;"><h3 class="h2" style="font-size: 24px;">Digital &amp; web</h3></div>
  </div>
</section>
<section style="padding: 72px 20px 64px; display: flex; flex-direction: column; gap: 24px;">
  {eyebrow("Cysylltu", "Get in touch")}
  <h2 class="display" style="font-size: 52px;">Got a brand that needs to move?</h2>
  <a href="#" style="align-self: flex-start; padding: 16px 24px; background: {TALLY}; color: {INK}; border-radius: 999px; font-weight: 600; font-size: 16px;">Start a project</a>
</section>
<footer style="padding: 40px 20px 32px; background: {INK}; color: {PAPER}; display: flex; flex-direction: column; gap: 24px;">
  <span class="wordmark" style="font-size: 22px;">Creadigol</span>
  <div style="display: flex; flex-direction: column; gap: 8px; font-size: 15px;"><a href="#">Work</a><a href="#">Studio</a><a href="#">Journal</a><a href="#">Contact</a></div>
  <div style="display: flex; flex-direction: column; gap: 8px; font-size: 15px; color: #C8CDC4;"><a href="#">Instagram</a><a href="#">LinkedIn</a><a href="#">vedrí — sister studio</a></div>
  <span class="mono" style="color: {MID}; border-top: 1px solid #2A2E33; padding-top: 16px;">© 2026 Creadigol · Cymraeg</span>
</footer>
</div>
""" + FOOT

# ---------------------------------------------------------------- WORK INDEX
def work():
    chips = ""
    for i, (l, n) in enumerate([("All", ""), ("Branding", ""), ("Motion", ""), ("Broadcast", ""), ("Digital", ""), ("Campaign", "")]):
        on = i == 0
        chips += f'<a href="#" class="mono" style="padding: 10px 16px; border: 1px solid {INK}; border-radius: 999px; background: {INK if on else "transparent"}; color: {PAPER if on else INK};">{l}</a>'
    tiles = [
        (TONES[0], "Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", "Rownd a Rownd idents"),
        (TONES[3], "Rondo Media", "Pen Petrol S1–2", "Titles · Graphics", "Pen Petrol titles"),
        (TONES[1], "BBC Sport", "[Project title]", "Motion · Broadcast", "BBC Sport project"),
        (TONES[2], "Menai Track &amp; Field", "Club website", "Digital", "Menai T&amp;F site"),
        (TONES[6], "Cwmni Da", "[Project title]", "Branding · Motion", "Cwmni Da project"),
        (TONES[7], "Nimble", "[Project title]", "Motion", "Nimble project"),
    ]
    grid = "".join(tile("100%", 520, t, c, ti, ta, label=l) for t, c, ti, ta, l in tiles)
    return head() + nav(active="Work") + f"""
<section style="padding: 56px 48px 40px; display: flex; flex-direction: column; gap: 32px;">
  {eyebrow("Gwaith", "Work")}
  <div style="display: flex; justify-content: space-between; align-items: end; gap: 48px;">
    <h1 class="display" style="font-size: 140px;">Work</h1>
    <p class="body-l" style="max-width: 480px; color: {MID}; padding-bottom: 12px;">[N] projects across broadcast, sport, culture and the public sector. Every one built to move.</p>
  </div>
  <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid {LINE}; border-bottom: 1px solid {LINE}; padding: 16px 0;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">{chips}</div>
    <div style="display: flex; gap: 4px; color: {INK};"><span style="display: flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: {INK}; color: {PAPER}; border-radius: 4px;">{GRID_ICON}</span><span style="display: flex; width: 40px; height: 40px; align-items: center; justify-content: center; color: {MID};">{LIST_ICON}</span></div>
  </div>
</section>
<section style="padding: 24px 48px 120px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 64px 48px;">{grid}</section>
{footer()}
""" + FOOT

# ---------------------------------------------------------------- CASE STUDY
def case_study():
    def textblock(cy, en, body):
        return f"""
<section style="padding: 120px 48px 0; display: grid; grid-template-columns: 4fr 8fr; gap: 48px;">
  <div>{eyebrow(cy, en)}</div>
  <div style="display: flex; flex-direction: column; gap: 24px; max-width: 720px;">{body}</div>
</section>"""
    meta = "".join(f'<div style="display: flex; flex-direction: column; gap: 8px; border-top: 1px solid {LINE}; padding-top: 16px;"><span class="mono" style="color: {MID};">{k}</span><span style="font-size: 17px; font-weight: 500;">{v}</span></div>' for k, v in [
        ("Cleient / Client", "Rondo Media for S4C"), ("Blwyddyn / Year", "[YEAR]"), ("Disgyblaethau / Disciplines", "Rebrand · Motion · Broadcast graphics"), ("Allbynnau / Deliverables", "Identity, idents, end boards, social toolkit, guidelines")])
    credits = "".join(f'<div style="display: grid; grid-template-columns: 200px 1fr; gap: 24px; padding: 14px 0; border-top: 1px solid {LINE}; font-size: 16px;"><span class="mono" style="color: {MID}; padding-top: 3px;">{r}</span><span>{n}</span></div>' for r, n in [
        ("Creative direction", "Daniel Parry Evans"), ("Design &amp; motion", "Creadigol"), ("Producer (client)", "[NAME], Rondo Media"), ("Music / sound", "[NAME]")])
    return head() + nav(active="Work") + f"""
<section style="padding: 56px 48px 48px; display: flex; flex-direction: column; gap: 36px;">
  <div class="mono" style="display: flex; gap: 28px; color: {MID};"><span>Rondo Media</span><span>S4C</span><span>[YEAR]</span><span>Rebrand · Broadcast</span></div>
  <h1 class="display" style="font-size: 160px;">Rownd a Rownd</h1>
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px; align-items: end;">
    <p class="body-l" style="font-size: 26px;">A new identity and ident system for one of S4C's longest-running dramas, built to move across broadcast, iPlayer and social.</p>
  </div>
</section>
<section style="padding: 0 48px;">{media("100%", 756, TONES[0], "Hero film · Rownd a Rownd idents", play=True)}</section>
<section style="padding: 48px 48px 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 32px;">{meta}</section>
{textblock("Y briff", "The ask", f'<p class="body-l">Rondo Media asked us to revamp the branding for Rownd a Rownd: a programme with a loyal audience and decades of history, that needed to feel current without losing what viewers love.</p><p style="margin: 0; color: {MID}; font-size: 18px; line-height: 1.55;">[Two or three sentences on context, audience and constraints. Replace when the case study is written up.]</p>')}
<section style="padding: 72px 48px 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px;">
  {media("100%", 500, TONES[3], "Logo lockup, CY", loop=False)}
  {media("100%", 500, TONES[4], "Colour and type system", loop=False)}
</section>
{textblock("Y syniad", "The idea", f'<p class="body-l">[The one idea the identity is built on, and how it behaves in motion: how it enters, holds and leaves the screen.]</p>')}
<section style="padding: 72px 48px 0;">{media("100%", 756, TONES[1], "Ident system in motion", play=True)}</section>
<section style="padding: 120px 48px 0; display: grid; grid-template-columns: 4fr 8fr; gap: 48px;">
  <div>{eyebrow("Canlyniad", "Outcome")}</div>
  <blockquote style="margin: 0; display: flex; flex-direction: column; gap: 24px;">
    <p class="h2" style="font-size: 44px; line-height: 1.1;">“[Client quote about the result, one or two sentences.]”</p>
    <span class="mono" style="color: {MID};">[NAME], [ROLE], Rondo Media</span>
  </blockquote>
</section>
<section style="padding: 96px 48px 0; display: grid; grid-template-columns: 4fr 8fr; gap: 48px;">
  <div>{eyebrow("Credydau", "Credits")}</div>
  <div style="display: flex; flex-direction: column;">{credits}</div>
</section>
<section style="margin-top: 140px; padding: 0 48px 120px; display: flex; flex-direction: column; gap: 24px;">
  {eyebrow("Nesaf", "Next project")}
  <a href="#" style="display: grid; grid-template-columns: 5fr 7fr; gap: 48px; align-items: center;">
    <div style="display: flex; flex-direction: column; gap: 16px;"><span class="mono" style="color: {MID};">Rondo Media</span><span class="display" style="font-size: 88px;">Pen Petrol</span><span style="display: flex; align-items: center; gap: 8px; color: {INK};">{ARROW_BIG}</span></div>
    {media("100%", 440, TONES[3], "Pen Petrol title sequence")}
  </a>
</section>
{footer()}
""" + FOOT

# ---------------------------------------------------------------- STUDIO
def studio():
    beliefs = "".join(f'<div style="display: flex; flex-direction: column; gap: 14px; border-top: 1px solid {LINE}; padding-top: 24px;"><h3 class="h2" style="font-size: 30px;">{t}</h3><p style="margin: 0; color: {MID}; font-size: 17px;">{d}</p></div>' for t, d in [
        ("Motion first", "We decide how a brand moves before we decide how it looks."),
        ("Broadcast standards", "Idents, stings and graphics built to survive a live gallery, a phone and a stadium screen."),
        ("Dwyieithog / Bilingual", "Welsh and English are designed together, never translated afterwards."),
    ])
    team = "".join(f'<div style="display: flex; flex-direction: column; gap: 14px;">{media("100%", 400, t, n + " portrait", loop=False)}<div style="display: flex; flex-direction: column; gap: 2px;"><span style="font-size: 20px; font-weight: 600;">{n}</span><span class="mono" style="color: {MID};">{r}</span></div></div>' for t, n, r in [
        (TONES[2], "Daniel Parry Evans", "Founder &amp; creative director"), (TONES[3], "[NAME]", "[ROLE]"), (TONES[4], "[NAME]", "[ROLE]")])
    return head() + nav(active="Studio") + f"""
<section style="padding: 56px 48px 48px; display: flex; flex-direction: column; gap: 36px;">
  {eyebrow("Y stiwdio", "The studio")}
  <h1 class="display" style="font-size: 128px; max-width: 1300px;">A motion-first studio from North Wales.</h1>
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px;">
    <p class="body-l" style="font-size: 24px;">Creadigol was founded in 2022 by Daniel Parry Evans after [N] years in sports broadcast with S4C and BBC Sport. We bring that discipline to branding: identities designed to move, delivered in Welsh and English.</p>
  </div>
</section>
<section style="padding: 0 48px;">{media("100%", 640, TONES[1], "Studio photograph, Bangor", loop=False)}</section>
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 40px;">
  {eyebrow("Beth rydyn ni'n ei gredu", "What we believe")}
  <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px;">{beliefs}</div>
</section>
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 40px;">
  {eyebrow("Y tîm", "The team")}
  <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px;">{team}</div>
</section>
<section style="padding: 120px 48px 0; display: grid; grid-template-columns: 4fr 8fr; gap: 48px;">
  <div>{eyebrow("Cydnabyddiaeth", "Recognition")}</div>
  <div style="display: flex; flex-direction: column;">
    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 24px; padding: 18px 0; border-top: 1px solid {LINE}; font-size: 20px; font-weight: 500;"><span class="mono" style="color: {MID}; padding-top: 5px;">2025</span><span>Finalist, UK StartUp Awards: Creative StartUp of the Year, Wales</span></div>
    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 24px; padding: 18px 0; border-top: 1px solid {LINE}; border-bottom: 1px solid {LINE}; font-size: 20px; font-weight: 500;"><span class="mono" style="color: {MID}; padding-top: 5px;">[YEAR]</span><span>Media Cymru Seed Fund, virtual production R&amp;D</span></div>
  </div>
</section>
<section style="margin: 140px 48px 0; padding: 72px; background: #111118; color: {PAPER}; border-radius: 4px; display: grid; grid-template-columns: 7fr 5fr; gap: 48px; align-items: center;">
  <div style="display: flex; flex-direction: column; gap: 20px;">
    <span class="mono" style="color: #9FCC3B;">Stiwdio chwaer / Sister studio</span>
    <h2 class="display" style="font-size: 72px; font-stretch: 112%; font-weight: 700;">vedrí. Virtual production, Bangor.</h2>
    <p class="body-l" style="color: #C2C1C0; max-width: 520px;">Real-time multi-cam virtual production for broadcast, brands and Welsh-language producers. Creadigol's motion work plays straight onto the wall.</p>
    <a href="#" style="display: flex; gap: 8px; align-items: center; font-weight: 600;">Visit vedrí {ARROW}</a>
  </div>
  {media("100%", 320, "#2A2B2A", "vedrí stage", loop=False)}
</section>
<section style="padding: 140px 48px 120px; display: flex; flex-direction: column; gap: 32px;">
  {eyebrow("Gweithio gyda ni", "Work with us")}
  <h2 class="display" style="font-size: 104px;">Let's make something<br>that moves.</h2>
  <a href="#" style="align-self: flex-start; padding: 18px 28px; background: {TALLY}; color: {INK}; border-radius: 999px; font-weight: 600; font-size: 17px;">Start a project</a>
</section>
{footer()}
""" + FOOT

# ---------------------------------------------------------------- CONTACT
def contact():
    def field(label, placeholder, h=56):
        return f'<label style="display: flex; flex-direction: column; gap: 8px;"><span class="mono" style="color: {MID};">{label}</span><span style="display: flex; align-items: center; height: {h}px; padding: 0 16px; border: 1px solid {INK}; border-radius: 4px; color: {MID}; font-size: 16px;">{placeholder}</span></label>'
    chips = "".join(f'<span class="mono" style="padding: 12px 16px; border: 1px solid {INK}; border-radius: 999px; background: {INK if i == 1 else "transparent"}; color: {PAPER if i == 1 else INK};">{c}</span>' for i, c in enumerate(["Brand identity", "Motion", "Broadcast graphics", "Website", "Not sure yet"]))
    return head() + nav(active="Contact") + f"""
<section style="padding: 56px 48px 120px; display: grid; grid-template-columns: 6fr 6fr; gap: 96px;">
  <div style="display: flex; flex-direction: column; gap: 48px;">
    <div style="display: flex; flex-direction: column; gap: 28px;">
      {eyebrow("Cysylltu", "Contact")}
      <h1 class="display" style="font-size: 148px;">Let's<br>talk.</h1>
      <p class="body-l" style="font-size: 22px; max-width: 520px;">Tell us about the brand, the programme or the problem. We reply within [N] working days, in Welsh or English.</p>
    </div>
    <div style="display: flex; flex-direction: column;">
      <a href="#" style="display: grid; grid-template-columns: 140px 1fr; gap: 24px; padding: 18px 0; border-top: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID}; padding-top: 6px;">E-bost</span><span>[EMAIL]</span></a>
      <a href="#" style="display: grid; grid-template-columns: 140px 1fr; gap: 24px; padding: 18px 0; border-top: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID}; padding-top: 6px;">Ffôn</span><span>[PHONE]</span></a>
      <div style="display: grid; grid-template-columns: 140px 1fr; gap: 24px; padding: 18px 0; border-top: 1px solid {LINE}; border-bottom: 1px solid {LINE}; font-size: 22px; font-weight: 500;"><span class="mono" style="color: {MID}; padding-top: 6px;">Stiwdio</span><span>[ADDRESS]<br>Bangor, Gwynedd</span></div>
    </div>
  </div>
  <form style="display: flex; flex-direction: column; gap: 28px; padding-top: 12px;">
    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px;">{field("Enw / Name", "Your name")}{field("E-bost / Email", "you@company.com")}</div>
    {field("Sefydliad / Organisation", "Company or programme")}
    <div style="display: flex; flex-direction: column; gap: 10px;"><span class="mono" style="color: {MID};">Beth sydd ei angen arnoch? / What do you need?</span><div style="display: flex; flex-wrap: wrap; gap: 8px;">{chips}</div></div>
    {field("Cyllideb / Budget", "Select a range", 56)}
    {field("Y prosiect / The project", "A few lines is plenty.", 160)}
    <button type="button" style="align-self: flex-start; padding: 18px 28px; background: {INK}; color: {PAPER}; border: 0; border-radius: 999px; font-family: inherit; font-weight: 600; font-size: 17px; cursor: pointer;">Send</button>
  </form>
</section>
{footer()}
""" + FOOT

# ---------------------------------------------------------------- EDIT FLOW (CMS)
def edit_flow():
    def f(label, value, w="100%", h=44, note=None):
        note_html = f'<span style="font-size: 12px; color: {MID};">{note}</span>' if note else ""
        return f'<div style="display: flex; flex-direction: column; gap: 6px; width: {w};"><span style="font-size: 13px; font-weight: 600;">{label}</span><div style="display: flex; align-items: center; min-height: {h}px; padding: 10px 12px; border: 1px solid #C9CCD2; border-radius: 6px; background: #fff; font-size: 14px; color: #1F2328;">{value}</div>{note_html}</div>'
    chips = "".join(f'<span style="padding: 4px 10px; border-radius: 999px; background: {"#0E1013" if on else "#fff"}; color: {"#fff" if on else "#1F2328"}; border: 1px solid #C9CCD2; font-size: 13px;">{c}</span>' for c, on in [("Branding", True), ("Motion", True), ("Broadcast", True), ("Digital", False), ("Campaign", False)])
    blocks = "".join(f'<div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border: 1px solid #C9CCD2; border-radius: 6px; background: #fff; font-size: 14px;"><span><span class="mono" style="color: {MID}; margin-right: 12px;">{t}</span>{d}</span><span style="color: {MID}; font-size: 12px;">drag</span></div>' for t, d in [
        ("Text", "The ask · 2 paragraphs"), ("Image pair", "logo-cy.png · system.png"), ("Text", "The idea · 1 paragraph"), ("Video", "idents-in-motion.mp4"), ("Quote", "[Client quote]")])
    md = """---
title: Rownd a Rownd
teitl: Rownd a Rownd
client: Rondo Media for S4C
year: [YEAR]
disciplines: [branding, motion, broadcast]
sector: broadcast
summary: A new identity and ident system…
crynodeb: Hunaniaeth newydd a system o idents…
hero: { video: hero.mp4 }
tile: tile.mp4
featured: true
---
## The ask
Rondo Media asked us to…"""
    return head(bg="#EEF0F3", fg="#1F2328", line="#C9CCD2") + f"""
<div style="width: 1440px; height: 1000px; display: grid; grid-template-columns: 240px 1fr 420px; font-family: Archivo, system-ui, sans-serif;">
  <aside style="background: #fff; border-right: 1px solid #C9CCD2; padding: 24px 20px; display: flex; flex-direction: column; gap: 28px;">
    <span class="wordmark" style="font-size: 20px; color: {INK};">Creadigol <span style="font-weight: 400; font-stretch: 100%; color: {MID}; font-size: 13px;">/ editor</span></span>
    <div style="display: flex; flex-direction: column; gap: 6px;"><span class="mono" style="color: {MID};">Collections</span>
      <a href="#" style="padding: 8px 10px; border-radius: 6px; background: #EEF0F3; font-weight: 600; font-size: 14px;">Work</a>
      <a href="#" style="padding: 8px 10px; font-size: 14px;">Journal</a>
    </div>
    <div style="display: flex; flex-direction: column; gap: 6px;"><span class="mono" style="color: {MID};">Pages</span>
      <a href="#" style="padding: 8px 10px; font-size: 14px;">Home</a><a href="#" style="padding: 8px 10px; font-size: 14px;">Studio</a><a href="#" style="padding: 8px 10px; font-size: 14px;">Contact</a>
    </div>
  </aside>
  <main style="padding: 28px 40px; display: flex; flex-direction: column; gap: 22px; overflow: hidden;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; flex-direction: column; gap: 2px;"><span class="mono" style="color: {MID};">Work / New case study</span><h1 style="margin: 0; font-size: 26px; font-weight: 700; letter-spacing: -0.02em;">Rownd a Rownd</h1></div>
      <div style="display: flex; gap: 8px;"><span style="padding: 10px 16px; border: 1px solid #C9CCD2; border-radius: 6px; background: #fff; font-size: 14px; font-weight: 600;">Preview</span><span style="padding: 10px 16px; border-radius: 6px; background: {INK}; color: #fff; font-size: 14px; font-weight: 600;">Save &amp; publish</span></div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">{f("Title (EN)", "Rownd a Rownd")}{f("Teitl (CY)", "Rownd a Rownd")}</div>
    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px;">{f("Client", "Rondo Media for S4C")}{f("Year", "[YEAR]")}{f("Sector", "Broadcast")}</div>
    <div style="display: flex; flex-direction: column; gap: 6px;"><span style="font-size: 13px; font-weight: 600;">Disciplines</span><div style="display: flex; gap: 6px;">{chips}</div></div>
    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">{f("Summary (EN)", "A new identity and ident system for one of S4C's longest-running dramas…", h=64)}{f("Crynodeb (CY)", "Hunaniaeth newydd a system o idents ar gyfer un o ddramâu hynaf S4C…", h=64)}</div>
    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">{f("Hero", "hero.mp4 · 1920×1080 · 14 MB", note="Drop a video or image, or paste a Cloudflare Stream / Vimeo ID")}{f("Tile (4:5)", "tile.mp4 · 1080×1350 · 2.1 MB")}</div>
    <div style="display: flex; flex-direction: column; gap: 8px;"><div style="display: flex; justify-content: space-between; align-items: center;"><span style="font-size: 13px; font-weight: 600;">Body</span><span style="font-size: 13px; color: {MID};">+ Text · Video · Image · Image pair · Quote · Stats</span></div>{blocks}</div>
  </main>
  <aside style="background: #fff; border-left: 1px solid #C9CCD2; padding: 28px 24px; display: flex; flex-direction: column; gap: 20px;">
    <span class="mono" style="color: {MID};">What this writes</span>
    <pre style="margin: 0; padding: 16px; background: #0E1013; color: #C8CDC4; border-radius: 6px; font-family: 'IBM Plex Mono', Menlo, monospace; font-size: 12px; line-height: 1.55; white-space: pre-wrap;">src/content/work/rownd-a-rownd/
├─ index.md
├─ hero.mp4
├─ tile.mp4
└─ logo-cy.png · system.png · …

{md}</pre>
    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 14px; line-height: 1.5; color: #1F2328;">
      <span class="mono" style="color: {MID};">Then</span>
      <span>Save commits to GitHub. Cloudflare Pages rebuilds in about a minute. The project appears on /work and, if featured, on the home page.</span>
      <span>Prefer files? Add the same folder by hand or with Claude Code and push. Same result.</span>
    </div>
  </aside>
</div>
""" + FOOT

# ---------------------------------------------------------------- DIRECTIONS
def direction_b():
    return head(bg=INK, fg=PAPER, line="#2A2E33") + nav(dark=True) + f"""
<section style="position: relative; height: 810px; padding: 40px 48px 48px; display: flex; flex-direction: column; justify-content: flex-end; gap: 32px; overflow: hidden;">
  <div class="hatch" style="position: absolute; inset: 0 48px 48px 48px; background: #1B1F24; border-radius: 4px;"></div>
  <div class="mono" style="position: relative; color: #8A93A0; display: flex; gap: 28px; padding: 0 48px;"><span>Stiwdio brandio a graffeg symud</span><span>Bangor, Gogledd Cymru</span><span>Showreel · [00:00]</span></div>
  <h1 class="display" style="position: relative; font-size: 190px; padding: 0 48px; color: {PAPER};">Brands built<br>to move.</h1>
  <div style="position: relative; padding: 0 48px 48px; display: flex; justify-content: space-between; align-items: end;">
    <p class="body-l" style="max-width: 520px; color: #C8CDC4;">Reel plays full-bleed behind the headline. Work tiles follow on the same dark ground.</p>
    <span style="color: {PAPER};">{PLAY}</span>
  </div>
</section>
""" + FOOT

def direction_c():
    cols = "".join(f'<div style="border-left: 1px solid rgba(14,16,19,0.18); height: 100%;"></div>' for _ in range(12))
    return head() + f"""
<div style="position: relative; height: 900px; overflow: hidden;">
  <div style="position: absolute; inset: 0 48px; display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); pointer-events: none;">{cols}</div>
  {nav()}
  <section style="position: relative; padding: 48px 48px 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0; align-items: start;">
    <div style="display: flex; flex-direction: column; gap: 24px; padding-right: 24px;">
      <span class="mono" style="color: {MID};">Cymraeg</span>
      <h1 class="display" style="font-size: 120px; font-stretch: 100%;">Brandiau sy'n symud.</h1>
    </div>
    <div style="display: flex; flex-direction: column; gap: 24px; padding-left: 24px; border-left: 1px solid {INK};">
      <span class="mono" style="color: {MID};">English</span>
      <h1 class="display" style="font-size: 120px; font-stretch: 100%;">Brands built to move.</h1>
    </div>
  </section>
  <section style="position: relative; margin-top: 56px; padding: 0 48px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));">
    <div style="height: 300px; background: {TALLY};"></div>
    <div class="hatch" style="height: 300px; background: {INK};"></div>
    <div style="height: 300px; background: {TONES[3]};"></div>
    <div style="height: 300px; display: flex; align-items: end; padding: 24px;"><p class="mono" style="margin: 0; color: {MID};">Both languages side by side, always. Visible grid, colour blocks, tighter type. Risk: colder, less filmic.</p></div>
  </section>
</div>
""" + FOOT

FILES = {
    "Main.dc.html": home(), "HomeMobile.dc.html": home_mobile(), "Work.dc.html": work(),
    "CaseStudy.dc.html": case_study(), "Studio.dc.html": studio(), "Contact.dc.html": contact(),
    "AddCaseStudy.dc.html": edit_flow(),
}
for name, src in FILES.items():
    with open(os.path.join(OUT, name), "w") as fh:
        fh.write(src)

canvas = {
  "pages": [
    {
      "id": "page-1",
      "name": "Directions A–E"
    },
    {
      "id": "page-2",
      "name": "Direction A · full set"
    }
  ],
  "artboards": [
    {
      "file": "Main.dc.html",
      "title": "A · Evolution",
      "x": 0,
      "y": 0,
      "w": 1440,
      "h": 5900,
      "page": "page-1"
    },
    {
      "file": "DirectionB.dc.html",
      "title": "B · Broadcast",
      "x": 1560,
      "y": 0,
      "w": 1440,
      "h": 4650,
      "page": "page-1"
    },
    {
      "file": "DirectionC.dc.html",
      "title": "C · Swiss grid, Welsh-first",
      "x": 3120,
      "y": 0,
      "w": 1440,
      "h": 3400,
      "page": "page-1"
    },
    {
      "file": "DirectionD.dc.html",
      "title": "D · Kinetic",
      "x": 4680,
      "y": 0,
      "w": 1440,
      "h": 5000,
      "page": "page-1"
    },
    {
      "file": "DirectionE.dc.html",
      "title": "E · Multiview (new)",
      "x": 6240,
      "y": 0,
      "w": 1440,
      "h": 2400,
      "page": "page-1"
    },
    {
      "file": "HomeMobile.dc.html",
      "title": "A · Home, mobile",
      "x": 0,
      "y": 0,
      "w": 390,
      "h": 4000,
      "page": "page-2"
    },
    {
      "file": "Work.dc.html",
      "title": "A · Work index",
      "x": 510,
      "y": 0,
      "w": 1440,
      "h": 2350,
      "page": "page-2"
    },
    {
      "file": "CaseStudy.dc.html",
      "title": "A · Case study",
      "x": 2070,
      "y": 0,
      "w": 1440,
      "h": 5150,
      "page": "page-2"
    },
    {
      "file": "Studio.dc.html",
      "title": "A · Studio",
      "x": 3630,
      "y": 0,
      "w": 1440,
      "h": 4250,
      "page": "page-2"
    },
    {
      "file": "Contact.dc.html",
      "title": "A · Contact",
      "x": 5190,
      "y": 0,
      "w": 1440,
      "h": 1480,
      "page": "page-2"
    },
    {
      "file": "AddCaseStudy.dc.html",
      "title": "Adding a case study (editor)",
      "x": 6750,
      "y": 0,
      "w": 1440,
      "h": 1000,
      "page": "page-2"
    }
  ],
  "annotations": [
    {
      "id": "note-directions",
      "x": 0,
      "y": -300,
      "w": 900,
      "page": "page-1",
      "text": "Five directions for the Creadigol home page, all in the brand's lime #D1DF5F and charcoal #2E2E2E, all set in Druk Web Bold with Supply labels. They differ in layout and personality, not colour. Zoom out to see them side by side.\nA · Evolution: off-white shell, lime as accent, video-led work grid. Least change.\nB · Broadcast: charcoal, full-bleed reel, lower-thirds, lime client ticker, REC tallies.\nC · Swiss grid, Welsh-first: white, visible 12-column grid, Welsh and English side by side, work as an index.\nD · Kinetic: lime, charcoal and grey blocks, rounded media, pill navigation.\nE · Multiview (brand new): the home page is a broadcast monitor wall of live project feeds, headline stamped across on a lime caption.\n\nGrey blocks are media placeholders. Square-bracket text is a fact to fill in."
    },
    {
      "id": "note-fullset",
      "x": 0,
      "y": -180,
      "w": 720,
      "page": "page-2",
      "text": "Direction A carried through the rest of the site: mobile home, work index, a case study, studio, contact, and the editor screen for adding a case study. Whichever direction is chosen gets the same set."
    }
  ],
  "launch": {
    "view": "canvas",
    "page": "page-1"
  }
}
with open(os.path.join(OUT, "canvas.json"), "w") as fh:
    json.dump(canvas, fh, indent=2)
print("wrote", len(FILES), "artboards")
