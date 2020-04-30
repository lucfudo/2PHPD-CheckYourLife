<!--login form-->
<div id="login-box">
    <h2>Login</h2>
    <form method="post" action="../second_page/second-page.php">
        <input id="login-nickname" type="text" name="nickname" placeholder="Nickname">
        <input id="login-password" type="password" name="password" placeholder="Password">
        <br>
        <p id="form-messages"></p>
        <button id="submit-login-button" class="validate" type="submit" name="submit">Validate</button>
    </form>
    <button id="sign-up-button" class="change">Create an account</button>

</div>

<!--change for create an account-->
<script>
    $(document).ready(function(){
        $("#sign-up-button").click(function(){
            $("#login-box").load("registration.php");
        });
    });
</script>

<!--check for login-->
<script>
    const form = {
      nickname: document.getElementById('login-nickname'),
      password: document.getElementById('login-password'),
      submit: document.getElementById('submit-login-button'),
      messages: document.getElementById('form-messages')
    };

    form.submit.addEventListener('click', (event) => {
        event.preventDefault();
        const request = new XMLHttpRequest();

        request.onload = () =>{
            let responseObject = null;

            try{
                responseObject = JSON.parse(request.responseText);
            } catch(e){
                console.error('Could not parse JSON!');
            }

            if (responseObject){
                handleResponse(responseObject);
            }
        };

        const requestData = `nickname=${form.nickname.value}&password=${form.password.value}`;


        request.open('post', 'login-check.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(requestData);

        function handleResponse(responseObject){
            if(!responseObject.change){
                while (form.messages.firstChild){
                    form.messages.removeChild(form.messages.firstChild);
                }

                responseObject.messages.forEach((message) =>{
                    const p = document.createElement('p');
                    p.textContent = message;
                    p.classList.add("form-message");
                    form.nickname.classList.add("input-error");
                    form.password.classList.add("input-error");
                    form.messages.appendChild(p);
                });
            }
            else{
                while (form.messages.firstChild){
                    form.messages.removeChild(form.messages.firstChild);
                }
                responseObject.messages.forEach((message) =>{
                    const p = document.createElement('p');
                    p.textContent = message;
                    p.classList.add("form-message");
                    p.classList.add("success-message");
                    form.messages.appendChild(p);
                });

                setTimeout(function () {
                    window.location.href = "http://localhost:63342/CheckYourLife/content/second_page/second-page.php";
                }, 2000)
            }
        }
    })
</script>
