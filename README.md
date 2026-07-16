# Pramish Thapa - Portfolio

A single-page, manually-scrolling personal portfolio (based on the BootstrapMade
**iPortfolio** template, rebuilt as plain static files). No build step, no CDNs -
every library is vendored locally so it drops straight onto Hostinger shared hosting
under `pramishthapa.com`.

Live sections: Home (animated hero) · About · Tech Stack · Curriculum Vitae · Portfolio · Contact.

## Tech
- Plain HTML / CSS / JavaScript + PHP (contact form only), mobile-first responsive
- Bootstrap 5, Bootstrap Icons, AOS, Typed.js - all stored locally in `css/vendor/` and `js/vendor/`
- PHPMailer (contact form) - local in `libs/php/PHPMailer/`
- Official tech logos - devicon SVGs in `assets/img/logos/` (36, grouped by category)
- Animated hero background is pure CSS (gradient drift + floating orbs), no images/JS

## Folder structure
```
index.html
css/            main.css + vendor/ (bootstrap, icons, aos, fonts)
js/             main.js  + vendor/ (bootstrap, typed, aos)
assets/img/     favicon.svg
                logos/     36 tech SVGs
                portfolio/ project screenshots (.jpg) + branded covers (.svg)
                profile/   profile.jpg (circular logo) + profile-about.jpg (About photo)
assets/cv/      Pramish_Thapa_CV.pdf
libs/php/       send-mail.php, mail-config.php (gitignored), mail-config.example.php, PHPMailer/
.gitignore  README.md  VERIFICATION.md
```

## Running locally
It's static, so any web server works. For the PHP contact form you need PHP:
```bash
php -S 127.0.0.1:8000
# then open http://127.0.0.1:8000
```
Opening `index.html` via `file://` works for everything **except** the contact form
(PHP needs a server).

## Contact form setup (SMTP)
The recipient email is NOT in the HTML - it lives only in this gitignored config.
1. Copy the template:
   ```bash
   cp libs/php/mail-config.example.php libs/php/mail-config.php
   ```
2. In Hostinger hPanel → Emails, create a mailbox (e.g. `contact@pramishthapa.com`).
   Edit `libs/php/mail-config.php`:
   - `host` = `smtp.hostinger.com`, `port` = `465`, `encryption` = `ssl`
   - `username` / `password` = the mailbox credentials
   - `from_email` = **the same mailbox as `username`** (Hostinger rejects a mismatched From)
   - `to_email` = where you want to receive messages
3. `mail-config.php` is **gitignored** - the password never reaches the repo.

## Deploying to Hostinger

### Option A - File Manager / SFTP
Upload the whole project into `public_html/` (the site root) via hPanel File Manager
or SFTP. No build, no npm. Your other projects in subfolders
(`/project2/companydirectory`, `/gazetteer`, `/earthletters`) are untouched.

### Option B - Git deploy
Push this repo to GitHub, then hPanel → Advanced → Git → paste the repo URL, branch
`main`, directory `public_html`, and Deploy. (Private repo → add Hostinger's deploy key
to GitHub first.) Add the auto-deploy webhook to GitHub for push-to-deploy.

### Required on the server (both options)
- Set PHP to **8.0+** (hPanel → Advanced → PHP Configuration).
- Create `public_html/libs/php/mail-config.php` **on the server** with real SMTP creds
  (it is gitignored, so it never arrives via Git - copy `mail-config.example.php` and
  edit it in File Manager). Because it is untracked, later Git deploys won't overwrite it.
- Enable Force HTTPS / SSL (hPanel → Security → SSL).

## Status
All 13 tutor requirements are implemented and verified - see `VERIFICATION.md` for the
per-item checklist and how to test each. Content (CV PDF, profile photos, project
screenshots) is in place; the only server-side step is the SMTP `mail-config.php` above.
