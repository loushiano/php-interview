CREATE TABLE IF NOT EXISTS tbl_user (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_name TEXT NOT NULL UNIQUE,
    user_password TEXT NOT NULL,
    user_first_name TEXT NOT NULL,
    user_last_name TEXT NOT NULL,
    status_id INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS tbl_client (
    client_id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_name TEXT NOT NULL,
    contact_name TEXT,
    email TEXT,
    country TEXT,
    status_id INTEGER NOT NULL DEFAULT 1
);
