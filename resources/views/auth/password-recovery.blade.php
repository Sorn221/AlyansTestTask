@include('common.header')

<div class="content">
    <div class="popup">
        <div class="popup--info">
            <h2>Восстановление пароля</h2>
            <div>Введите свою почту, и мы отправим вам ссылку на восстановление пароля</div>
        </div>
        <div id="auth-data" class="popup--fields">
            <div class="field">
                <label class="field--label">E-mail</label>
                <div class="field--data">
                    <input type="text" id="email" placeholder="Введите ваш E-mail">
                    <div id="email-error" class="error-message" style="color: red; display: none;">Неверный E-mail</div>
                </div>
            </div>
            <div class="field buttons">
                <div class="button" id="back-button" onclick="openPage('authentication')">
                    Назад
                </div>
                <div class="button primary" id="next-button" onclick="nextButtonClick()">
                    Далее
                </div>
            </div>
        </div>
    </div>
</div>

@include('common.footer')
