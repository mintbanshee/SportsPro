# 🏀 SportsPro Technical Support System
A role-based PHP/MySQL helpdesk system 

- **Developer:** MintBanshee
- **Course:** PHP and MySQL Development Project
- **Status:** Complete

## 🔄 System Workflow
Customer registers product has issue and calls tech support → Admin creates incident report and assigns technician → Technician resolves and closes incident

## ✨ AI Use

**Documentation:** Co-authored this README with Artemis (Gemini) and Luna (ChatGPT) to help organize project goals and instructor notes.

**Syntax & Logic Mentorship:**
- conceptual guidance and workflow planning (including minor UX improvements beyond assignment requirements)
- debugging assistance for pathing and logic issues
- demonstration-style examples for concepts not covered in class (I learn best through demonstrations)

## 🌿 Project Goals
This is a PHP/MySQL application for tracking technical support incidents. 

## 📝 Dev-Student Notes

### 🧱 Architecture
- separated concerns, creating MVC scaffolding
- moved customer management and technician management in to controller files and cleaned up the admin files
- moved product management in to controller file and cleaned up product admin files
- created technician_db and class models
- created product_db model
- added Database::getDB(); to retrieve pdo database connection
- started to update data access functions to return arrays instead of pdo statement object

### 🔐 Authentication & Sessions
- created login for customers and technicians
- added some session handling for success messages
- implemented session regeneration for added security

### 🗄 Database & Models
- added try/catch database error handling
- added TypeError handling
- started converting SQL queries to prepare statements
- upgraded input validation
- manually seeded the database to allow Japan (JP) as a country and added Japan to the dropdown menu

### 🎨 UX Improvements
- integrated search customers feature on to customers manager to reduce redundancy
- added Register Another Product and Cancel button
- added success and error alerts for better user experience including adding a check for if product is already registered
- added success popup alerts for user clarity
- updated edit customer country drop-down menu

### 🛠 Features
- added admin ability to edit user information and role
- started incident pages
- added add customer feature for admin on manage customers page
- upgraded the edit customer form to double as add customer form depending on which way you enter the page
- added ability to assign incident to technician for admins
- created technician dashboard
- technicians can close their incidents and add notes to description
- added a page for admin to view assigned and unassigned incidents

### Previous Focus (Assignment 2 & 3)
- Initialize the tech_support database. 
- Create the Product Manager and Technician Manager modules. 
- Build the core MVC scaffold (Model-View-Controller).
- ensure products manager is fully functional
- ensure technicians manager is fully functional
- ensure customers manager is fully functional

### What is to Come
- completed - 

## 📷 Screenshots
Visuals of the assignment pages

 ### Login Screen and Admin Landing Page After Login Success 
<br>
<img width="1157" height="1001" alt="SignUp" src="https://github.com/user-attachments/assets/0de4479d-239a-452e-9850-4729563df16f" />
<img width="739" height="468" alt="Login" src="https://github.com/user-attachments/assets/cd4a1352-47fb-432a-a0e7-428c128d8f09" />
<img width="1203" height="876" alt="AdminDashboard" src="https://github.com/user-attachments/assets/0930ac3e-beaa-47b2-a2f0-dccb95cf8730" />

### Admin Incident Functions 
<br>
<img width="1368" height="912" alt="CreatingReport" src="https://github.com/user-attachments/assets/76696399-1e28-4e4a-9a0d-2008e0a46150" />
<img width="1368" height="618" alt="IncidentSuccess" src="https://github.com/user-attachments/assets/74ed5315-5ad2-450f-8fa6-00fbade69e5e" />
<img width="1200" height="964" alt="DisplayIncidents" src="https://github.com/user-attachments/assets/9c485ef5-3d12-4524-9020-f15d23fda262" />
<img width="1370" height="707" alt="SelectIncident" src="https://github.com/user-attachments/assets/2b40118b-4d08-4308-9468-d690c1180bb5" />
<img width="1372" height="690" alt="SelectTechnician" src="https://github.com/user-attachments/assets/ea838f73-2b83-4952-b9ec-094c5fe6cb08" />
<img width="1360" height="606" alt="AssignIncident" src="https://github.com/user-attachments/assets/15e658e3-98f9-45e1-b70d-8c46f3c0fa87" />

 ### Admin Edit Customer Function
<br>
<img width="1399" height="803" alt="UpdatedCxList" src="https://github.com/user-attachments/assets/cc7106c2-023c-4b4f-9b7b-47a8097bef3e" />
<img width="1365" height="842" alt="UpdatedCountryDropdown" src="https://github.com/user-attachments/assets/e0871a67-dfe4-43c2-9518-6fea335e351e" />

### Manage Products
<br>
<img width="1363" height="771" alt="UpdatedManageProduct" src="https://github.com/user-attachments/assets/653db425-defc-45bc-a246-02871cc07c41" />
<img width="1370" height="864" alt="NewAddProduct" src="https://github.com/user-attachments/assets/13916360-900c-48c6-bdb9-8c82b86c515b" />
<img width="1367" height="891" alt="DeleteProductConfirm" src="https://github.com/user-attachments/assets/2bd9db29-6094-4b72-82e2-6daa67160628" />

### Manage Technicians
<br>
<img width="1366" height="606" alt="UpdatedManageTech" src="https://github.com/user-attachments/assets/f72d5694-7772-4d72-94cf-0fc187bb007e" />
<img width="1365" height="810" alt="UpdatedAddTech" src="https://github.com/user-attachments/assets/72435cb5-21ea-4570-9784-49286362fcb1" />

### Technician Function
<br>
<img width="1206" height="894" alt="TechDashboard" src="https://github.com/user-attachments/assets/abdad6e7-965d-4a9f-a036-b644aa8c7473" />
<img width="1205" height="880" alt="TechUpdate" src="https://github.com/user-attachments/assets/b86543a6-f546-4162-a984-a19003a37bed" />
<img width="1205" height="904" alt="ClosedIncident" src="https://github.com/user-attachments/assets/b6b12f9a-81ea-4853-8594-5cf515d51630" />

### Customer Register Product
<br>
<img width="1155" height="623" alt="RegisterProduct" src="https://github.com/user-attachments/assets/6bced3f3-ff7f-46e1-92c2-20af7e89a48b" />
<img width="1155" height="653" alt="RegisterSuccess" src="https://github.com/user-attachments/assets/0931f058-2d2f-47a3-89d1-8a2ecbebdbab" />

### Flash Alerts
<br>
<img width="1363" height="769" alt="DeleteTechConfirm" src="https://github.com/user-attachments/assets/85f43103-8b55-45e9-80d2-8e481a9cae5c" />
<img width="1363" height="970" alt="DeletedSuccess" src="https://github.com/user-attachments/assets/5f6ae55d-d8f2-4a1e-bff5-9b2d2ca948cf" />











