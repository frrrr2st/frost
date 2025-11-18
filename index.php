<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>BTS Errachidia - Journée d'Intégration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    * { font-family: 'Inter', sans-serif; }
    
    body {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
      position: relative;
      overflow-x: hidden;
    }
    
    body::before {
      content: '';
      position: fixed;
      top: -50%;
      right: -50%;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(251,146,60,0.1) 0%, transparent 70%);
      animation: float 20s ease-in-out infinite;
    }
    
    body::after {
      content: '';
      position: fixed;
      bottom: -50%;
      left: -50%;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
      animation: float 25s ease-in-out infinite reverse;
    }
    
    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      50% { transform: translate(50px, 50px) rotate(5deg); }
    }
    
    .glass-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .input-wrapper {
      position: relative;
      margin-bottom: 1.5rem;
    }
    
    .input-wrapper input,
    .input-wrapper textarea,
    .input-wrapper select {
      width: 100%;
      padding: 1rem 1rem 1rem 1rem;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      background: white;
      font-size: 1rem;
      transition: all 0.3s ease;
      outline: none;
    }
    
    .input-wrapper input:focus,
    .input-wrapper textarea:focus,
    .input-wrapper select:focus {
      border-color: #f97316;
      box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
      transform: translateY(-2px);
    }
    
    .input-wrapper label {
      position: absolute;
      left: 1rem;
      top: 1rem;
      color: #64748b;
      pointer-events: none;
      transition: all 0.3s ease;
      background: white;
      padding: 0 0.5rem;
      font-size: 1rem;
    }
    
    .input-wrapper input:focus + label,
    .input-wrapper input:not(:placeholder-shown) + label,
    .input-wrapper textarea:focus + label,
    .input-wrapper textarea:not(:placeholder-shown) + label,
    .input-wrapper select:focus + label,
    .input-wrapper select:not([value=""]) + label {
      top: -0.5rem;
      left: 0.75rem;
      font-size: 0.75rem;
      color: #f97316;
      font-weight: 600;
    }
    
    .radio-card {
      position: relative;
      cursor: pointer;
    }
    
    .radio-card input {
      position: absolute;
      opacity: 0;
    }
    
    .radio-card-content {
      padding: 1rem 1.5rem;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      background: white;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-weight: 500;
    }
    
    .radio-card-content::before {
      content: '';
      width: 20px;
      height: 20px;
      border: 2px solid #cbd5e1;
      border-radius: 50%;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }
    
    .radio-card:hover .radio-card-content {
      border-color: #f97316;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
    }
    
    .radio-card input:checked + .radio-card-content {
      border-color: #f97316;
      background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
      box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
    }
    
    .radio-card input:checked + .radio-card-content::before {
      border-color: #f97316;
      background: #f97316;
      box-shadow: inset 0 0 0 4px white;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
      color: white;
      padding: 1rem 2.5rem;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1.125rem;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
      position: relative;
      overflow: hidden;
    }
    
    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }
    
    .btn-primary:hover::before {
      left: 100%;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 40px rgba(249, 115, 22, 0.4);
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: white;
      border-radius: 100px;
      font-size: 0.875rem;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .header-glow {
      text-shadow: 0 0 40px rgba(249, 115, 22, 0.3);
    }
    
    .alert {
      padding: 1.25rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      animation: slideIn 0.5s ease;
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .alert-success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
      border: 2px solid #6ee7b7;
    }
    
    .alert-error {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
      border: 2px solid #fca5a5;
    }
    
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      z-index: 100;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    
    .modal.active {
      opacity: 1;
      pointer-events: all;
    }
    
    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 20px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
      transform: scale(0.9);
      transition: transform 0.3s ease;
    }
    
    .modal.active .modal-content {
      transform: scale(1);
    }
    
    .section-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .section-title::before {
      content: '';
      width: 4px;
      height: 24px;
      background: linear-gradient(180deg, #f97316 0%, #ea580c 100%);
      border-radius: 100px;
    }
    
    select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23f97316'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1.25rem;
      padding-right: 3rem;
    }
  </style>
</head>
<body class="min-h-screen py-8 px-4">
  
  <!-- Modal Info Médias -->
  <div id="mediaModal" class="modal">
    <div class="modal-content">
      <h3 class="text-2xl font-bold mb-4 text-slate-800">📸 Information Photo/Vidéo</h3>
      <div class="space-y-3 text-slate-600 leading-relaxed">
        <p class="font-semibold text-orange-600">تنبيه التصوير:</p>
        <p>قد يتم التقاط صور/فيديو خلال يوم الاندماج لأغراض تذكارية وتواصل داخلي.</p>
        <p class="font-medium">Votre consentement est important. Vous pouvez choisir d'accepter ou de refuser. Votre choix sera entièrement respecté et vous pouvez le modifier à tout moment.</p>
      </div>
      <div class="mt-6 flex gap-3">
        <button onclick="closeModal()" class="flex-1 px-4 py-2.5 bg-slate-100 rounded-lg font-semibold text-slate-700 hover:bg-slate-200 transition">
          Fermer
        </button>
      </div>
    </div>
  </div>

  <div class="max-w-4xl mx-auto relative z-10">
    
    <!-- En-tête -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl shadow-2xl mb-4 transform hover:scale-110 transition">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
      </div>
      <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3 header-glow">
        BTS Errachidia
      </h1>
      <p class="text-xl text-slate-300 font-medium">Journée d'Intégration 2024-2025</p>
      <div class="mt-4">
        <span class="badge">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
          </svg>
          Inscription Ouverte
        </span>
      </div>
      <div class="mt-6 bg-white/10 border border-white/20 rounded-2xl px-6 py-5 text-slate-100 space-y-3 max-w-2xl mx-auto">
        <p class="text-base md:text-lg font-semibold">
          Tu as une موهبة ? voix, rap, danse, sketch ? Viens la montrer pendant le show !
        </p>
        <a href="talent.php" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white/90 text-slate-900 font-semibold hover:bg-white transition">
          🎤 Proposer ma موهبة
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </a>
        <p class="text-sm text-slate-200">
          Utilise la meme adresse email que sur ce formulaire pour qu'on puisse confirmer ton identite sur Telegram.
        </p>
      </div>
    </div>

    <!-- Messages -->
    <div id="successMsg" class="alert alert-success" style="display: none;">
      <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
      </svg>
      <div>
        <div class="font-bold">Parfait !</div>
        <div>Votre inscription a été enregistrée avec succès.</div>
      </div>
    </div>

    <div id="errorMsg" class="alert alert-error" style="display: none;">
      <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
      </svg>
      <div>
        <div class="font-bold">Erreur</div>
        <div id="errorText">Une erreur s'est produite.</div>
      </div>
    </div>

    <!-- Formulaire -->
    <div class="glass-card rounded-3xl p-6 md:p-10">
      <form action="submit.php" method="post" class="space-y-8" novalidate>
        <!-- Honeypot -->
        <input type="text" name="website" autocomplete="off" class="hidden" aria-hidden="true"/>
        
        <input id="cohort" name="cohort" type="hidden" value="">

        <!-- Identité -->
        <div>
          <h2 class="section-title">👤 Informations Personnelles</h2>
          
          <div class="grid md:grid-cols-2 gap-6">
            <div class="input-wrapper">
              <input name="name" type="text" required placeholder=" " />
              <label>Nom Complet <span class="text-orange-500">*</span></label>
            </div>

            <div class="input-wrapper">
              <select id="filiere" name="filiere_select" required>
                <option value="" selected disabled></option>
                <option value="PME">PME - Productique Mécanique</option>
                <option value="Énergétique">Énergétique</option>
                <option value="Développement Web">Développement Web</option>
                <option value="MI">MI - Maintenance Industrielle</option>
              </select>
              <label>Filière <span class="text-orange-500">*</span></label>
            </div>

            <div class="input-wrapper md:col-span-2">
              <select id="classe" name="classe_select" required>
                <option value="" selected disabled></option>
                <option value="1ère année">1ère année</option>
                <option value="2ème année">2ème année</option>
              </select>
              <label>Classe <span class="text-orange-500">*</span></label>
            </div>
          </div>
        </div>

        <!-- Présence -->
        <div>
          <h2 class="section-title">📅 Votre Présence</h2>
          <p class="text-slate-600 mb-4">Serez-vous présent(e) à la journée d'intégration ?</p>
          
          <div class="grid md:grid-cols-3 gap-4">
            <label class="radio-card">
              <input type="radio" name="attend" value="Yes" required>
              <div class="radio-card-content">
                <span>✅ Oui, je serai là</span>
              </div>
            </label>
            <label class="radio-card">
              <input type="radio" name="attend" value="Maybe" required>
              <div class="radio-card-content">
                <span>🤔 Peut-être</span>
              </div>
            </label>
            <label class="radio-card">
              <input type="radio" name="attend" value="No" required>
              <div class="radio-card-content">
                <span>❌ Non</span>
              </div>
            </label>
          </div>

          <div id="reasonWrap" class="mt-6" style="display: none;">
            <div class="input-wrapper">
              <textarea name="no_reason" rows="3" placeholder=" "></textarea>
              <label>Pouvez-vous nous expliquer pourquoi ?</label>
            </div>
          </div>
        </div>

        <!-- Activités -->
        <div>
          <h2 class="section-title">🎯 Vos Suggestions</h2>
          
          <div class="space-y-6">
            <div>
              <div class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-xs font-semibold uppercase tracking-wide text-orange-500">Music suggestion</p>
                  <p class="text-slate-500 text-sm">Choisissez ce que vous aimeriez entendre pendant l'événement.</p>
                </div>
              </div>
              <input type="hidden" name="activities_free" id="musicSelectionValue" />
              <div class="grid md:grid-cols-2 gap-4">
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Hits &amp; Pop modernes">
                  <div class="radio-card-content">Hits &amp; Pop modernes</div>
                </label>
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Rap / Hip-Hop">
                  <div class="radio-card-content">Rap / Hip-Hop</div>
                </label>
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Electro / Dancefloor">
                  <div class="radio-card-content">Electro / Dancefloor</div>
                </label>
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Chaâbi / Raï / Amazigh">
                  <div class="radio-card-content">Chaâbi / Raï / Amazigh</div>
                </label>
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Chill / Lo-fi">
                  <div class="radio-card-content">Chill / Lo-fi</div>
                </label>
                <label class="radio-card">
                  <input type="checkbox" class="music-choice" value="Surprise / Mix Party">
                  <div class="radio-card-content">Surprise / Mix Party</div>
                </label>
              </div>
              <div class="input-wrapper mt-4">
                <input type="text" id="musicCustom" placeholder=" " />
                <label>Un titre ou artiste précis ?</label>
              </div>
            </div>

            <div class="input-wrapper">
              <textarea name="ideas" rows="3" placeholder=" "></textarea>
              <label>Avez-vous d'autres idées pour améliorer cette journée ?</label>
            </div>
          </div>
        </div>

        <!-- Contact -->
        <div>
          <h2 class="section-title">📱 Contact</h2>
          <p class="text-slate-500 text-sm mb-4">Informations optionnelles pour vous contacter si nécessaire</p>
          
          <div class="grid md:grid-cols-2 gap-6">
            <div class="input-wrapper">
              <input name="phone" type="tel" placeholder=" " />
              <label>Téléphone / WhatsApp</label>
            </div>

            <div class="input-wrapper">
              <input name="email" type="email" placeholder=" " />
              <label>Email</label>
            </div>
          </div>
        </div>

        <!-- Consentement -->
        <div>
          <div class="flex items-center justify-between mb-4">
            <h2 class="section-title mb-0">📸 Autorisation Photo/Vidéo</h2>
            <button type="button" onclick="openModal()" class="text-orange-600 hover:text-orange-700 font-semibold text-sm flex items-center gap-1">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              En savoir plus
            </button>
          </div>
          
          <div class="grid md:grid-cols-2 gap-4">
            <label class="radio-card">
              <input type="radio" name="media_consent" value="I consent" required>
              <div class="radio-card-content">
                <span>✅ J'accepte</span>
              </div>
            </label>
            <label class="radio-card">
              <input type="radio" name="media_consent" value="I do not consent" required>
              <div class="radio-card-content">
                <span>🚫 Je refuse</span>
              </div>
            </label>
          </div>
          <p class="text-xs text-slate-500 mt-3">Vous pouvez modifier votre choix à tout moment en nous contactant.</p>
        </div>

        <!-- Bouton Submit -->
        <div class="pt-4">
          <button type="submit" class="btn-primary w-full md:w-auto">
            Valider mon inscription
            <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </button>
          <p class="text-slate-500 text-sm mt-4">
            <span class="text-orange-500">*</span> Les champs marqués sont obligatoires
          </p>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="text-center mt-8 text-slate-300 text-sm">
      <p>© 2024 BTS Errachidia - Tous droits réservés</p>
    </div>
  </div>

  <script>
    // Construction du cohort
    const filiere = document.getElementById('filiere');
    const classe = document.getElementById('classe');
    const cohort = document.getElementById('cohort');
    
    function updateCohort() {
      if (filiere.value && classe.value) {
        cohort.value = filiere.value + ' — ' + classe.value;
      } else {
        cohort.value = '';
      }
    }
    
    filiere.addEventListener('change', updateCohort);
    classe.addEventListener('change', updateCohort);

    // Gestion du modal
    function openModal() {
      document.getElementById('mediaModal').classList.add('active');
    }
    
    function closeModal() {
      document.getElementById('mediaModal').classList.remove('active');
    }
    
    document.getElementById('mediaModal').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });

    // Gestion de la visibilité de la raison
    const reasonWrap = document.getElementById('reasonWrap');
    const attendRadios = document.querySelectorAll('input[name="attend"]');
    
    function updateReasonVisibility() {
      const selected = document.querySelector('input[name="attend"]:checked');
      if (selected && selected.value === 'Yes') {
        reasonWrap.style.display = 'none';
        document.querySelector('textarea[name="no_reason"]').value = '';
      } else if (selected) {
        reasonWrap.style.display = 'block';
      }
    }
    
    attendRadios.forEach(radio => {
      radio.addEventListener('change', updateReasonVisibility);
    });

    // Affichage des messages (simulé)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
      document.getElementById('successMsg').style.display = 'flex';
      setTimeout(() => {
        document.getElementById('successMsg').style.display = 'none';
      }, 5000);
    }
    if (urlParams.get('error')) {
      document.getElementById('errorText').textContent = urlParams.get('error');
      document.getElementById('errorMsg').style.display = 'flex';
    }
  </script>
</body>
</html>
