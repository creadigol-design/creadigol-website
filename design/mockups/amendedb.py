#!/usr/bin/env python3
"""Amended Direction B, the build reference: home page, desktop and mobile."""
import os
os.environ["THEME"] = "B"
import build as b
from build import INK, PAPER, MID, LINE, TALLY, TONES, PLAY, ARROW, MENU, head, nav, media, footer, eyebrow, lower_third

PROJECTS = [
    ("Rondo Media", "Rownd a Rownd", "Rebrand · Broadcast", TONES[0], "Rownd a Rownd idents"),
    ("Rondo Media", "Pen Petrol S1–2", "Titles · Programme graphics", TONES[1], "Pen Petrol title sequence"),
    ("Menai Track &amp; Field", "Club website", "Digital · Identity", TONES[2], "Menai T&amp;F site"),
    ("Codi'r To", "10th birthday rebrand", "Branding · Motion", TONES[6], "Codi'r To identity"),
    ("Eisteddfod", "Esports tournament", "Branding · Motion · 3D", TONES[7], "Esports ident"),
    ("Self Storage Booker", "Brand identity", "Branding · Campaign", TONES[3], "Self Storage Booker campaign"),
]
CLIENTS = ["BBC Sport", "Rondo Media", "Cwmni Da", "Nimble", "Menai Track &amp; Field", "Codi'r To", "Self Storage Booker"]

def strip(pad="14px 48px", size=20):
    items = "".join(f'<span>{c}</span><span style="color: {INK}; opacity: 0.45;">//</span>' for c in CLIENTS + CLIENTS[:4])
    return f'<div class="display" style="display: flex; gap: 24px; padding: {pad}; font-size: {size}px; background: {TALLY}; color: {INK}; white-space: nowrap; overflow: hidden;">{items}</div>'

def big_tile(h, tone, client, title, tags, label):
    m = media("100%", h, tone, label, radius=0).rstrip()
    return f'<a href="#" style="display: block;">{m[:-6]}{lower_third(client, title, tags)}</div></a>'

def hero(desktop=True):
    if desktop:
        return f"""
<section style="position: relative; height: 820px; background: {INK}; color: {PAPER}; overflow: hidden;">
  <div class="hatch" style="position: absolute; inset: 0; background: #383838;"></div>
  <span class="mono" style="position: absolute; top: 24px; left: 48px; color: #9A9A9A;">[LOOP] Showreel plays behind the headline · muted · 01 of 06</span>
  <span class="mono" style="position: absolute; top: 24px; right: 48px; color: {TALLY};">Bangor, Gogledd Cymru · Stiwdio brandio a graffeg symud</span>
  <div style="position: absolute; left: 48px; right: 48px; bottom: 56px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px; align-items: end;">
    <h1 class="display" style="font-size: 124px; color: {PAPER};">Brandiau sy'n symud.</h1>
    <div style="display: flex; flex-direction: column; gap: 28px;">
      <h1 class="display" style="font-size: 124px; color: {TALLY};">Brands built to move.</h1>
      <div style="display: flex; justify-content: space-between; align-items: end; gap: 24px;">
        <p style="margin: 0; font-size: 19px; line-height: 1.4; max-width: 34ch; color: #DADADA;">Identities with motion at the core, from a sports-broadcast background. Designed in Welsh and English together.</p>
        <span>{PLAY}</span>
      </div>
    </div>
  </div>
</section>
{strip()}"""
    return f"""
<section style="position: relative; height: 620px; background: {INK}; color: {PAPER}; overflow: hidden;">
  <div class="hatch" style="position: absolute; inset: 0; background: #383838;"></div>
  <span class="mono" style="position: absolute; top: 16px; left: 20px; color: #9A9A9A;">[LOOP] Showreel</span>
  <div style="position: absolute; left: 20px; right: 20px; bottom: 28px; display: flex; flex-direction: column; gap: 14px;">
    <h1 class="display" style="font-size: 60px; color: {PAPER};">Brandiau sy'n symud.</h1>
    <h1 class="display" style="font-size: 60px; color: {TALLY};">Brands built to move.</h1>
    <div style="display: flex; justify-content: space-between; align-items: end; gap: 16px;"><p style="margin: 0; font-size: 16px; line-height: 1.4; color: #DADADA;">Identities with motion at the core. Designed in Welsh and English together.</p><span style="transform: scale(0.75); transform-origin: bottom right;">{PLAY}</span></div>
  </div>
</section>
{strip(pad="10px 20px", size=16)}"""

def work_section():
    p = PROJECTS
    small = "".join(big_tile(300, t[3], t[0], t[1], t[2], t[4]) for t in p[2:6])
    return f"""
<section style="padding: 96px 48px 0; display: flex; flex-direction: column; gap: 32px;">
  <div style="display: flex; justify-content: space-between; align-items: end;">
    <h2 class="display" style="font-size: 96px;">Gwaith <span style="color: {MID};">/</span> Work</h2>
    <a href="#" class="mono" style="display: flex; gap: 8px; align-items: center;">Pob prosiect / All work {ARROW}</a>
  </div>
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 32px;">
    {big_tile(440, p[0][3], p[0][0], p[0][1], p[0][2], p[0][4])}
    {big_tile(440, p[1][3], p[1][0], p[1][1], p[1][2], p[1][4])}
  </div>
  <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px;">{small}</div>
</section>"""

def statement():
    return f"""
<section style="margin-top: 120px; padding: 96px 48px; background: {TALLY}; color: {INK}; display: flex; flex-direction: column; gap: 28px;">
  {eyebrow("Sut rydyn ni'n gweithio", "How we work", color=INK)}
  <p class="display" style="font-size: 112px; max-width: 1300px;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>"""

def services():
    cols = "".join(f'<div style="display: flex; flex-direction: column; gap: 14px; border-top: 2px solid {INK}; padding-top: 20px;"><span class="mono" style="color: {MID};">{cy}</span><h3 class="display" style="font-size: 40px;">{en}</h3><p style="margin: 0; color: {MID}; font-size: 17px;">{d}</p></div>' for cy, en, d in [
        ("Hunaniaeth brand a strategaeth", "Brand identity<br>&amp; strategy", "Positioning, naming, identity systems and guidelines, designed to move from day one."),
        ("Graffeg symud ac animeiddio", "Motion<br>&amp; animation", "Idents, title sequences, programme graphics, social and explainer animation."),
        ("Digidol a gwe", "Digital<br>&amp; web", "Fast, bilingual websites that carry the identity into every screen.")])
    return f'<section style="padding: 120px 48px 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px;">{cols}</section>'

def journal():
    rows = "".join(f'<a href="#" style="display: grid; grid-template-columns: 160px 1fr 40px; gap: 32px; align-items: center; padding: 22px 0; border-top: 1px solid {LINE}; font-size: 20px; font-weight: 500;"><span class="mono" style="color: {MID};">{d}</span><span>{t}</span>{ARROW}</a>' for d, t in [
        ("[DATE]", "Creadigol Design is now Creadigol"), ("Jun 2025", "Behind the scenes: vedrí's first virtual production shoot at Aria Studios"), ("2025", "Finalist, UK StartUp Awards 2025: Creative StartUp of the Year, Wales")])
    return f"""
<section style="padding: 120px 48px 0; display: flex; flex-direction: column; gap: 24px;">
  <div style="display: flex; justify-content: space-between; align-items: baseline;">{eyebrow("Dyddiadur", "Journal")}<a href="#" class="mono" style="display: flex; gap: 8px; align-items: center;">All notes {ARROW}</a></div>
  <div style="display: flex; flex-direction: column; border-bottom: 1px solid {LINE};">{rows}</div>
</section>"""

def cta():
    return f"""
<section style="margin-top: 140px; padding: 120px 48px; background: {INK}; color: {PAPER}; display: flex; flex-direction: column; gap: 32px;">
  {eyebrow("Cysylltu", "Get in touch", color="#9A9A9A")}
  <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 48px; align-items: end;">
    <h2 class="display" style="font-size: 104px;">Oes gennych chi frand sydd angen symud?</h2>
    <h2 class="display" style="font-size: 104px; color: {TALLY};">Got a brand that needs to move?</h2>
  </div>
  <div style="display: flex; gap: 16px; align-items: center;"><a href="#" style="padding: 18px 28px; background: {TALLY}; color: {INK}; font-weight: 600; font-size: 17px;">Start a project / Dechrau prosiect</a><a href="#" style="font-size: 20px; font-weight: 500; padding: 18px 8px; color: {PAPER};">[EMAIL]</a></div>
</section>"""

def home_desktop():
    return head() + nav() + hero() + work_section() + statement() + services() + journal() + cta() + footer() + b.FOOT

def home_mobile():
    tiles = "".join(f'<a href="#" style="display: block;">{media("100%", 240, t[3], t[4], radius=0).rstrip()[:-6]}{lower_third(t[0], t[1], t[2]).replace("font-size: 28px", "font-size: 22px")}</div></a>' for t in PROJECTS[:4])
    return head() + f"""
<div style="width: 390px; display: flex; flex-direction: column;">
<header style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: {INK}; color: {PAPER};">
  <span class="wordmark" style="font-size: 20px;"><span style="width: 10px; height: 10px; background: {TALLY}; display: inline-block; margin-right: 10px; vertical-align: 1px;"></span>Creadigol</span>
  <div style="display: flex; gap: 10px; align-items: center;"><span class="mono" style="font-size: 11px;">EN <span style="opacity: 0.5;">/ CY</span></span><span style="display: flex; width: 44px; height: 44px; align-items: center; justify-content: center;">{MENU}</span></div>
</header>
{hero(desktop=False)}
<section style="padding: 56px 20px 0; display: flex; flex-direction: column; gap: 20px;">
  <h2 class="display" style="font-size: 56px;">Gwaith <span style="color: {MID};">/</span> Work</h2>
  {tiles}
  <a href="#" class="mono" style="display: flex; gap: 8px; align-items: center; padding: 8px 0;">Pob prosiect / All work {ARROW}</a>
</section>
<section style="margin-top: 64px; padding: 56px 20px; background: {TALLY}; color: {INK}; display: flex; flex-direction: column; gap: 18px;">
  {eyebrow("Sut rydyn ni'n gweithio", "How we work", color=INK)}
  <p class="display" style="font-size: 44px;">Motion isn't a layer we add at the end. It's the first question we ask.</p>
</section>
<section style="padding: 56px 20px 0; display: flex; flex-direction: column; gap: 16px;">
  {"".join(f'<div style="border-top: 2px solid {INK}; padding-top: 14px; display: flex; flex-direction: column; gap: 4px;"><span class="mono" style="color: {MID};">{cy}</span><h3 class="display" style="font-size: 30px;">{en}</h3></div>' for cy, en in [("Hunaniaeth brand a strategaeth", "Brand identity &amp; strategy"), ("Graffeg symud ac animeiddio", "Motion &amp; animation"), ("Digidol a gwe", "Digital &amp; web")])}
</section>
<section style="margin-top: 64px; padding: 64px 20px; background: {INK}; color: {PAPER}; display: flex; flex-direction: column; gap: 20px;">
  <h2 class="display" style="font-size: 48px;">Oes gennych chi frand sydd angen symud?</h2>
  <h2 class="display" style="font-size: 48px; color: {TALLY};">Got a brand that needs to move?</h2>
  <a href="#" style="align-self: flex-start; padding: 16px 24px; background: {TALLY}; color: {INK}; font-weight: 600; font-size: 16px;">Start a project</a>
</section>
<footer style="padding: 32px 20px; background: {INK}; color: {PAPER}; border-top: 1px solid #454545; display: flex; flex-direction: column; gap: 12px;">
  <div class="mono" style="display: flex; flex-direction: column; gap: 8px; font-size: 11px;"><a href="#">Gwaith / Work</a><a href="#">Stiwdio / Studio</a><a href="#">Dyddiadur / Journal</a><a href="#">Cysylltu / Contact</a></div>
  <span class="mono" style="color: #9A9A9A; font-size: 11px;">© 2026 Creadigol · Bangor, Gwynedd · vedrí (stiwdio chwaer)</span>
</footer>
</div>
""" + b.FOOT

if __name__ == "__main__":
    open(os.path.join(b.OUT, "AmendedB.dc.html"), "w").write(home_desktop())
    open(os.path.join(b.OUT, "AmendedBMobile.dc.html"), "w").write(home_mobile())
    print("wrote AmendedB.dc.html, AmendedBMobile.dc.html")
