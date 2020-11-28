<?php
require $_SERVER['DOCUMENT_ROOT'] . "/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('1');
$professor = R::findOne('professor', 'id_person = ?', [$person->id]);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css'>
    <link rel="stylesheet" href="/frameworks/semantic.min.css"/>
    <link rel="shortcut icon" href="/images/ugatu_logo.png" type="image/x-icon">
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Личный кабинет</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<!--
* Контейнер - блок с содержимым, имеющий отступы по краям (слева и справа)
-->
<div class="ui container">
    <!--
    * Делим контейнер на две колонки
    -->
    <div class="ui two column stackable grid">
        <!--
        * Ширина первой колонки - 4. Всего в ширину может быть 16 колонок
        -->
        <div class="column four wide">
            <!--
            * Сегмент, в котором располагается аватарка
            -->
            <div class="ui segment inverted blue">
                <div class="ui red left ribbon label"><?php echo $person->login; ?></div>

                <img class="ui image centered" src="<? echo getImageSource($person->photo);?>"
                     style="object-fit: cover; height: 200px; width: 200px; border-radius: 54% 46% 47% 53% / 24% 55% 45% 76%;">
                <div class="ui tiny icon buttons orange fluid" style="margin-top: 20px">
                    <a href="/queries/exit.php" class="ui button hint" data-content="Выйти" data-position="top center">
                        <i class=" sign-out large icon"></i>
                    </a>
                    <button class="ui button hint" data-content="Сменить фотографию" data-position="top center"
                            onclick="openModalWindowForAvatarReplace()" >
                        <i class="file large image icon"></i>
                    </button>
                </div>
            </div>
            <? if ($professor->status == 0 || $professor->status == 2) { ?>
                <div class="ui info message">
                    Для доступа к панели управления подтвердите личность преподавателя с помощью удостоверения
                </div>
            <? } ?>

            <!--
            * Кнопка для перехода в панель управления
            -->
            <a href="/professor/panel.php"
               class="ui green button fluid <? if ($professor->status == 0 || $professor->status == 2) echo "disabled" ?>">
                Панель управления
            </a>
        </div>
        <div class="column twelve wide">
            <div class="ui segment">
                <h2 class="ui center aligned header" style="color: #db2828">Портфолио</h2>
                <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Личные данные </h4>
                <table class="ui very basic table">
                    <tbody class="center aligned">
                    <tr>
                        <td><b>ФИО:</b></td>
                        <td><?php echo $person->surname, " ", $person->name, " ", $person->patronymic ?></td>
                    </tr>
                    <tr>
                        <td><b>Роль:</b></td>
                        <td>Преподаватель</td>
                    </tr>
                    <tr>
                        <td><b>Должность:</b></td>
                        <td><? if ($professor->job == null) echo "—"; else echo $professor->job; ?></td>
                    </tr>
                    </tbody>
                    <tfoot class="full-width">
                    <tr>
                        <th></th>
                        <th>
                            <div class="ui right floated small green labeled icon button"
                                 onclick="openModalForReplacePersonalData()">
                                <i class="edit icon"></i>
                                Изменить
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Учетные данные </h4>
                <table class="ui very basic table">
                    <tbody class="center aligned">
                    <tr>
                        <td><b>Почта:</b></td>
                        <td><?php echo $person->email; ?></td>
                    </tr>
                    <tr>
                        <td><b>Смена пароля:</b></td>
                        <td><a href="#" onclick="openModalWindowForPassReplace()">Изменить</a></td>
                    </tr>
                    <tr>
                        <td><b>Статус:</b></td>
                        <td>
                            <? if($professor->status == 0) { ?>
                                <a href="#" style="color: #db2828" onclick="openModalCheckProfessor()">Подтвердить</a>
                            <? } elseif ($professor->status == 1) { ?>
                                <p style="color: green">Подтвержден</p>
                            <? } else { ?>
                                <a href="#" style="color: saddlebrown" onclick="openModalCheckProfessor()">Ожидание</a>
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="ui segment">
                <h2 class="ui center aligned header" style="color: #db2828">Возможно, что-то будет</h2>
            </div>
        </div>
    </div>
</div>


<div class="ui modal horizontal flip big" id="modalReplacePersonalData">
    <div class="header" style="color: #db2828">
        Смена личных данных
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalData">
            <div class="fields">
                <div class="required field five wide">
                    <label>Фамилия</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваша фамилия"
                               value="<?php echo $person->surname; ?>" onkeyup="Cyrillic(this)" maxlength="20" minlength="2" name="professor_surname" required>
                        <i class="font icon red"></i>
                    </div>
                </div>
                <div class="required field five wide">
                    <label>Имя</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваше имя"
                               value="<?php echo $person->name; ?>" name="professor_name" onkeyup="Cyrillic(this)" maxlength="20" minlength="2"required>
                        <i class="font icon red"></i>
                    </div>
                </div>
                <div class="field six wide">
                    <label>Отчество</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваше отчество"
                               value="<?php echo $person->patronymic; ?>" onkeyup="Cyrillic(this)" maxlength="40" name="professor_patronymic">
                        <i class="font icon red"></i>
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="required field seven wide">
                    <label>Должность</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ученая степень или звание"
                               value="<?php echo $professor->job; ?>" name="professor_job" onkeyup="CyrillicTwo(this)" maxlength="20" minlength="2" required>
                        <i class="users icon red"></i>
                    </div>
                </div>
            </div>
            <input type="hidden" name="professor_id" value="<? echo $person->id; ?>">
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalForReplacePersonalData()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalData">
            Изменить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalPassReplace">
    <div class="header" style="color: #db2828">
        Смена пароля
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalPassword">
            <div class="required field">
                <label>Старый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите старый пароль" name="person_old_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Новый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите новый пароль" name="person_new_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Повтор пароля</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Повторите новый пароль" maxlength="20" minlength="6" name="person_repeat_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <input type="hidden" name="person_id" value="<? echo $person->id; ?>">
        </form>
        <div class="ui error message" id="msgErrorReplacePassword" style="display: none">
            <i class="close icon"></i>
            <div class="header">Ошибка смены пароля</div>
            <ul>
                <li>Старый пароль неверен или новые не совпадают</li>
                <li>Повторите ввод</li>
            </ul>
        </div>
        <div class="ui success message" id="msgSuccessReplacePassword" style="display: none">
            <div class="header">Пароль успешно сменился на новый!</div>
        </div>
    </div>
    <div class="actions" id="actionsReplacePassword">
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalPassword">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>


<div class="ui modal horizontal flip tiny" id="modalCheckProfessor">
    <div class="header" style="color: #db2828">
        Подтвердить личность преподавателя
    </div>
    <div class="content">
        <form class="ui form" id="formSendRequest"
            <? if ($professor->job === null || $professor->status == 2) echo "hidden" ?> >
            <div class="required field">
                <label>Ваше удостоверение</label>
                <div class="ui left icon input">
                    <input type="file" accept="image/png,image/jpeg" name="professor_certificate" required>
                    <i class="image icon red"></i>
                </div>
            </div>
            <input type="hidden" name="professor_id" value="<? echo $professor->id; ?>">
        </form>
        <? if ($professor->job === null) { ?>
            <div class="ui error message">
                <div class="header">Нет доступа:</div>
                <ul>
                    <li>Вы не можете подать заявку, заполните все данные</li>
                </ul>
            </div>
        <? } ?>

        <? if($professor->status == 2) { ?>
        <div class="ui warning message">
            <div class="header">Вы уже отправили свои данные на проверку</div>
            <ul>
                <li>Дождитесь подтверждения</li>
                <li>Если администратор отклонит запрос, то ваш личный кабинет будет удален</li>
            </ul>
        </div>
        <? } ?>
        <div class="ui success message" id="msgSuccessSendRequest" style="display: none">
            <div class="header">Ваши данные отправлены на проверку! Ожидайте результатов проверки</div>
        </div>

    </div>
    <div class="actions" <? if ($professor->job === null || $professor->status == 2) echo "hidden" ?> id="actionSendRequest">
        <button class="ui right labeled icon green button" form="formSendRequest">
            Отправить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalAvatarReplace">
    <div class="header" style="color: #db2828">
        Смена фотографии
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalAvatar">
            <div class="ui left icon input fluid">
                <input type="file" accept="image/png,image/jpeg" name="person_photo" required>
                <i class="image icon red"></i>
            </div>
            <input type="hidden" value="<? echo $person->id; ?>" name="person_id">
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalAvatar">
            Сменить
            <i class="check icon"></i>
        </button>
    </div>
</div>
</body>
<script>
    function Latin(obj) {
        if (/^[a-zA-Z0-9 ,@.\-:"()]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }

    function Cyrillic(obj) {
        if (/^[а-яА-Я]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }

    function CyrillicTwo(obj) {
        if (/^[а-яА-Я. ]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }



    $("#formReplacePersonalData").submit(function () {
        $.ajax({
            url: "/queries/professor/replacePersonalData.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                location.reload();
            },
            error: function () {
            }
        });
        return false;
    });

    $("#formReplacePersonalAvatar").submit(function () {
        $.ajax({
            url: "/queries/replaceAvatar.php",
            contentType: false,
            processData: false,
            method: "POST",
            data: new FormData(this),
            success: function () {
                location.reload();
            },
            error: function () {
                //location.reload();
            }
        });
        return false;
    });

    $("#formSendRequest").submit(function () {
        $.ajax({
            url: "/queries/professor/sendRequest.php",
            contentType: false,
            processData: false,
            method: "POST",
            data: new FormData(this),
            success: function () {
                document.getElementById("formSendRequest").hidden = true;
                document.getElementById("actionSendRequest").hidden = true;
                document.getElementById("msgSuccessSendRequest").style.display = "block";
                setTimeout(function () {
                    location.reload();
                }, 1100);
            },
            error: function () {
                location.reload();
            }
        });
        return false;
    });

    $("#formReplacePersonalPassword").submit(function () {
        $.ajax({
            url: "/queries/replacePassword.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                document.getElementById("msgSuccessReplacePassword").style.display = "block";
                document.getElementById("msgErrorReplacePassword").style.display = "none";
                document.getElementById("actionsReplacePassword").style.display = "none";
                document.getElementById("formReplacePersonalPassword").hidden = true;
                setTimeout(function () {
                    location.reload();
                }, 1100);

            },
            error: function () {
                document.getElementById("msgSuccessReplacePassword").style.display = "none";
                document.getElementById("msgErrorReplacePassword").style.display = "block";
                document.getElementsByName("person_old_password")[0].value = "";
                document.getElementsByName("person_new_password")[0].value = "";
                document.getElementsByName("person_repeat_password")[0].value = "";
            }
        });
        return false;
    });
</script>
<script>
    $('.message .close')
        .on('click', function () {
            $(this)
                .closest('.message')
                .transition('fade')
            ;
        })
    ;

    $('.ui.dropdown')
        .dropdown()
    ;

    $('.hint')
        .popup()
    ;

    function openModalForReplacePersonalData() {
        $('#modalReplacePersonalData')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalForReplacePersonalData() {
        $('#modalReplacePersonalData')
            .modal('hide')
        ;
    }

    function openModalWindowForAvatarReplace() {
        $('#modalAvatarReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForPassReplace() {
        $('#modalPassReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalCheckProfessor() {
        $('#modalCheckProfessor')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

</script>
</html>