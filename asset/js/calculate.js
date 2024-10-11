// fonction qui sert à calculer automatiquement les points total attribués...
// ...pour une mission en fonction de sa durée (en heure)...
//... et du nombre de point par heure puis ca mets à jour le champ des points total 

function calculatePoints() {
    // On récupère la date et l'heure de début depuis l'input avec l'ID 'start_date'
    const startDate = new Date(document.getElementById('start_date').value);

    // On récupère la date et l'heure de fin depuis l'input avec l'ID 'end_date'
    const endDate = new Date(document.getElementById('end_date').value);

    // On récupère la valeur des point par heure depuis l'input avec l'ID 'points_per_hour'
    // parseInt sert à convertir cette valeur en nombre entier (base de 10)
    const pointsPerHour = parseInt(document.getElementById('points_per_hour').value, 10);

    // Si les deux date existe et que la date de fin est après la date de début
    if (startDate && endDate && endDate > startDate) {
        // On calcule alors la durée entre les deux dates en heures
        const durationInHours = Math.abs(endDate - startDate) / 36e5;

        // On multiplie la durée en heures par les points par heure pour obtenir les points total
        const totalPoints = durationInHours * pointsPerHour;

        // On met à jour l'input avec l'ID 'total_points' avec la valeur des points total arrondie
        document.getElementById('total_points').value = Math.round(totalPoints);
    } else {
        // Si les dates sont invalides ou si la date de fin est avant la date de début, on met les points à 0
        document.getElementById('total_points').value = 0;
    }
}

// écouteur d'évenemnt
// On écoute les changements dans l'input 'start_date' et on appelle calculatePoints quand ça change
document.getElementById('start_date').addEventListener('change', calculatePoints);

// On écoute les changements dans l'input 'end_date' et on appelle calculatePoints quand ça change
document.getElementById('end_date').addEventListener('change', calculatePoints);


function calculatePoints() {
    let startDate = new Date(document.getElementById('start_date').value);
    let endDate = new Date(document.getElementById('end_date').value);
    let pointsPerHour = parseInt(document.getElementById('points_per_hour').value, 10);

    if (startDate && endDate && endDate > startDate) {
        let durationInHours = Math.abs(endDate - startDate) / 36e5;
        let totalPoints = durationInHours * pointsPerHour;
        document.getElementById('total_points').value = Math.round(totalPoints);
    } else {
        document.getElementById('total_points').value = 0;
    }
}
document.getElementById('start_date').addEventListener('change', calculatePoints);
document.getElementById('end_date').addEventListener('change', calculatePoints);