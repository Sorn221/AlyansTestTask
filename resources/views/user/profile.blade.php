@include('common.header')

<div class="content">
    <h2>Мой профиль</h2>


    <div class="profile">
        <div class="my-profile">
            <div class="photo">
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Фото профиля" class="profile-photo">
                @else
                    <img src="{{ asset('image/default-avatar.png') }}" alt="Фото профиля" class="profile-photo">
                @endif
            </div>
            <div class="info">
                <div class="info--nickname">{{ $user->login }}</div>
                <div class="info--id">ID: {{ $user->id }}</div>
                <div class="info--update-photo pointer" onclick="document.getElementById('upload-photo').click()">
                    Заменить фото
                </div>
                <form id="upload-photo-form" action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="info">
                        <input type="file" id="upload-photo" name="photo" accept="image/*">
                        <button class="button primary" type="submit">Загрузить</button>
                    </div>
                </form>
            </div>
        </div>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="update-data">
                <div class="fields">
                    <div class="field">
                        <label class="field--label">Логин / Имя пользователя</label>
                        <div class="field--data">
                            <input type="text" name="login" value="{{ $user->login }}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="field--label">E-mail</label>
                        <div class="field--data">
                            <input type="email" name="email" value="{{ $user->email }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" class="button primary" style="margin-bottom: 20px;">Сохранить</button>
            </div>
        </form>

        <div class="buttons">
            <div class="button" id="change-pass-btn">Сменить пароль</div>
        </div>

        <div id="change-password" class="no-display">
            <form action="{{ route('profile.change-password') }}" method="POST">
                @csrf
                <div class="update-data">
                    <div class="fields">
                        <div class="field">
                            <label class="field--label">Новый пароль</label>
                            <div class="field--data with-image">
                                <input type="password" id="new-password" name="new_password">
                                <span class="private" onclick="showPassword('new-password', this)"></span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="field--label">Подтвердите пароль</label>
                            <div class="field--data with-image">
                                <input type="password" id="confirm-password" name="new_password_confirmation">
                                <span class="private" onclick="showPassword('confirm-password', this)"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" class="button primary">Сменить пароль</button>
                </div>
            </form>
        </div>
    </div>

    <h2>Мои отзывы</h2>

    <div class="comments">
        @foreach ($reviews as $review)
            <div class="comment">
                <div class="person">
                    <span class="person--icon">
                        <img src="{{ asset('image/Union.png') }}" alt="User Icon">
                    </span>
                    <span class="person--nickname">{{ $review->user->login }}</span>
                </div>
                <div class="date">
                    {{ $review->created_at->format('d.m.Y') }}
                </div>
                <div class="comment--title">
                    {{ $review->title }}
                </div>
                <div class="comment--data">
                    {{ Str::limit($review->content, 350) }}
                </div>
                <div class="buttons">
                    <div class="button" onclick="showAll({{ $review->id }})">Читать весь отзыв</div>
                </div>
            </div>
        @endforeach
    </div>

</div>

@include('common.footer')

<div id="popup-comment" class="add-comment popup-comment no-display">
    <div class="comment-form">
        <div class="popup--title">
            Отзыв
            <div class="close pointer" onclick="closePopup()">
                <img src="./image/close.svg">
            </div>
        </div>
        <div class="comment--info">
            <div class="person">
                            <span class="person--icon">
                                <img src="./image/Union.png">
                            </span>
                <span class="person--nickname">Nickname</span>
            </div>
            <div class="comment--title">
            </div>
            <div class="comment--data">
            </div>
            <div class="recommend no-display">
                <img src="./image/mdi_thumb-up-outline.svg">
                <div>
                    <div class="nickname">Nickname</div>
                    <div class="status">рекомендует</div>
                </div>
            </div>
            <div class="recommend no-recommend">
                <img src="./image/mdi_thumb-up-outline-red.svg">
                <div>
                    <div class="nickname">Nickname</div>
                    <div class="status">нерекомендует</div>
                </div>
            </div>
        </div>
        <div class="comment--footer buttons">
            <div class="button" onclick="closePopup()">Назад</div>
        </div>
    </div>
</div>
