# Online Transport Booking — Final Year Project (Localhost / XAMPP)

This is a ready-to-run PHP + MySQL project you can present to your supervisor.
It includes:
- Secure user registration (password hashing)
- Admin panel (create admin via setup script)
- CRUD for routes, vehicles, trips (admin)
- User search & booking flow (bookings stored in DB)
- Clean responsive CSS and placeholder GIGM bus background image

## Installation (Windows, XAMPP)

1. Copy the folder `transport_booking_final` to `C:\xampp\htdocs\` and rename to `transport_booking` if desired.
2. Start Apache and MySQL in XAMPP Control Panel.
3. Open phpMyAdmin (http://localhost/phpmyadmin) and import `database.sql` (in the project root).
4. Visit `http://localhost/transport_booking/admin/setup_admin.php` to create a default admin (run once).
5. Open site: http://localhost/transport_booking/

Default admin after running setup:
- Email: admin@local
- Password: Admin@123
