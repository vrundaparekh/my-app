# Comprehensive User Management & Healthcare AI Assistant Platform

A full-stack enterprise web application built using CodeIgniter 4 following rigid MVC architecture and security practices.This platform features secure role-based authentication, interactive live-filtering administrative CRUD structures, binary data exports, and real-time voice-driven Agentic AI helper modules.

## Technologies Used 
Following the exact UI and frontend technical requirements:
* **Backend Framework:** CodeIgniter 4.7.3 (PHP 8.2) 
* **HTML5 & Bootstrap 5:** Used to build a fully responsive layout with clean form designs and proper error/success notification structures.
* **jQuery & JavaScript:** Powers asynchronous modal-based CRUD operations, dynamic views, and instant data synchronization.
* **Visual Popups:** SweetAlert2 & jQuery Validation Plugin for streamlined user feedback.
* **Document Engine:** mPDF Wrapper Library for professional PDF reports.

---

## Features Checklist
* **Secure Authentication System:** Core registration, secure login hash matching via `password_hash()`, interactive session rules, and token-based forgot/reset flows
* **Role-Based Access Control (RBAC):** Restrictive filter barriers classifying Admin (Full Master Privileges), Manager, Staff, and Basic Users
* **Agentic Healthcare Voice Assistant:** Real-time conversational interface utilizing the ElevenLabs Web SDK widget paired with strict instructional medical safeguard banners.

---

## User Management Module 
The Admin panel is fully equipped to manage registered system users through dynamic, asynchronous operations:
* **View User List:** Displayed cleanly in a responsive tabular structure incorporating full names, emails, DOBs, genders, profile pictures, assigned roles, and current statuses.
* **Search & Live Filtering:** Allows the admin to type queries to filter users by name or email details instantly alongside selective gender option filtering.
* **Pagination:** Clean server-side data chunking to optimize load times for large datasets.
* **Modal-Based Actions:** Fully features asynchronous interactions:
  * **View:** Slides open a dedicated details profile layout.
  * **Edit:** Dynamically populates records inside standard inputs for instant updates.
  * **Delete:** Safely flags profiles as `inactive` while automatically logging the `deleted_at` datetime matrix into the table row.

---

##  Export Functionality 
Admin operators can download properly formatted user records using server-side binary stream operations
* **Export to Excel:** Generated dynamically via native PHP memory buffering using standard Excel content headers. This forces an immediate attachment download of the tabular user schema dataset.
* **Export to PDF (mPDF):** Leverages the **mPDF library wrapper** to compile database records into clean layouts. Configured explicitly in **A4-Landscape mode** to accommodate multi-column formats beautifully without text overlappin[cite: 71]. Active output buffers are cleanly flushed using `ob_clean()` prior to download to guarantee file integrity.

---
## AI Agent Integration Notes
* **Engine Integration:** Powered by the **ElevenLabs Conversational AI Native Web SDK** embedded directly via asynchronous frontend JavaScript component scripts (`<elevenlabs-convai>`).
* **Operational Scope:** Explicitly restricted via system prompts to provide basic educational medical assistance covering common drug facts, generic wellness queries, and primary symptom lookups.
* **Safety Controls:** Outfitted with an explicit UI warning block stating that the assistant provides general knowledge vectors only and **does not replace professional medical evaluations**.

---

## Built-in Account Evaluation Credentials

Use these pre-seeded diagnostic profiles to verify your role-based restriction filters:

| Target System Role | Form Email Input | Plain Text Password | Access Level |
| :--- | :--- | :--- | :--- |
| **Admin System Master** | `admin@admin.com` | `admin123` | Full Dashboard Access & CRUD Operations |
| **Standard User Account** | `abhi.mehta@gmail.com` | `123456` | Restricted Healthcare AI Portal View Only |

---
## Local System Installation Steps

1. Project Cloning
Extract this project package directory directly into your web root (`htdocs` or `www`) folder, or clone the repository via terminal/SourceTree:
```bash
git clone <your-repository-url>
2. Database Environment Setup
    Launch your local database server application (phpMyAdmin).
    Instantiate a fresh schema profile named my_app_db.
    Open the SQL query execution window panel and import the bundled database dump script file named my_app_db.sql located in your project root directory.
3. Environment Variables Configuration

Duplicate the local environment template file env and rename it to .env. Open the file and configure your database parameters and environment flags:

CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = my_app_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

4. Install Project Dependencies (Required for mPDF)

Run the following command in your project root terminal to install the necessary vendor packages defined in your composer.json file:
composer install
(Note: This creates the vendor/ directory and downloads the mPDF library files instantly so the PDF export doesn't throw a "Class not found" error).
5. Running the Development Server
Execute the built-in development engine inside your root terminal location:
php spark serve
The application will launch on your local host interface link: http://localhost:8080