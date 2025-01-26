async function showUpdateComment(reviewId) {
    try {
        const response = await fetch(`/reviews/${reviewId}`);
        const review = await response.json();

        document.querySelector('#review-title').value = review.title;

        document.querySelector('#review-content').value = review.content;

        const recommendYes = document.querySelector('#recommend-yes');
        const recommendNo = document.querySelector('#recommend-no');

        if (review.recommend === 1) {
            recommendYes.checked = true;
            recommendNo.checked = false;
        } else if (review.recommend === 0) {
            recommendYes.checked = false;
            recommendNo.checked = true;
        } else {
            recommendYes.checked = false;
            recommendNo.checked = false;
        }

        document.querySelector('#add-review-btn').addEventListener('click', updateComment)
        openPopup();
    } catch (error) {
        console.error('Ошибка при получении отзыва:', error);
        alert('Произошла ошибка при загрузке отзыва.');
    }
}

function showAddComment() {
    document.querySelector('#add-review-btn').addEventListener('click', addComment)
    openPopup();
}

async function showAll(reviewId) {
    try {
        const response = await fetch(`/reviews/${reviewId}`);
        const review = await response.json();

        document.querySelector('#popup-comment .person--nickname').textContent = review.user.login;
        document.querySelector('.nickname').textContent = review.user.login;
        document.querySelector('#popup-comment .comment--title').textContent = review.title;
        document.querySelector('#popup-comment .comment--data').textContent = review.content;

        const recommendDiv = document.querySelector('#popup-comment .recommend');
        const noRecommendDiv = document.querySelector('#popup-comment .no-recommend');

        if (review.recommend === 1) {
            recommendDiv.classList.remove('no-display');
            noRecommendDiv.classList.add('no-display');
            recommendDiv.querySelector('.nickname').textContent = review.user.login;
        } else if (review.recommend === 0) {
            noRecommendDiv.classList.remove('no-display');
            recommendDiv.classList.add('no-display');
            noRecommendDiv.querySelector('.nickname').textContent = review.user.login;
        } else {
            recommendDiv.classList.add('no-display');
            noRecommendDiv.classList.add('no-display');
        }

        document.getElementById('popup-comment').classList.remove('no-display');
    } catch (error) {
        console.error('Ошибка при получении отзыва:', error);
        alert('Произошла ошибка при загрузке отзыва.');
    }
}

function updateSort() {
    let sort = $('#sort').attr('class');
    if (sort.indexOf('up') >= 0) {
        $('#sort').addClass('down');
        $('#sort').removeClass('up');
    } else {
        $('#sort').addClass('up');
        $('#sort').removeClass('down');
    }
}

function updateComment() {
    const reviewId = document.querySelector('#review-id').value;
    const title = document.querySelector('#review-title').value;
    const content = document.querySelector('#review-content').value;
    const recommend = document.querySelector('input[name="recommend"]:checked')?.value;

    if (!title || !content) {
        alert('Заполните все обязательные поля.');
        return;
    }

    fetch(`/reviews/${reviewId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            title: title,
            content: content,
            recommend: recommend
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при обновлении отзыва.');
        });
}

function addComment() {
    const title = document.querySelector('#review-title').value;
    const content = document.querySelector('#review-content').value;
    const recommend = document.querySelector('input[name="recommend"]:checked')?.value;

    if (!title || !content) {
        alert('Заполните все обязательные поля.');
        return;
    }

    fetch('/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            title: title,
            content: content,
            recommend: recommend
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при добавлении отзыва.');
        });
}

//region search
const searchInput = document.getElementById('search-input-field');
const searchIcon = document.getElementById('search-icon');

function performSearch() {
    const search = searchInput.value.trim();

    fetch(`/reviews/search/${encodeURIComponent(search)}`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.json();
        })
        .then(data => {
            updateReviewsList(data);
            updateTotalReviews(data.length);
        })
        .catch(error => {
            console.error('Ошибка при поиске:', error);
        });
}
searchInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});

searchIcon.addEventListener('click', function () {
    performSearch();
});
//endregion

//region search
let sortOrder = 'desc';

document.getElementById('sort').addEventListener('click', function () {
    sortOrder = sortOrder === 'desc' ? 'asc' : 'desc';

    fetch(`/reviews/sort/${sortOrder}`)
        .then(response => response.json())
        .then(data => {
            updateReviewsList(data);
            // updateSortIcon(sortOrder);
        })
        .catch(error => {
            console.error('Ошибка при сортировке:', error);
        });
});

async function updateReviewsList(reviews) {
    const commentsContainer = document.querySelector('.comments');
    commentsContainer.innerHTML = '';

    const response = await fetch('/check-auth', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
    });

    const data = await response.json();

    let userId = null;
    if (data.authorized) userId = data.user.id;

    let imgPath = window.location.origin

    reviews.forEach(review => {
        let editReviewButton = '';
        if (review.user_id === userId) {
            editReviewButton = `
                    <div class="button with-image" onclick="showUpdateComment(${review.id})">
                        <img src="{{ asset('image/Review.svg') }}" alt="Edit Icon">
                        Редактировать отзыв
                    </div>
                `
        }

        const commentElement = document.createElement('div');
        commentElement.className = 'comment';
        commentElement.innerHTML = `
            <div class="person">
                <span class="person--icon">
                    <img src="${imgPath}/image/Union.png" alt="User Icon">
                </span>
                <span class="person--nickname">${review.user.login}</span>
            </div>
            <div class="date">
                ${new Date(review.created_at).toLocaleDateString()}
            </div>
            <div class="comment--title">
                ${review.title}
            </div>
            <div class="comment--data">
                ${review.content.length > 350 ? review.content.substring(0, 350) + '...' : review.content}
            </div>
            <div class="buttons">`
            + editReviewButton
            + `<div class="button" onclick="showAll(${review.id})">Читать весь отзыв</div>
            </div>`;
        commentsContainer.appendChild(commentElement);
    });
}

function updateTotalReviews(count) {
    const totalReviewsElement = document.querySelector('.all-count');
    totalReviewsElement.textContent = `Найден(о) ${count} отзыв(а/ов)`;
}
//endregion
