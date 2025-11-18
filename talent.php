<?php
$success = isset($_GET['success']);
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>BTS Errachidia - Talents</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    * { font-family: 'Inter', sans-serif; }
    body {
      min-height: 100vh;
      padding: 3rem 1.5rem;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #334155 100%);
      color: #0f172a;
      position: relative;
      overflow-x: hidden;
    }
    body::before,
    body::after {
      content: '';
      position: fixed;
      width: 60vw;
      height: 60vw;
      border-radius: 999px;
      filter: blur(120px);
      opacity: 0.4;
      z-index: 0;
    }
    body::before {
      top: -10vw;
      right: -15vw;
      background: rgba(249, 115, 22, 0.4);
    }
    body::after {
      bottom: -15vw;
      left: -10vw;
      background: rgba(59, 130, 246, 0.35);
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 2rem;
      padding: 2.5rem;
      box-shadow: 0 30px 80px rgba(15, 23, 42, 0.25);
      position: relative;
      z-index: 10;
      border: 1px solid rgba(148, 163, 184, 0.2);
    }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(249, 115, 22, 0.15);
      border: 1px solid rgba(249, 115, 22, 0.3);
      color: #fff;
      font-weight: 600;
      border-radius: 999px;
      padding: 0.35rem 1rem;
      font-size: 0.95rem;
    }
    .input-wrapper {
      position: relative;
    }
    .input-wrapper input,
    .input-wrapper textarea,
    .input-wrapper select {
      width: 100%;
      padding: 1rem 1.1rem;
      border-radius: 1rem;
      border: 1.5px solid rgba(15, 23, 42, 0.15);
      background: rgba(15, 23, 42, 0.02);
      transition: all 0.2s ease;
    }
    .input-wrapper select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23f97316'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1.2rem;
      padding-right: 3rem;
    }
    .input-wrapper label {
      display: block;
      margin-bottom: 0.4rem;
      font-weight: 600;
      color: #475569;
    }
    .radio-card input {
      display: none;
    }
    .radio-card-content {
      display: block;
      border-radius: 1.25rem;
      border: 1.5px solid rgba(15, 23, 42, 0.15);
      padding: 1rem 1.25rem;
      font-weight: 600;
      color: #0f172a;
      transition: all 0.2s ease;
      background: rgba(15, 23, 42, 0.02);
    }
    .radio-card input:checked + .radio-card-content {
      border-color: rgba(249, 115, 22, 0.8);
      background: rgba(249, 115, 22, 0.12);
      box-shadow: 0 10px 35px rgba(249, 115, 22, 0.2);
    }
    .btn-primary {
      background: linear-gradient(120deg, #f97316, #ea580c);
      color: #fff;
      font-weight: 600;
      padding: 0.95rem 2rem;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      box-shadow: 0 20px 35px rgba(249, 115, 22, 0.35);
    }
    .btn-primary:hover {
      transform: translateY(-2px);
    }
    .alert {
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      padding: 1rem 1.3rem;
      border-radius: 1rem;
      margin-bottom: 1.5rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
    }
    .alert-success {
      background: rgba(34, 197, 94, 0.18);
      color: #14532d;
    }
    .alert-error {
      background: rgba(248, 113, 113, 0.2);
      color: #7f1d1d;
    }
    .section-title {
      font-size: 1.35rem;
      font-weight: 700;
      color: #0f172a;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin-bottom: 1rem;
    }
    .section-title span {
      width: 14px;
      height: 14px;
      border-radius: 4px;
      background: linear-gradient(150deg, #f97316, #fb923c);
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="max-w-4xl mx-auto relative z-10 space-y-6">
    <div class="text-center text-white space-y-4">
      <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl shadow-2xl mb-2">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L7.5 21l2.25-4m4.5 0L16.5 21l-2.25-4m-3-13v11m0 0a4 4 0 11-8 0 4 4 0 018 0zm4 0a4 4 0 108 0 4 4 0 00-8 0z"/>
        </svg>
      </div>
      <p class="badge text-sm uppercase tracking-wide">موهبة ? On veut te voir sur scene !</p>
      <h1 class="text-4xl font-extrabold leading-tight">Partage ta موهبة pour la Journee d'Integration</h1>
      <p class="text-lg text-slate-200 max-w-2xl mx-auto">
        Tu sais chanter, danser, jouer d'un instrument, faire du stand-up ou proposer un numero original ?
        Remplis ce formulaire, partage une video ou des photos, et l'equipe te repondra par email apres revue.
      </p>
      <a href="index.php" class="inline-flex items-center text-slate-200 hover:text-white text-sm font-medium gap-2">
        <- Retour a l'inscription principale
      </a>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success">
        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 10-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div>
          <p class="font-semibold">Merci !</p>
          <p>Ta candidature talent a bien ete enregistree. On revient vers toi par email apres revue.</p>
        </div>
      </div>
    <?php elseif (!empty($error)): ?>
      <div class="alert alert-error">
        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
          <p class="font-semibold">Oups...</p>
          <p><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></p>
        </div>
      </div>
    <?php endif; ?>

    <div class="glass-card">
      <form action="submit_talent.php" method="post" enctype="multipart/form-data" class="space-y-10" novalidate>
        <input type="text" name="website" class="hidden" autocomplete="off" aria-hidden="true">

        <div>
          <h2 class="section-title"><span></span>Identite & suivi</h2>
          <p class="text-slate-500 mb-6 text-sm">
            Utilise le meme email que sur le formulaire principal pour qu'on puisse te retrouver facilement dans Telegram.
          </p>
          <div class="grid gap-6 md:grid-cols-2">
            <div class="input-wrapper">
              <label>Nom complet <span class="text-orange-500">*</span></label>
              <input type="text" name="name" required placeholder="Ex : Othmane El M."/>
            </div>
            <div class="input-wrapper">
              <label>Email <span class="text-orange-500">*</span></label>
              <input type="email" name="email" required placeholder="Ex : toi@example.com"/>
            </div>
            <div class="input-wrapper">
              <label>Telephone / WhatsApp</label>
              <input type="tel" name="phone" placeholder="+212 6 xx xx xx xx"/>
            </div>
            <div class="input-wrapper">
              <label>Instagram ou reseau (optionnel)</label>
              <input type="text" name="instagram" placeholder="@mon_talent"/>
            </div>
          </div>
        </div>

        <div>
          <h2 class="section-title"><span></span>Ta موهبة</h2>
          <div class="grid gap-6 md:grid-cols-2">
            <div class="input-wrapper">
              <label>Discipline <span class="text-orange-500">*</span></label>
              <select name="talent_type" required>
                <option value="" disabled selected>Choisis ta vibe</option>
                <option value="Chant">Chant</option>
                <option value="Danse">Danse</option>
                <option value="Instrument">Instrument</option>
                <option value="Stand-up / Humour">Stand-up / Humour</option>
                <option value="Theatre / Sketch">Theatre / Sketch</option>
                <option value="Beatbox / Rap">Beatbox / Rap</option>
                <option value="Arts visuels">Arts visuels</option>
                <option value="Autre performance">Autre performance</option>
              </select>
            </div>
            <div class="input-wrapper">
              <label>Experience (clubs, scenes...)</label>
              <input type="text" name="experience" placeholder="Ex : 2 ans de chorale, scenes lycee..."/>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6 mt-6">
            <label class="radio-card">
              <input type="radio" name="stage_ready" value="Oui, pret(e) !" required>
              <span class="radio-card-content">Oui, je suis pret(e) pour la scene</span>
            </label>
            <label class="radio-card">
              <input type="radio" name="stage_ready" value="Besoin d'accompagnement" required>
              <span class="radio-card-content">J'ai besoin d'un petit coaching</span>
            </label>
          </div>

          <div class="mt-6">
            <div class="input-wrapper">
              <label>Decris ce que tu sais faire <span class="text-orange-500">*</span></label>
              <textarea name="description" rows="4" required placeholder="Raconte ton act, ton energie, tes inspirations..."></textarea>
            </div>
          </div>
        </div>

        <div>
          <h2 class="section-title"><span></span>Video / photos de ton act</h2>
          <p class="text-slate-500 text-sm mb-4">
            Upload jusqu'a 3 fichiers (images ou videos, max 50MB chacun) ou partage un lien YouTube/Drive.
          </p>
          <div class="space-y-4">
            <div class="input-wrapper">
              <label>Fichiers (image / video)</label>
              <input type="file" name="talent_media[]" accept="image/*,video/*" multiple>
            </div>
            <div class="input-wrapper">
              <label>Liens complementaires</label>
              <textarea name="links" rows="2" placeholder="Liens YouTube, TikTok, Drive..."></textarea>
            </div>
          </div>
        </div>

        <div>
          <h2 class="section-title"><span></span>Besoin technique ?</h2>
          <div class="input-wrapper">
            <label>Materiel / setup souhaite</label>
            <textarea name="needs" rows="3" placeholder="Ex : 2 micros, tabouret, cable jack..."></textarea>
          </div>
        </div>

        <div class="pt-4">
          <button class="btn-primary" type="submit">
            Envoyer ma candidature
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </button>
          <p class="text-slate-500 text-sm mt-3">On t'ecrit par email apres revue. Verifie ton spam !</p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
