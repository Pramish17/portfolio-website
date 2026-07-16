/* ==========================================================================
   Pramish Thapa - Portfolio: interactions
   Vanilla JS only (Bootstrap bundle, Typed.js and AOS loaded separately).
   ========================================================================== */
(function () {
  "use strict";

  /* ---- Req 2: Pre-loader - reveal the site only once fully loaded ------- */
  window.addEventListener("load", function () {
    document.body.classList.add("loaded");
  });

  /* ---- Req 3: Grammatical typing effect -------------------------------- */
  const typedEl = document.querySelector(".typed");
  if (typedEl && typeof Typed !== "undefined" && !typedEl.dataset.typedInit) {
    typedEl.dataset.typedInit = "1"; // guard against any double-initialisation
    const items = typedEl.getAttribute("data-typed-items").split(",").map(s => s.trim());
    new Typed(".typed", {
      strings: items,
      loop: true,
      typeSpeed: 55,
      backSpeed: 25,
      backDelay: 1600,
      startDelay: 400,
      smartBackspace: true,
      showCursor: true,
      cursorChar: "|"
    });
  }

  /* ---- Animate On Scroll ----------------------------------------------- */
  if (typeof AOS !== "undefined") {
    AOS.init({ duration: 700, easing: "ease-in-out", once: true, mirror: false });
  }

  /* ---- Mobile nav toggle ----------------------------------------------- */
  const navToggle = document.querySelector(".mobile-nav-toggle");
  function toggleNav() {
    document.body.classList.toggle("mobile-nav-active");
    navToggle.querySelector("i").classList.toggle("bi-list");
    navToggle.querySelector("i").classList.toggle("bi-x");
  }
  if (navToggle) navToggle.addEventListener("click", toggleNav);

  // Close mobile nav after clicking a link
  document.querySelectorAll("#navmenu a").forEach(link => {
    link.addEventListener("click", () => {
      if (document.body.classList.contains("mobile-nav-active")) toggleNav();
    });
  });

  /* ---- Active nav link on scroll (lightweight scrollspy) --------------- */
  // Only the in-page menu links (exclude the external social links in the profile block).
  const navLinks = document.querySelectorAll("#navmenu ul a");
  const spyTargets = Array.from(navLinks)
    .map(a => {
      const href = a.getAttribute("href");
      const section = href && href.charAt(0) === "#" ? document.querySelector(href) : null;
      return section ? { link: a, section: section } : null;
    })
    .filter(Boolean);

  function onScroll() {
    const pos = window.scrollY + 200;
    // The active section is the last one whose top has scrolled past the marker.
    let current = null;
    spyTargets.forEach(t => {
      if (t.section.offsetTop <= pos) current = t.link;
    });
    if (current) {
      navLinks.forEach(l => l.classList.remove("active"));
      current.classList.add("active");
    }
    // Scroll-to-top button
    const top = document.getElementById("scroll-top");
    if (top) top.classList.toggle("active", window.scrollY > 100);
  }
  window.addEventListener("scroll", onScroll);
  onScroll();

  /* ---- Req 13: Contact form - client validation + AJAX, no page reload -- */
  const form = document.getElementById("contact-form");
  if (form) {
    const loading = form.querySelector(".loading");
    const errorBox = form.querySelector(".error-message");
    const sentBox = form.querySelector(".sent-message");

    function show(el, msg) {
      [loading, errorBox, sentBox].forEach(b => (b.style.display = "none"));
      if (el) {
        el.style.display = "block";
        if (msg) el.textContent = msg;
      }
    }

    function validEmail(v) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    function validate() {
      let ok = true;
      const fields = form.querySelectorAll("[required]");
      fields.forEach(f => {
        const empty = !f.value.trim();
        const badEmail = f.type === "email" && f.value && !validEmail(f.value);
        f.classList.toggle("is-invalid", empty || badEmail);
        if (empty || badEmail) ok = false;
      });
      return ok;
    }

    // Clear invalid state as the user corrects a field
    form.querySelectorAll("[required]").forEach(f => {
      f.addEventListener("input", () => f.classList.remove("is-invalid"));
    });

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      if (!validate()) {
        show(errorBox, "Please fill in all fields with a valid email address.");
        return;
      }

      show(loading);
      const data = new FormData(form);

      fetch(form.getAttribute("action"), { method: "POST", body: data })
        .then(res => res.json().catch(() => { throw new Error("Bad server response"); }))
        .then(json => {
          if (json.status === "success") {
            show(sentBox, json.message || "Your message has been sent. Thank you!");
            form.reset();
          } else {
            show(errorBox, json.message || "Something went wrong. Please try again.");
          }
        })
        .catch(() => show(errorBox, "Unable to send your message right now. Please try again later."));
    });
  }
})();
