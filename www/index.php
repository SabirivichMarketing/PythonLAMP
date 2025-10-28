<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAMP + Python Bot</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; }
        .status { padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid; }
        .success { background: #d4edda; color: #155724; border-color: #28a745; }
        .error { background: #f8d7da; color: #721c24; border-color: #dc3545; }
        .info { background: #d1ecf1; color: #0c5460; border-color: #17a2b8; }
        .warning { background: #fff3cd; color: #856404; border-color: #ffc107; }
        .panel { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin: 20px 0; }
        .service-card { background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd; }
        .btn { display: inline-block; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1>🚀 LAMP + Python Bot System</h1>
            
            <div class="services-grid">
                <div class="service-card">
                    <h3>🌐 Веб-сервер</h3>
                    <p>Apache + PHP <?php echo phpversion(); ?></p>
                    <a href="/" class="btn">Главная страница</a>
                </div>
                
                <div class="service-card">
                    <h3>🗄️ База данных</h3>
                    <p>MySQL 8.0</p>
                    <a href="http://localhost:8080" class="btn" target="_blank">phpMyAdmin</a>
                </div>
                
                <div class="service-card">
                    <h3>🤖 Python Bot</h3>
                    <p>Фоновый процесс</p>
                    <span class="btn" style="background: #6c757d;">Автономный</span>
                </div>
            </div>
        </div>

        <div class="status info">
            <h3>📊 Информация о системе</h3>
            <?php
            echo "<p><strong>PHP версия:</strong> " . phpversion() . "</p>";
            echo "<p><strong>Доступные PDO драйверы:</strong> " . implode(', ', PDO::getAvailableDrivers()) . "</p>";
            echo "<p><strong>Сервер:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
            ?>
        </div>

        <div class="status info">
            <h3>📈 Статус базы данных</h3>
            <?php
            try {
                $pdo = new PDO('mysql:host=mysql;dbname=myapp', 'appuser', 'apppassword');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<div class='status success'>✅ База данных подключена успешно</div>";
                
                // Проверяем таблицу пользователей
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "<p><strong>Пользователей в системе:</strong> " . $userCount . "</p>";
                
                // Последние логи бота
                $stmt = $pdo->query("SELECT * FROM bot_logs ORDER BY timestamp DESC LIMIT 10");
                $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if ($logs) {
                    echo "<h4>📝 Последние действия бота:</h4>";
                    echo "<div style='max-height: 300px; overflow-y: auto;'>";
                    echo "<table style='width: 100%; border-collapse: collapse;'>";
                    echo "<tr style='background: #e9ecef;'><th style='padding: 8px; border: 1px solid #ddd;'>Время</th><th style='padding: 8px; border: 1px solid #ddd;'>Сообщение</th></tr>";
                    foreach ($logs as $log) {
                        echo "<tr>";
                        echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($log['timestamp']) . "</td>";
                        echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($log['message']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<div class='status warning'>⚠️ Логов бота пока нет</div>";
                }
                
            } catch (PDOException $e) {
                echo "<div class='status error'>❌ Ошибка подключения к базе данных: " . $e->getMessage() . "</div>";
                echo "<p>Проверьте:</p>";
                echo "<ul>";
                echo "<li>Запущен ли контейнер MySQL</li>";
                echo "<li>Правильность учетных данных</li>";
                echo "<li>Доступность сети между контейнерами</li>";
                echo "</ul>";
            }
            ?>
        </div>
        
        <div class="status success">
            <h3>🔧 Доступные сервисы</h3>
            <ul>
                <li><strong>Веб-сервер:</strong> <a href="http://localhost" target="_blank">http://localhost</a> (порт 80)</li>
                <li><strong>phpMyAdmin:</strong> <a href="http://localhost:8080" target="_blank">http://localhost:8080</a> (порт 8080)</li>
                <li><strong>MySQL:</strong> localhost:3306 (только для внутреннего использования)</li>
                <li><strong>Python Bot:</strong> Фоновый процесс (логи в базе данных)</li>
            </ul>
            
            <div class="status warning">
                <h4>📋 Учетные данные для phpMyAdmin:</h4>
                <p><strong>Сервер:</strong> mysql</p>
                <p><strong>Пользователь:</strong> root</p>
                <p><strong>Пароль:</strong> rootpassword</p>
                <p><strong>Или:</strong> appuser / apppassword (для базы myapp)</p>
            </div>
        </div>
    </div>
</body>
</html>