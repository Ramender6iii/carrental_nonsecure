# Basic Non-secure Car Rental Coursework Build

Folders: public (pages/assets), api (JSON endpoints), config (database), sql (schema).
common.php contains the shared login and layout helpers used by the pages.
The unused includes folder, audit helper/table/display, mail configuration and inactive CSRF helpers have been removed.
Basic login, dashboard, administration, operations and reports are retained.
API account/role checks and existing business validation are retained.

## Setup
1. Use PHP 8.1 or newer with PDO MySQL (for example XAMPP).
2. Create the database car_rental_nonsecure and import sql/schema.sql.
3. Adjust config/db.php for your local database credentials.
4. Open public/setup_admin.php once to seed demo accounts and data.
5. Open public/login.php. Demo credentials remain shown on that page.

This is a deliberately non-secure coursework build. Use synthetic data in a local lab.
The removed audit feature is not available in this version.

## Validation
Static checks confirmed local PHP require paths resolve and removed helper references are absent.
PHP execution and database workflows were not tested in the editing environment.
