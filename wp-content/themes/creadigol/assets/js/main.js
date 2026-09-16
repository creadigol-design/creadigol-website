/* Creadigol theme: menu, loops, filters, reveal, showreel. No dependencies. */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var touch = window.matchMedia('(hover: none)').matches;

  /* Mobile menu */
  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.nav-toggle');
  if (header && toggle) {
    toggle.addEventListener('click', function () {
      var open = header.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* Video loops: source is set lazily; play on hover/focus, or when in view on touch devices. */
  var loops = Array.prototype.slice.call(document.querySelectorAll('video.loop[data-src]'));
  function load(video) {
    if (!video.getAttribute('src')) { video.setAttribute('src', video.getAttribute('data-src')); video.load(); }
  }
  function play(video) { load(video); var p = video.play(); if (p && p.catch) { p.catch(function () {}); } }
  function pause(video) { if (!video.paused) { video.pause(); } }

  loops.forEach(function (video) {
    var host = video.closest('a, .hero, .next') || video;
    if (video.hasAttribute('data-autoplay')) {
      if (!reduced) { play(video); }
      return;
    }
    if (touch || reduced) { return; }
    host.addEventListener('mouseenter', function () { play(video); });
    host.addEventListener('mouseleave', function () { pause(video); });
    host.addEventListener('focus', function () { play(video); }, true);
    host.addEventListener('blur', function () { pause(video); }, true);
  });

  if ('IntersectionObserver' in window) {
    var inView = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var video = entry.target;
        if (video.hasAttribute('data-autoplay')) { return; }
        if (touch && !reduced) { entry.isIntersecting ? play(video) : pause(video); }
        else if (entry.isIntersecting) { load(video); }
      });
    }, { rootMargin: '200px 0px' });
    loops.forEach(function (v) { inView.observe(v); });

    /* Reveal: elements below the fold start nudged down and settle when they enter. */
    if (!reduced) {
      var items = document.querySelectorAll('.tile, .service, .row');
      var fold = window.innerHeight;
      var reveal = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) { entry.target.classList.remove('is-below'); reveal.unobserve(entry.target); }
        });
      }, { rootMargin: '0px 0px -8% 0px' });
      items.forEach(function (el) {
        if (el.getBoundingClientRect().top > fold) { el.classList.add('is-below'); reveal.observe(el); }
      });
      /* Safety net: nothing stays hidden if the observer never fires (print, odd embeds, old browsers). */
      window.setTimeout(function () {
        document.querySelectorAll('.is-below').forEach(function (el) { el.classList.remove('is-below'); reveal.unobserve(el); });
      }, 2500);
    }
  }

  /* Work grid filter: instant on the page; the chips are also real links for search engines. */
  var grid = document.querySelector('[data-work-grid]');
  var chips = document.querySelectorAll('.filters .chip[data-filter]');
  if (grid && chips.length) {
    chips.forEach(function (chip) {
      chip.addEventListener('click', function (e) {
        e.preventDefault();
        var f = chip.getAttribute('data-filter');
        chips.forEach(function (c) { c.classList.toggle('is-active', c === chip); });
        grid.querySelectorAll('.work-grid__item').forEach(function (item) {
          var list = (item.getAttribute('data-disciplines') || '').split(' ');
          item.classList.toggle('is-hidden', f !== '*' && list.indexOf(f) === -1);
        });
        if (history.replaceState) { history.replaceState(null, '', chip.getAttribute('href')); }
      });
    });
  }

  /* Showreel dialog */
  var dialog = document.getElementById('reel');
  var playBtn = document.querySelector('[data-showreel]');
  if (dialog && playBtn && typeof dialog.showModal === 'function') {
    var frame = dialog.querySelector('.reel__frame');
    function embed(url) {
      var m;
      if ((m = url.match(/vimeo\.com\/(?:video\/)?(\d+)/))) { return '<iframe src="https://player.vimeo.com/video/' + m[1] + '?autoplay=1&title=0&byline=0&portrait=0" allow="autoplay; fullscreen" allowfullscreen title="Showreel"></iframe>'; }
      if ((m = url.match(/(?:youtu\.be\/|v=)([\w-]{11})/))) { return '<iframe src="https://www.youtube-nocookie.com/embed/' + m[1] + '?autoplay=1&rel=0" allow="autoplay; fullscreen" allowfullscreen title="Showreel"></iframe>'; }
      return '<video src="' + url + '" controls autoplay playsinline></video>';
    }
    playBtn.addEventListener('click', function () {
      frame.innerHTML = embed(playBtn.getAttribute('data-showreel'));
      dialog.showModal();
    });
    function close() { dialog.close(); frame.innerHTML = ''; }
    dialog.querySelector('.reel__close').addEventListener('click', close);
    dialog.addEventListener('click', function (e) { if (e.target === dialog) { close(); } });
    dialog.addEventListener('close', function () { frame.innerHTML = ''; });
  }
})();
