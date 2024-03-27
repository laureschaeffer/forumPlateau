<!-- register  -->

<h2>Create a new account</h2>

<!-- lien vers le controller  -->
<div id="register">
    <form action="index.php?ctrl=security&action=register" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required><br>

        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" required><br>

        <label for="password">Password</label>
        <input type="password" name="pass1" id="password" required><br>

        <label for="password">Check again your password</label>
        <input type="password" name="pass2" id="password" required><br>

        <input type="submit" name="submit" value="Create an account">
    </form>
</div>