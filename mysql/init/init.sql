-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица логов основного бота
CREATE TABLE IF NOT EXISTS bot_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    message TEXT,
    bot_name VARCHAR(100)
);

-- Таблица логов Telegram бота
CREATE TABLE IF NOT EXISTS telegram_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id BIGINT,
    username VARCHAR(100),
    message TEXT,
    message_type VARCHAR(50)
);

-- Начальные данные
INSERT IGNORE INTO users (username, email) VALUES 
('admin', 'admin@example.com'),
('user1', 'user1@example.com');

-- Индексы для улучшения производительности
CREATE INDEX IF NOT EXISTS idx_telegram_logs_user_id ON telegram_logs(user_id);
CREATE INDEX IF NOT EXISTS idx_telegram_logs_timestamp ON telegram_logs(timestamp);
CREATE INDEX IF NOT EXISTS idx_bot_logs_timestamp ON bot_logs(timestamp);