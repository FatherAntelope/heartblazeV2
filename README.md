# HeartBlaze
Веб-приложение для занятия физической культурой в режиме online.
## Описание папок c их содержимым

### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `administrator`
> Располагает в себе все файлы для работы с личным кабинетом администратора и его панелью управления
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `groups.php`
> Страница работы с группами сайта
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `lk.php`
> Страница личного кабинета администратора
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `professors.php`
> Страница работы с преподавателями сайта
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `students.php`
> Страница работы со студентами сайта

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `db`
> Располагает в себе файл, необходимый для подключения к базе данных

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `error`
> Располагает в себе все файлы для отображение ошибок, таких как **401**, **403** и **404**

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `frameworks`
> Располагает в себе фреймворки, используемые приложением
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `jquery.min.js`
> Фреймворк jQuery
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `rb.php`
> ORM фреймворк RedBeanPHP
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `semantic.min.css`
> CSS фреймворк Semantic UI (стили)
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `semantic.min.js`
> CSS фреймворк Semantic UI (сценарии)

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `professor`
> Располагает в себе все файлы для работы с личным кабинетом преподавателя и его панелью управления
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `group.php`
> Страница работы с группами
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `lk.php`
> Страница личного кабинета преподавателя
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `panel.php`
> Страница работы с панелью управления преподавателя

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `queries`
> Располагает в себе файлы запросов на сервер или в базу данных
#### ![#f03c15](https://placehold.it/15/177245/000000?text=+) `administrator`
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `addSpecialization.php`
>> Запрос на добавление специализации
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `confirmCertificate.php`
>> Запрос на проверку документа/заявки преподавателя на подтверждение личности
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeGroup.php`
>> Запрос на удаление группы преподавателя
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeProfessor.php`
>> Запрос на удаление учетной записи преподавателя
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeSpecialization.php`
>> Запрос на удаление специализации
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeStudent.php`
>> Запрос на удаление учетной записи студента
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `uploadCertificate.php`
>> Запрос на выгрузку документа преподавателя
#### ![#f03c15](https://placehold.it/15/177245/000000?text=+) `professor`
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `addGroup.php`
>> Запрос на добавление группы
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `addLesson.php`
>> Запрос на добавление занятия
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `getLessonStudentsData.php`
>> Запрос на получение данных студентов по группе
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeGroup.php`
>> Запрос на удаление группы
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeLesson.php`
>> Запрос на удаление занятие
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `removeStudent.php`
>> Запрос на удаление студента из группы
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `replacePersonalData.php`
>> Запрос на смену персональных данных преподавателя
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `sendCheckData.php`
>> Запрос на проверку данных студентов за занятие
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `sendRequest.php`
>> Запрос на подтверждение личности преподавателя
#### ![#f03c15](https://placehold.it/15/177245/000000?text=+) `student`
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `getNormatives.php`
>> Запрос на получение нормативов студента
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `getStudentPhysicalData.php`
>> Запрос на получение физических параметров студента
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `leaveGroup.php`
>> Запрос на выход из группы
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `referenceGroup.php`
>> Запрос на привязку к группе преподавателя
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `replacePersonalData.php`
>> Запрос на смену персональных данных студента
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `sendLessonParticipation.php`
>> Запрос на отправку данных занятия
> ##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `sendPhysicalParameters.php`
>> Запрос на отправку физических параметров студента


##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `exit.php`
> Запрос на выход из личного кабинета
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `function.php`
> Функции, используемые в приложении
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `registration.php`
> Запрос на регистрацию аккаунта
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `replaceAvatar.php`
> Запрос на смену аватарки
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `replacePassword.php`
> Запрос на смену пароля
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `sendMsgToMailForRecoveryPass.php`
> Запрос на отправку сообщения на почту персоны для смены пароля

---
### ![#c5f015](https://via.placeholder.com/15/c5f015/000000?text=+) `student`
> Располагает в себе все файлы для работы с личным кабинетом студента и его панелью управления
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `lk.php`
> Страница личного кабинета студента
##### ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) `panel.php`
> Страница работы с панелью управления студента

---
## Описание прочих файлов
### ![#f03c15](https://placehold.it/15/256d7b/000000?text=+) `index.php`
> Главная страница и страница аутентификации пользователя
### ![#f03c15](https://placehold.it/15/256d7b/000000?text=+) `sql.sql`
> SQL запросы на создание таблиц базы данных в MySQL