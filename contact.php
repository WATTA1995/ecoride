<?php include('header.php'); ?>
<div class="contact">
    <p>Contactez-nous</p> 
    
    <form action="envoyer_message.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
<?php include('footer.php'); ?>