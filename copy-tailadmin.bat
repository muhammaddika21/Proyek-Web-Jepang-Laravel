@echo off
REM ============================================================
REM Script: Salin TailAdmin Template ke NihonLearn
REM Jalankan file ini dari mana saja (double-click)
REM ============================================================

set SRC=c:\laragon\www\tailadmin-starter
set DST=c:\stis\NON KULIAH\Project\Web dev\CODELARAVELBARU\nihon-learn-laravel

echo ============================================
echo  Menyalin TailAdmin ke NihonLearn...
echo ============================================

REM -- 1. CSS --
echo [1/7] Menyalin CSS...
copy /Y "%SRC%\resources\css\app.css" "%DST%\resources\css\app.css"

REM -- 2. Layout Admin --
echo [2/7] Menyalin Layout Admin...
if not exist "%DST%\resources\views\layouts" mkdir "%DST%\resources\views\layouts"
copy /Y "%SRC%\resources\views\layouts\app-header.blade.php" "%DST%\resources\views\layouts\admin-header.blade.php"
copy /Y "%SRC%\resources\views\layouts\sidebar.blade.php" "%DST%\resources\views\layouts\admin-sidebar.blade.php"
copy /Y "%SRC%\resources\views\layouts\backdrop.blade.php" "%DST%\resources\views\layouts\admin-backdrop.blade.php"
copy /Y "%SRC%\resources\views\layouts\sidebar-widget.blade.php" "%DST%\resources\views\layouts\admin-sidebar-widget.blade.php"

REM -- 3. Components --
echo [3/7] Menyalin Components...
xcopy /E /I /Y "%SRC%\resources\views\components\common" "%DST%\resources\views\components\common"
xcopy /E /I /Y "%SRC%\resources\views\components\forms" "%DST%\resources\views\components\forms"
xcopy /E /I /Y "%SRC%\resources\views\components\header" "%DST%\resources\views\components\header"
xcopy /E /I /Y "%SRC%\resources\views\components\ui" "%DST%\resources\views\components\ui"
xcopy /E /I /Y "%SRC%\resources\views\components\layouts" "%DST%\resources\views\components\layouts"
xcopy /E /I /Y "%SRC%\resources\views\components\ecommerce" "%DST%\resources\views\components\ecommerce"

REM -- 4. Helpers --
echo [4/7] Menyalin MenuHelper...
if not exist "%DST%\app\Helpers" mkdir "%DST%\app\Helpers"
copy /Y "%SRC%\app\Helpers\MenuHelper.php" "%DST%\app\Helpers\MenuHelper.php"

REM -- 5. Artikel Pages --
echo [5/7] Menyalin Halaman Artikel...
if not exist "%DST%\resources\views\admin\articles" mkdir "%DST%\resources\views\admin\articles"
copy /Y "%SRC%\resources\views\pages\articles\index.blade.php" "%DST%\resources\views\admin\articles\index.blade.php"
copy /Y "%SRC%\resources\views\pages\articles\create.blade.php" "%DST%\resources\views\admin\articles\create.blade.php"
copy /Y "%SRC%\resources\views\pages\articles\create-bahasa.blade.php" "%DST%\resources\views\admin\articles\create-bahasa.blade.php"

REM -- 6. Dashboard --
echo [6/7] Menyalin Dashboard...
copy /Y "%SRC%\resources\views\dashboard.blade.php" "%DST%\resources\views\admin\dashboard-new.blade.php"

REM -- 7. Models --
echo [7/7] Menyalin Models...
copy /Y "%SRC%\app\Models\Category.php" "%DST%\app\Models\Category.php"
copy /Y "%SRC%\app\Models\Article.php" "%DST%\app\Models\Article.php"
copy /Y "%SRC%\app\Models\ArticleVocabulary.php" "%DST%\app\Models\ArticleVocabulary.php"
copy /Y "%SRC%\app\Models\ArticleQuiz.php" "%DST%\app\Models\ArticleQuiz.php"

REM -- Migrations --
if not exist "%DST%\database\migrations" mkdir "%DST%\database\migrations"
copy /Y "%SRC%\database\migrations\2024_01_01_001001_create_categories_table.php" "%DST%\database\migrations\2024_01_01_001001_create_categories_table.php"

echo.
echo ============================================
echo  SELESAI! Semua file berhasil disalin.
echo ============================================
echo.
echo Selanjutnya jalankan command di bawah ini di folder NihonLearn:
echo   1. npm install
echo   2. npm run dev
echo.
pause
