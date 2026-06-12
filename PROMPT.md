Act as a Senior Frontend Engineer and Expert UI Designer.

Build the public frontend for SIROMA: Sistem Informasi Rekrutmen Organisasi Mahasiswa.

## Product Context

SIROMA helps students:

- discover active organization recruitment periods
- view organization and division details
- submit recruitment applications
- upload application documents
- track application status

The admin and reviewer workflow is handled separately through Filament at `/admin`.

## Visual Direction

Use the Manga Instructional Comic design system from `DESIGN.md`, adapted for a readable student recruitment web app.

Use:

- Indonesian copywriting
- black and white dominant UI
- comic panel cards
- strong ink borders
- subtle screentone textures
- speed-line accents only for decorative sections
- asymmetric layouts on desktop
- clean, readable forms on application pages

Avoid:

- pricing sections
- fake testimonials
- generic SaaS copywriting
- emojis as icons
- unreadable decorative fonts in forms
- overusing manga effects on form-heavy pages
- external image links that can break

## Required Public Pages

1. Landing page `/`
   - Navbar
   - Hero section
   - Active recruitment preview
   - How to apply
   - Organization preview
   - Recruitment statistics
   - FAQ
   - Footer

2. Recruitment listing `/rekrutmen`
   - Active and recent recruitment periods
   - Organization filter
   - Recruitment cards
   - Status badges

3. Recruitment detail `/rekrutmen/{period}`
   - Recruitment title
   - Organization info
   - Registration dates
   - Quota
   - Available divisions
   - CTA to apply

4. Application form `/rekrutmen/{period}/daftar`
   - Applicant data
   - First division choice
   - Optional second division choice
   - Motivation field
   - Document upload section
   - Clear validation messages

5. Application status `/pendaftaran/{application}`
   - Application code
   - Current status
   - Division preferences
   - Uploaded documents
   - Status history timeline

## Technical Direction

Use Laravel Blade, Tailwind CSS, and Vite.

Suggested structure:

- `resources/views/layouts/public.blade.php`
- `resources/views/components/*`
- `resources/views/pages/*`
- `app/Http/Controllers/*`

The frontend must be responsive on mobile, tablet, and desktop.

Use data from Eloquent models and database views where useful. Keep Filament-specific UI separate from the public frontend.
