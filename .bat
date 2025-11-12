@echo off
cd /d C:\websites\Blog--Tangier-Inspire-Blog\blog-tanger
start php artisan serve
start http://localhost:8000
echo Projet lancé !
pause
