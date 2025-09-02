<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - USSD</title>
   <link rel="stylesheet" href="/css/ussd.css">
</head>
<body>
    <div class="ussd-container">
        <div class="ussd-header">
            *126*5# - NGOMBILAND
        </div>
        <div class="ussd-content">
            <h3>Menu Principal</h3>
            <ul class="ussd-menu">
                <li><a href="#">1. Rechercher un bien</a></li>
                <li><a href="#">2. Mes favoris</a></li>
                <li><a href="#">3. Mes investissements</a></li>
                <li><a href="#">4. Mon solde (2500 FCFA)</a></li>
                <li><a href="#">5. Notifications</a></li>
                <li><a href="#">6. Support client</a></li>
            </ul>
            
            <div class="ussd-input">
                <p>Entrez votre choix:</p>
                <input type="text" placeholder="Ex: 1">
                <button class="ussd-btn">Envoyer</button>
            </div>
        </div>
        <div class="ussd-footer">
            Frais: 25 FCFA par session
        </div>
    </div>
</body>
</html>