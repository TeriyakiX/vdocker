<?php

//Путь до директории с конфигурационными файлами
const DIR_CONFIG = '/../configs';

//Добавляем пользовательскую функцию автозагрузки классов
spl_autoload_register(function ($className) {
    $paths = include __DIR__ . DIR_CONFIG . '/path.php';
    $className = str_replace('\\', '/', $className);

    foreach ($paths['classes'] as $path) {
        $fileName = $_SERVER['DOCUMENT_ROOT'].'/..'. "/$path/$className.php";
        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }
});

//Функция, возвращающая массив всех настроек приложения
function getConfigs(string $path = DIR_CONFIG): array
{
    $settings = [];
    foreach (scandir(__DIR__ . $path) as $file) {
        $name = explode('.', $file)[0];
        if (!empty($name)) {
            $settings[$name] = include __DIR__ . "$path/$file";
        }
    }
    return $settings;
}
require_once __DIR__ . '/../routes/web.php';

return new Src\Application(new Src\Settings(getConfigs()));


