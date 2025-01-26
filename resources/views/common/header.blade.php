<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta lang="ru">
    <link rel="stylesheet" href="{{ asset('/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/comments.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/popup.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/profile.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>

<div id="header" class="header"></div>
<div id="menu" class="menu"></div>
<div id="add-comment" class="add-comment no-display">
    <input type="hidden" id="review-id" name="id" value="">
    <div class="comment-form">
        <div class="popup--title">
            Новый отзыв
            <div class="close pointer" onclick="closePopup()">
                <img src="./image/close.svg">
            </div>
        </div>
        <div class="comment--info">
            <div class="field">
                <label class="field--label">Заголовок отзыва одной фразой</label>
                <div class="field--data">
                    <input type="text" id="review-title" name="title" required/>
                </div>
            </div>
            <div class="field">
                <label class="field--label">Ваш отзыв</label>
                <textarea class="field--data" name="content" id="review-content" rows="20" required></textarea>
            </div>
            <div class="field--radio" authorized>
                <label class="field--label">Вы бы порекомендовали это?</label>
                <div class="field--data">
                    <input type="radio" name="recommend" id="recommend-yes" value="1"/>
                    <label>Да</label>
                </div>
                <div class="field--data">
                    <input type="radio" name="recommend" id="recommend-no" value="0"/>
                    <label>Нет</label>
                </div>
            </div>
            <div class="field" not-authorized>
                Для того, чтобы оставить рекомендацию к отзыву, <a href="/authentication">войдите или
                    зарегистрируйтесь</a>
            </div>
        </div>
        <div class="comment--footer buttons">
            <div  id="add-review-btn" class="button primary">Отправить отзыв</div>
            <div class="button" onclick="closePopup()">Назад</div>
        </div>
    </div>
</div>

