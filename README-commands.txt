# 1) initialize repo
cd c:\xampp\htdocs\myapp
git init

# 2) stage and commit
git add .
git commit -m "Initial commit - Mini Task Management"

# 3a) create GitHub repo via web:
#   - go to https://github.com/new, create repo (name: myapp), do NOT initialize with README
#   - copy the repo URL (e.g. https://github.com/YOUR_USERNAME/myapp.git)
# 3b) OR create with GitHub CLI:
#   gh repo create YOUR_USERNAME/myapp --public --source=. --push

# 4) add remote and push (if you used web UI)
git remote add origin https://github.com/YOUR_USERNAME/myapp.git
git branch -M main
git push -u origin main
