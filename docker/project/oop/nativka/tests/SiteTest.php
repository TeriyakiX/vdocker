<?php
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['login'] === 'login is busy') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Site())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();

        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }


//Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'login' => '', 'password' => ''],
                '<h3></h3>'
            ],
            ['POST', ['name' => '', 'login' => '', 'password' => ''],
                '<h3>{"name":["Поле name пусто"],"login":["Поле login пусто"],"password":["Поле password пусто"]}</h3>',
            ],
            ['POST', ['name' => 'admin', 'login' => 'login is busy', 'password' => 'admin'],
                '<h3>{"login":["Поле login должно быть уникально"]}</h3>',
            ],
            ['POST', ['name' => 'admin', 'login' => md5(time()), 'password' => 'admin'],
                'Location: /pop-it-mvc/hello',
            ],
        ];
    }
    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www/html';

        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/configs/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/configs/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/configs/config/path.php',
        ]));

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }


}
