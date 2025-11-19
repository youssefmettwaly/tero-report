import os
import base64
from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

GITHUB_TOKEN = "github_pat_xxxxx"   # حط توكن جيت هب هنا
REPO_OWNER = "اسم-يوزر-جيت-هب"
REPO_NAME = "اسم-مستودعك"

def upload_to_github(content):
    filename = f"report_{os.urandom(8).hex()}.txt"
    url = f"https://api.github.com/repos/{REPO_OWNER}/{REPO_NAME}/contents/{filename}"
    headers = {
        "Authorization": f"token {GITHUB_TOKEN}",
        "Accept": "application/vnd.github.v3+json"
    }
    data = {
        "message": "نشر تقرير جديد",
        "content": base64.b64encode(content.encode()).decode(),
        "branch": "main"
    }
    r = requests.put(url, headers=headers, json=data)
    return r.ok

@app.route('/upload', methods=['POST'])
def upload():
    report_data = request.form.get('data')
    if not report_data:
        return jsonify({"ok": False, "error": "No data found"}), 400
    if upload_to_github(report_data):
        return jsonify({"ok": True, "msg": "تم رفع التقرير!"})
    else:
        return jsonify({"ok": False, "error": "فشل رفع التقرير"}), 500

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=10000)
