<div class="step-content hidden" id="step2">
    <div class="mb-5">
        <h2 class="text-xl font-semibold text-white mb-1">Choisissez Votre Rôle</h2>
        <p class="text-white/70 text-sm">Sélectionnez comment vous utiliserez NGOMBILAND</p>
    </div>
    
    <div class="grid grid-cols-1 gap-3 mb-5">
        <div class="profile-card glass-card p-4 rounded-lg cursor-pointer" data-role="client">
            <h3 class="text-sm font-semibold text-white mb-0.5">Client</h3>
            <p class="text-xs text-white/70">Je cherche une nouvelle maison</p>
        </div>
        <div class="profile-card glass-card p-4 rounded-lg cursor-pointer" data-role="investor">
            <h3 class="text-sm font-semibold text-white mb-0.5">Investisseur</h3>
            <p class="text-xs text-white/70">Je veux investir dans l'immobilier</p>
        </div>
        <div class="profile-card glass-card p-4 rounded-lg cursor-pointer" data-role="proprietor">
            <h3 class="text-sm font-semibold text-white mb-0.5">Propriétaire</h3>
            <p class="text-xs text-white/70">J'ai des projets à lister</p>
        </div>
        <div class="profile-card glass-card p-4 rounded-lg cursor-pointer" data-role="agent">
            <h3 class="text-sm font-semibold text-white mb-0.5">Agent Immobilier</h3>
            <p class="text-xs text-white/70">Je vends des propriétés</p>
        </div>
    </div>
    
    <input type="hidden" name="role" id="roleInput">

    <div class="flex justify-between">
        <button type="button" class="bg-transparent border border-white/20 text-white w-1/3 py-2 text-xs rounded-lg" id="step2-back">Retour</button>
        <button type="button" class="primary-btn w-2/3 py-2 ml-3 text-xs rounded-lg" id="step2-next" disabled>Continuer</button>
    </div>
</div>
