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

        //  afficher la bulle de bienvenue
        function showBubble() {
            document.getElementById('welcomeBubble').classList.remove('hidden');
        }

        //  automatique 5 secondes
        setTimeout(function() {
            closeBubble();
        }, 5000);


  // Code pour les étoiles d'avis
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const noteInput = document.getElementById('noteInput');
    const ratingText = document.getElementById('ratingText');
    
    if (stars.length === 0) return; // Pas d'étoiles sur cette page
    
    let currentRating = 0;

    stars.forEach(star => {
        // Au clic sur une étoile
        star.addEventListener('click', function() {
            currentRating = this.getAttribute('data-value');
            noteInput.value = currentRating;
            updateStars(currentRating);
            updateRatingText(currentRating);
        });

        // Au survol d'une étoile
        star.addEventListener('mouseenter', function() {
            const hoverValue = this.getAttribute('data-value');
            updateStars(hoverValue);
        });
    });

    // Quand la souris quitte la zone des étoiles
    document.getElementById('stars').addEventListener('mouseleave', function() {
        updateStars(currentRating);
    });

    function updateStars(rating) {
        stars.forEach(star => {
            const starValue = star.getAttribute('data-value');
            if (starValue <= rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }

    function updateRatingText(rating) {
        const texts = {
            1: 'Très mauvais',
            2: 'Mauvais',
            3: 'Moyen',
            4: 'Bon',
            5: 'Excellent'
        };
        ratingText.textContent = texts[rating] || '';
    }
});