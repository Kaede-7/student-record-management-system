# Student Attendance Management System
##  Credentials

### **Admin Login** (Full CRUD & Attendance Control)
- **Username:** `admin`
- **Password:** `admin123`

### **User Login** (Profile View Only)
- **Username:** `saksham`
- **Password:** `saksham123`

> **Note:** To create more student accounts, log in as **Admin** and use the **"Add Student"** feature.

## Features List

* **Authentication:** Secure Login as Admin or User according to credentials.
* **Full CRUD Operations:** * Add New Students
    * View All Students
    * Edit Student Information
    * Delete Student Records
* **AJAX Live Search:** Real-time student filtering (Autocomplete style) for quick management.
* **Attendance Logic:**
    * **Admin Side:** One-click attendance marking and unmarking.
    * **User Side:** Attendance viewing for the logged-in user only.

## Security 

* **CSRF Protection:** Secure session tokens for all state-changing actions (Mark/Unmark/Delete/Edit).
* **XSS Protection:** Sanitized output using `htmlspecialchars()` to prevent malicious script injection.
* **SQL Injection Protection:** 100% use of **Prepared Statements** for all database queries.
* **Password Security:** Industry-standard **Password Hashing** (`password_hash`) for secure credential storage.
