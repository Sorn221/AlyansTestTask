/** закрывать при клике вне */
function openPersonPopup() {
    let popupClasses = $("#person-popup").attr('class');
    if (popupClasses.indexOf('no-display') >= 0) {
        $("#person-popup").removeClass('no-display');
    } else {
        $("#person-popup").addClass('no-display');
    }
}

jQuery(function($){
    $(document).mouseup( function(e) {
        var div = $("#person-popup");
        if ( !div.is(e.target) && div.has(e.target).length === 0 ) {
            $("#person-popup").addClass('no-display');
        }
    });
});

function openPage(page) {
    if (page === 'home') {
        window.location = './';
    }else {
        window.location = './' + page;
    }
}

function openPopup() {
    $('#add-comment').removeClass('no-display');
}

function closePopup() {
    document.querySelector('#review-id').value = '';
    document.querySelector('#review-title').value = '';
    document.querySelector('#review-content').value = '';
    document.querySelector('#recommend-yes').checked = false;
    document.querySelector('#recommend-no').checked = false;

    // костыль, что бы удалять все слушатели событий при закрытии модалки ._.
    const button = document.querySelector('#add-review-btn');
    const parent = button.parentNode;
    button.remove();
    parent.appendChild(button);

    $('#add-comment').addClass('no-display');
    $('#popup-comment').addClass('no-display');
}

function changePassBtnClick(){
    $('#change-password').removeClass('no-display');
    $('#change-pass-btn').addClass('no-display');
}

async function isAuthorized() {
    try {
        const response = await fetch('/check-auth', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'include',
        });

        const data = await response.json();

        if (data.authorized) {
            $('[authorized]').removeClass('no-display');
            $('[not-authorized]').addClass('no-display');
            $('.person--nickname').text(data.user.login);
            document.querySelector('#change-pass-btn').addEventListener('click', changePassBtnClick);
            document.querySelector('#submit-review').addEventListener('click', submitReview);
        } else {
            $('[authorized]').addClass('no-display');
            $('[not-authorized]').removeClass('no-display');
        }
    } catch (error) {
        console.error('Ошибка при проверке авторизации:', error);
    }
}

function selectActiveMenuItem(){
    let location = window.location.pathname;
    location === '/' ? location = 'home' : location = location.slice(1);
    const element = document.querySelector(`div.menu--item#${location}`);

    if (!element) return;

    element.classList.add('active');
}

function showPassword(inputId, element) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        element.classList.add('private-off');
    } else {
        input.type = 'password';
        element.classList.remove('private-off');
    }
}

async function submitReview() {
    try {
        const authResponse = await fetch('/check-auth', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'include',
        });

        const authData = await authResponse.json();


        if (!authData.authorized) {
            alert('Для отправки отзыва необходимо авторизоваться.');
            window.location.href = '/authentication';
            return;
        }


        const title = document.getElementById('review-title').value;
        const content = document.getElementById('review-content').value;
        const recommendYes = document.getElementById('recommend-yes').checked;
        const recommendNo = document.getElementById('recommend-no').checked;


        const data = {
            user_id: authData.user.id,
            title: title,
            content: content,
            recommend: recommendYes ? 1 : (recommendNo ? 0 : null),
        };


        const response = await fetch('/reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            credentials: 'include',
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message);
            closePopup();
            window.location.reload();
        } else {
            alert('Ошибка при отправке отзыва: ' + result.message);
        }
    } catch (error) {
        console.error('Ошибка при отправке отзыва:', error);
        alert('Произошла ошибка при отправке отзыва.');
    }
}

window.onload = function () {
    $("#header").load('./components/header.html');
    $("#menu").load('./components/menu.html');
    // $("#add-comment").load('./components/add-comment.html');
    $("#footer").load('./components/footer.html');

    setTimeout(function () {
        isAuthorized();
    }, 10);
};
