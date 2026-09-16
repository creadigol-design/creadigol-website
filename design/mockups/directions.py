#!/usr/bin/env python3
"""Three alternative design directions for the Creadigol home page, each a full page."""
import os
OUT = os.path.dirname(os.path.abspath(__file__))
FONTCSS = open(os.path.join(OUT, "fonts.css")).read()

def shell(fonts_href, css):
    return f"""<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <script src="./support.js"></script>
</head>
<body>
<x-dc>
<helmet>
  <link rel="stylesheet" href="{fonts_href}">
  <style>
{FONTCSS}
{css}
  </style>
</helmet>
"""
FOOT = "</x-dc>\n</body>\n</html>\n"
PLAY = lambda c: f'<svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="36" cy="36" r="35" stroke="{c}" stroke-width="1.5"></circle><path d="M29 24 L48 36 L29 48 Z" fill="{c}"></path></svg>'
ARROW = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10 H16 M11 5 L16 10 L11 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>'

PROJECTS = [
    ("Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", "Rownd a Rownd idents"),
    ("Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics", "Pen Petrol title sequence"),
    ("BBC Sport", "[Project title]", "Motion · Broadcast", "BBC Sport project"),
    ("Menai Track &amp; Field", "Club website", "Digital · Identity refresh", "Menai T&amp;F site"),
]

# ============================================================ B · BROADCAST
def direction_b():
    BG, FG, AMBER, GREY, PANEL = "#2E2E2E", "#F5F5F0", "#D1DF5F", "#9A9A9A", "#383838"
    css = f"""
    body {{ margin: 0; background: {BG}; color: {FG}; font-family: Barlow, 'Helvetica Neue', Arial, sans-serif; font-size: 17px; line-height: 1.5; -webkit-font-smoothing: antialiased; }}
    a {{ color: inherit; text-decoration: none; }} a:hover {{ color: {AMBER}; }}
    .cond {{ font-family: 'Druk Web', Impact, 'Arial Narrow', Arial, sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 0.01em; line-height: 0.9; margin: 0; }}
    .label {{ font-family: Supply, 'Barlow Condensed', Arial, sans-serif; font-weight: 400; text-transform: uppercase; letter-spacing: 0.1em; font-size: 13px; line-height: 1.2; }}
    .scan {{ background-image: repeating-linear-gradient(0deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 4px); }}
    """
    def media(h, tone, label, play=False, lower_third=None):
        lt = f'<div style="position: absolute; left: 0; bottom: 40px; display: flex; align-items: stretch;"><div style="width: 10px; background: {AMBER};"></div><div style="background: {BG}; padding: 14px 24px; display: flex; flex-direction: column; gap: 2px;"><span class="label" style="color: {AMBER};">{lower_third[0]}</span><span class="cond" style="font-size: 40px; color: {FG};">{lower_third[1]}</span></div></div>' if lower_third else ""
        return f"""<div class="scan" style="position: relative; height: {h}px; background: {tone}; display: flex; align-items: center; justify-content: center; overflow: hidden;">
  <span class="label" style="position: absolute; top: 20px; left: 24px; color: {GREY};">[LOOP] {label}</span>
  <span class="label" style="position: absolute; top: 20px; right: 24px; color: {AMBER}; display: flex; gap: 8px; align-items: center;"><span style="width: 8px; height: 8px; background: {AMBER}; border-radius: 50%;"></span>REC</span>
  {PLAY(FG) if play else ""}{lt}</div>"""
    ticker = "".join(f'<span>{c}</span><span style="color: {AMBER};">//</span>' for c in ["BBC Sport", "Rondo Media", "Cwmni Da", "Nimble", "Menai Track &amp; Field", "S4C", "BBC Sport", "Rondo Media", "Cwmni Da", "Nimble"])
    rows = "".join(f"""<a href="#" style="display: grid; grid-template-columns: 120px 2fr 3fr 2fr 40px; gap: 24px; align-items: center; padding: 22px 0; border-top: 1px solid #454545;">
      <span class="label" style="color: {GREY};">[YEAR]</span><span class="label" style="color: {GREY};">{c}</span><span class="cond" style="font-size: 36px;">{t}</span><span class="label" style="color: {GREY};">{tags}</span><span style="color: {AMBER};">{ARROW}</span></a>"""
        for c, t, tags, _ in [("BBC Sport", "[Project title]", "Motion · Broadcast", ""), ("Menai Track &amp; Field", "Club website", "Digital", ""), ("Cwmni Da", "[Project title]", "Branding · Motion", ""), ("Nimble", "[Project title]", "Motion", "")])
    services = "".join(f'<div style="display: flex; flex-direction: column; gap: 14px; border-top: 2px solid {FG}; padding-top: 20px;"><h3 class="cond" style="font-size: 44px;">{t}</h3><p style="margin: 0; color: {GREY}; font-size: 17px;">{d}</p></div>' for t, d in [
        ("Brand identity<br>&amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        ("Motion<br>&amp; animation", "Idents, title sequences, programme graphics, social and explainer animation."),
        ("Digital<br>&amp; web", "Fast, bilingual websites that carry the identity into every screen.")])
    return shell("https://fonts.googleapis.com/css2?family=Anton&amp;family=Barlow+Condensed:wght@600&amp;family=Barlow:wght@400;500&amp;display=swap", css) + f"""
<header style="display: flex; align-items: center; justify-content: space-between; padding: 24px 40px; border-bottom: 1px solid #454545;">
  <a href="#" class="cond" style="font-size: 30px; display: flex; align-items: center; gap: 12px;"><span style="width: 14px; height: 14px; background: {AMBER};"></span>Creadigol</a>
  <nav class="label" style="display: flex; gap: 36px;"><a href="#">Gwaith / Work</a><a href="#">Stiwdio / Studio</a><a href="#">Dyddiadur / Journal</a><a href="#">Cysylltu / Contact</a></nav>
  <div class="label" style="display: flex; gap: 20px; align-items: center;"><span><span style="color: {FG};">EN</span> <span style="color: {GREY};">/ CY</span></span><a href="#" style="padding: 12px 18px; background: {AMBER}; color: {BG};">Start a project</a></div>
</header>
<section style="position: relative; height: 820px; overflow: hidden;">
  <div class="scan" style="position: absolute; inset: 0; background: {PANEL};"></div>
  <span class="label" style="position: absolute; top: 28px; left: 40px; color: {GREY};">[LOOP] Showreel 2026 · full-bleed, muted</span>
  <span class="label" style="position: absolute; top: 28px; right: 40px; color: {AMBER}; display: flex; gap: 8px; align-items: center;"><span style="width: 8px; height: 8px; background: {AMBER}; border-radius: 50%;"></span>Live · Bangor, Gogledd Cymru</span>
  <div style="position: absolute; left: 40px; right: 40px; bottom: 48px; display: flex; justify-content: space-between; align-items: end; gap: 48px;">
    <h1 class="cond" style="font-size: 168px; color: {FG}; flex: 1; white-space: nowrap;">Brands built<br>to move<span style="color: {AMBER};">.</span></h1>
    <div style="display: flex; flex-direction: column; gap: 20px; align-items: end; max-width: 360px; padding-bottom: 16px;">
      <p style="margin: 0; color: {FG}; font-size: 19px; text-align: right;">Identities with motion at the core, from a sports-broadcast background. Bilingual, from North Wales.</p>
      <span>{PLAY(FG)}</span>
    </div>
  </div>
</section>
<div class="cond" style="display: flex; gap: 28px; padding: 16px 40px; font-size: 22px; background: {AMBER}; color: {BG}; white-space: nowrap; overflow: hidden;">{ticker}</div>
<section style="padding: 96px 40px 0; display: flex; flex-direction: column; gap: 40px;">
  <div style="display: flex; justify-content: space-between; align-items: end;"><h2 class="cond" style="font-size: 96px;">Gwaith <span style="color: {GREY};">/</span> Work</h2><a href="#" class="label" style="color: {AMBER};">All projects</a></div>
  <a href="#">{media(640, "#3A3A3A", PROJECTS[0][3], lower_third=(PROJECTS[0][0] + " · Rebrand · Broadcast", PROJECTS[0][1]))}</a>
  <a href="#">{media(640, "#444444", PROJECTS[1][3], lower_third=(PROJECTS[1][0] + " · Titles · Programme graphics", PROJECTS[1][1]))}</a>
  <div style="display: flex; flex-direction: column; border-bottom: 1px solid #454545;">{rows}</div>
</section>
<section style="margin-top: 120px; padding: 96px 40px; background: {AMBER}; color: {BG};">
  <span class="label">Sut rydyn ni'n gweithio / How we work</span>
  <p class="cond" style="font-size: 120px; max-width: 1300px; margin-top: 24px;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>
<section style="padding: 120px 40px 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px;">{services}</section>
<section style="padding: 140px 40px 120px; display: flex; flex-direction: column; gap: 32px;">
  <span class="label" style="color: {GREY};">Cysylltu / Get in touch</span>
  <h2 class="cond" style="font-size: 136px; white-space: nowrap;">Got a brand that<br>needs to move?</h2>
  <div class="label" style="display: flex; gap: 16px; align-items: center;"><a href="#" style="padding: 18px 28px; background: {AMBER}; color: {BG};">Start a project</a><a href="#" style="padding: 18px 8px; font-size: 16px;">[EMAIL]</a></div>
</section>
<footer class="label" style="display: flex; justify-content: space-between; padding: 24px 40px; border-top: 1px solid #454545; color: {GREY};"><span>© 2026 Creadigol · Bangor, Gwynedd</span><span>Instagram · LinkedIn · Vimeo · vedrí (sister studio) · Cymraeg</span></footer>
""" + FOOT

# ============================================================ C · SWISS GRID, WELSH-FIRST
def direction_c():
    BG, FG, BLUE, GRID, GREY = "#FFFFFF", "#2E2E2E", "#D1DF5F", "#E4E4E4", "#6E6E6E"
    css = f"""
    body {{ margin: 0; background: {BG}; color: {FG}; font-family: 'Schibsted Grotesk', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.45; -webkit-font-smoothing: antialiased; }}
    a {{ color: inherit; text-decoration: none; }} a:hover {{ color: {BLUE}; }}
    .h {{ font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0; line-height: 0.92; margin: 0; }}
    .sm {{ font-size: 13px; line-height: 1.35; }}
    .cell {{ border-top: 1px solid {FG}; padding: 12px 12px 12px 0; }}
    """
    def media(h, tone, label):
        return f'<div style="position: relative; height: {h}px; background: {tone}; display: flex; align-items: flex-end; padding: 12px; box-sizing: border-box; color: #fff;"><span class="sm">[LOOP] {label}</span></div>'
    def bil(cy, en):
        return f'<span style="display: flex; flex-direction: column; line-height: 1.2;"><span>{cy}</span><span style="color: {GREY};">{en}</span></span>'
    index_rows = "".join(f"""<a href="#" style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 18px 0; border-top: 1px solid {FG}; align-items: baseline;">
      <span class="sm" style="grid-column: span 1; color: {GREY};">[YEAR]</span><span style="grid-column: span 3;">{c}</span><span class="h" style="grid-column: span 5; font-size: 28px; letter-spacing: -0.02em;">{t}</span><span class="sm" style="grid-column: span 3; color: {GREY};">{tags}</span></a>"""
        for c, t, tags in [("Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast"), ("Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics"), ("BBC Sport", "[Project title]", "Motion · Broadcast"), ("Menai Track &amp; Field", "Club website", "Digital"), ("Cwmni Da", "[Project title]", "Branding · Motion"), ("Nimble", "[Project title]", "Motion")])
    services = "".join(f'<div class="cell" style="grid-column: span 4; display: flex; flex-direction: column; gap: 32px; min-height: 220px;"><span class="sm">{cy}<br><span style="color: {GREY};">{en}</span></span><p style="margin: 0; font-size: 18px; max-width: 34ch;">{d}</p></div>' for cy, en, d in [
        ("Hunaniaeth brand a strategaeth", "Brand identity &amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        ("Graffeg symud ac animeiddio", "Motion &amp; animation", "Idents, title sequences, programme graphics, social and explainer animation."),
        ("Digidol a gwe", "Digital &amp; web", "Fast, bilingual websites that carry the identity into every screen.")])
    return shell("https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@125,800&amp;family=Schibsted+Grotesk:wght@400;500;700&amp;display=swap", css) + f"""
<div style="padding: 0 40px;">
<header style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 24px 0; border-bottom: 1px solid {FG}; align-items: start;" class="sm">
  <a href="#" class="h" style="grid-column: span 3; font-size: 22px; letter-spacing: -0.02em;">Creadigol</a>
  <a href="#" style="grid-column: span 2;">{bil("Gwaith", "Work")}</a><a href="#" style="grid-column: span 2;">{bil("Stiwdio", "Studio")}</a><a href="#" style="grid-column: span 2;">{bil("Dyddiadur", "Journal")}</a><a href="#" style="grid-column: span 2;">{bil("Cysylltu", "Contact")}</a>
  <span style="grid-column: span 1; text-align: right;"><span style="text-decoration: underline;">CY</span> EN</span>
</header>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 64px 0 0;">
  <h1 class="h" style="grid-column: span 6; font-size: 128px;">Brandiau sy'n symud.</h1>
  <h1 class="h" style="grid-column: span 6; font-size: 128px; color: {GREY};">Brands built to move.</h1>
</section>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 56px 0 0;" class="sm">
  <div class="cell" style="grid-column: span 2;">{bil("Stiwdio brandio a graffeg symud", "Branding &amp; motion studio")}</div>
  <div class="cell" style="grid-column: span 2;">{bil("Bangor, Gwynedd", "North Wales")}</div>
  <div class="cell" style="grid-column: span 2;">{bil("Sefydlwyd 2022", "Est. 2022")}</div>
  <div class="cell" style="grid-column: span 2;">{bil("Dwyieithog", "Bilingual")}</div>
  <div class="cell" style="grid-column: span 4;"><p style="margin: 0; font-size: 18px;">Identities with motion at the core, from broadcast idents to whole brand systems. Designed in Welsh and English together, never translated afterwards.</p></div>
</section>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 40px 0 0;">
  <div style="grid-column: span 8;">{media(600, FG, "Showreel 2026")}</div>
  <div style="grid-column: span 4; display: grid; grid-template-rows: repeat(2, minmax(0, 1fr)); gap: 24px;">{media(288, "#2E2E2E", "Rownd a Rownd idents")}{media(288, "#BFBFBF", "Pen Petrol titles")}</div>
</section>
<section style="padding: 120px 0 0;">
  <div style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding-bottom: 24px;" class="sm"><span style="grid-column: span 6;" class="h" >Gwaith <span style="color: {GREY};">Work</span></span><span style="grid-column: span 6; text-align: right; color: {GREY};">Mynegai o bob prosiect / Index of all projects</span></div>
  <div style="display: flex; flex-direction: column; border-bottom: 1px solid {FG};">{index_rows}</div>
</section>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 120px 0 0;">
  <div style="grid-column: span 8; background: {BLUE}; color: {FG}; padding: 56px; box-sizing: border-box; display: flex; flex-direction: column; gap: 40px; min-height: 520px; justify-content: space-between;">
    <span class="sm">Sut rydyn ni'n gweithio / How we work</span>
    <p class="h" style="font-size: 56px; letter-spacing: -0.03em;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
  </div>
  <div style="grid-column: span 4; background: {FG}; color: #fff; padding: 56px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between;">
    <span class="sm">Wedi gweithio gyda / Worked with</span>
    <p class="h" style="font-size: 32px; line-height: 1.15; letter-spacing: -0.02em;">BBC Sport<br>Rondo Media<br>Cwmni Da<br>Nimble<br>Menai Track &amp; Field</p>
  </div>
</section>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 120px 0 0;">{services}</section>
<section style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 140px 0 120px; align-items: end;">
  <h2 class="h" style="grid-column: span 8; font-size: 88px;">Oes gennych chi frand sydd angen symud?</h2>
  <div style="grid-column: span 4; display: flex; flex-direction: column; gap: 16px;"><p class="h" style="font-size: 28px; letter-spacing: -0.02em; color: {GREY};">Got a brand that needs to move?</p><a href="#" style="padding: 16px 20px; background: {BLUE}; color: {FG}; align-self: flex-start; font-weight: 500;">Start a project / Dechrau prosiect</a></div>
</section>
<footer class="sm" style="display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; padding: 24px 0 32px; border-top: 1px solid {FG}; color: {GREY};"><span style="grid-column: span 4;">© 2026 Creadigol · Bangor, Gwynedd</span><span style="grid-column: span 4;">Instagram · LinkedIn · Vimeo</span><span style="grid-column: span 4; text-align: right;">vedrí, stiwdio chwaer / sister studio</span></footer>
</div>
""" + FOOT

# ============================================================ D · KINETIC COLOUR
def direction_d():
    VIOLET, CREAM, TANG, INK, MINT = "#D1DF5F", "#F4F5F2", "#2E2E2E", "#2E2E2E", "#DADADA"
    css = f"""
    body {{ margin: 0; background: {CREAM}; color: {INK}; font-family: 'Bricolage Grotesque', 'Helvetica Neue', Arial, sans-serif; font-size: 17px; line-height: 1.5; -webkit-font-smoothing: antialiased; }}
    a {{ color: inherit; text-decoration: none; }} a:hover {{ opacity: 0.8; }}
    .d {{ font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0; line-height: 0.9; margin: 0; }}
    .pill {{ display: inline-flex; align-items: center; padding: 10px 16px; border-radius: 999px; font-weight: 600; font-size: 14px; }}
    .d.cream {{ color: #F4F5F2; }}
    """
    def media(h, tone, label, fg="#fff", play=False):
        return f'<div style="position: relative; height: {h}px; background: {tone}; border-radius: 28px; display: flex; align-items: center; justify-content: center; color: {fg}; overflow: hidden;"><span style="position: absolute; top: 18px; left: 20px; font-size: 13px; font-weight: 600; opacity: 0.85;">[LOOP] {label}</span>{PLAY(fg) if play else ""}</div>'
    def tile(tone, client, title, tags, label, h=520, fg="#fff"):
        return f'<a href="#" style="display: flex; flex-direction: column; gap: 16px;">{media(h, tone, label, fg)}<div style="display: flex; justify-content: space-between; align-items: center; gap: 16px;"><span class="d" style="font-size: 30px; letter-spacing: -0.03em;">{title}</span><span class="pill" style="background: {INK}; color: {CREAM};">{client}</span></div><span style="color: #6B6580; font-size: 15px; margin-top: -8px;">{tags}</span></a>'
    services = "".join(f'<div style="background: {bg}; color: {fg}; border-radius: 28px; padding: 36px; display: flex; flex-direction: column; justify-content: space-between; min-height: 300px;"><h3 class="d" style="font-size: 40px;">{t}</h3><p style="margin: 0; font-size: 17px; opacity: 0.9;">{d}</p></div>' for bg, fg, t, d in [
        (INK, "#F4F5F2", "Brand identity &amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        (VIOLET, INK, "Motion &amp; animation", "Idents, title sequences, programme graphics, social and explainer animation."),
        (MINT, INK, "Digital &amp; web", "Fast, bilingual websites that carry the identity into every screen.")])
    return shell("https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@125,800&amp;family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600&amp;display=swap", css) + f"""
<section style="background: {VIOLET}; color: {INK}; padding: 24px 40px 48px; border-radius: 0 0 40px 40px; display: flex; flex-direction: column; gap: 72px;">
  <header style="display: flex; align-items: center; justify-content: space-between;">
    <a href="#" class="d" style="font-size: 30px; letter-spacing: -0.04em;">creadigol</a>
    <nav style="display: flex; gap: 6px; background: rgba(46,46,46,0.08); padding: 6px; border-radius: 999px;"><a href="#" class="pill" style="background: {INK}; color: {VIOLET};">Work</a><a href="#" class="pill">Studio</a><a href="#" class="pill">Journal</a><a href="#" class="pill">Contact</a></nav>
    <div style="display: flex; gap: 8px; align-items: center;"><span class="pill" style="border: 1px solid rgba(46,46,46,0.4);">Cymraeg</span><a href="#" class="pill" style="background: {INK}; color: {VIOLET};">Start a project</a></div>
  </header>
  <div style="display: grid; grid-template-columns: 7fr 5fr; gap: 48px; align-items: end;">
    <h1 class="d" style="font-size: 190px;">Brands<br>built to<br><span style="color: {CREAM};">move.</span></h1>
    <div style="display: flex; flex-direction: column; gap: 28px; padding-bottom: 20px;">
      <p style="margin: 0; font-size: 24px; line-height: 1.35; max-width: 22ch;">A branding and motion studio from North Wales. Bilingual, playful, built for screens that never stand still.</p>
      <div style="display: flex; gap: 8px; flex-wrap: wrap;"><span class="pill" style="background: rgba(46,46,46,0.1);">Branding</span><span class="pill" style="background: rgba(46,46,46,0.1);">Motion</span><span class="pill" style="background: rgba(46,46,46,0.1);">Broadcast</span><span class="pill" style="background: rgba(46,46,46,0.1);">Digital</span></div>
    </div>
  </div>
  {media(640, INK, "Showreel 2026", play=True)}
</section>
<section style="padding: 120px 40px 0; display: flex; flex-direction: column; gap: 40px;">
  <div style="display: flex; justify-content: space-between; align-items: end;"><h2 class="d" style="font-size: 80px;">Recent work</h2><a href="#" class="pill" style="border: 1.5px solid {INK};">All projects {ARROW}</a></div>
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 40px;">
    {tile(INK, "Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", "Rownd a Rownd idents")}
    {tile(VIOLET, "Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics", "Pen Petrol titles", fg=INK)}
    {tile(MINT, "BBC Sport", "[Project title]", "Motion · Broadcast", "BBC Sport project", h=420, fg=INK)}
    {tile("#5B6B7A", "Menai Track &amp; Field", "Club website", "Digital · Identity refresh", "Menai T&amp;F site", h=420)}
  </div>
</section>
<section style="margin: 140px 40px 0; background: {TANG}; color: {CREAM}; border-radius: 40px; padding: 80px 64px; display: flex; flex-direction: column; gap: 32px;">
  <span class="pill" style="background: {VIOLET}; color: {INK}; align-self: flex-start;">How we work</span>
  <p class="d" style="font-size: 80px; max-width: 1200px;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>
<section style="padding: 120px 40px 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 28px;">{services}</section>
<section style="padding: 120px 40px 0; display: flex; flex-direction: column; gap: 20px;">
  <span style="font-weight: 600; color: #6B6580;">Worked with</span>
  <div style="display: flex; flex-wrap: wrap; gap: 12px;">{"".join(f'<span class="pill" style="border: 1.5px solid {INK}; font-size: 20px; padding: 14px 22px;">{c}</span>' for c in ["BBC Sport", "Rondo Media", "Cwmni Da", "Nimble", "Menai Track &amp; Field"])}</div>
</section>
<section style="margin: 140px 40px 40px; background: {VIOLET}; color: {INK}; border-radius: 40px; padding: 96px 64px; display: flex; flex-direction: column; gap: 40px; align-items: flex-start;">
  <h2 class="d" style="font-size: 104px;">Got a brand that<br>needs to move?</h2>
  <div style="display: flex; gap: 12px; align-items: center;"><a href="#" class="pill" style="background: {INK}; color: {VIOLET}; font-size: 18px; padding: 18px 28px;">Start a project</a><span style="font-size: 20px; font-weight: 600;">[EMAIL]</span></div>
</section>
<footer style="display: flex; justify-content: space-between; padding: 24px 40px 40px; font-size: 14px; color: #6B6580;"><span>© 2026 Creadigol · Bangor, Gwynedd</span><span>Instagram · LinkedIn · Vimeo · vedrí (sister studio) · Cymraeg</span></footer>
""" + FOOT


# ============================================================ E · MULTIVIEW (brand new)
def direction_e():
    BG, SURF, FG, DIM, TALLY, LINE = "#2E2E2E", "#383838", "#F4F5F2", "#9A9A9A", "#D1DF5F", "#4A4A4A"
    css = f"""
    body {{ margin: 0; background: {BG}; color: {FG}; font-family: 'IBM Plex Sans', 'Helvetica Neue', Arial, sans-serif; font-size: 16px; line-height: 1.5; -webkit-font-smoothing: antialiased; }}
    a {{ color: inherit; text-decoration: none; }} a:hover {{ color: #fff; }}
    .druk {{ font-family: 'Druk Web', Impact, 'Arial Narrow', sans-serif; font-weight: 700; letter-spacing: 0.01em; line-height: 0.9; margin: 0; text-transform: uppercase; }}
    .tc {{ font-family: Supply, 'IBM Plex Mono', Menlo, monospace; font-size: 12px; letter-spacing: 0.06em; text-transform: uppercase; color: {DIM}; font-variant-numeric: tabular-nums; }}
    .feed {{ position: relative; background: {SURF}; overflow: hidden; display: flex; flex-direction: column; justify-content: flex-end; box-sizing: border-box; }}
    .feed .tag {{ position: absolute; top: 12px; left: 12px; display: flex; gap: 8px; align-items: center; }}
    .feed .tally {{ width: 8px; height: 8px; border-radius: 50%; background: {DIM}; }}
    .feed.live {{ outline: 2px solid {TALLY}; outline-offset: -2px; }}
    .feed.live .tally {{ background: {TALLY}; }}
    .feed .name {{ padding: 12px; background: linear-gradient(to top, rgba(15,17,19,0.85), rgba(15,17,19,0)); display: flex; justify-content: space-between; align-items: end; gap: 12px; }}
    """
    def feed(n, client, title, tags, live=False, tone=None, h=300):
        tone = tone or SURF
        return f"""<a href="#" class="feed{' live' if live else ''}" style="height: {h}px; background: {tone};">
      <span class="tag"><span class="tally"></span><span class="tc">{n} · {client}</span></span>
      <span class="tc" style="position: absolute; top: 12px; right: 12px;">[LOOP]</span>
      <span class="name"><span class="druk" style="font-size: 22px; text-transform: none; letter-spacing: -0.02em;">{title}</span><span class="tc">{tags}</span></span></a>"""
    feeds = [
        ("PGM", "Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", True, "#444444"),
        ("CAM 1", "Rondo Media", "Pen Petrol S1–2", "Titles · Graphics", False, "#3C3C3C"),
        ("CAM 2", "BBC Sport", "[Project title]", "Motion · Broadcast", False, "#404040"),
        ("CAM 3", "Menai Track &amp; Field", "Club website", "Digital", False, "#363636"),
        ("CAM 4", "Cwmni Da", "[Project title]", "Branding · Motion", False, "#424242"),
        ("CAM 5", "Nimble", "[Project title]", "Motion", False, "#3A3A3A"),
    ]
    wall = "".join(feed(*f) for f in feeds)
    channels = "".join(f"""<a href="#" style="display: grid; grid-template-columns: 90px 1fr 2fr 40px; gap: 24px; align-items: center; padding: 26px 0; border-top: 1px solid {LINE};">
      <span class="tc">CH {i}</span><span class="druk" style="font-size: 30px; text-transform: none; letter-spacing: -0.02em;">{t}</span><span style="color: {DIM};">{d}</span><span style="color: {DIM};">{ARROW}</span></a>""" for i, (t, d) in enumerate([
        ("Brand identity &amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        ("Motion &amp; animation", "Idents, title sequences, programme graphics, social and explainer animation."),
        ("Digital &amp; web", "Fast, bilingual websites that carry the identity into every screen.")], start=1))
    return shell("https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@125,800&amp;family=IBM+Plex+Sans:wght@400;500&amp;family=IBM+Plex+Mono:wght@400;500&amp;display=swap", css) + f"""
<header style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; padding: 18px 24px; border-bottom: 1px solid {LINE};">
  <a href="#" class="druk" style="font-size: 22px; text-transform: none;">Creadigol</a>
  <nav class="tc" style="display: flex; gap: 28px; color: {FG};"><a href="#" style="color: {TALLY};">Gwaith / Work</a><a href="#">Stiwdio / Studio</a><a href="#">Dyddiadur / Journal</a><a href="#">Cysylltu / Contact</a></nav>
  <div class="tc" style="display: flex; justify-content: flex-end; gap: 20px; align-items: center;"><span>EN <span style="color: {DIM};">/ CY</span></span><span style="color: {FG};">TC 00:00:00:00</span><span style="display: flex; gap: 8px; align-items: center; color: {TALLY};"><span style="width: 8px; height: 8px; border-radius: 50%; background: {TALLY};"></span>Live · Bangor</span></div>
</header>
<section style="position: relative; padding: 4px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px;">
  {wall}
  <div style="position: absolute; left: 0; right: 0; top: 50%; transform: translateY(-50%); display: flex; justify-content: center; pointer-events: none;">
    <div style="background: {TALLY}; color: {BG}; padding: 28px 40px 24px; display: flex; flex-direction: column; gap: 10px; box-shadow: 0 30px 80px rgba(0,0,0,0.5);">
      <span class="tc" style="color: {BG};">Stiwdio brandio a graffeg symud · Branding &amp; motion studio</span>
      <h1 class="druk" style="font-size: 120px;">Brands built<br>to move.</h1>
    </div>
  </div>
</section>
<section style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px; padding: 0 4px;">
  <div style="background: {SURF}; padding: 32px; display: flex; flex-direction: column; gap: 12px;"><span class="tc">Beth</span><p style="margin: 0; font-size: 20px; line-height: 1.4;">Identities with motion at the core, from broadcast idents to whole brand systems.</p></div>
  <div style="background: {SURF}; padding: 32px; display: flex; flex-direction: column; gap: 12px;"><span class="tc">Ble</span><p style="margin: 0; font-size: 20px; line-height: 1.4;">Bangor, North Wales. Bilingual by design, from a sports-broadcast background.</p></div>
  <div style="background: {SURF}; padding: 32px; display: flex; flex-direction: column; gap: 12px; justify-content: space-between;"><span class="tc">Wedi gweithio gyda / Worked with</span><p style="margin: 0; font-size: 20px; line-height: 1.4; color: {DIM};">BBC Sport · Rondo Media · Cwmni Da · Nimble · Menai Track &amp; Field</p></div>
</section>
<section style="padding: 120px 24px 0; display: grid; grid-template-columns: 5fr 7fr; gap: 48px; align-items: start;">
  <span class="tc">Sut rydyn ni'n gweithio / How we work</span>
  <p class="druk" style="font-size: 72px; text-transform: none;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>
<section style="padding: 120px 24px 0; display: flex; flex-direction: column; gap: 24px;">
  <span class="tc">Sianeli / What we do</span>
  <div style="display: flex; flex-direction: column; border-bottom: 1px solid {LINE};">{channels}</div>
</section>
<section style="margin: 120px 4px 4px; background: {TALLY}; color: {BG}; padding: 96px 40px; display: flex; flex-direction: column; gap: 32px;">
  <span class="tc" style="color: {BG};">Cysylltu / Get in touch</span>
  <h2 class="druk" style="font-size: 132px;">Got a brand that<br>needs to move?</h2>
  <div style="display: flex; gap: 16px; align-items: center;"><a href="#" style="padding: 18px 28px; background: {FG}; color: {BG}; font-weight: 600;">Start a project</a><span style="font-size: 18px; font-weight: 500;">[EMAIL]</span></div>
</section>
<footer class="tc" style="display: flex; justify-content: space-between; padding: 24px;"><span>© 2026 Creadigol · Bangor, Gwynedd</span><span>Instagram · LinkedIn · Vimeo · vedrí (stiwdio chwaer) · Cymraeg</span></footer>
""" + FOOT

for name, fn in [("DirectionB.dc.html", direction_b), ("DirectionC.dc.html", direction_c), ("DirectionD.dc.html", direction_d), ("DirectionE.dc.html", direction_e)]:
    open(os.path.join(OUT, name), "w").write(fn())
print("wrote 4 directions")
