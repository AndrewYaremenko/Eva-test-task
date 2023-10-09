# Eva-test-task

## Стек технологий
- PHP v8.1.0
- Laravel v8.83.27 
- Vue3, vuex, vue-router, vue-datepicker, Bootstrap5
- MySQL

## API v1
#### Salons
**GET /api/v1/salons** - SalonController:index<br>
**GET /api/v1/salons/{id}** - SalonController:show<br>
**POST /api/v1/salons** - SalonController:store<br>
**PUT /api/v1/salons/{id}** - SalonController:update<br>
**DELETE /api/v1/salons/{id}** - SalonController:destroy<br>
#### Services
**GET /api/v1/services** - ServiceController:index<br>
**GET /api/v1/services/{id}** - ServiceController:show<br>
**POST /api/v1/services** - ServiceController:store<br>
**PUT /api/v1/services** - ServiceController:update<br>
**DELETE /api/v1/services/{id}** - ServiceController:destroy<br>
#### Appointments
**GET /api/v1/appointments** - AppointmentController:index<br>
**GET /api/v1/appointments/{id}** - AppointmentController:show<br>
**POST /api/v1/appointments** - AppointmentController:store<br>
**PUT /api/v1/appointments** - AppointmentController:update<br>
**DELETE /api/v1/appointments/{id}** - AppointmentController:destroy<br>
**GET /api/v1/appointments/hours/free** - AppointmentController:freeHours<br>

## Web
**View /salon**<br>
**View /appointment**<br>
**View /admin**<br>
**View /admin/salons**<br>
**View /admin/services**<br>
**View /admin/appointments**<br>

## Встановлення за допомогою Docker

- Завантажте репозиторій ```git clone https://github.com/AndrewYaremenko/Eva-test-task.git```
- Перейдіть до каталогу проекту: ```cd Eva-test-task```
- Встановіть необхідні PHP бібліотеки: ```composer install```
- Встановіть необхідні NPM бібліотеки: ```npm install```
- Скомпілюйте фронтенд: ```npm run dev```
- Скопіюйте файл ```.env.docker``` та перейменуйте його в ```.env```
- Запустіть додаток: ```docker-compose up -d```
- Відкрийте термінал контейнера: ```docker exec -it project_app bash```
- Виконайте міграцію таблиць у БД: ```php artisan migrate```
- Згенеруйте ключ додатку: ```php artisan key:generate```
