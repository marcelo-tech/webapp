<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
    <title>Registro de Usuarios</title>
    <!--style>
       carrega main.css "styles"
       apartir de public diretorio.
    </style-->
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <header>
        <h1 class="main-header">Backend Tests Dot Com</h1>
    </header>
    <main>
            <h1 class="page-header">Dados do Usuario</h1>

            <!--
            Erros serao mostrados nessa area
        -->
            <?php if (count($errors) > 0): ?>
                <ul class="warnings">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post" action="/users/new" class="form-control">
                <div id="fullnamebox">
                    <label for="fullname">Nome Completo: </label>
                    <input type="text" name="fullname" id="fullname" class="fullname">
                </div>

                <div id="birthdaybox">
                    <label for="birthday">Data de Nacimento: </label>
                    <input type="date" name="birthday" id="birthday">
                </div>


                <div id="genrebox">
                    <div>
                        <input type="radio" name="genre" id="male" value="Male">
                        <label for="male">Masculino</label>
                    </div>
                    <div>
                        <input type="radio" name="genre" id="female" value="Female">
                        <label for="female">Feminino</label>
                    </div>
                </div>


                <div id="citybox">
                    <label for="city">Cidade: </label>
                    <input type="text" name="city" id="city">
                </div>


                <div id="countrybox">
                    <select name="country" id="country">
                        <option value="default">País</option>
                        <option value="brazil">Brazil</option>
                        <option value="argentina">Argentina</option>
                        <option value="paraguai">Paraguai</option>
                    </select>
                </div>


                <div id="phonebox">
                    <label for="phone">Telefone: </label>
                    <input type="text" name="phone" id="phone">
                </div>

                <div id="usernamebox">
                    <label for="username">Nome de Usuario: </label>
                    <input type="text" name="username" id="username">
                </div>

                <div id="passwordbox">
                    <label for="password">Senha: </label>
                    <input type="password" name="password" id="password">
                </div>

                <div id="emailbox">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email">
                </div>


                <div id="agreementbox">
                    <input type="checkbox" name="agreement" id="agreement" value="ok">
                    <label for="agreement">Aceito os termos e condições de uso?</label>
                </div>
                <div id="submitbox">
                    <input type="submit" value="Submit" id="submit">
                </div>
            </form>
    </main>
    <footer>&copy backend tests dot com</footer>
</body>

</html>