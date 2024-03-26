<h2>Welcome back</h2>

<!-- lien vers le controller  -->
    <form action="index.php?ctrl=security&action=login" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" name="submit" value="Log in">
    </form>

    <div class="create-account">
        <p>No account yet? Sign up here</p>
        <a href="index.php?ctrl=security&action=viewRegister">Create an account</a>
    </div>