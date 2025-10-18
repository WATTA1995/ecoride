function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}


 function closeBubble() {
            document.getElementById('welcomeBubble').classList.add('hidden');
        }

        // Fonction pour afficher la bulle (pour les tests)
        function showBubble() {
            document.getElementById('welcomeBubble').classList.remove('hidden');
        }

        // Fermer automatiquement après 5 secondes
        setTimeout(function() {
            closeBubble();
        }, 5000);

    