# Requirements Verification - Pramish Thapa Portfolio

All 13 mandatory checklist items, where each is implemented, and how to test it.
Re-audited against the current code; every item is met.

Status key: ✅ done & verified

---

### 1. Template scrolls manually top to bottom ✅
- **Where:** Single `index.html`; all nav links are `#anchor` in-page jumps. No
  scroll-jacking / fullpage.js / isotope / swiper / snap libraries anywhere (grep-confirmed).
- **Test:** Scroll with the wheel/trackpad from Home → Contact - it scrolls freely and
  continuously. Clicking a sidebar link jumps to that section.

### 2. Pre-loader hides the site while it renders ✅
- **Where:** `<div id="preloader">` in `index.html`; styles in `css/main.css`
  (`#preloader`, spinner); `js/main.js` adds `body.loaded` on `window load`.
- **Test:** Reload (ideally throttled network in DevTools). A white screen with a blue
  spinner covers everything, then fades out once loaded.

### 3. Typed message is grammatical ✅
- **Where:** Hero `#hero` - `I am a <span class="typed" ...>` cycling
  "Backend Software Engineer", "Web Developer", "Cloud Developer".
- **Test:** Watch the hero. It reads "I am a Backend Software Engineer" - zero occurrences
  of "I'm" in the page.

### 4. No age / birthday / email / phone anywhere on the page ✅
- **Where:** About + Contact carry none. Contact is a form only; the recipient email lives
  server-side in `libs/php/mail-config.php` (gitignored), never in the HTML.
- **Test:** Grep of `index.html` for `mailto:`, `tel:`, `@…`, `age`, `birthday`, phone
  patterns → zero hits. (The form's "Your Email" field is the *visitor's* address, required.)

### 5. Skill bars replaced with a responsive grid of official logos ✅
- **Where:** `#techstack` - no progress bars. Official **devicon** SVGs in
  `assets/img/logos/`, arranged as responsive grids grouped by category
  (Languages / Frontend / Backend / Databases & Messaging / Cloud & DevOps /
  Machine Learning / Tools). Includes **all 20 tutor-required technologies**
  (Java, Spring Boot, Python, JavaScript, React, PHP, MySQL, PostgreSQL, MongoDB,
  GCP, AWS, Docker, Kubernetes, Jenkins, Git, Bootstrap, jQuery, Node.js, HTML5, CSS3)
  plus real additions from my CV (Angular, Vite, Tailwind, Express, Flask, SQLite,
  Firebase, Apache Kafka, HashiCorp Vault, scikit-learn, PyTorch, pandas, NumPy,
  Heroku, Vercel, Jira) - **36 logos total**, every file in use, no orphans.
- **Test:** Resize the window - each category grid reflows from 3 columns (mobile) to 6
  (desktop). All logos render with labels; none are progress bars.

### 6. Every "Resume" replaced with "Curriculum Vitae" ✅
- **Where:** Nav link, section heading, and download button all read "Curriculum Vitae".
- **Test:** Ctrl+F "Resume" → 0 matches. "Curriculum Vitae" appears 3× (nav, title, button).

### 7. Download-PDF button for the full CV ✅
- **Where:** `#cv` - `<a href="assets/cv/Pramish_Thapa_CV.pdf" download target="_blank" rel="noopener">`.
- **Test:** File present at `assets/cv/Pramish_Thapa_CV.pdf` (327 KB). Click "Download CV (PDF)"
  → downloads. **Note:** ensure this file is your backend Software-Engineer CV (not the
  battery-research one), since that's what the section describes.

### 8. Portfolio filter removed; cards spread evenly ✅
- **Where:** `#portfolio` - no `All / App / Web` filter, no `isotope`/`data-filter` JS.
  **7 project cards** in a responsive `row gy-4 justify-content-center`
  (1 col mobile → 2 → 3 desktop), even gutters.
- **Test:** No filter buttons above the projects; cards form a tidy, evenly-spaced grid
  at every width. (Projects: Credit Risk, Company Directory, MeroJobRadar, Energy
  Prediction, Battery RUL, Gazetteer, Earth Letters.)

### 9. Project descriptions open in a Bootstrap modal, not a new page ✅
- **Where:** Each card has a "Details" button (`data-bs-toggle="modal"`) targeting its own
  modal. **7 cards → 7 distinct modals.**
- **Test:** Click "Details" on any card - a modal opens in-page with the description; the URL
  does not change and no new tab opens.

### 10. Tech stack shown for each project ✅
- **Where:** Tech badges appear on **both** the card and inside the modal (`.tech-badges`).
- **Test:** Each card shows pill badges (e.g. Java 17, Spring Boot 3…); the modal repeats
  them under a "Tech stack" heading.

### 11. All links open in a new tab (`target="_blank"` + `rel="noopener"`) ✅
- **Where:** Every external link (social, repo, live-demo) has both attributes.
- **Test:** Automated check - **16/16** external `<a>` links carry `target="_blank"`
  **and** `rel="noopener"`. Click any repo/demo link → opens in a new tab.

### 12. Images optimised (compressed, right-sized, lazy-loaded) ✅
- **Where:** Real compressed raster images, all under 100 KB:
  profile logo 37 KB, About photo 94 KB, project screenshots 24-76 KB
  (originals were 0.6-4.2 MB). All 36 tech logos are **SVG** (vector, tiny). The hero
  background is now a **pure-CSS animated gradient** (no image at all).
- **Lazy-loading:** every content `<img>` uses `loading="lazy"`, **except** the sidebar
  profile logo, which is intentionally eager (above the fold - lazy would delay it).
- **Test:** DevTools → Network: logos/screenshots load only as you scroll to them; total
  image weight is a few hundred KB.

### 13. Working contact form: AJAX → PHPMailer, from-me-to-me, validation, sanitisation, gitignored creds ✅
- **Where:**
  - Front end: `#contact-form` + `js/main.js` - client-side validation (required fields,
    email pattern), AJAX `fetch()` POST, success/error message shown **without page reload**.
  - Back end: `libs/php/send-mail.php` - server-side sanitisation (`strip_tags`, trim,
    control-char strip), server-side validation, honeypot anti-spam, sends via **PHPMailer**
    over authenticated SMTP FROM the site address TO you with the form contents in the body,
    returns JSON. `from_email` is aligned to the authenticated mailbox (`contact@pramishthapa.com`)
    so Hostinger won't reject it.
  - Secrets: `libs/php/mail-config.php` holds SMTP credentials and is **gitignored**
    (verified via `git check-ignore`); `mail-config.example.php` is the committed template.
- **Test (verified live):**
  - `GET` → `{"status":"error","message":"Invalid request method."}`
  - Empty POST → validation error JSON
  - Honeypot filled → silent success (bot trap)
  - **Real submission with live credentials → delivered to the inbox** (confirmed received).

---

## Manual inputs - all provided ✅
| Item | Status |
|------|--------|
| CV PDF (`assets/cv/Pramish_Thapa_CV.pdf`) | ✅ in place (confirm it's the SWE version) |
| Profile logo (`assets/img/profile/profile.jpg`) | ✅ circular crop, optimised |
| About photo (`assets/img/profile/profile-about.jpg`) | ✅ fuller photo, optimised |
| Project screenshots (`assets/img/portfolio/*.jpg`) | ✅ all in place, optimised |
| SMTP password (`libs/php/mail-config.php`) | ✅ set; live email test passed |

## Technical constraints - met
- ✅ Plain HTML/CSS/JS/PHP, **no build step** (no `package.json`/webpack)
- ✅ Clean folders: `css/`, `js/`, `assets/img/`, `assets/cv/`, `libs/php/`
- ✅ **All libraries local**, **zero CDN references** in html/css/js (grep-confirmed)
- ✅ Mobile-first responsive: off-canvas sidebar + hamburger on tablet/phone, fluid
  typography (`clamp`), category grids reflow, no horizontal overflow, large-screen cap.

## Notes on fixes made during review
- Scrollspy previously selected the sidebar's external social links and threw on
  `querySelector("https://…")`, which aborted `main.js` - so the active-nav highlight stuck
  on Home **and the contact form's client-side AJAX never attached**. Both fixed by scoping
  the scrollspy to `#navmenu ul a`.
- Nav hover no longer shares the filled "active" style, so only one item is highlighted.
