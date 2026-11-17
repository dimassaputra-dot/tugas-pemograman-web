@echo off
git add .
git commit -m "Update website DUEVE: %date% %time%"
git push -u origin main --force
pause