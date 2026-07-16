# Pramish Thapa - Portfolio

A single-page, manually-scrolling personal portfolio (based on the BootstrapMade
**iPortfolio** template, rebuilt as plain static files). No build step, no CDNs -
every library is vendored locally so it drops straight onto Hostinger shared hosting
under `pramishthapa.com`.

## Tech
- Plain HTML / CSS / JavaScript + PHP (contact form only)
- Bootstrap 5, Bootstrap Icons, AOS, Typed.js - all stored locally in `css/vendor/` and `js/vendor/`
- PHPMailer (contact form) - local in `libs/php/PHPMailer/`
- Official tech logos - devicon SVGs in `assets/img/logos/`

## Folder structure
```
index.html
css/            main.css + vendor/ (bootstrap, icons, aos)
js/             main.js  + vendor/ (bootstrap, typed, aos)
assets/img/     logos/ (20 tech SVGs), portfolio/ (screenshots), profile/ (photo)
assets/cv/      Pramish_Thapa_CV.pdf   <-- you drop this in
libs/php/       send-mail.php, mail-config.php (gitignored), mail-config.example.php, PHPMailer/
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
1. Copy the config template and fill in real credentials:
   ```bash
   cp libs/php/mail-config.example.php libs/php/mail-config.php
   ```
2. In Hostinger hPanel → Emails, create a mailbox (e.g. `no-reply@pramishthapa.com`)
   and use its SMTP details. Edit `libs/php/mail-config.php`:
   - `host` = `smtp.hostinger.com`, `port` = `465`, `encryption` = `ssl`
   - `username` / `password` = the mailbox credentials
   - `to_email` = where you want to receive messages
3. `mail-config.php` is **gitignored** - your password never reaches the repo.

## Deploying to Hostinger
Upload the whole folder to `public_html/` (or a subfolder) via hPanel File Manager
or SFTP. No build, no npm. Ensure `libs/php/mail-config.php` exists on the server
with real credentials (it won't be in git, so upload it manually or create it via
the File Manager).

## Things YOU still need to add (see VERIFICATION.md)
- `assets/cv/Pramish_Thapa_CV.pdf` - your CV
- `assets/img/profile/profile.(jpg|webp)` - your photo (replace the placeholder SVG)
- `assets/img/portfolio/*.(jpg|webp)` - project screenshots (replace placeholder SVGs)
- Real SMTP password in `libs/php/mail-config.php`
