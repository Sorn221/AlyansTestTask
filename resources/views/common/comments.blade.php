@include('common.header')

<div class="content with-pagination">
    <h2>Отзывы</h2>

    <div class="filters">
        <div class="search">
            <img id="search-icon" src="./image/Magnifier.svg"/>
            <input type="text" id="search-input-field" placeholder="Найти..."/>
        </div>
        <div class="field">
            <div class="sort">
                Показывать:
                <span onclick="updateSort()" id="sort" class="up">по дате <img
                        src="./image/arrow-wrapper-black.svg"></span>
            </div>
            <div class="all-count">
                Найден(о) {{ $totalReviews }} отзыв(а/ов)
            </div>
        </div>
    </div>

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
                    @if ($review->user_id === Auth::id())
                        <div class="button with-image" onclick="showUpdateComment({{ $review->id }})">
                            <img src="{{ asset('image/Review.svg') }}" alt="Edit Icon">
                            Редактировать отзыв
                        </div>
                    @endif
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
                Прототип нового сервиса — это как треск разлетающихся скреп!
            </div>
            <div class="comment--data">
                Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого
                факта: граница обучения кадров способствует повышению качества экспериментов, поражающих по своей
                масштабности и грандиозности. Следует отметить, что реализация намеченных плановых заданий создаёт
                необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса
                новых принципов формирования материально-технической и кадровой базы.
                Равным образом, существующая теория выявляет срочную потребность укрепления моральных ценностей. В
                целом, конечно, высококачественный прототип будущего проекта влечет за собой процесс внедрения и
                модернизации распределения внутренних резервов и ресурсов. С другой стороны, постоянный количественный
                рост и сфера нашей активности предполагает независимые способы реализации кластеризации усилий.
                Как принято считать, акционеры крупнейших компаний формируют глобальную экономическую сеть и при этом —
                объективно рассмотрены соответствующими инстанциями. Мы вынуждены отталкиваться от того, что глубокий
                уровень погружения требует определения и уточнения прогресса профессионального сообщества! Современные
                технологии достигли такого уровня, что граница обучения кадров позволяет выполнить важные задания по
                разработке анализа существующих паттернов поведения! Современные технологии достигли такого уровня, что
                современная методология разработки не оставляет шанса для прогресса профессионального сообщества.
                Ясность нашей позиции очевидна: постоянный количественный рост и сфера нашей активности обеспечивает
                актуальность приоретизации разума над эмоциями. Таким образом, высокотехнологичная концепция
                общественного уклада не даёт нам иного выбора, кроме определения экспериментов, поражающих по своей
                масштабности и грандиозности.
                Но постоянное информационно-пропагандистское обеспечение нашей деятельности, а также свежий взгляд на
                привычные вещи — безусловно открывает новые горизонты для прогресса профессионального сообщества. Равным
                образом, начало повседневной работы по формированию позиции, а также свежий взгляд на привычные вещи —
                безусловно открывает новые горизонты для приоретизации разума над эмоциями. Приятно, граждане,
                наблюдать, как элементы политического процесса, которые представляют собой яркий пример
                континентально-европейского типа политической культуры, будут представлены в исключительно положительном
                свете. Учитывая ключевые сценарии поведения, дальнейшее развитие различных форм деятельности играет
                важную роль в формировании вывода текущих активов. Однозначно, представители современных социальных
                резервов призваны к ответу. Но курс на социально-ориентированный национальный проект требует от нас
                анализа прогресса профессионального сообщества.
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
