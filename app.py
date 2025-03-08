from flask import Flask, render_template, request, redirect, url_for, flash, send_from_directory
import os
import datetime
from cryptography.fernet import Fernet  
import PyPDF2 
import re

app = Flask(__name__)
app.secret_key = 'your_secret_key'

# Encryption key - generate only once and reuse for both encryption and decryption
def load_key():
    key_file = "secret.key"
    if os.path.exists(key_file):
        with open(key_file, "rb") as key_file_obj:
            return key_file_obj.read()
    else:
        # Generate key if it doesn't exist
        key = Fernet.generate_key()
        with open(key_file, "wb") as key_file_obj:
            key_file_obj.write(key)
        return key

key = load_key()
cipher_suite = Fernet(key)

# File directories
base_dir = os.path.abspath(os.path.dirname(__file__))
upload_folders = {
    "Prescriptions": os.path.join(base_dir, "uploads/Prescriptions"),
    "Doctor Consultation Notes": os.path.join(base_dir, "uploads/Doctor Consultation Notes"),
    "Lab Reports": os.path.join(base_dir, "uploads/Lab Reports"),
    "Surgery Reports": os.path.join(base_dir, "uploads/Surgery Reports"),
    "Radiology Reports": os.path.join(base_dir, "uploads/Radiology Reports"),
    "Medical History Reports": os.path.join(base_dir, "uploads/Medical History Reports"),
    "Insurance and Billing Records": os.path.join(base_dir, "uploads/Insurance and Billing Records"),
}

# Ensure directories exist
for folder in upload_folders.values():
    os.makedirs(folder, exist_ok=True)

# Reference intervals for lab values (sample data)
reference_intervals = {
    'Hemoglobin': (13.5, 17),
    'Platelet Count': (150, 410),
    'Total Leucocyte Count': (4, 10),
    'RBC Count': (4.5, 5.5),
    'HCT': (40, 50),
    'MCV': (83, 100),
    'MCH': (27, 32),
    'MCHC': (31.5, 34.5),
    'Neutrophils': (40, 80),
    'Lymphocytes': (20, 40),
}

# Precautions for specific lab values
precautions = {
    'Hemoglobin': "Eat iron-rich foods like spinach and red meat.",
    'Platelet Count': "Avoid injury; eat foods rich in Vitamin K.",
    'Total Leucocyte Count': "Ensure good hygiene to prevent infections.",
    'RBC Count': "Include foods with folic acid and Vitamin B12.",
    'Neutrophils': "Avoid crowded areas to minimize infection risk.",
    'Lymphocytes': "Consult a doctor for immune-boosting advice."
}


@app.route('/')
def index():
    # Redirect to the PHP registration page
    return redirect("http://localhost/medi_project/php/register.php")


@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        file = request.files['file']
        category = request.form['category']
        folder = upload_folders.get(category)

        if not folder:
            flash("Invalid category selected!", "error")
            return redirect(url_for('upload_file'))

        if file:
            timestamp = datetime.datetime.now().strftime("%Y%m%d_%H%M%S")
            filename = f"{file.filename}"
            file_path = os.path.join(folder, filename)

            # Encrypt and save file
            encrypted_data = cipher_suite.encrypt(file.read())
            with open(file_path, 'wb') as f:
                f.write(encrypted_data)

            flash("File uploaded and encrypted successfully!", "success")
            return redirect(url_for('upload_file'))

    # Prepare data to display
    files_data = {}
    for category, path in upload_folders.items():
        files_data[category] = [
            (file, datetime.datetime.fromtimestamp(os.path.getmtime(os.path.join(path, file))).strftime("%Y-%m-%d %H:%M:%S"))
            for file in os.listdir(path)
        ]

    return render_template('upload.html', categories=upload_folders.keys(), files_data=files_data)

@app.route('/delete/<category>/<filename>', methods=['POST'])
def delete_file(category, filename):
    folder = upload_folders.get(category)
    if not folder:
        flash("Invalid category selected!", "error")
        return redirect(url_for('upload_file'))

    file_path = os.path.join(folder, filename)
    if os.path.exists(file_path):
        os.remove(file_path)
        flash("File deleted successfully!", "success")
    else:
        flash("File not found!", "error")
    return redirect(url_for('upload_file'))

@app.route('/lab_reports', methods=['GET', 'POST'])
def lab_reports():
    analysis = None
    if request.method == 'POST':
        file = request.files['file']
        if file:
            pdf_reader = PyPDF2.PdfReader(file)
            text = "".join(page.extract_text() for page in pdf_reader.pages)
            analysis = analyze_lab_report(text)

    return render_template('lab_reports.html', analysis=analysis)

@app.route('/download/<category>/<filename>', methods=['GET'])
def download_file(category, filename):
    folder = upload_folders.get(category)
    if folder:
        file_path = os.path.join(folder, filename)
        if os.path.exists(file_path):
            # Decrypt the file before sending (without creating a temporary file)
            with open(file_path, 'rb') as encrypted_file:
                encrypted_data = encrypted_file.read()

            # Decrypt the file content
            try:
                decrypted_data = cipher_suite.decrypt(encrypted_data)

                # Serve the decrypted file directly
                response = app.response_class(
                    decrypted_data,
                    mimetype='application/octet-stream',
                    headers={'Content-Disposition': f'attachment;filename={filename}'}
                )
                return response
            except Exception as e:
                flash(f"Error decrypting file: {str(e)}", "error")
                return redirect(url_for('upload_file'))

    flash("File not found!", "error")
    return redirect(url_for('upload_file'))

@app.route('/downloadreport')
def download_report():
    return render_template('downloadreport.html')


def analyze_lab_report(text):
    results = []
    for key, (low, high) in reference_intervals.items():
        match = re.search(fr'{key}\s*:?[\s]*([\d.]+)', text, re.IGNORECASE)
        if match:
            value = float(match.group(1))
            if value < low or value > high:
                advice = precautions.get(key, "Consult a healthcare professional.")
                results.append((key, value, f"Out of range! {advice}"))
            else:
                results.append((key, value, "Within the normal range."))
    return results

if __name__ == '__main__':
    app.run(debug=True)
