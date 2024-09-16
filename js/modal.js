document.getElementById('openModal').onclick = function() {
    document.getElementById('myModal').style.display = 'block';
}

// Fermer le modal
document.getElementsByClassName('close')[0].onclick = function() {
    document.getElementById('myModal').style.display = 'none';
}

// Fermer le modal si l'utilisateur clique en dehors de celui-ci
window.onclick = function(event) {
    if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = 'none';
    }
}

// Action du bouton de confirmation
document.getElementById('confirmButton').onclick = function() {
    alert('Action confirmée !');
    document.getElementById('myModal').style.display = 'none';
}