# 🚀 Important Deployment Note for Developers
When deploying a Laravel + Vue application on Hostinger, remember that public_html is the default root (index) directory.

🔹 Key Deployment Step:
👉 Rename your Laravel public folder to public_html to ensure your application functions correctly within Hostinger’s directory structure otherwise some of the build files won't work as expected.

© Bellie Joe Jandusay