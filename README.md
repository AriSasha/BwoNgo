# BwoNgo

A web-based mental health screening and referral platform for Makerere University Business School students and the counseling office. 

## What it does

**Students**
- Create an account and take a private check-in: PHQ-9 (mood), GAD-7 (anxiety), or both.
- See scores and severity bands straight away.
- If PHQ-9 question 9 (self-harm thoughts) is answered above zero, Uganda crisis lines are shown immediately.
- At or above the referral threshold, request a referral. A ticket such as `BWN-261019-K7Q2` is created only after the student consents to share their name and contact details.
- Below the threshold, see self-help ideas (and still request a referral if they want).
- Message the counseling office anonymously. The office sees an alias such as "Student K7Q2", never the name.
- See past check-ins and referral status.

**Counseling office** (role `counselor` or `admin`)
- Referral queue, urgent cases first (self-harm answer = urgent, any score 15+ = high), with status and private notes.
- Anonymous message threads with replies.
- Overview of check-in totals and severity spread, with no names.
- Admins only: office details, referral thresholds, self-help ideas, and staff accounts.


### Starter accounts (change the passwords)

| Role | Email | Password |
|---|---|---|
| Admin | admin@bwongo.test | password |
| Counselor | counselor@bwongo.test | password |
| Student | student@bwongo.test | password |

Students can also create their own accounts from the sign-up page.

## MUBS logo and colors

- Logo: save it as `public/images/mubs-logo.png` (or `.svg`). It shows in the header and on the welcome and sign-in pages automatically.
- Colors: edit the first block of `public/css/bwongo.css` (`--brand`, `--brand-ink`, `--brand-soft`, `--accent`).

## Where things are

| Part | Location |
|---|---|
| PHQ-9 / GAD-7 questions, scoring, bands, crisis lines | `app/Support/Screening.php` |
| Database tables | `database/migrations/2026_10_19_000100_create_bwongo_tables.php` |
| Models | `app/Models` (User, Screening, Referral, Conversation, Message, Setting, Resource) |
| Student pages | `app/Http/Controllers/Student`, `resources/views/student` |
| Counseling office pages | `app/Http/Controllers/Office`, `resources/views/office` |
| Routes and role access | `routes/web.php`, `app/Http/Middleware/EnsureRole.php` |
| Styles | `public/css/bwongo.css` |
| Tests | `tests/` (run with `php artisan test`) |

## Notes

- BwoNgo is a screening tool, not a diagnostic tool. Referral tickets are not connected to any real counseling records system.
- The office cannot see who wrote an anonymous message in the app, but anyone with direct database access can link a conversation to an account. Limit database access accordingly.
- Crisis numbers (verified October 2026): 999/112, Butabika toll-free 0800 211 306, Mental Health Uganda 0800 21 21 21 (weekdays). 
