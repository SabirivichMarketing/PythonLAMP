from telegram import Update
from telegram.ext import Application, CommandHandler, MessageHandler, filters, ContextTypes
import os

# Токен бота (лучше хранить в переменных окружения)
BOT_TOKEN = "1231788061:AAE-czpea-vvG6tDnUA9EILwxB97OreONmM"  # или прямо здесь: "YOUR_BOT_TOKEN_HERE"

async def start_command(update: Update, context: ContextTypes.DEFAULT_TYPE):
    """Обработчик команды /start"""
    await update.message.reply_text("Привет! Я echo бот. Просто отправь мне любое сообщение, и я его повторю!")

async def help_command(update: Update, context: ContextTypes.DEFAULT_TYPE):
    """Обработчик команды /help"""
    help_text = """
Доступные команды:
/start - начать работу
/help - показать эту справку

Просто отправь любое сообщение, и я его повторю!
    """
    await update.message.reply_text(help_text)

async def echo_handler(update: Update, context: ContextTypes.DEFAULT_TYPE):
    """Обработчик текстовых сообщений"""
    user_message = update.message.text
    await update.message.reply_text(f"Вы сказали: {user_message}")

async def error_handler(update: Update, context: ContextTypes.DEFAULT_TYPE):
    """Обработчик ошибок"""
    print(f"Ошибка: {context.error}")

def main():
    """Основная функция для запуска бота"""
    # Создаем приложение
    application = Application.builder().token(BOT_TOKEN).build()
    
    # Добавляем обработчики команд
    application.add_handler(CommandHandler("start", start_command))
    application.add_handler(CommandHandler("help", help_command))
    
    # Добавляем обработчик текстовых сообщений
    application.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, echo_handler))
    
    # Добавляем обработчик ошибок
    application.add_error_handler(error_handler)
    
    # Запускаем бота
    print("Бот запущен...")
    application.run_polling()

if __name__ == "__main__":
    main()