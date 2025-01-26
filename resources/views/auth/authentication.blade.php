@include('common.header')

<div class="content">
    <div class="popup">
        <div class="popup--tabs" id="popup-tabs">
            <div id="auth" class="tab pointer active">Вход</div>
            <div id="registration" class="tab pointer">Регистрация</div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div id="auth-data" class="popup--fields">
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image">
                        <input id="password" type="password" name="password" required>
                        <span class="private" onclick="showPassword('password',this)"></span>
                    </div>
                </div>
                <div class="field text-right">
                    <a href="{{route('password-recovery')}}">Забыли пароль?</a>
                </div>
                <div class="field">
                    <div class="button primary">
                        <button type="submit">Войти</button>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div id="registration-data" class="popup--fields no-display">
                <div class="field">
                    <label class="field--label">Логин / Имя пользователя</label>
                    <div class="field--data">
                        <input type="text" id="login" name="login" value="{{ old('login') }}" required>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image">
                        <input id="password" type="password" name="password" required>
                        <span class="private" onclick="showPassword('password', this)"></span>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Повторите пароль</label>
                    <div class="field--data with-image">
                        <input id="password-confirm" type="password" name="password_confirmation" required>
                        <span class="private" onclick="showPassword('password-confirm', this)"></span>
                    </div>
                </div>
                <div class="field">
                    <input type="checkbox"/>
                    <span>Я даю согласие на <a href="{{route('privacy')}}">обработку моих персональных данных</a></span>
                </div>
                <div class="field">
                    <div class="button primary">
                        <button type="submit">
                            Зарегистрироваться
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('common.footer')
