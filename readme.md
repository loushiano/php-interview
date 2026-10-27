# SMG Clients — interview exercise

A small PHP app in the same shape as `php-database`: front controller, router, controllers, models, views, and a database adapter. It has a sign-in screen and a dashboard that lists clients. A signed-in user can change a client's name from that list.

The main application uses MySQL. This exercise uses a SQLite file so it runs with PHP only. The file is created on first request at `data/interview.sqlite`.

## Run it

PHP 8.0 or newer.

```bash
cd php-interview
php -S localhost:8080 router.php
```

Open http://localhost:8080/

| Username | Password |
|----------|----------|
| admin    | admin123 |

After sign-in the app opens `Dashboard`. Log out from the top bar.

Apache with `mod_rewrite` can use the included `.htaccess` instead of `router.php`. The document root must be this folder.

## Routes

| URL | What it does |
|-----|----------------|
| `/` or `/smc` | Sign-in page (`smc` controller, `landing`) |
| `POST /smc/doLogin` | Checks `tbl_user` and starts the session |
| `/Dashboard` | Client count and client list |
| `/Dashboard/edit/{id}` | Form to change that client's name |
| `POST /Dashboard/updateName` | Saves the client name and returns to the dashboard |
| `/smc/dologout` | Ends the session |

## Tables

Defined in `sql/schema.sql`.

- `tbl_user` — people who can sign in. `status_id = 1` means active. Passwords are stored with `password_hash`.
- `tbl_client` — client records. The dashboard counts rows where `status_id = 1`.

Twelve sample clients are inserted the first time the database file is created.

## Layout

```
index.php                  front controller
router.php                 built-in server rewrite
autoload.smart.php         session, paths, class loader
Controllers/               smc, Dashboard, Errors
Models/                    authModel, dashboardModel
Views/                     login, Dashboard, error
Includes/Public/HTML/      header, body, footer
System/Core/               Router, Request, Loader, Registry
System/Database/           SQLite adapter
libs/Common/               Session, Person, DBConnectorFactory
```
