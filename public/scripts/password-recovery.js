function nextButtonClick() {
    const email = document.getElementById('email').value;
    const emailError = document.getElementById('email-error');

    if (!validateEmail(email)) {
        emailError.style.display = 'block';
        return;
    } else {
        emailError.style.display = 'none';
    }

    fetch('/check-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({email: email})
    })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                fetch('/send-reset-link', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({email: email})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при отправке письма:', error);
                    });
            } else {
                emailError.textContent = 'Неверный E-mail';
                emailError.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Ошибка при проверке E-mail:', error);
        });
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
