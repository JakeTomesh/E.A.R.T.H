# E.A.R.T.H

**E.A.R.T.H** (**E**mission **A**nd **R**esource **T**racking **H**ub) is a PHP/MySQL web application for logging, standardizing, and monitoring emissions and resource-usage data. The system supports normalized CO₂e tracking, threshold-based alerting, administrative management, and embedded analytics dashboards through Metabase.

This repository is intended as an educational capstone and portfolio project. The setup instructions are written so an employer or reviewer can run the project locally with the same core stack used during development.

---

## Overview

Organizations often collect environmental and operational data in many different units and formats. E.A.R.T.H addresses that problem by:

- validating emissions and resource input
- converting activity values into a standardized CO₂e representation
- storing historical logs for reporting
- comparing emissions activity against configured thresholds
- generating in-app alert notifications when limits are exceeded
- embedding interactive analytics dashboards with Metabase

The application is organized using an MVC-style structure and includes both user-facing and administrative workflows.

---

## Tech Stack

### Application
- PHP
- MySQL 8
- Apache
- JavaScript
- HTML/CSS

### Tooling / Local Dev
- Docker Compose
- phpMyAdmin
- Metabase

### Architecture
- MVC-style PHP application
- Session-based authentication
- PDO database access
- Signed Metabase embedding with JWT

---

## Repository Structure

```text
.

|E.A.R.T.H/
|──app/
    ├── dashboard_manager/
    ├── emission_manager/
    ├── include/
    ├── js/
    ├── metrics_manager/
    ├── misc/
    ├── model/
    ├── styles/
    ├── user_manager/
    └── index.php
    └── README
├── db/
    ├── earth.sql
├── .env
├── apache-config.conf
├── docker-compose.yml
├── Dockerfile
├── phpmyadmin-config.inc.php
```

### Important Files
- **Application entry point:** `E.A.R.T.H/app/index.php`
- **Metabase token endpoint:** `E.A.R.T.H/app/metrics_manager/metabase_token.php`
- **Database SQL script:** `E.A.R.T.H/db/earth.sql`

---

## Core Features

- Emissions and resource activity logging
- Unit-based normalization and CO₂e conversion
- Threshold configuration and in-app alert generation
- User and admin role support
- Historical data storage
- Dashboard metrics and embedded Metabase reporting
- Administrative management for users and related system data

### Current Scope Notes
- Dashboard metrics: **implemented**
- Metabase dashboard integration: **implemented**
- Threshold alert pop-up behavior: **implemented**
- Email alerts: **not implemented**
- Forecasting: **removed from current scope**

---

## Authentication and Roles

The application uses session-based authentication.

### Roles
- **admin**
- **user**

### Demo Login
This project is designed to run with seeded demo accounts from the provided SQL script.

Use the following placeholders and update them before publishing or sharing the repository:

- **Company #1**
- **Admin username:** `AAdmin`
- **Admin password:** `TestPassword`
- **User username:** `UUser`
- **User password:** `TestPassword`

- **Company #2**
- **Admin username:** `AAdmin2`
- **Admin password:** `TestPassword`
- **User username:** `UUser2`
- **User password:** `TestPassword`
---

## How Metabase Is Integrated

E.A.R.T.H uses **signed Metabase embedding**.

The token endpoint is located at:

```text
php/Assignments/E.A.R.T.H/metrics_manager/metabase_token.php
```

The application generates a signed JWT server-side and uses it to embed a Metabase dashboard. Dashboard access is scoped using locked parameters, including the current user's `licenseeid`.

### Security Note
Do **not** commit a real Metabase embed secret to a public repository. Use an environment variable instead, such as:

```env
MB_EMBED_SECRET=change-me
```

---

## Requirements

Install the following before running the project:

- Docker Desktop or Docker Engine + Docker Compose
- Git

You do **not** need a separate local PHP, Apache, or MySQL install if using the provided Compose setup.

---

## Running the Project Locally

### 1. Clone the repository

```bash
git clone https://github.com/JakeTomesh/E.A.R.T.H.git
cd E.A.R.T.H
```

### 2. Create your environment file

Create a `.env` file in the repository root using the example below.

Example:

```env
MYSQL_DATABASE=earth
MYSQL_USER=mgs_user
MYSQL_PASSWORD=password
MYSQL_ROOT_PASSWORD=root
MB_EMBED_SECRET=change-me
```

A sample `.env.example` file is included in this repository setup.

### 3. Start the containers

```bash
docker compose up --build -d
```

This starts:

- PHP/Apache app container
- MySQL database
- phpMyAdmin
- Metabase

### 4. Import the database manually

This project uses a manual SQL import.

(you may need to create the database 'earth' manually if you do not have the correct privlages before running the script)

Open phpMyAdmin:

```text
http://localhost:8083
```

Then log in with:

- **Server:** `db`
- **Username:** `root`
- **Password:** `root`

Create or confirm the `earth` database exists, then import:

```text
php/Assignments/E.A.R.T.H/db/earth.sql
```


### 5. Open the application

Application:

```text
http://localhost:8082
```

phpMyAdmin:

```text
http://localhost:8083
```

Metabase:

```text
http://localhost:3001
```

---

## Default Container Services

### PHP / Apache
Serves the application at port `8082`.

### MySQL
Provides the relational database used by the application and by Metabase as a data source.

### phpMyAdmin
Provides a browser-based interface for importing and inspecting the MySQL database.

### Metabase
Runs as a separate service for dashboard and analytics embedding.

Metabase is persisted with a Docker volume so its internal state survives container restarts.

---

## Docker Compose Notes

The included `docker-compose.yml` is set up to:

- serve the PHP app from `./app:/var/www/html`
- expose Apache on port `8082`
- expose MySQL on port `3307`
- expose phpMyAdmin on port `8083`
- expose Metabase on port `3001`

Because the application code connects to MySQL using host `db`, all services run on the same Compose network.

---

## Configuration Notes

### Database Connection
The application expects the MySQL service hostname to be:

```text
db
```

### Metabase Secret
For public repositories, do not leave a real secret hardcoded in `metabase_token.php`.

Use:

```php
getenv('MB_EMBED_SECRET')
```

and supply the value through `.env`.

---

## Suggested First-Run Workflow

1. Start Docker containers.
2. Import `earth.sql` into the `earth` database using phpMyAdmin.
3. Open the application in the browser.
4. Log in with a seeded demo account.
5. Review emissions logging, threshold behavior, and dashboard pages.
6. Open Metabase separately if needed to inspect the analytics instance.

---

## Troubleshooting

### The app cannot connect to the database
Make sure:
- the MySQL container is running
- the database name is `earth`
- the application is using host `db`
- the SQL script has been imported successfully

### Metabase dashboard does not load
Check:
- the Metabase container is running on port `3001`
- `MB_EMBED_SECRET` matches the Metabase embedding secret
- the dashboard ID used in `metabase_token.php` exists in your Metabase instance
- for demo purposes, Metabase dashboards may not sync as expected. Please refer to the docs folder for application screenshots

### Login does not work
Make sure:
- the seeded data from `earth.sql` was imported
- the demo credentials in this README have been updated
- session support is working in the PHP container

---

## Security Considerations

This project is educational, but it follows several real-world practices:

- session-based authentication
- role-based access separation
- server-side database access through PDO
- signed dashboard embedding

Before publishing the repository publicly, review and remove any real secrets, tokens, or private credentials.


---

## Author

**Jacob Tomesh**

Educational capstone and portfolio project.

---

## License

This repository is shared for educational and portfolio review purposes.
