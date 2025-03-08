# healthlink

HealthLink 🚑💡
An Integrated Health & Wellness Platform
HealthLink is a comprehensive healthcare platform that provides secure medical data management, automated report analysis, health tracking, and real-time sensor-based monitoring for vital health parameters.

🚀 Features
🔐 Secure Medi-Cloud (Medical File Management)
Encrypted storage for medical files (PDFs, reports, prescriptions).
Secure authentication with password hashing.
Cloud backup & data accessibility anytime, anywhere.
📊 Automated Medical Report Analysis
OCR-based text extraction from lab reports.
AI-powered health insights & analysis for quick medical evaluation.
User-friendly dashboard to view analyzed data.
📜 Medical History & Health Logs
Long-term medical records tracking for chronic conditions.
Short-term health logs (e.g., fever, BP monitoring, daily symptoms).
Downloadable medical reports in PDF format.
🌐 IoT-Based Health Monitoring
Real-time sensor integration for:
🫀 Pulse Rate Monitoring
🌡️ Temperature Tracking
🩸 SpO2 (Blood Oxygen Levels) Measurement
Data storage in SQL & Python processing for analytics.
📰 Health & Medicinal News Module
Live health updates & medical news feed from trusted sources.
Personalized recommendations based on user health conditions.
📅 Doctor Appointment & Telemedicine
Find & book appointments with doctors.
Video consultations via integrated telemedicine features.
🩺 User Dashboard & Secure Access
Centralized dashboard to manage medical history, health stats & reports.
Role-based authentication for patients, doctors, and administrators.
🛠️ Tech Stack
Frontend: HTML, CSS, JavaScript, Bootstrap
Backend: PHP, MySQL
IoT Sensors: ESP32 + Pulse Sensor, Temperature Sensor, SpO2 Sensor
Data Processing: Python for real-time health analytics
Security: Encrypted file storage, secure login system

📌 Setup Instructions
1️⃣ Clone the Repository
git clone https://github.com/sreechakra-dheram/healthlink.git
cd healthlink
2️⃣ Backend Setup
Install XAMPP (for Apache + MySQL).
Place project files inside the htdocs folder.
Import medpro.sql database into phpMyAdmin.
3️⃣ IoT Sensor Integration
Connect ESP32 with Pulse, SpO2, and Temperature sensors.
Use Python scripts to process sensor data & store it in SQL.
4️⃣ Start the Server
Run XAMPP and start Apache & MySQL, then open in browser:
http://localhost/healthlink
