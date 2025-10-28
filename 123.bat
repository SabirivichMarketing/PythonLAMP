@echo off
chcp 65001 > nul
setlocal enabledelayedexpansion

set tempfile=%temp%\file_contents_%random%.txt
type nul > "%tempfile%"

echo 📁 Сканирование структуры папок...
tree /f > "%temp%\_tree.txt"

echo 📝 Обработка файлов...
set /a filecount=0

:: Исключаем папку .git и файлы изображений
for /f "delims=" %%f in ('dir /s /b /a-d ^| findstr /v /i "\\\.git\\ \.jpg$ \.jpeg$ \.png$ \.gif$ \.bmp$ \.ico$ \.svg$ \.webp$ \.pdf$"') do (
    set /a filecount+=1
    echo Обработано файлов: !filecount! > "%temp%\_counter.txt"
    
    echo [%%~nxf]: >> "%tempfile%"
    
    :: Проверяем, является ли файл текстовым
    findstr /m ".*" "%%f" >nul 2>&1
    if !errorlevel! equ 0 (
        type "%%f" 2>nul >> "%tempfile%"
    ) else (
        echo [БИНАРНЫЙ ФАЙЛ - СОДЕРЖИМОЕ НЕ ОТОБРАЖАЕТСЯ] >> "%tempfile%"
    )
    
    echo. >> "%tempfile%"
    echo ---конец файла--- >> "%tempfile%"
    echo. >> "%tempfile%"
)

:: Добавляем дерево папок в начало
echo ══════════════════════════════════════ > "%temp%\_final.txt"
echo 🌳 СТРУКТУРА ПАПОК И ФАЙЛОВ >> "%temp%\_final.txt"
echo ══════════════════════════════════════ >> "%temp%\_final.txt"
type "%temp%\_tree.txt" >> "%temp%\_final.txt"
echo. >> "%temp%\_final.txt"
echo ══════════════════════════════════════ >> "%temp%\_final.txt"
echo 📄 СОДЕРЖИМОЕ ФАЙЛОВ >> "%temp%\_final.txt"
echo ══════════════════════════════════════ >> "%temp%\_final.txt"
type "%tempfile%" >> "%temp%\_final.txt"

:: Копируем в буфер обмена
clip < "%temp%\_final.txt"

:: Показываем информацию
cls
echo ========================================
echo ✅ ГОТОВО!
echo ========================================
echo Обработано файлов: !filecount!
echo Данные скопированы в буфер обмена
echo.
echo 📋 Вставьте в текстовый редактор (Ctrl+V)
echo ========================================

:: Очистка временных файлов
del "%tempfile%" 2>nul
del "%temp%\_tree.txt" 2>nul
del "%temp%\_final.txt" 2>nul
del "%temp%\_counter.txt" 2>nul

pause