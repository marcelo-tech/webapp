<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuario</title>
</head>

<body>
    <header>
        <h1 class="main-header">Backend Tests Dot Com</h1>
    </header>
    <main>
        <h1 class="page-header">Lista de usuarios</h1>
        <article>
            <ul class="users-data">
                <!-- a array vazia e para remover erros do IDE, não importa! -->
                <?php foreach ($users ?? [] as $user): ?>
                    <h2><?= $user->fullname ?></h2>
                    <li><?= $user->fullname ?></li>
                    <li><?= $user->username ?></li>
                    <li><?= $user->email ?></li>
                    <li><?= $user->birthday ?></li>
                    <li><?= $user->genre ?></li>
                    <li><?= $user->city ?></li>
                    <li><?= $user->phone ?></li>
                    <li><?= $user->country ?></li>
                    <li><?= $user->password ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </main>
    <footer>&copy backend tests dot com</footer>
</body>

</html>