// /static/js/auth.js
let auth_form = document.forms.auth;
console.log("AUTH");
auth_form.addEventListener('submit', async (event)=>{
    event.preventDefault();
    try {
        const response =
            await fetch('/login', {
            method: 'POST',
            body: new FormData(auth_form)
        });
        const answer = await response.text(); // .json();
        console.log("ответ сервера " + answer);
        responseHandler(answer);
    } catch (error) {
        console.log("ошибка", error);
    }
});

const AUTH_LOGIN_ERROR = 'Ошибка LOGIN авторизации';
const AUTH_PWD_ERROR = 'Ошибка PWD авторизации';
const AUTH_SUCCESS = 'Авторизация прошла успешно';
function responseHandler(answer){
    if (answer === AUTH_LOGIN_ERROR || answer === AUTH_PWD_ERROR){
        alert(answer)
    } else if (answer === AUTH_SUCCESS){
        window.location.replace('/account');
    }
}
