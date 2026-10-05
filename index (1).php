<!--
  Coparbi — El árbitro también juega
  Página HTML autónoma (sin backend): ligas y clubes reales + ficha de valoración del árbitro.
  Todo el juego (datos de ligas, jugadas, VAR, economía, fichajes y progreso) corre en el navegador.
-->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Coparbi — El árbitro también juega</title>
<meta name="description" content="Coparbi: ponte en la piel de un árbitro de fútbol, pita jugadas, usa el VAR, gestiona tu economía y haz carrera desde ligas locales hasta la gran final continental. Juega gratis desde el navegador.">
<meta name="keywords" content="coparbi, juego de arbitro, juego de futbol online, simulador de arbitro, juego gratis navegador">
<meta name="robots" content="index, follow">
<!-- Cambia esta URL por la de tu dominio real una vez publicado -->
<link rel="canonical" href="https://www.tudominio.com/">

<!-- Open Graph (Facebook, WhatsApp, etc.) -->
<meta property="og:type" content="website">
<meta property="og:title" content="Coparbi — El árbitro también juega">
<meta property="og:description" content="Ponte el silbato: pita jugadas, revisa el VAR y haz carrera como árbitro hasta llegar a la gran final. Juego gratuito en el navegador.">
<meta property="og:url" content="https://www.tudominio.com/">
<!-- Añade aquí una imagen de portada (1200x630px) subida a tu hosting -->
<meta property="og:image" content="https://www.tudominio.com/og-image.jpg">
<meta property="og:locale" content="es_ES">

<!-- Twitter / X Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Coparbi — El árbitro también juega">
<meta name="twitter:description" content="Ponte el silbato: pita jugadas, revisa el VAR y haz carrera como árbitro hasta llegar a la gran final. Juego gratuito en el navegador.">
<meta name="twitter:image" content="https://www.tudominio.com/og-image.jpg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --grass-dark:#0d3d2a;
    --grass-line:#12492f;
    --chalk:#f4f4ef;
    --chalk-dim:#cfd8cf;
    --card-yellow:#f2c14e;
    --card-red:#c0392b;
    --ink:#0f1210;
    --panel:#123626;
    --panel-2:#0a2419;
    --accent:#8fd8b0;
    --danger:#e35d4f;
    --money:#7fd858;
    --shadow: 0 10px 30px rgba(0,0,0,.35);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    font-family:'Inter',sans-serif;
    background:var(--ink);
    color:var(--chalk);
    min-height:100vh;
    overflow-x:hidden;
  }
  h1,h2,h3,.num,.stat-num,.timer-label,button{
    font-family:'Oswald',sans-serif;
  }
  #app{
    position:relative;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background:
      repeating-linear-gradient(90deg, var(--grass-dark) 0 80px, var(--grass-line) 80px 160px);
  }
  .screen{
    flex:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:32px 20px 48px;
    position:relative;
    animation: fadeIn .5s ease;
  }
  @keyframes fadeIn{ from{opacity:0; transform:translateY(8px);} to{opacity:1; transform:translateY(0);} }
  .hidden{ display:none !important; }

  .brand{ display:flex; align-items:baseline; gap:10px; margin-bottom:6px; }
  .brand .whistle{ width:34px; height:34px; }
  .brand h1{
    font-size:clamp(2.6rem, 8vw, 4.4rem);
    font-weight:700; letter-spacing:1px; margin:0; color:var(--chalk);
    text-shadow: 0 4px 0 rgba(0,0,0,.25);
  }
  .tagline{ color:var(--chalk-dim); font-size:1.05rem; margin:0 0 30px; text-align:center; max-width:560px; line-height:1.5; }
  .step-label{
    font-size:.85rem; letter-spacing:.4px; color:var(--card-yellow);
    margin:22px 0 10px; text-align:center;
  }

  .comp-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(170px,1fr));
    gap:14px; width:100%; max-width:900px;
  }
  .comp-card{
    background:var(--panel); border:2px solid transparent; border-radius:10px;
    padding:18px 14px; text-align:left; cursor:pointer; color:var(--chalk);
    transition:transform .15s ease, border-color .15s ease, background .15s ease;
    box-shadow:var(--shadow);
  }
  .comp-card:hover{ transform:translateY(-3px); border-color:var(--accent); }
  .comp-card.selected{ border-color:var(--card-yellow); background:var(--panel-2); }
  .comp-card .comp-name{ font-family:'Oswald',sans-serif; font-size:1.1rem; font-weight:600; display:block; margin-bottom:2px; }
  .comp-card .comp-region{ font-size:.8rem; color:var(--chalk-dim); }
  .comp-card .comp-crest{ font-size:1.6rem; display:block; margin-bottom:8px; }
  .comp-card .comp-desc{ font-size:.76rem; color:var(--chalk-dim); margin-top:6px; line-height:1.35; }

  .primary-btn{
    margin-top:28px; background:var(--card-yellow); color:#241a02; border:none;
    padding:16px 40px; font-size:1.15rem; font-weight:600; letter-spacing:.5px;
    border-radius:8px; cursor:pointer; box-shadow:var(--shadow);
    transition:transform .12s ease, filter .12s ease;
  }
  .primary-btn:hover{ transform:translateY(-2px); filter:brightness(1.06); }
  .primary-btn:disabled{ opacity:.4; cursor:not-allowed; transform:none; }
  .ghost-btn{
    margin-top:14px; background:transparent; color:var(--chalk-dim);
    border:1px solid rgba(244,244,239,.25); padding:10px 22px; border-radius:8px;
    cursor:pointer; font-family:'Inter',sans-serif; font-size:.9rem;
  }
  .ghost-btn:hover{ color:var(--chalk); border-color:var(--chalk); }
  .ghost-btn:disabled{ opacity:.35; cursor:not-allowed; }

  /* ---------- Nombre del árbitro ---------- */
  .name-input-wrap{ width:100%; max-width:360px; margin:0 auto; }
  .name-input{
    width:100%; background:var(--panel-2); border:2px solid rgba(244,244,239,.2); color:var(--chalk);
    padding:12px 14px; border-radius:8px; font-family:'Oswald',sans-serif; font-size:1rem; text-align:center;
    letter-spacing:.3px;
  }
  .name-input:focus{ outline:none; border-color:var(--card-yellow); }
  .name-input::placeholder{ color:var(--chalk-dim); }

  /* ---------- Trofeos junto al nombre ---------- */
  .trophy-badges{ display:inline-flex; gap:4px; flex-wrap:wrap; vertical-align:middle; }
  .trophy-badge{
    font-size:.72rem; font-weight:700; background:rgba(242,193,78,.18); color:var(--card-yellow);
    padding:2px 7px; border-radius:20px; border:1px solid rgba(242,193,78,.4); white-space:nowrap;
  }
  .rc-name{ font-family:'Oswald',sans-serif; font-size:.95rem; font-weight:700; margin-top:2px; }
  .rc-trophies{ margin-top:6px; display:flex; gap:4px; flex-wrap:wrap; }

  /* ---------- Ficha de árbitro (carta de valoración) ---------- */
  .ref-card{
    width:230px;
    border-radius:18px;
    padding:18px 18px 16px;
    color:#1c1a0d;
    box-shadow:var(--shadow);
    position:relative;
    overflow:hidden;
  }
  .ref-card.tier-bronce{ background:linear-gradient(160deg,#c98a4b,#8a5a2c); color:#2a1806; }
  .ref-card.tier-plata{ background:linear-gradient(160deg,#d9dee2,#9aa4ac); color:#20262b; }
  .ref-card.tier-oro{ background:linear-gradient(160deg,#f7dd8a,#c99a2e); color:#2b2005; }
  .ref-card.tier-elite{ background:linear-gradient(160deg,#8ff0e8,#1f7a86); color:#062023; }
  .ref-card .rc-media{ font-size:3rem; font-weight:700; line-height:.9; }
  .ref-card .rc-pos{ font-size:.85rem; font-weight:600; letter-spacing:1px; margin-top:2px; }
  .ref-card .rc-flag{ position:absolute; top:18px; right:18px; font-size:1.6rem; }
  .ref-card .rc-league{ font-size:.72rem; opacity:.85; margin-top:2px; }
  .ref-card .rc-divider{ height:1px; background:rgba(0,0,0,.2); margin:12px 0 10px; }
  .ref-card .rc-attrs{ display:grid; grid-template-columns:1fr 1fr; gap:4px 14px; font-size:.82rem; font-weight:600; }
  .ref-card .rc-attrs span.val{ float:right; }

  .comp-grid.small-margin{ margin-bottom:6px; }

  /* ---------- Carrera / cabecera de estado ---------- */
  .career-bar{
    width:100%; max-width:960px; display:flex; align-items:center; justify-content:space-between;
    gap:16px; background:var(--panel-2); border-radius:10px; padding:14px 20px; margin-bottom:22px;
    box-shadow:var(--shadow); flex-wrap:wrap;
  }
  .career-item{ text-align:center; min-width:90px; }
  .career-item .label{ font-size:.65rem; color:var(--chalk-dim); letter-spacing:.4px; }
  .career-item .value{ font-size:1.25rem; font-weight:600; color:var(--chalk); }
  .career-item .value.money{ color:var(--money); }
  .mini-attrs{ display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
  .mini-attr{ text-align:center; font-size:.68rem; color:var(--chalk-dim); min-width:40px; }
  .mini-attr .mv{ font-size:.95rem; font-weight:700; color:var(--chalk); display:block; }
  .career-actions{ display:flex; gap:8px; flex-wrap:wrap; justify-content:center; }

  /* ---------- Pantalla de partido ---------- */
  .match-wrap{ width:100%; max-width:820px; }
  .stage-head{
    display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px; flex-wrap:wrap;
  }
  .stage-banner{
    text-align:center; font-size:.85rem; letter-spacing:.4px; color:var(--card-yellow);
    font-weight:600; flex:1;
  }
  .small-btn{ margin-top:0; padding:7px 14px; font-size:.75rem; white-space:nowrap; }
  .scoreboard{
    display:flex; align-items:center; justify-content:center; gap:22px;
    background:var(--panel-2); border-radius:10px; padding:16px 20px; box-shadow:var(--shadow); margin-bottom:6px;
  }
  .team-name{ font-family:'Oswald',sans-serif; font-size:1.1rem; font-weight:600; flex:1; text-align:center; }
  .score{
    font-family:'Oswald',sans-serif; font-size:1.8rem; font-weight:700; background:#000;
    padding:4px 16px; border-radius:6px; letter-spacing:2px;
  }
  .clock{ font-family:'Oswald',sans-serif; font-size:.95rem; color:var(--chalk-dim); text-align:center; margin:2px 0 6px; }
  .bribe-flag{ text-align:center; font-size:.78rem; color:var(--card-yellow); margin:0 0 14px; min-height:1.1em; }

  .incident-card{
    background:var(--chalk); color:var(--ink); border-radius:14px; padding:26px 26px 22px;
    box-shadow:var(--shadow); position:relative; overflow:hidden;
    animation: dropIn .4s cubic-bezier(.2,.9,.3,1.2);
  }
  @keyframes dropIn{ from{ transform:translateY(-40px) scale(.97); opacity:0;} to{ transform:translateY(0) scale(1); opacity:1;} }
  .incident-tag{
    display:inline-block; background:var(--grass-dark); color:var(--chalk); font-size:.72rem; font-weight:600;
    letter-spacing:.4px; padding:4px 10px; border-radius:20px; margin-bottom:12px; margin-right:6px;
  }
  .incident-teams{
    display:inline-flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;
  }
  .team-chip{
    font-size:.72rem; font-weight:600; padding:4px 10px; border-radius:20px; letter-spacing:.2px;
  }
  .team-chip.offender{ background:#f6dede; color:#8f2a1f; border:1px solid #e6b6ae; }
  .team-chip.affected{ background:#dfeee5; color:#1c6b3f; border:1px solid #a9d8bb; }
  .incident-text{ font-size:1.15rem; line-height:1.55; margin:0 0 18px; }
  .incident-extra{
    font-size:.95rem; color:#3b3b38; background:#e9e9e1; border-left:4px solid var(--card-yellow);
    padding:10px 14px; border-radius:6px; margin-bottom:18px; display:none;
  }
  .incident-extra.show{ display:block; animation:fadeIn .3s ease; }

  /* ---------- Revisión interactiva del VAR (fluida) ---------- */
  .var-review{
    background:#12100a; color:var(--chalk); border-radius:12px; padding:16px 18px 18px;
    margin-bottom:18px; animation: dropIn .35s cubic-bezier(.2,.9,.3,1.2);
  }
  .var-review.hidden{ display:none !important; }
  .var-review-head{ display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px; flex-wrap:wrap; }
  .var-badge{
    background:var(--danger); color:#fff; font-size:.68rem; font-weight:700; letter-spacing:.5px;
    padding:4px 10px; border-radius:20px;
  }
  .var-frame-count{ font-size:.75rem; color:var(--chalk-dim); }
  .var-pitch{ background:var(--grass-dark); border-radius:8px; padding:8px 8px 4px; margin-bottom:12px; }
  .var-pitch svg{ width:100%; height:auto; display:block; }
  .var-pitch circle{ transition: cx .18s linear, cy .18s linear; }
  .var-pitch line#var-offside-line{ transition: opacity .2s ease, x1 .18s linear, x2 .18s linear; }
  .var-zone-label{ text-align:center; font-size:.7rem; color:var(--chalk-dim); letter-spacing:.3px; padding-top:4px; }
  .var-review-text{ font-size:.95rem; line-height:1.55; margin:0 0 12px; min-height:3em; }
  .var-scrubber{ width:100%; margin:0 0 14px; accent-color:var(--card-yellow); }
  .var-controls{ display:flex; gap:8px; margin-bottom:12px; }
  .var-controls button{ flex:1; padding:10px 4px; font-size:.8rem; margin:0; }
  .var-controls button:disabled{ opacity:.3; cursor:not-allowed; }
  .var-done-btn{ width:100%; margin-top:0 !important; }

  .timer-track{ height:8px; width:100%; background:#dcdcd3; border-radius:6px; overflow:hidden; margin-bottom:20px; }
  .timer-fill{ height:100%; background:var(--card-red); width:100%; transform-origin:left; }

  .pre-match-panel{ text-align:center; padding:6px 0 4px; }
  .pre-match-panel.hidden{ display:none !important; }
  .pre-match-panel .primary-btn{ margin-top:4px; }

  .options-grid{ display:grid; grid-template-columns:repeat(auto-fit, minmax(140px,1fr)); gap:10px; }
  .opt-btn{
    border:2px solid #d8d8cf; background:#fff; color:var(--ink); padding:14px 10px; border-radius:9px;
    font-family:'Oswald',sans-serif; font-size:.95rem; font-weight:600; cursor:pointer;
    transition:all .12s ease; display:flex; align-items:center; justify-content:center; gap:8px;
  }
  .opt-btn:hover{ border-color:var(--grass-dark); background:#f2f2ea; }
  .opt-btn .swatch{ width:14px; height:18px; border-radius:2px; display:inline-block; }
  .var-btn{ grid-column:1/-1; background:var(--ink); color:var(--chalk); border-color:var(--ink); }
  .var-btn:hover{ background:#000; }
  .var-btn:disabled{ opacity:.35; cursor:not-allowed; }
  .opt-btn.opt-correct{ border-color:var(--money); box-shadow:0 0 0 2px var(--money) inset; background:#eafbef; }

  /* ---------- Tarjetas rojas junto al nombre del equipo ---------- */
  .red-badge{
    display:inline-flex; align-items:center; gap:2px; font-size:.72rem; font-weight:700;
    background:var(--card-red); color:#fff; padding:1px 6px; border-radius:10px; margin-left:6px; vertical-align:middle;
  }

  /* ---------- Compra de revisiones VAR extra durante el partido ---------- */
  .var-shop-row{ text-align:center; margin:0 0 12px; }
  .var-shop-row .ghost-btn{ margin-top:0; }

  .feedback-banner{ margin-top:16px; padding:12px 16px; border-radius:8px; font-size:.95rem; font-weight:500; display:none; }
  .feedback-banner.show{ display:block; animation:fadeIn .3s ease; }
  .feedback-banner.correct{ background:#dff3e6; color:#1c6b3f; border:1px solid #9bd8b4; }
  .feedback-banner.wrong{ background:#fbe3e0; color:#8f2a1f; border:1px solid #f0aca3; }

  .attr-delta{ font-size:.8rem; margin-top:6px; color:#4a4a44; }
  .attr-delta b{ color:var(--grass-dark); }

  .crowd-note{ margin-top:10px; font-size:.82rem; color:var(--chalk-dim); font-style:italic; min-height:1.2em; }
  .continue-wrap{ text-align:center; margin-top:18px; }

  /* ---------- Modales genéricos ---------- */
  .modal-overlay{
    position:fixed; inset:0; background:rgba(4,10,7,.72); display:flex; align-items:center; justify-content:center;
    z-index:80; padding:20px;
  }
  .modal-overlay.hidden{ display:none !important; }
  .modal-box{
    background:var(--panel); border-radius:14px; padding:22px 24px; max-width:680px; width:100%;
    max-height:82vh; display:flex; flex-direction:column; box-shadow:var(--shadow);
  }
  .modal-box.narrow{ max-width:440px; text-align:center; }
  .modal-head{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px; }
  .modal-head h3{ margin:0; font-size:1.15rem; color:var(--chalk); }
  .modal-close{
    background:transparent; border:1px solid rgba(244,244,239,.3); color:var(--chalk-dim);
    width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:.95rem; line-height:1;
  }
  .modal-close:hover{ color:var(--chalk); border-color:var(--chalk); }
  .standings-scroll{ overflow-y:auto; }
  .standings-table{ width:100%; border-collapse:collapse; font-size:.82rem; }
  .standings-table th, .standings-table td{ padding:7px 6px; text-align:center; border-bottom:1px solid rgba(244,244,239,.08); }
  .standings-table th{ color:var(--chalk-dim); font-weight:600; font-size:.68rem; letter-spacing:.3px; text-transform:uppercase; }
  .standings-table td:nth-child(2), .standings-table th:nth-child(2){ text-align:left; }
  .standings-table tr.playing td{ color:var(--card-yellow); font-weight:700; }
  .standings-table td.pts{ font-weight:700; color:var(--chalk); }

  /* ---------- Tienda ---------- */
  .shop-tabs{ display:flex; gap:8px; margin-bottom:14px; }
  .shop-tab{
    flex:1; background:var(--panel-2); border:1px solid rgba(244,244,239,.15); color:var(--chalk-dim);
    padding:10px; border-radius:8px; cursor:pointer; font-family:'Oswald',sans-serif; font-size:.85rem;
  }
  .shop-tab.active{ background:var(--card-yellow); color:#241a02; border-color:var(--card-yellow); }
  .shop-list{ overflow-y:auto; display:flex; flex-direction:column; gap:10px; }
  .shop-item{
    display:flex; align-items:center; gap:12px; background:var(--panel-2); border-radius:10px; padding:12px 14px;
  }
  .shop-item .emoji{ font-size:1.7rem; width:40px; text-align:center; }
  .shop-item .info{ flex:1; }
  .shop-item .info .name{ font-family:'Oswald',sans-serif; font-weight:600; font-size:.95rem; }
  .shop-item .info .desc{ font-size:.76rem; color:var(--chalk-dim); }
  .shop-item .buy-btn{
    background:var(--money); border:none; color:#0a2b0a; padding:8px 14px; border-radius:7px; font-weight:700;
    cursor:pointer; font-size:.8rem; white-space:nowrap;
  }
  .shop-item .buy-btn:disabled{ background:#5c655e; color:#c9d0c9; cursor:not-allowed; }
  .shop-item.owned .buy-btn{ background:#3a4a3f; color:var(--chalk-dim); }

  /* ---------- Sobornos ---------- */
  .bribe-amount{ font-size:2.2rem; font-weight:700; color:var(--card-yellow); font-family:'Oswald',sans-serif; margin:10px 0; }
  .bribe-actions{ display:flex; gap:10px; justify-content:center; margin-top:16px; flex-wrap:wrap; }

  /* ---------- Resumen de partido ---------- */
  .summary-wrap{ display:flex; gap:24px; flex-wrap:wrap; align-items:flex-start; justify-content:center; max-width:960px; width:100%; }
  .summary-card{
    background:var(--panel); border-radius:14px; padding:32px; max-width:520px; width:100%;
    box-shadow:var(--shadow); text-align:center;
  }
  .summary-card h2{ margin-top:0; font-size:1.8rem; }
  .summary-stats{ display:flex; justify-content:center; gap:26px; margin:22px 0; flex-wrap:wrap; }
  .summary-stat .num{ font-size:2.1rem; font-weight:700; display:block; }
  .summary-stat .num.money{ color:var(--money); }
  .summary-stat .lbl{ font-size:.78rem; color:var(--chalk-dim); }
  .promo-msg{ background:var(--panel-2); border-radius:8px; padding:12px 16px; font-size:.95rem; margin-bottom:16px; }
  .bribe-note{ background:#2a2410; border:1px solid rgba(242,193,78,.4); border-radius:8px; padding:10px 14px; font-size:.85rem; margin-bottom:16px; }
  .final-msg{ background:linear-gradient(120deg,#1f7a86,#8ff0e8); color:#062023; border-radius:8px; padding:14px 16px; font-weight:600; margin-bottom:16px; }
  .patrimonio-box{ margin-top:18px; text-align:left; background:var(--panel-2); border-radius:10px; padding:14px 16px; }
  .patrimonio-box h4{ margin:0 0 8px; font-size:.85rem; color:var(--chalk-dim); letter-spacing:.3px; }
  .patrimonio-items{ display:flex; flex-wrap:wrap; gap:8px; }
  .patrimonio-items span{ background:var(--panel); padding:4px 10px; border-radius:16px; font-size:.8rem; }
  .patrimonio-empty{ font-size:.8rem; color:var(--chalk-dim); font-style:italic; }

  .leaderboard{
    margin-top:0; width:100%; max-width:340px; background:var(--panel-2); border-radius:10px; padding:16px 20px;
  }
  .leaderboard h3{ margin:0 0 10px; font-size:1rem; color:var(--chalk-dim); letter-spacing:.3px; }
  .leaderboard ol{ margin:0; padding-left:22px; }
  .leaderboard li{ font-size:.88rem; padding:3px 0; display:flex; justify-content:space-between; gap:10px;}
  .leaderboard li span.pts{ color:var(--card-yellow); font-weight:600; }

  /* ---------- Fin de temporada / fichajes ---------- */
  .season-recap{ display:flex; justify-content:center; gap:26px; margin:18px 0 28px; flex-wrap:wrap; }
  .offer-grid{ display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:16px; width:100%; max-width:900px; }
  .offer-card{
    background:var(--panel); border:2px solid transparent; border-radius:12px; padding:20px; text-align:left;
    cursor:pointer; box-shadow:var(--shadow); transition:transform .15s ease, border-color .15s ease;
  }
  .offer-card:hover{ transform:translateY(-3px); border-color:var(--accent); }
  .offer-card .offer-kind{ font-size:.68rem; letter-spacing:.5px; color:var(--card-yellow); font-weight:600; margin-bottom:6px; text-transform:uppercase; }
  .offer-card .offer-name{ font-family:'Oswald',sans-serif; font-size:1.15rem; font-weight:600; }
  .offer-card .offer-desc{ font-size:.8rem; color:var(--chalk-dim); margin-top:6px; line-height:1.4; }

  footer.credit{ text-align:center; color:rgba(244,244,239,.35); font-size:.75rem; padding:14px 0 20px; }

  /* ---------- Mercado de fichajes ---------- */
  .transfers-list{
    width:100%; max-width:700px; display:flex; flex-direction:column; gap:8px; margin-bottom:10px;
  }
  .transfer-item{
    background:var(--panel-2); border-radius:8px; padding:9px 14px; font-size:.85rem; text-align:left;
    color:var(--chalk-dim);
  }
  .transfer-item .transfer-player{ color:var(--chalk); font-weight:600; }
  .transfer-item b{ color:var(--card-yellow); }
  .transfer-item .transfer-season{ font-size:.75rem; opacity:.7; }

  @media (max-width:520px){
    .scoreboard{ flex-direction:column; gap:8px; }
    .team-name{ font-size:1rem; }
  }
</style>
</head>
<body>
<div id="app">

  <!-- ============ PANTALLA 1: INICIO ============ -->
  <section id="screen-start" class="screen">
    <div class="brand">
      <svg class="whistle" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="32" cy="32" r="30" stroke="#f4f4ef" stroke-width="3"/>
        <circle cx="32" cy="32" r="9" fill="#f2c14e"/>
        <line x1="32" y1="2" x2="32" y2="14" stroke="#f4f4ef" stroke-width="3"/>
      </svg>
      <h1>COPARBI</h1>
    </div>
    <p class="tagline">Elige la liga en la que empiezas tu carrera arbitral. Sube tu media dirigiendo bien los partidos, gana dinero cada jornada, móntate tu vida fuera del campo y, al final de cada temporada, decide si te quedas o fichas por otra liga o competición.</p>

    <div class="step-label">1. Ponle nombre a tu árbitro</div>
    <div class="name-input-wrap">
      <input type="text" id="ref-name-input" class="name-input" placeholder="Nombre de tu árbitro" maxlength="24">
    </div>

    <div class="step-label">2. Elige tu liga de inicio</div>
    <div class="comp-grid" id="comp-grid"></div>

    <button class="primary-btn" id="btn-start-career" disabled>Empezar carrera</button>
    <button class="ghost-btn hidden" id="btn-continue-career">Continuar carrera guardada</button>
  </section>

  <!-- ============ PANTALLA 2: PARTIDO ============ -->
  <section id="screen-match" class="screen hidden">
    <div class="career-bar">
      <div class="career-item">
        <div class="label">ÁRBITRO</div>
        <div class="value" id="hud-ref-name">Árbitro</div>
        <div class="trophy-badges" id="hud-trophies"></div>
      </div>
      <div class="career-item">
        <div class="label">ETAPA</div>
        <div class="value" id="hud-category">Liga</div>
      </div>
      <div class="career-item">
        <div class="label">MEDIA</div>
        <div class="value" id="hud-media">50</div>
      </div>
      <div class="mini-attrs" id="hud-attrs"></div>
      <div class="career-item">
        <div class="label">DINERO</div>
        <div class="value money" id="hud-money">500€</div>
      </div>
      <div class="career-item">
        <div class="label">PARTIDOS</div>
        <div class="value" id="hud-match-num">1</div>
      </div>
      <div class="career-item">
        <div class="label">QUEDAN (TEMP.)</div>
        <div class="value" id="hud-season-left">20</div>
      </div>
      <div class="career-actions">
        <button class="ghost-btn small-btn" id="btn-shop">🏪 Tienda</button>
        <button class="ghost-btn small-btn" id="btn-transfers">🔄 Fichajes</button>
      </div>
    </div>

    <div class="match-wrap">
      <div class="stage-head">
        <div class="stage-banner" id="stage-banner">Liga · Jornada</div>
        <button class="ghost-btn small-btn" id="btn-standings">📊 Clasificación</button>
      </div>
      <div class="scoreboard">
        <div class="team-name" id="team-home">Local</div>
        <div class="score" id="score">0 – 0</div>
        <div class="team-name" id="team-away">Visitante</div>
      </div>
      <div class="clock" id="clock">Min. 12'</div>
      <div class="bribe-flag" id="bribe-flag"></div>
      <div class="var-shop-row">
        <button class="ghost-btn small-btn" id="btn-buy-var">🎥 Comprar 2 revisiones VAR extra · 250€</button>
      </div>

      <div class="incident-card">
        <span class="incident-tag" id="incident-tag">JUGADA</span>
        <div class="incident-teams" id="incident-teams"></div>
        <p class="incident-text" id="incident-text">Cargando jugada...</p>
        <div class="incident-extra" id="incident-extra"></div>

        <div class="timer-track" id="timer-track"><div class="timer-fill" id="timer-fill"></div></div>

        <div class="pre-match-panel hidden" id="pre-match-panel">
          <button class="primary-btn" id="btn-begin-match">🏁 Iniciar partido</button>
        </div>

        <div class="options-grid" id="options-grid"></div>

        <!-- Revisión interactiva del VAR: fluida, con más jugadores en el campo -->
        <div class="var-review hidden" id="var-review">
          <div class="var-review-head">
            <span class="var-badge">📺 REVISIÓN VAR</span>
            <span class="var-frame-count" id="var-frame-count">Fotograma 1/1</span>
          </div>
          <div class="var-pitch">
            <svg viewBox="0 0 300 150" xmlns="http://www.w3.org/2000/svg">
              <rect x="4" y="4" width="292" height="142" rx="6" fill="none" stroke="rgba(244,244,239,.35)" stroke-width="2"/>
              <line x1="150" y1="4" x2="150" y2="146" stroke="rgba(244,244,239,.25)" stroke-width="2"/>
              <circle cx="150" cy="75" r="22" fill="none" stroke="rgba(244,244,239,.25)" stroke-width="2"/>
              <circle cx="150" cy="75" r="1.6" fill="rgba(244,244,239,.4)"/>
              <!-- Áreas y porterías -->
              <rect x="4" y="34" width="50" height="82" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <rect x="4" y="58" width="18" height="34" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <rect x="246" y="34" width="50" height="82" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <rect x="278" y="58" width="18" height="34" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <rect x="0" y="66" width="4" height="18" fill="rgba(244,244,239,.55)"/>
              <rect x="296" y="66" width="4" height="18" fill="rgba(244,244,239,.55)"/>
              <circle cx="26" cy="75" r="1.4" fill="rgba(244,244,239,.4)"/>
              <circle cx="274" cy="75" r="1.4" fill="rgba(244,244,239,.4)"/>
              <!-- Cuartos de círculo de córner -->
              <path d="M 4 12 A 8 8 0 0 0 12 4" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <path d="M 288 4 A 8 8 0 0 0 296 12" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <path d="M 12 146 A 8 8 0 0 0 4 138" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <path d="M 296 138 A 8 8 0 0 0 288 146" fill="none" stroke="rgba(244,244,239,.3)" stroke-width="1.5"/>
              <!-- Línea de fuera de juego, solo visible en jugadas de fuera de juego -->
              <line id="var-offside-line" x1="150" y1="4" x2="150" y2="146" stroke="#f2c14e" stroke-width="1.5" stroke-dasharray="5 4" opacity="0"/>
              <circle id="var-marker-a1" cx="80" cy="55" r="6" fill="#e35d4f"/>
              <circle id="var-marker-a2" cx="70" cy="100" r="6" fill="#e35d4f"/>
              <circle id="var-marker-b1" cx="140" cy="60" r="6" fill="#8fd8b0"/>
              <circle id="var-marker-b2" cx="150" cy="105" r="6" fill="#8fd8b0"/>
              <circle id="var-marker-ball-glow" cx="110" cy="78" r="11" fill="#f2c14e" opacity=".35"/>
              <circle id="var-marker-ball" cx="110" cy="78" r="5.5" fill="#f2c14e" stroke="#0f1210" stroke-width="1.5"/>
            </svg>
            <div class="var-zone-label" id="var-zone-label">Zona: Medio campo</div>
          </div>
          <p class="var-review-text" id="var-review-text"></p>
          <button class="primary-btn var-done-btn" id="var-btn-done">🏃 Volver al campo con la decisión</button>
        </div>

        <div class="feedback-banner" id="feedback-banner"></div>
        <div class="crowd-note" id="crowd-note"></div>

        <div class="continue-wrap">
          <button class="primary-btn hidden" id="btn-next-incident">Siguiente jugada</button>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ PANTALLA 3: RESUMEN DE PARTIDO ============ -->
  <section id="screen-summary" class="screen hidden">
    <div class="summary-wrap">
      <div class="summary-card">
        <h2 id="summary-title">Pitido final</h2>
        <p id="summary-sub" style="color:var(--chalk-dim);"></p>
        <div class="summary-stats">
          <div class="summary-stat"><span class="num" id="sum-correct">0</span><span class="lbl">ACIERTOS</span></div>
          <div class="summary-stat"><span class="num" id="sum-wrong">0</span><span class="lbl">ERRORES</span></div>
          <div class="summary-stat"><span class="num" id="sum-media-change">+0</span><span class="lbl">MEDIA</span></div>
          <div class="summary-stat"><span class="num money" id="sum-money">+0€</span><span class="lbl">GANADO</span></div>
        </div>
        <div class="bribe-note hidden" id="bribe-note"></div>
        <div class="final-msg hidden" id="final-msg"></div>
        <div class="promo-msg" id="promo-msg"></div>
        <button class="primary-btn" id="btn-next-match">Siguiente partido</button>
        <br>
        <button class="ghost-btn" id="btn-standings-summary">📊 Ver clasificación</button>
        <button class="ghost-btn" id="btn-shop-summary">🏪 Tienda</button>
        <button class="ghost-btn" id="btn-transfers-summary">🔄 Fichajes</button>
        <button class="ghost-btn" id="btn-quit-career">Volver al inicio</button>

        <div class="patrimonio-box">
          <h4>TU VIDA FUERA DEL CAMPO</h4>
          <div class="patrimonio-items" id="patrimonio-items"></div>
        </div>
      </div>

      <div id="ref-card-container"></div>
    </div>

    <div class="leaderboard">
      <h3>Mejores árbitros (local)</h3>
      <ol id="leaderboard-list"></ol>
    </div>
  </section>

  <!-- ============ PANTALLA 4: FIN DE TEMPORADA / FICHAJES ============ -->
  <section id="screen-season" class="screen hidden">
    <div class="brand"><h1 style="font-size:2.2rem;">FIN DE TEMPORADA</h1></div>
    <p class="tagline" id="season-recap-text">Balance de la temporada.</p>
    <div class="final-msg hidden" id="season-trophy-msg"></div>
    <div class="season-recap" id="season-recap"></div>
    <div class="step-label">🔄 Mercado de fichajes de la temporada</div>
    <div class="transfers-list" id="season-transfers"></div>
    <button class="ghost-btn" id="btn-transfers-season">📜 Ver historial completo de fichajes</button>
    <div class="step-label">Elige tu próximo destino</div>
    <div class="offer-grid" id="offer-grid"></div>
  </section>

  <!-- ============ MODAL: CLASIFICACIÓN DE LA LIGA ============ -->
  <div class="modal-overlay hidden" id="standings-overlay">
    <div class="modal-box">
      <div class="modal-head">
        <h3 id="standings-title">Clasificación</h3>
        <button class="modal-close" id="standings-close">✕</button>
      </div>
      <div class="standings-scroll">
        <table class="standings-table">
          <thead>
            <tr><th>#</th><th>Equipo</th><th>PJ</th><th>G</th><th>E</th><th>P</th><th>GF</th><th>GC</th><th>DG</th><th>Pts</th></tr>
          </thead>
          <tbody id="standings-body"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ============ MODAL: TIENDA ============ -->
  <div class="modal-overlay hidden" id="shop-overlay">
    <div class="modal-box">
      <div class="modal-head">
        <h3>🏪 Tienda — Dinero disponible: <span id="shop-money">0€</span></h3>
        <button class="modal-close" id="shop-close">✕</button>
      </div>
      <div class="shop-tabs">
        <button class="shop-tab active" id="shop-tab-pro" data-cat="pro">Mejoras profesionales</button>
        <button class="shop-tab" id="shop-tab-personal" data-cat="personal">Vida personal</button>
      </div>
      <div class="shop-list" id="shop-list"></div>
    </div>
  </div>

  <!-- ============ MODAL: FICHAJES ============ -->
  <div class="modal-overlay hidden" id="transfers-overlay">
    <div class="modal-box">
      <div class="modal-head">
        <h3>🔄 Historial de fichajes de tu carrera</h3>
        <button class="modal-close" id="transfers-close">✕</button>
      </div>
      <div class="standings-scroll" id="transfers-body"></div>
    </div>
  </div>

  <!-- ============ MODAL: SOBORNO ============ -->
  <div class="modal-overlay hidden" id="bribe-overlay">
    <div class="modal-box narrow">
      <div class="modal-head" style="justify-content:center;">
        <h3>💰 Oferta bajo cuerda</h3>
      </div>
      <p id="bribe-text">Un equipo quiere comprarte antes del partido.</p>
      <div class="bribe-amount" id="bribe-amount">0€</div>
      <p style="font-size:.8rem; color:var(--chalk-dim);">Nadie más lo sabrá... de momento.</p>
      <div class="bribe-actions">
        <button class="primary-btn" id="bribe-accept" style="margin-top:0;">Aceptar el dinero</button>
        <button class="ghost-btn" id="bribe-decline" style="margin-top:0;">Rechazar y arbitrar limpio</button>
      </div>
    </div>
  </div>

  <footer class="credit">Coparbi © <span id="credit-year"></span> — proyecto de aficionado sin relación oficial con las ligas o clubes mencionados.</footer>
</div>

<script>
(function(){
  "use strict";

  /* ================= LIGAS REALES ================= */
  // "top" = clubes históricamente más fuertes (también usados en fases continentales).
  // "mid" = resto de clubes de la misma liga, para partidos de fase inicial de carrera.
  const LEAGUES = {
    laliga: {
      name: "LaLiga", country: "España", flag: "🇪🇸",
      top: ["Real Madrid","FC Barcelona","Atlético de Madrid","Real Sociedad"],
      mid: ["Sevilla FC","Real Betis","Athletic Club","Villarreal CF","Valencia CF","Celta de Vigo",
            "Getafe CF","CA Osasuna","Rayo Vallecano","Girona FC","RCD Mallorca","Deportivo Alavés",
            "UD Las Palmas","CD Leganés","RCD Espanyol","Real Valladolid"]
    },
    premier: {
      name: "Premier League", country: "Inglaterra", flag: "🏴",
      top: ["Manchester City","Liverpool FC","Arsenal FC","Chelsea FC"],
      mid: ["Manchester United","Tottenham Hotspur","Newcastle United","Aston Villa","West Ham United","Brighton & Hove Albion",
            "Everton FC","Wolverhampton Wanderers","Crystal Palace","Fulham FC","Brentford FC","Nottingham Forest",
            "AFC Bournemouth","Leicester City","Ipswich Town","Southampton FC"]
    },
    seriea: {
      name: "Serie A", country: "Italia", flag: "🇮🇹",
      top: ["Juventus","Inter de Milán","AC Milan","SSC Nápoles"],
      mid: ["AS Roma","Atalanta","Lazio","Fiorentina","Bologna","Torino",
            "Udinese Calcio","Genoa CFC","Cagliari Calcio","Empoli FC","Hellas Verona","Parma Calcio",
            "Como 1907","US Lecce","Venezia FC","AC Monza"]
    },
    bundesliga: {
      name: "Bundesliga", country: "Alemania", flag: "🇩🇪",
      top: ["Bayern de Múnich","Borussia Dortmund","RB Leipzig","Bayer Leverkusen"],
      mid: ["Eintracht Frankfurt","VfB Stuttgart","SC Friburgo","Borussia Mönchengladbach","Union Berlin",
            "VfL Wolfsburgo","Werder Bremen","TSG Hoffenheim","FC Augsburgo","FSV Maguncia 05",
            "VfL Bochum","FC St. Pauli","Holstein Kiel","1. FC Heidenheim"]
    },
    ligue1: {
      name: "Ligue 1", country: "Francia", flag: "🇫🇷",
      top: ["Paris Saint-Germain","Olympique de Marsella","AS Mónaco","Olympique de Lyon"],
      mid: ["Lille OSC","Stade Rennais","OGC Niza","RC Lens","Stade de Reims",
            "RC Estrasburgo","Toulouse FC","FC Nantes","Montpellier HSC","Le Havre AC",
            "AJ Auxerre","Angers SCO","AS Saint-Étienne","Stade Brestois 29"]
    },
    liga_mx: {
      name: "Liga MX", country: "México", flag: "🇲🇽",
      top: ["Club América","Chivas Guadalajara","Cruz Azul","CF Monterrey"],
      mid: ["Tigres UANL","Pumas UNAM","Toluca FC","Santos Laguna","Club León","Pachuca CF",
            "Atlas FC","Necaxa","Puebla FC","Tijuana Xolos","Mazatlán FC","Querétaro FC",
            "FC Juárez","Atlético San Luis"]
    },
    liga_arg: {
      name: "Liga Profesional Argentina", country: "Argentina", flag: "🇦🇷",
      top: ["River Plate","Boca Juniors","Racing Club","San Lorenzo"],
      mid: ["Independiente","Estudiantes de La Plata","Vélez Sarsfield","Talleres de Córdoba",
            "Newell's Old Boys","Rosario Central","Argentinos Juniors","Huracán",
            "Gimnasia La Plata","Banfield","Lanús","Defensa y Justicia","Godoy Cruz","Unión de Santa Fe"]
    },
    brasileirao: {
      name: "Brasileirão Série A", country: "Brasil", flag: "🇧🇷",
      top: ["Flamengo","Palmeiras","São Paulo FC","Corinthians"],
      mid: ["Grêmio","Internacional","Atlético Mineiro","Fluminense","Botafogo","Cruzeiro",
            "Santos FC","Vasco da Gama","Bahia","Fortaleza EC","Athletico Paranaense","Red Bull Bragantino",
            "Ceará SC","Criciúma EC"]
    },
    primeira: {
      name: "Primeira Liga", country: "Portugal", flag: "🇵🇹",
      top: ["SL Benfica","FC Porto","Sporting CP","SC Braga"],
      mid: ["Vitória de Guimarães","Rio Ave FC","Boavista FC","Estoril Praia","Casa Pia AC",
            "Gil Vicente FC","Moreirense FC","Famalicão","Farense","Arouca"]
    },
    eredivisie: {
      name: "Eredivisie", country: "Países Bajos", flag: "🇳🇱",
      top: ["Ajax","PSV Eindhoven","Feyenoord","AZ Alkmaar"],
      mid: ["FC Twente","FC Utrecht","Vitesse","FC Groningen","Sparta Rotterdam",
            "Heerenveen","NEC Nijmegen","Go Ahead Eagles","Fortuna Sittard","PEC Zwolle"]
    },
    mls: {
      name: "Major League Soccer", country: "Estados Unidos", flag: "🇺🇸",
      top: ["Inter Miami CF","LA Galaxy","Seattle Sounders","LAFC"],
      mid: ["New York City FC","New York Red Bulls","Atlanta United","Columbus Crew",
            "Portland Timbers","FC Cincinnati","Orlando City","Philadelphia Union",
            "Toronto FC","Real Salt Lake"]
    }
  };

  /* ================= PLANTILLAS REALES (para el mercado de fichajes) =================
     Jugadores reales y conocidos, asignados a sus clubes "top" de cada liga tal y
     como estaban al preparar esta actualización. El mercado de fichajes de cada
     fin de temporada los mueve de un club a otro dentro del juego, así que con el
     tiempo tu propia partida tendrá su propia historia de fichajes (ficticia a
     partir de aquí, aunque los nombres sean reales). */
  const PLAYER_POOL_INITIAL = {
    "Real Madrid": ["Kylian Mbappé","Vinícius Júnior","Jude Bellingham"],
    "FC Barcelona": ["Lamine Yamal","Pedri","Raphinha"],
    "Atlético de Madrid": ["Julián Álvarez","Antoine Griezmann","Jan Oblak"],
    "Real Sociedad": ["Mikel Oyarzabal","Take Kubo","Álex Remiro"],
    "Manchester City": ["Erling Haaland","Phil Foden","Enzo Fernández"],
    "Liverpool FC": ["Mohamed Salah","Virgil van Dijk","Alexis Mac Allister"],
    "Arsenal FC": ["Bukayo Saka","Martin Ødegaard","Declan Rice"],
    "Chelsea FC": ["Cole Palmer","Moisés Caicedo","Maxence Lacroix"],
    "Juventus": ["Dusan Vlahović","Kenan Yıldız","Manuel Locatelli"],
    "Inter de Milán": ["Lautaro Martínez","Nicolò Barella","Hakan Çalhanoğlu"],
    "AC Milan": ["Rafael Leão","Christian Pulisic","Mike Maignan"],
    "SSC Nápoles": ["Romelu Lukaku","Scott McTominay","Alex Meret"],
    "Bayern de Múnich": ["Harry Kane","Jamal Musiala","Michael Olise"],
    "Borussia Dortmund": ["Julian Brandt","Serhou Guirassy","Gregor Kobel"],
    "RB Leipzig": ["Willi Orbán","Lukas Klostermann","Xavi Simons"],
    "Bayer Leverkusen": ["Granit Xhaka","Patrik Schick","Jonas Hofmann"],
    "Paris Saint-Germain": ["Ousmane Dembélé","Achraf Hakimi","Vitinha"],
    "Olympique de Marsella": ["Mason Greenwood","Adrien Rabiot","Gerónimo Rulli"],
    "AS Mónaco": ["Aleksandr Golovin","Denis Zakaria","Philipp Köhn"],
    "Olympique de Lyon": ["Alexandre Lacazette","Corentin Tolisso","Moussa Niakhaté"],
    "Club América": ["Henry Martín","Álvaro Fidalgo","Alejandro Zendejas"],
    "Chivas Guadalajara": ["Fernando Beltrán","Cade Cowell","Luis Romo"],
    "Cruz Azul": ["Ángel Sepúlveda","Carlos Rodríguez","Kevin Mier"],
    "CF Monterrey": ["Sergio Ramos","Germán Berterame","Sergio Canales"],
    "River Plate": ["Maximiliano Salas","Gonzalo Montiel","Franco Armani"],
    "Boca Juniors": ["Edinson Cavani","Miguel Merentiel","Leandro Paredes"],
    "Racing Club": ["Juan Fernando Quintero","Gabriel Arias","Marco Di Cesare"],
    "San Lorenzo": ["Adam Bareiro","Elián Irala","Facundo Cambeses"],
    "Flamengo": ["Gerson","Pedro","Bruno Henrique"],
    "Palmeiras": ["Raphael Veiga","Gustavo Gómez","Weverton"],
    "São Paulo FC": ["Lucas Moura","Jonathan Calleri","Rafael"],
    "Corinthians": ["Yuri Alberto","Memphis Depay","Hugo Souza"],
    "SL Benfica": ["Ángel Di María","Vangelis Pavlidis","Anatoliy Trubin"],
    "FC Porto": ["Pepê","Deyverson","Diogo Costa"],
    "Sporting CP": ["Geny Catamo","Ousmane Diomande","Franco Israel"],
    "SC Braga": ["Ricardo Horta","Roger Fernandes","Lukas Černý"],
    "Ajax": ["Kenneth Taylor","Wout Weghorst","Remko Pasveer"],
    "PSV Eindhoven": ["Ivan Perišić","Luuk de Jong","Walter Benítez"],
    "Feyenoord": ["Anis Hadj Moussa","Givairo Read","Timon Wellenreuther"],
    "AZ Alkmaar": ["Ernest Poku","Peer Koopmeiners","Mathew Ryan"],
    "Inter Miami CF": ["Lionel Messi","Luis Suárez","Sergio Busquets"],
    "LA Galaxy": ["Riqui Puig","Gabriel Pec","John McCarthy"],
    "Seattle Sounders": ["Cristian Roldán","Jordan Morris","Stefan Frei"],
    "LAFC": ["Denis Bouanga","Hugo Lloris","Timothy Tillman"]
  };

  function clonePlayerPool(){
    const out = {};
    Object.keys(PLAYER_POOL_INITIAL).forEach(team=>{ out[team] = PLAYER_POOL_INITIAL[team].slice(); });
    return out;
  }

  /* ================= ETAPAS DE CARRERA (según media) ================= */
  const STAGES = [
    {name:"Liga · partidos de media tabla", min:40, max:54, pool:"domestic-mid"},
    {name:"Liga · grandes partidos",         min:55, max:69, pool:"domestic-top"},
    {name:"Competición Continental",         min:70, max:79, pool:"continental-mid"},
    {name:"Fase de Campeones",               min:80, max:89, pool:"continental-top"},
    {name:"Gran Final Continental",          min:90, max:99, pool:"final"}
  ];

  function stageFor(media){
    for(const s of STAGES){ if(media>=s.min && media<=s.max) return s; }
    return media<40 ? STAGES[0] : STAGES[STAGES.length-1];
  }

  /* ================= BANCO DE JUGADAS (con equipos dinámicos) ================= */
  // {A} = equipo protagonista/posible sancionado · {B} = equipo rival/afectado.
  // aSide: "def" (el que defiende suele cometer la acción), "att" (el que ataca), "random" (indistinto).
  // singleTeam: true cuando solo interviene un equipo (no hay rival directo en la jugada).
  const INCIDENT_BANK = [
    {tag:"ENTRADA", attr:"FIS", difficulty:1, aSide:"def",
      text:"Un defensa de {A} llega con los tacos altos por delante y golpea la espinilla de un delantero de {B} en la banda derecha.",
      options:["nada","falta","amarilla","roja"], correct:"amarilla",
      varReveal:"La repetición muestra que el jugador de {A} golpea el balón primero, pero con fuerza excesiva y sin control sobre la pierna."},
    {tag:"ÁREA", attr:"PRE", difficulty:2, aSide:"def",
      text:"Balón centrado al área de {A}; un delantero de {B} cae tras un ligero contacto de espaldas con el central. Ambos se disputaban el hueco.",
      options:["nada","falta","penalti"], correct:"nada",
      varReveal:"Desde otro ángulo se ve que el jugador de {B} busca el contacto y se deja caer antes de que el central de {A} lo empuje realmente."},
    {tag:"MANO", attr:"PRE", difficulty:2, aSide:"def",
      text:"El balón golpea el brazo de un defensor de {A} que está lanzándose para bloquear un disparo de {B} desde muy cerca.",
      options:["nada","penalti"], correct:"nada",
      varReveal:"El brazo del jugador de {A} estaba pegado al cuerpo y la distancia de reacción era mínima; postura natural."},
    {tag:"FUERA DE JUEGO", attr:"PRE", difficulty:1, aSide:"att",
      text:"Un extremo de {A} recibe un pase filtrado y marca gol frente a {B}, pero parecía estar adelantado por medio cuerpo en el momento del pase.",
      options:["gol valido","anular gol"], correct:"anular gol", goalOption:"gol valido", goalTeam:"A",
      varReveal:"La línea del VAR confirma que el hombro del atacante de {A} estaba claramente por delante del último defensa de {B}."},
    {tag:"SIMULACIÓN", attr:"COM", difficulty:2, aSide:"att",
      text:"Un jugador de {A} se tira dentro del área tras un contacto mínimo con un rival de {B} y pide penalti a gritos.",
      options:["nada","penalti","amarilla por simular"], correct:"amarilla por simular",
      varReveal:"La repetición muestra que no hay contacto real: el jugador de {A} se lanza antes de que le toquen."},
    {tag:"ENTRADA DURA", attr:"FIS", difficulty:2, aSide:"def",
      text:"Un centrocampista de {A} llega tarde y con las dos piernas por delante sobre el tobillo de un rival de {B} en una disputa de balón dividido.",
      options:["nada","amarilla","roja"], correct:"roja",
      varReveal:"La velocidad y la altura de la entrada de {A} ponen en serio riesgo la integridad del rival, aunque toque algo de balón."},
    {tag:"PROTESTA", attr:"COM", difficulty:1, singleTeam:true,
      text:"Tras pitar una falta en contra, el capitán de {A} se encara contigo y te reclama con gestos exagerados sin llegar a insultar.",
      options:["nada","amarilla","charla y calmar"], correct:"charla y calmar",
      varReveal:null},
    {tag:"ÚLTIMO HOMBRE", attr:"FIS", difficulty:1, aSide:"def",
      text:"El defensa central de {A}, siendo el último jugador, derriba al delantero de {B} que se iba solo hacia portería justo en el borde del área.",
      options:["amarilla","roja"], correct:"roja",
      varReveal:"Se confirma que no había ningún otro defensor de {A} en condiciones de recuperar antes que el atacante de {B}."},
    {tag:"SAQUE RÁPIDO", attr:"PRE", difficulty:3, aSide:"att",
      text:"{A}, que va perdiendo, saca una falta rápidamente mientras {B} aún coloca la barrera, sin que hayas señalado la distancia.",
      options:["permitir gol","anular y repetir"], correct:"permitir gol", goalOption:"permitir gol", goalTeam:"A",
      varReveal:null},
    {tag:"CHOQUE FORTUITO", attr:"PRE", difficulty:1, aSide:"random",
      text:"Un jugador de {A} y otro de {B} chocan cabeza con cabeza en un salto disputado limpiamente, ambos caen tocados sin intención de dañarse.",
      options:["nada","falta"], correct:"nada",
      varReveal:null},
    {tag:"MANO EN ATAQUE", attr:"PRE", difficulty:3, aSide:"att",
      text:"Un delantero de {A} controla el balón con el brazo pegado al cuerpo dentro del área de {B} y remata a gol.",
      options:["gol valido","anular por mano"], correct:"anular por mano", goalOption:"gol valido", goalTeam:"A",
      varReveal:"Aunque el brazo esté pegado, el reglamento anula el gol si el balón toca la mano antes del remate y este llega directamente de ese contacto."},
    {tag:"PISOTÓN", attr:"FIS", difficulty:2, aSide:"def",
      text:"En un forcejeo dentro del área de {A} tras un córner, un defensor pisa el pie de un delantero de {B} de forma que parece accidental en la pelea por la posición.",
      options:["nada","penalti","amarilla"], correct:"penalti",
      varReveal:"El pisotón del jugador de {A} es claro e innecesario, ocurre cuando el rival de {B} ya controlaba el espacio."},
    {tag:"CELEBRACIÓN", attr:"AUT", difficulty:1, singleTeam:true,
      text:"Tras marcar, un jugador de {A} se quita la camiseta para celebrar delante de su afición.",
      options:["nada","amarilla"], correct:"amarilla",
      varReveal:null},
    {tag:"CARGA SOBRE PORTERO", attr:"AUT", difficulty:1, aSide:"att",
      text:"Un delantero de {A} empuja claramente al portero de {B}, que tenía el balón controlado con las manos dentro del área pequeña.",
      options:["nada","falta al portero"], correct:"falta al portero",
      varReveal:null},
    {tag:"ENTRADA POR DETRÁS", attr:"FIS", difficulty:2, aSide:"def",
      text:"Un lateral de {A} llega por detrás y se lleva el tobillo de un rival de {B} en una jugada de contragolpe, sin opción real al balón.",
      options:["nada","amarilla","roja"], correct:"roja",
      varReveal:"El estudio a cámara lenta confirma que {A} no tiene ninguna intención de jugar el balón, solo frenar el contragolpe de {B}."},
    {tag:"CODAZO", attr:"FIS", difficulty:2, aSide:"random",
      text:"En la disputa de un balón aéreo, un jugador de {A} y otro de {B} suben con los codos altos y se golpean en la cara.",
      options:["nada","falta","amarilla","roja"], correct:"falta",
      varReveal:"El contacto es casual dentro de un salto natural, sin intención de golpear, aunque el gesto sea aparatoso."},
    {tag:"PENALTI DUDOSO", attr:"PRE", difficulty:3, aSide:"def",
      text:"Dentro del área, un defensor de {A} pone la pierna y roza levemente el tobillo de un delantero de {B}, que cae al instante.",
      options:["nada","penalti"], correct:"penalti",
      varReveal:"El roce de {A} sí altera el equilibrio del jugador de {B}: hay contacto real, aunque mínimo, dentro del área."},
    {tag:"BALÓN A LA MANO", attr:"PRE", difficulty:2, aSide:"def",
      text:"Un centro raso golpea la mano pegada al muslo de un defensor de {A}, en una postura totalmente natural, ante el ataque de {B}.",
      options:["nada","penalti"], correct:"nada",
      varReveal:"La mano de {A} no amplía el volumen del cuerpo ni se mueve hacia el balón; no hay infracción."},
    {tag:"PÉRDIDA DE TIEMPO", attr:"AUT", difficulty:1, singleTeam:true,
      text:"El portero de {A} tarda casi un minuto en sacar de puerta mientras su equipo defiende un resultado ajustado.",
      options:["nada","amarilla por perder tiempo"], correct:"amarilla por perder tiempo",
      varReveal:null},
    {tag:"MANO DEL PORTERO", attr:"PRE", difficulty:1, aSide:"def",
      text:"El portero de {A} recoge con las manos un pase claramente intencionado de su propio compañero de espaldas, ante la presión de {B}.",
      options:["nada","falta indirecta"], correct:"falta indirecta",
      varReveal:null},
    {tag:"AGARRÓN EN CÓRNER", attr:"FIS", difficulty:2, aSide:"random",
      text:"En un córner, un jugador de {A} agarra visiblemente la camiseta de un rival de {B} para evitar que salte con libertad.",
      options:["nada","penalti","amarilla"], correct:"penalti",
      varReveal:"El agarrón de {A} es continuado y evita claramente el salto del jugador de {B}: infracción sancionable."},
    {tag:"FALTA TÁCTICA", attr:"FIS", difficulty:1, aSide:"def",
      text:"Con el equipo lanzado a la contra, un centrocampista de {A} corta con una falta clara sobre un jugador de {B} que ya le había superado.",
      options:["falta","amarilla"], correct:"amarilla",
      varReveal:"La falta de {A} corta una ocasión manifiesta de gol de {B}: merece tarjeta, aunque el contacto no sea muy fuerte."},
    {tag:"ESCUPITAJO", attr:"AUT", difficulty:2, aSide:"random",
      text:"Tras un forcejeo, parece que un jugador de {A} escupe en dirección a uno de {B}, aunque el ángulo no es del todo claro.",
      options:["nada","amarilla","roja"], correct:"roja",
      varReveal:"Varios ángulos confirman que el gesto de {A} es intencionado y va dirigido al rival de {B}."},
    {tag:"DOBLE AMARILLA", attr:"COM", difficulty:2, aSide:"def",
      text:"Un jugador de {A}, ya amonestado, comete una segunda falta clara sobre un rival de {B} en el centro del campo.",
      options:["nada","amarilla","roja"], correct:"roja",
      varReveal:"La segunda falta de {A} es innegable; con la amarilla previa, corresponde la expulsión."},
    {tag:"GOL FANTASMA", attr:"PRE", difficulty:3, aSide:"att",
      text:"Un disparo de {A} golpea el larguero, bota justo sobre la línea de la portería de {B} y sale rechazado; a simple vista no queda claro si entró.",
      options:["gol valido","no fue gol"], correct:"gol valido", goalOption:"gol valido", goalTeam:"A",
      varReveal:"La tecnología de línea de meta confirma que el balón de {A} cruzó por completo la línea antes de salir despejado."},
    {tag:"OBSTRUCCIÓN", attr:"PRE", difficulty:2, aSide:"att",
      text:"Un delantero de {A} en fuera de juego no toca el balón, pero se cruza claramente en el camino de un defensor de {B} que iba a despejarlo.",
      options:["nada","fuera de juego"], correct:"fuera de juego",
      varReveal:"El jugador de {A}, aunque no toca el balón, interfiere de forma evidente en la acción defensiva de {B}."},
    {tag:"BANQUILLO", attr:"COM", difficulty:1, singleTeam:true,
      text:"El entrenador de {A} sale varios metros de su área técnica gritándote una decisión con la que no está de acuerdo.",
      options:["nada","amarilla al banquillo"], correct:"amarilla al banquillo",
      varReveal:null},
    {tag:"MANO SALVADORA", attr:"PRE", difficulty:3, aSide:"def",
      text:"Un defensor de {A}, ya batido, desvía con la mano un balón que iba directo a gol tras un disparo de {B}.",
      options:["nada","penalti","roja"], correct:"roja",
      varReveal:"El jugador de {A} impide con la mano un gol manifiesto de {B}: penalti y expulsión."},
    {tag:"EMPUJÓN SIN BALÓN", attr:"FIS", difficulty:2, aSide:"random",
      text:"Lejos del balón, un jugador de {A} empuja por la espalda a un rival de {B} en una acción que se escapa a primera vista.",
      options:["nada","falta","amarilla"], correct:"amarilla",
      varReveal:"La imagen del VAR muestra con claridad el empujón de {A} sobre {B}, sin ninguna disputa por el balón."},
    {tag:"PENALTI REPETIDO", attr:"AUT", difficulty:2, singleTeam:true,
      text:"Al lanzar un penalti, un jugador de {A} pisa claramente el área antes de que el balón salga despedido.",
      options:["gol valido","repetir penalti"], correct:"repetir penalti", goalOption:"gol valido", goalTeam:"A",
      varReveal:null},
    {tag:"TIRÓN DE CAMISETA", attr:"FIS", difficulty:1, aSide:"def",
      text:"En una carrera hacia el área, un defensor de {A} tira claramente de la camiseta de un delantero de {B} para frenarlo.",
      options:["nada","falta","amarilla"], correct:"falta",
      varReveal:null},
    {tag:"BARRIDA POR DETRÁS", attr:"FIS", difficulty:2, aSide:"def",
      text:"Un central de {A} llega deslizándose por detrás y se lleva por delante a un rival de {B} que controlaba el balón de espaldas.",
      options:["nada","amarilla","roja"], correct:"amarilla",
      varReveal:"La entrada de {A} es imprudente pero llega con algo de balón y sin excesiva violencia: amonestación."},
    {tag:"MANO INVOLUNTARIA", attr:"PRE", difficulty:2, aSide:"def",
      text:"Un disparo muy cercano de {B} rebota en la espalda de un defensor de {A} y sube hasta golpearle el brazo, pegado al cuerpo.",
      options:["nada","penalti"], correct:"nada",
      varReveal:"No hay tiempo de reacción posible para {A}; la distancia y la postura hacen el contacto involuntario."},
    {tag:"FUERA DE JUEGO AJUSTADO", attr:"PRE", difficulty:3, aSide:"att",
      text:"Un pase en profundidad deja a un delantero de {A} en una posición milimétrica frente a la defensa de {B}; el gol llega segundos después.",
      options:["gol valido","anular gol"], correct:"gol valido", goalOption:"gol valido", goalTeam:"A",
      varReveal:"Las líneas trazadas por el VAR muestran al jugador de {A} en posición legal por unos centímetros."},
    {tag:"AGRESIÓN FUERA DE JUEGO", attr:"AUT", difficulty:3, aSide:"random",
      text:"Tras una jugada ya cortada, un jugador de {A} da un manotazo en la cara a uno de {B} en un cruce de palabras.",
      options:["nada","amarilla","roja"], correct:"roja",
      varReveal:"El contacto de {A} hacia el rostro del rival de {B} es intencionado, aunque con poca fuerza: expulsión igualmente."},
    {tag:"SUSTITUCIÓN IRREGULAR", attr:"COM", difficulty:1, singleTeam:true,
      text:"{A} intenta hacer un cambio adicional alegando una lesión que no parece real, buscando parar el partido.",
      options:["permitir cambio","denegar cambio"], correct:"denegar cambio",
      varReveal:null},
    {tag:"CARGA LEGAL", attr:"FIS", difficulty:1, aSide:"random",
      text:"Un defensor de {A} carga hombro con hombro a un delantero de {B} en la disputa de un balón dividido, ambos con el pie en el suelo.",
      options:["nada","falta"], correct:"nada",
      varReveal:null},
    {tag:"BALÓN GOLPEA ÁRBITRO", attr:"PRE", difficulty:1, singleTeam:true,
      text:"Un pase de {A} te golpea a ti, el árbitro, en pleno centro del campo, y el balón cambia de dirección favoreciendo a {A}.",
      options:["bota neutral","ventaja para B"], correct:"bota neutral",
      varReveal:null},
    {tag:"ROJA POR INSULTO", attr:"COM", difficulty:2, aSide:"random",
      text:"Tras una decisión tuya, un jugador de {A} te dedica un insulto muy grave que escuchas con claridad.",
      options:["amarilla","roja"], correct:"roja",
      varReveal:null},
    {tag:"PENALTI EN EL AÑADIDO", attr:"TEM", difficulty:3, aSide:"def",
      text:"En el último minuto de descuento, con {A} ganando por la mínima, un defensor suyo derriba a un delantero de {B} dentro del área.",
      options:["nada","penalti"], correct:"penalti",
      varReveal:"El derribo de {A} sobre el jugador de {B} es claro, sin importar el momento del partido."},
    {tag:"FALTA FUERA DEL ÁREA", attr:"PRE", difficulty:2, aSide:"def",
      text:"Un defensor de {A} derriba a un delantero de {B} justo en el borde del área, sin que quede claro si el contacto empieza dentro o fuera.",
      options:["falta fuera","penalti"], correct:"falta fuera",
      varReveal:"El punto exacto de contacto entre {A} y {B} queda, por poco, fuera de la línea del área."},
    {tag:"GOL EN FUERA DE JUEGO PASIVO", attr:"PRE", difficulty:2, aSide:"att",
      text:"Un jugador de {A} está adelantado pero lejos de la jugada mientras un compañero suyo remata y marca ante {B}.",
      options:["gol valido","anular gol"], correct:"gol valido", goalOption:"gol valido", goalTeam:"A",
      varReveal:"El jugador adelantado de {A} no interfiere ni participa en la jugada activa: el gol sube al marcador."}
  ];

  const INCIDENT_LABELS = {
    "nada":"Nada, sigue el juego", "falta":"Pitar falta", "amarilla":"Tarjeta amarilla", "roja":"Tarjeta roja",
    "penalti":"Señalar penalti", "gol valido":"Dar el gol por válido", "anular gol":"Anular el gol",
    "amarilla por simular":"Amarilla por simular", "charla y calmar":"Calmar con una charla",
    "permitir gol":"Dejar seguir la jugada", "anular y repetir":"Cortar y repetir la falta",
    "anular por mano":"Anular por mano", "falta al portero":"Pitar falta al portero",
    "amarilla por perder tiempo":"Amarilla por perder tiempo", "falta indirecta":"Falta indirecta",
    "no fue gol":"No fue gol", "fuera de juego":"Fuera de juego", "amarilla al banquillo":"Amarilla al banquillo",
    "repetir penalti":"Repetir el penalti", "permitir cambio":"Permitir el cambio", "denegar cambio":"Denegar el cambio",
    "bota neutral":"Bote neutral, sigue el juego", "ventaja para B":"Dar ventaja al rival",
    "falta fuera":"Falta fuera del área"
  };
  const SWATCH = { "amarilla":"#f2c14e", "roja":"#c0392b", "amarilla por simular":"#f2c14e", "amarilla por perder tiempo":"#f2c14e", "amarilla al banquillo":"#f2c14e" };

  /* ================= ESCENAS DEL VAR (según el tipo de jugada) =================
     Cada jugada del banco se asocia a una "escena" (córner, área, fuera de
     juego, banda...) para que en la revisión del VAR los jugadores y el balón
     aparezcan colocados donde realmente ocurre la acción, en vez de moverse
     de forma genérica por todo el campo. */
  const SCENE_BY_TAG = {
    "ENTRADA":"wing", "ÁREA":"box", "MANO":"box", "FUERA DE JUEGO":"offside",
    "SIMULACIÓN":"box", "ENTRADA DURA":"midfield", "PROTESTA":"solo",
    "ÚLTIMO HOMBRE":"outsidebox", "SAQUE RÁPIDO":"midfield", "CHOQUE FORTUITO":"midfield",
    "MANO EN ATAQUE":"box", "PISOTÓN":"corner", "CELEBRACIÓN":"solo",
    "CARGA SOBRE PORTERO":"box", "ENTRADA POR DETRÁS":"midfield", "CODAZO":"midfield",
    "PENALTI DUDOSO":"box", "BALÓN A LA MANO":"box", "PÉRDIDA DE TIEMPO":"solo",
    "MANO DEL PORTERO":"box", "AGARRÓN EN CÓRNER":"corner", "FALTA TÁCTICA":"midfield",
    "ESCUPITAJO":"midfield", "DOBLE AMARILLA":"midfield", "GOL FANTASMA":"goalline",
    "OBSTRUCCIÓN":"offside", "BANQUILLO":"solo", "MANO SALVADORA":"goalline",
    "EMPUJÓN SIN BALÓN":"midfield", "PENALTI REPETIDO":"penaltyspot", "TIRÓN DE CAMISETA":"outsidebox",
    "BARRIDA POR DETRÁS":"midfield", "MANO INVOLUNTARIA":"box", "FUERA DE JUEGO AJUSTADO":"offside",
    "AGRESIÓN FUERA DE JUEGO":"solo", "SUSTITUCIÓN IRREGULAR":"solo", "CARGA LEGAL":"midfield",
    "BALÓN GOLPEA ÁRBITRO":"midfield", "ROJA POR INSULTO":"solo", "PENALTI EN EL AÑADIDO":"box",
    "FALTA FUERA DEL ÁREA":"outsidebox", "GOL EN FUERA DE JUEGO PASIVO":"offside"
  };
  const ZONE_LABELS = {
    corner:"Zona: Córner", box:"Zona: Área", outsidebox:"Zona: Borde del área",
    offside:"Zona: Línea de fuera de juego", midfield:"Zona: Medio campo", wing:"Zona: Banda",
    goalline:"Zona: Línea de gol", penaltyspot:"Zona: Punto de penalti", solo:"Zona: Jugada aislada"
  };

  // Calcula las posiciones inicial (t=0) y final (t=1) de los 4 jugadores y el
  // balón para una escena concreta. "gx"/"dir" sitúan la jugada cerca de la
  // portería izquierda o derecha; "flankTop" decide si la acción es en el
  // lado superior o inferior del campo (córners, banda...).
  function getScenePositions(scene, goalSide, flankTop){
    const gx = goalSide === "left" ? 10 : 290;
    const dir = goalSide === "left" ? 1 : -1;
    const fy = flankTop ? 1 : -1; // +1 = hacia arriba (y pequeña), -1 = hacia abajo
    const P = (x0,y0,x1,y1)=>({x0,y0,x1,y1});
    let out;
    switch(scene){
      case "corner": {
        const boxY = 75 - fy*15;
        out = {
          ball: P(gx, 75 - fy*67, gx+dir*20, boxY),
          a1: P(gx+dir*26, boxY-fy*14, gx+dir*15, boxY-fy*6),
          a2: P(gx+dir*40, boxY+fy*16, gx+dir*27, boxY+fy*10),
          b1: P(gx+dir*20, boxY-fy*6,  gx+dir*14, boxY-fy*2),
          b2: P(gx+dir*34, boxY+fy*8,  gx+dir*24, boxY+fy*12)
        };
        break;
      }
      case "box": {
        out = {
          ball: P(gx+dir*72, 40, gx+dir*22, 75),
          a1: P(gx+dir*60, 60, gx+dir*18, 68),
          a2: P(gx+dir*50, 98, gx+dir*32, 92),
          b1: P(gx+dir*30, 68, gx+dir*26, 76),
          b2: P(gx+dir*40, 100, gx+dir*36, 88)
        };
        break;
      }
      case "outsidebox": {
        out = {
          ball: P(gx+dir*115, 75, gx+dir*66, 75),
          a1: P(gx+dir*135, 58, gx+dir*64, 68),
          a2: P(gx+dir*145, 98, gx+dir*76, 100),
          b1: P(gx+dir*150, 70, gx+dir*68, 78),
          b2: P(gx+dir*160, 100, gx+dir*82, 90)
        };
        break;
      }
      case "offside": {
        out = {
          ball: P(150, 75, gx+dir*45, 62),
          a1: P(gx+dir*130, 62, gx+dir*45, 62),
          a2: P(gx+dir*118, 100, gx+dir*75, 95),
          b1: P(gx+dir*70, 58, gx+dir*60, 58),
          b2: P(gx+dir*40, 82, gx+dir*35, 82),
          offsideXEnd: gx+dir*60
        };
        break;
      }
      case "midfield": {
        out = {
          ball: P(145, 70, 155, 80),
          a1: P(136, 60, 150, 68),
          a2: P(122, 96, 138, 90),
          b1: P(162, 64, 150, 82),
          b2: P(176, 96, 160, 98)
        };
        break;
      }
      case "wing": {
        const wy = 75 - fy*58;
        const ax = gx+dir*95;
        out = {
          ball: P(ax-dir*16, wy, ax, wy+fy*8),
          a1: P(ax-dir*10, wy+fy*10, ax, wy+fy*4),
          a2: P(ax-dir*32, 75, ax-dir*10, 75),
          b1: P(ax+dir*10, wy+fy*6, ax+dir*2, wy),
          b2: P(ax+dir*26, 75, ax+dir*10, 80)
        };
        break;
      }
      case "goalline": {
        out = {
          ball: P(gx+dir*18, 75, gx-dir*3, 75),
          a1: P(gx+dir*24, 82, gx+dir*14, 78),
          a2: P(gx+dir*36, 98, gx+dir*22, 94),
          b1: P(gx+dir*4, 75, gx+dir*6, 70),
          b2: P(gx+dir*12, 60, gx+dir*9, 64)
        };
        break;
      }
      case "penaltyspot": {
        const spotX = gx+dir*20;
        out = {
          ball: P(spotX-2, 75, spotX+2, 75),
          a1: P(spotX-dir*8, 68, spotX-dir*5, 70),
          a2: P(gx+dir*60, 95, gx+dir*45, 90),
          b1: P(gx+dir*2, 68, gx+dir*2, 82),
          b2: P(gx+dir*60, 55, gx+dir*45, 60)
        };
        break;
      }
      case "solo":
      default: {
        out = {
          ball: P(150, 75, 150, 75),
          a1: P(144, 64, 150, 70),
          a2: P(156, 86, 150, 80),
          b1: P(134, 75, 140, 75),
          b2: P(166, 75, 160, 75)
        };
        break;
      }
    }
    out.showOffsideLine = scene === "offside";
    return out;
  }

  const CROWD_CORRECT = [
    "El estadio respira aliviado con tu decisión.", "Los banquillos se calman tras el pitido.",
    "La grada aplaude la seguridad del árbitro.", "El capitán asiente, de acuerdo con la lectura."
  ];
  const CROWD_WRONG = [
    "Un rugido de protesta recorre las gradas.", "El entrenador sale del área técnica gesticulando.",
    "Las redes ya están comentando la polémica.", "El capitán te sigue varios metros reclamando."
  ];

  const VAR_WATCH_NOTE = "Paras el juego. Todo el estadio mira hacia la pantalla mientras revisas tú mismo la jugada, con la repetición corriendo fluida.";

  const ATTR_LABELS = {PRE:"Precisión", AUT:"Autoridad", FIS:"Físico", COM:"Comunicación", TEM:"Sangre fría"};

  const SEASON_LENGTH = 20;   // partidos por temporada (marca también las jornadas de la clasificación)
  const BRIBE_LIMIT = 8;      // máximo de ofertas de soborno aceptables por temporada

  /* ================= TIENDA ================= */
  // Los artículos SIN "once:true" se pueden comprar varias veces, pero cada
  // compra encarece la siguiente (ver priceFor / SHOP_PRICE_GROWTH): así el
  // primer capricho es asequible, pero seguir mejorando cuesta cada vez más,
  // ni demasiado fácil ni imposible.
  const SHOP_PRICE_GROWTH = 1.45;
  const SHOP_ITEMS = [
    {id:"curso_pre", cat:"pro", emoji:"🎯", name:"Curso de posicionamiento", price:650, desc:"+3 Precisión. Cada vez que lo repitas, el curso sube de precio.",
      effect:function(){ applyAttrDelta("PRE", 3); }},
    {id:"curso_aut", cat:"pro", emoji:"🗣️", name:"Curso de gestión de grupos", price:650, desc:"+3 Autoridad. Cada vez que lo repitas, el curso sube de precio.",
      effect:function(){ applyAttrDelta("AUT", 3); }},
    {id:"curso_fis", cat:"pro", emoji:"🏃", name:"Preparador físico personal", price:650, desc:"+3 Físico. Cada vez que lo repitas, el curso sube de precio.",
      effect:function(){ applyAttrDelta("FIS", 3); }},
    {id:"curso_com", cat:"pro", emoji:"🎤", name:"Coach de comunicación", price:650, desc:"+3 Comunicación. Cada vez que lo repitas, el curso sube de precio.",
      effect:function(){ applyAttrDelta("COM", 3); }},
    {id:"curso_tem", cat:"pro", emoji:"🧊", name:"Entrenamiento de sangre fría", price:650, desc:"+3 Sangre fría. Cada vez que lo repitas, el curso sube de precio.",
      effect:function(){ applyAttrDelta("TEM", 3); }},
    {id:"botas_pro", cat:"pro", emoji:"👟", name:"Botas de última generación", price:300, desc:"Capricho barato: +1 a un atributo al azar.",
      effect:function(){ const keys=Object.keys(ATTR_LABELS); applyAttrDelta(pickRandom(keys), 1); }},
    {id:"analista_video", cat:"pro", emoji:"📹", name:"Analista de vídeo personal", price:1050, desc:"+2 en dos atributos al azar, estudiando tus propias jugadas.",
      effect:function(){ const keys=shuffleArr(Object.keys(ATTR_LABELS)); applyAttrDelta(keys[0],2); applyAttrDelta(keys[1],2); }},
    {id:"escudo_error", cat:"pro", emoji:"🛡️", name:"Preparación mental / psicólogo deportivo", price:1500, desc:"La próxima vez que falles una jugada, el golpe a tu media será mucho menor.",
      once:true, effect:function(){ state.perks.errorShieldCharges = (state.perks.errorShieldCharges||0) + 1; }},
    {id:"perro", cat:"personal", emoji:"🐶", name:"Perro", price:350, desc:"Compañía para los días sin partido."},
    {id:"reloj", cat:"personal", emoji:"⌚", name:"Reloj de lujo", price:700, desc:"Un capricho pequeño, pero se nota en el círculo central."},
    {id:"piscina", cat:"personal", emoji:"🏊", name:"Piscina para la casa", price:800, desc:"Para desconectar entre jornada y jornada."},
    {id:"viaje", cat:"personal", emoji:"✈️", name:"Viaje de fin de temporada", price:900, desc:"Te lo has ganado tras tantas jornadas pitando."},
    {id:"coche", cat:"personal", emoji:"🚗", name:"Coche nuevo", price:1150, desc:"Llegar a los estadios con estilo."},
    {id:"casa", cat:"personal", emoji:"🏠", name:"Casa a las afueras", price:1600, desc:"Tu primer gran capricho fuera del campo.", once:true},
    {id:"bodega", cat:"personal", emoji:"🍷", name:"Bodega de vinos", price:1650, desc:"Para las cenas con compañeros de profesión."},
    {id:"oficina", cat:"personal", emoji:"🏢", name:"Oficina / academia de arbitraje", price:2800, desc:"Inviertes en formar a la próxima generación.", once:true},
    {id:"yate", cat:"personal", emoji:"🛥️", name:"Yate", price:3600, desc:"El sueño de todo árbitro con carrera consolidada.", once:true},
    {id:"isla", cat:"personal", emoji:"🏝️", name:"Casa en una isla privada", price:6000, desc:"La cúspide de una carrera arbitral de leyenda.", once:true}
  ];

  function priceFor(it){
    if(it.once) return it.price;
    const count = (state.itemPurchaseCounts && state.itemPurchaseCounts[it.id]) || 0;
    return Math.round((it.price * Math.pow(SHOP_PRICE_GROWTH, count)) / 10) * 10;
  }

  /* ================= ESTADO / PERSISTENCIA ================= */
  const STORAGE_KEY = "coparbi_career_v1";
  const LEADERBOARD_KEY = "coparbi_leaderboard_v1";

  let state = null;
  let selectedLeagueId = null;

  function clampAttr(v){ return Math.max(30, Math.min(99, Math.round(v))); }
  function mediaFromAttrs(a){ return clampAttr((a.PRE+a.AUT+a.FIS+a.COM+a.TEM)/5); }
  function pickRandom(arr){ return arr[Math.floor(Math.random()*arr.length)]; }
  function shuffleArr(arr){ return [...arr].sort(()=>Math.random()-0.5); }

  /* ================= CLASIFICACIÓN DE LA LIGA (sincronizada por jornadas) ================= */
  function blankRecord(){ return {pj:0,pg:0,pe:0,pp:0,gf:0,gc:0,pts:0}; }

  function initStandings(leagueId){
    const league = LEAGUES[leagueId];
    const table = {};
    league.top.forEach(team=> table[team] = blankRecord());
    league.mid.forEach(team=> table[team] = blankRecord());
    return table;
  }

  function isTopTeam(leagueId, team){
    return LEAGUES[leagueId] && LEAGUES[leagueId].top.indexOf(team) !== -1;
  }

  function simResultInto(recA, recB, aIsTop, bIsTop){
    const strength = (isTop)=> isTop ? 1.6 : 1.0;
    const gA = Math.max(0, Math.round((Math.random()*2.6) * strength(aIsTop) - 0.3));
    const gB = Math.max(0, Math.round((Math.random()*2.6) * strength(bIsTop) - 0.3));
    recA.pj++; recB.pj++;
    recA.gf += gA; recA.gc += gB;
    recB.gf += gB; recB.gc += gA;
    if(gA > gB){ recA.pg++; recA.pts += 3; recB.pp++; }
    else if(gB > gA){ recB.pg++; recB.pts += 3; recA.pp++; }
    else { recA.pe++; recB.pe++; recA.pts++; recB.pts++; }
  }

  // Simula de golpe todos los demás partidos de la jornada, para que el resto de
  // equipos de la liga lleguen exactamente a los mismos partidos jugados que el
  // encuentro que estás arbitrando, con los puntos ya actualizados.
  function simulateRestOfMatchday(){
    if(!state.standings) return;
    const others = shuffleArr(Object.keys(state.standings).filter(t=> t!==state.home && t!==state.away));
    for(let i=0;i+1<others.length;i+=2){
      const tA = others[i], tB = others[i+1];
      simResultInto(state.standings[tA], state.standings[tB], isTopTeam(state.leagueId, tA), isTopTeam(state.leagueId, tB));
    }
    // Si el número de equipos es impar, el que sobra descansa esta jornada (como en la vida real).
  }

  function updateStandingsAfterMatch(){
    if(!state.standings) return;
    const h = state.standings[state.home];
    const a = state.standings[state.away];
    if(!h || !a) return;
    h.pj++; a.pj++;
    h.gf += state.homeScore; h.gc += state.awayScore;
    a.gf += state.awayScore; a.gc += state.homeScore;
    if(state.homeScore > state.awayScore){ h.pg++; h.pts += 3; a.pp++; }
    else if(state.homeScore < state.awayScore){ a.pg++; a.pts += 3; h.pp++; }
    else { h.pe++; a.pe++; h.pts++; a.pts++; }
  }

  function renderStandings(){
    const league = LEAGUES[state.leagueId];
    standingsTitle.textContent = `Clasificación · ${league.flag} ${league.name} · Jornada ${state.seasonMatch}`;
    const rows = Object.keys(state.standings).map(team=> Object.assign({team}, state.standings[team]));
    rows.sort((x,y)=> y.pts - x.pts || (y.gf-y.gc) - (x.gf-x.gc) || y.gf - x.gf);
    standingsBody.innerHTML = rows.map((r,i)=>{
      const dg = r.gf - r.gc;
      const playing = (r.team===state.home || r.team===state.away) ? "playing" : "";
      return `<tr class="${playing}"><td>${i+1}</td><td>${r.team}</td><td>${r.pj}</td><td>${r.pg}</td><td>${r.pe}</td><td>${r.pp}</td><td>${r.gf}</td><td>${r.gc}</td><td>${dg>=0?"+":""}${dg}</td><td class="pts">${r.pts}</td></tr>`;
    }).join("");
  }

  function openStandings(){ renderStandings(); standingsOverlay.classList.remove("hidden"); }
  function closeStandings(){ standingsOverlay.classList.add("hidden"); }

  /* ================= EQUIPOS COMPRABLES (sobornos) ================= */
  function pickBribeableTeams(leagueId){
    const mid = LEAGUES[leagueId].mid;
    const n = Math.min(3, mid.length);
    return shuffleArr(mid).slice(0, n);
  }

  /* ================= COLA DE JUGADAS SIN REPETICIÓN ================= */
  function freshIncidentQueue(){
    return shuffleArr(INCIDENT_BANK.map((_,i)=>i));
  }

  function nextIncidentTemplates(n){
    const out = [];
    for(let i=0;i<n;i++){
      if(!state.incidentQueue || state.incidentQueue.length===0){
        state.incidentQueue = freshIncidentQueue();
      }
      out.push(INCIDENT_BANK[state.incidentQueue.pop()]);
    }
    return out;
  }

  function instantiateIncident(tpl){
    let A, B;
    if(tpl.singleTeam){
      A = Math.random()<0.5 ? state.home : state.away;
      B = null;
    } else {
      const attacking = Math.random()<0.5 ? state.home : state.away;
      const defending = attacking===state.home ? state.away : state.home;
      if(tpl.aSide==="att"){ A = attacking; B = defending; }
      else if(tpl.aSide==="def"){ A = defending; B = attacking; }
      else { A = Math.random()<0.5 ? state.home : state.away; B = A===state.home ? state.away : state.home; }
    }
    const fill = (s)=> s ? s.replace(/\{A\}/g, A).replace(/\{B\}/g, B||"") : s;
    return Object.assign({}, tpl, { text: fill(tpl.text), varReveal: fill(tpl.varReveal), teamA:A, teamB:B });
  }

  function pickIncidentsForMatch(n){
    return nextIncidentTemplates(n).map(instantiateIncident);
  }

  /* ================= ESTADO POR DEFECTO ================= */
  function defaultState(leagueId, refName){
    const attrs = {PRE:50, AUT:50, FIS:50, COM:50, TEM:50};
    return {
      leagueId: leagueId,
      refName: (refName && refName.trim()) ? refName.trim().slice(0,24) : "Árbitro anónimo",
      attrs: attrs,
      media: mediaFromAttrs(attrs),
      matchNumber: 1,
      seasonNumber: 1,
      seasonMatch: 0,
      finalsDirected: 0,
      money: 0,
      ownedItems: [],
      itemPurchaseCounts: {},
      perks: { extraTimeMs: 0, varUnlimited: false, errorShieldCharges: 0 },
      bribesThisSeason: 0,
      bribeableTeams: pickBribeableTeams(leagueId),
      pendingBribe: null,
      matchBribeTeam: null,
      home:"", away:"", homeScore:0, awayScore:0, minute:0,
      incidentsThisMatch:[], incidentIndex:0,
      correctCount:0, wrongCount:0,
      mediaChangeThisMatch:0,
      moneyThisMatch:0,
      attrsAtMatchStart:Object.assign({}, attrs),
      standings: initStandings(leagueId),
      incidentQueue: freshIncidentQueue(),
      customLeagues: {},
      playerPool: clonePlayerPool(),
      transferHistory: [],
      lastTransfers: [],
      redCardsThisMatch: {},
      varMaxThisMatch: 1,
      varUsesThisMatch: 0,
      varExtraBoughtThisMatch: false,
      trophies: { world: 0, leagues: {} },
      trophyMsgThisSeason: null
    };
  }

  function ensureStateDefaults(s){
    // Compatibilidad con partidas guardadas de versiones anteriores.
    if(typeof s.money !== "number") s.money = 0;
    if(!Array.isArray(s.ownedItems)) s.ownedItems = [];
    if(!s.itemPurchaseCounts) s.itemPurchaseCounts = {};
    if(!s.perks) s.perks = { extraTimeMs:0, varUnlimited:false, errorShieldCharges:0 };
    if(typeof s.perks.errorShieldCharges !== "number") s.perks.errorShieldCharges = 0;
    if(typeof s.bribesThisSeason !== "number") s.bribesThisSeason = 0;
    if(!Array.isArray(s.bribeableTeams)) s.bribeableTeams = pickBribeableTeams(s.leagueId);
    if(s.pendingBribe === undefined) s.pendingBribe = null;
    if(s.matchBribeTeam === undefined) s.matchBribeTeam = null;
    if(typeof s.seasonNumber !== "number") s.seasonNumber = 1;
    if(typeof s.seasonMatch !== "number") s.seasonMatch = 0;
    if(typeof s.moneyThisMatch !== "number") s.moneyThisMatch = 0;
    if(!s.standings) s.standings = initStandings(s.leagueId);
    if(!Array.isArray(s.incidentQueue)) s.incidentQueue = freshIncidentQueue();
    if(!s.customLeagues) s.customLeagues = {};
    Object.keys(s.customLeagues).forEach(id=>{ if(!LEAGUES[id]) LEAGUES[id] = s.customLeagues[id]; });
    if(!s.playerPool) s.playerPool = clonePlayerPool();
    if(!Array.isArray(s.transferHistory)) s.transferHistory = [];
    if(!Array.isArray(s.lastTransfers)) s.lastTransfers = [];
    if(typeof s.refName !== "string" || !s.refName) s.refName = "Árbitro anónimo";
    if(!s.redCardsThisMatch) s.redCardsThisMatch = {};
    if(typeof s.varMaxThisMatch !== "number") s.varMaxThisMatch = 1;
    if(typeof s.varUsesThisMatch !== "number") s.varUsesThisMatch = 0;
    if(typeof s.varExtraBoughtThisMatch !== "boolean") s.varExtraBoughtThisMatch = false;
    if(!s.trophies) s.trophies = { world: 0, leagues: {} };
    if(typeof s.trophies.world !== "number") s.trophies.world = 0;
    if(!s.trophies.leagues) s.trophies.leagues = {};
    if(s.trophyMsgThisSeason === undefined) s.trophyMsgThisSeason = null;
    return s;
  }

  function saveCareer(){ localStorage.setItem(STORAGE_KEY, JSON.stringify(state)); }
  function loadCareerFromStorage(){
    try{ const raw = localStorage.getItem(STORAGE_KEY); return raw ? ensureStateDefaults(JSON.parse(raw)) : null; }catch(e){ return null; }
  }
  function getLeaderboard(){
    try{ const raw = localStorage.getItem(LEADERBOARD_KEY); return raw ? JSON.parse(raw) : []; }catch(e){ return []; }
  }
  function pushLeaderboard(entry){
    const list = getLeaderboard();
    list.push(entry);
    list.sort((a,b)=>b.media-a.media);
    localStorage.setItem(LEADERBOARD_KEY, JSON.stringify(list.slice(0,8)));
  }

  /* ================= TROFEOS: MEJOR ÁRBITRO DEL MUNDO / DE CADA LIGA ================= */
  // Al cerrar cada temporada, se compara tu media con el resto de árbitros que
  // aparecen en el ranking histórico (otras jornadas ya jugadas, en tu liga o
  // en cualquier otra) para repartir el título de mejor árbitro del mundo y el
  // de mejor árbitro de la liga/competición en la que has terminado.
  function evaluateSeasonTrophies(){
    const lb = getLeaderboard();
    const leagueName = LEAGUES[state.leagueId] ? LEAGUES[state.leagueId].name : "";
    let wonWorld = false, wonLeague = false;

    const rivalsWorld = lb.filter(e=> e.media > state.media);
    if(rivalsWorld.length === 0){
      state.trophies.world = (state.trophies.world||0) + 1;
      wonWorld = true;
    }

    const leagueRivals = lb.filter(e=> e.league === leagueName && e.media > state.media);
    if(leagueRivals.length === 0){
      state.trophies.leagues[leagueName] = (state.trophies.leagues[leagueName]||0) + 1;
      wonLeague = true;
    }

    if(wonWorld && wonLeague){
      return `🏆 ¡Temporadón! Te proclaman <b>Mejor Árbitro del Mundo</b> y <b>Mejor Árbitro de ${leagueName}</b>.`;
    } else if(wonWorld){
      return `🌍 ¡Te proclaman <b>Mejor Árbitro del Mundo</b> esta temporada!`;
    } else if(wonLeague){
      return `🏆 ¡Te proclaman <b>Mejor Árbitro de ${leagueName}</b> esta temporada!`;
    }
    return null;
  }

  /* ================= UTILIDADES DE EQUIPOS ================= */
  function allClubs(field){
    let out = [];
    Object.values(LEAGUES).forEach(l=> out = out.concat(l[field]));
    return out;
  }

  function pickTeamsForStage(pool){
    let source;
    const isCustomLeague = state.leagueId && state.leagueId.indexOf("continental_")===0;
    if(pool==="domestic-mid") source = LEAGUES[state.leagueId].mid;
    else if(pool==="domestic-top"){
      // Los grandes salen con más frecuencia (están "duplicados" en el bombo),
      // pero se combinan con TODA la liga, no solo los dos primeros equipos
      // del listado, para que los partidos varíen mucho de una jornada a otra.
      source = LEAGUES[state.leagueId].top.concat(LEAGUES[state.leagueId].top, LEAGUES[state.leagueId].mid);
    }
    else if(isCustomLeague){
      // Si has fichado por una competición internacional, sus partidos salen de esa
      // misma competición, para que la clasificación siempre cuadre con quien juega.
      source = LEAGUES[state.leagueId].top.concat(LEAGUES[state.leagueId].mid);
    }
    else if(pool==="continental-mid") source = allClubs("mid");
    else source = allClubs("top"); // continental-top y final usan a los grandes de todas las ligas

    // Reintenta varias veces si el sorteo repite exactamente el mismo partido
    // que acabas de arbitrar, para que no te toque siempre el mismo choque.
    let home, away;
    for(let attempt=0; attempt<8; attempt++){
      const shuffled = [...new Set(source)].sort(()=>Math.random()-0.5);
      home = shuffled[0]; away = shuffled[1];
      if(!home || !away) break;
      const isRepeat = state.lastHome && state.lastAway &&
        ((home===state.lastHome && away===state.lastAway) || (home===state.lastAway && away===state.lastHome));
      if(!isRepeat) break;
    }
    return [home, away];
  }

  /* ================= MERCADO DE FICHAJES (fin de temporada) ================= */
  function simulateTransferMarket(){
    const teams = Object.keys(state.playerPool);
    const numTransfers = 4 + Math.floor(Math.random()*5); // entre 4 y 8 fichajes por temporada
    const transfers = [];
    for(let i=0;i<numTransfers;i++){
      const fromCandidates = teams.filter(t=> state.playerPool[t] && state.playerPool[t].length>1);
      if(fromCandidates.length<2) break;
      const fromTeam = pickRandom(fromCandidates);
      const toCandidates = teams.filter(t=> t!==fromTeam);
      const toTeam = pickRandom(toCandidates);
      const idx = Math.floor(Math.random()*state.playerPool[fromTeam].length);
      const player = state.playerPool[fromTeam].splice(idx,1)[0];
      state.playerPool[toTeam].push(player);
      transfers.push({ player, from: fromTeam, to: toTeam, season: state.seasonNumber });
    }
    state.lastTransfers = transfers;
    state.transferHistory = state.transferHistory.concat(transfers);
    if(state.transferHistory.length > 80) state.transferHistory = state.transferHistory.slice(-80);
  }

  function renderSeasonTransfers(){
    const el = document.getElementById("season-transfers");
    if(!el) return;
    if(state.lastTransfers.length===0){
      el.innerHTML = `<span class="patrimonio-empty">Mercado tranquilo: ningún equipo ha movido ficha esta temporada.</span>`;
    } else {
      el.innerHTML = state.lastTransfers.map(t=>
        `<div class="transfer-item"><span class="transfer-player">✍️ ${t.player}</span> ficha por <b>${t.to}</b>, procedente de ${t.from}</div>`
      ).join("");
    }
  }

  function renderTransfersModal(){
    const body = document.getElementById("transfers-body");
    if(!body) return;
    const list = state.transferHistory.slice().reverse();
    if(list.length===0){
      body.innerHTML = `<span class="patrimonio-empty">Todavía no se ha movido ningún fichaje en tu carrera.</span>`;
    } else {
      body.innerHTML = list.map(t=>
        `<div class="transfer-item"><span class="transfer-player">✍️ ${t.player}</span> · ${t.from} → <b>${t.to}</b> <span class="transfer-season">(temporada ${t.season})</span></div>`
      ).join("");
    }
  }

  function buildContinentalLeague(){
    const id = "continental_" + Date.now();
    const topPool = shuffleArr([...new Set(allClubs("top"))]).slice(0, 8);
    const midPool = shuffleArr([...new Set(allClubs("mid"))]).slice(0, 8);
    return {
      id: id,
      def: { name:"Copa de Campeones", country:"Internacional", flag:"🏆", top: topPool, mid: midPool }
    };
  }

  /* ================= REFERENCIAS DOM ================= */
  const screenStart = document.getElementById("screen-start");
  const screenMatch = document.getElementById("screen-match");
  const screenSummary = document.getElementById("screen-summary");
  const screenSeason = document.getElementById("screen-season");

  const btnStartCareer = document.getElementById("btn-start-career");
  const btnContinueCareer = document.getElementById("btn-continue-career");

  const hudCategory = document.getElementById("hud-category");
  const hudMedia = document.getElementById("hud-media");
  const hudAttrs = document.getElementById("hud-attrs");
  const hudMoney = document.getElementById("hud-money");
  const hudMatchNum = document.getElementById("hud-match-num");
  const hudSeasonLeft = document.getElementById("hud-season-left");
  const hudRefName = document.getElementById("hud-ref-name");
  const hudTrophies = document.getElementById("hud-trophies");
  const btnBuyVar = document.getElementById("btn-buy-var");

  const stageBanner = document.getElementById("stage-banner");
  const teamHomeEl = document.getElementById("team-home");
  const teamAwayEl = document.getElementById("team-away");
  const scoreEl = document.getElementById("score");
  const clockEl = document.getElementById("clock");
  const bribeFlagEl = document.getElementById("bribe-flag");

  const incidentTag = document.getElementById("incident-tag");
  const incidentTeamsEl = document.getElementById("incident-teams");
  const incidentText = document.getElementById("incident-text");
  const incidentExtra = document.getElementById("incident-extra");
  const timerTrack = document.getElementById("timer-track");
  const timerFill = document.getElementById("timer-fill");
  const preMatchPanel = document.getElementById("pre-match-panel");
  const btnBeginMatch = document.getElementById("btn-begin-match");
  const optionsGrid = document.getElementById("options-grid");
  const feedbackBanner = document.getElementById("feedback-banner");
  const crowdNote = document.getElementById("crowd-note");
  const btnNextIncident = document.getElementById("btn-next-incident");

  const varReviewPanel = document.getElementById("var-review");
  const varFrameCount = document.getElementById("var-frame-count");
  const varReviewText = document.getElementById("var-review-text");
  const varBtnDone = document.getElementById("var-btn-done");
  const varMarkerA1 = document.getElementById("var-marker-a1");
  const varMarkerA2 = document.getElementById("var-marker-a2");
  const varMarkerB1 = document.getElementById("var-marker-b1");
  const varMarkerB2 = document.getElementById("var-marker-b2");
  const varMarkerBall = document.getElementById("var-marker-ball");
  const varMarkerBallGlow = document.getElementById("var-marker-ball-glow");
  const varOffsideLine = document.getElementById("var-offside-line");
  const varZoneLabel = document.getElementById("var-zone-label");

  const summaryTitle = document.getElementById("summary-title");
  const summarySub = document.getElementById("summary-sub");
  const sumCorrect = document.getElementById("sum-correct");
  const sumWrong = document.getElementById("sum-wrong");
  const sumMediaChange = document.getElementById("sum-media-change");
  const sumMoney = document.getElementById("sum-money");
  const bribeNoteEl = document.getElementById("bribe-note");
  const promoMsg = document.getElementById("promo-msg");
  const finalMsg = document.getElementById("final-msg");
  const btnNextMatch = document.getElementById("btn-next-match");
  const btnQuitCareer = document.getElementById("btn-quit-career");
  const leaderboardList = document.getElementById("leaderboard-list");
  const refCardContainer = document.getElementById("ref-card-container");
  const patrimonioItemsEl = document.getElementById("patrimonio-items");

  const btnStandings = document.getElementById("btn-standings");
  const btnStandingsSummary = document.getElementById("btn-standings-summary");
  const standingsOverlay = document.getElementById("standings-overlay");
  const standingsClose = document.getElementById("standings-close");
  const standingsTitle = document.getElementById("standings-title");
  const standingsBody = document.getElementById("standings-body");

  const btnShop = document.getElementById("btn-shop");
  const btnShopSummary = document.getElementById("btn-shop-summary");
  const shopOverlay = document.getElementById("shop-overlay");
  const shopClose = document.getElementById("shop-close");
  const shopMoneyEl = document.getElementById("shop-money");
  const shopList = document.getElementById("shop-list");
  const shopTabPro = document.getElementById("shop-tab-pro");
  const shopTabPersonal = document.getElementById("shop-tab-personal");

  const btnTransfers = document.getElementById("btn-transfers");
  const btnTransfersSummary = document.getElementById("btn-transfers-summary");
  const transfersOverlay = document.getElementById("transfers-overlay");
  const transfersClose = document.getElementById("transfers-close");

  function openTransfersModal(){ renderTransfersModal(); transfersOverlay.classList.remove("hidden"); }
  function closeTransfersModal(){ transfersOverlay.classList.add("hidden"); }
  btnTransfers.addEventListener("click", openTransfersModal);
  btnTransfersSummary.addEventListener("click", openTransfersModal);
  transfersClose.addEventListener("click", closeTransfersModal);
  transfersOverlay.addEventListener("click", (e)=>{ if(e.target === transfersOverlay) closeTransfersModal(); });
  const btnTransfersSeason = document.getElementById("btn-transfers-season");
  if(btnTransfersSeason) btnTransfersSeason.addEventListener("click", openTransfersModal);

  const bribeOverlay = document.getElementById("bribe-overlay");
  const bribeText = document.getElementById("bribe-text");
  const bribeAmountEl = document.getElementById("bribe-amount");
  const bribeAccept = document.getElementById("bribe-accept");
  const bribeDecline = document.getElementById("bribe-decline");

  const seasonRecapText = document.getElementById("season-recap-text");
  const seasonRecap = document.getElementById("season-recap");
  const offerGrid = document.getElementById("offer-grid");
  const seasonTrophyMsg = document.getElementById("season-trophy-msg");

  /* ================= FICHA DE ÁRBITRO ================= */
  function tierClass(media){
    if(media>=85) return "tier-elite";
    if(media>=75) return "tier-oro";
    if(media>=60) return "tier-plata";
    return "tier-bronce";
  }

  function trophyBadgesHtml(){
    let html = "";
    if(state.trophies.world > 0){
      html += `<span class="trophy-badge">🌍 Mejor del Mundo${state.trophies.world>1?" ×"+state.trophies.world:""}</span>`;
    }
    const league = LEAGUES[state.leagueId];
    const leagueName = league ? league.name : "";
    const leagueCount = (state.trophies.leagues && state.trophies.leagues[leagueName]) || 0;
    if(leagueCount > 0){
      html += `<span class="trophy-badge">🏆 Mejor de ${leagueName}${leagueCount>1?" ×"+leagueCount:""}</span>`;
    }
    return html;
  }

  function renderRefCard(container){
    const league = LEAGUES[state.leagueId];
    const tier = tierClass(state.media);
    container.innerHTML = `
      <div class="ref-card ${tier}">
        <span class="rc-flag">${league.flag}</span>
        <div class="rc-media">${state.media}</div>
        <div class="rc-pos">ÁRBITRO</div>
        <div class="rc-name">${state.refName}</div>
        <div class="rc-league">${league.name}</div>
        <div class="rc-divider"></div>
        <div class="rc-attrs">
          ${Object.keys(ATTR_LABELS).map(k=>`<div>${k} <span class="val">${state.attrs[k]}</span></div>`).join("")}
        </div>
        <div class="rc-trophies">${trophyBadgesHtml()}</div>
      </div>`;
  }

  function renderPatrimonio(){
    const owned = SHOP_ITEMS.filter(it=> it.cat==="personal" && state.ownedItems.indexOf(it.id)!==-1);
    if(owned.length===0){
      patrimonioItemsEl.innerHTML = `<span class="patrimonio-empty">Aún no te has dado ningún capricho. Visita la tienda.</span>`;
    } else {
      patrimonioItemsEl.innerHTML = owned.map(it=> `<span>${it.emoji} ${it.name}</span>`).join("");
    }
  }

  function renderHudAttrs(){
    hudAttrs.innerHTML = Object.keys(ATTR_LABELS).map(k=>
      `<div class="mini-attr"><span class="mv">${state.attrs[k]}</span>${k}</div>`
    ).join("");
  }

  function updateHud(){
    const stage = stageFor(state.media);
    hudCategory.textContent = stage.name;
    hudMedia.textContent = state.media;
    hudMoney.textContent = state.money + "€";
    hudMatchNum.textContent = state.matchNumber;
    hudSeasonLeft.textContent = Math.max(0, SEASON_LENGTH - state.seasonMatch);
    renderHudAttrs();
    if(hudRefName) hudRefName.textContent = state.refName;
    if(hudTrophies) hudTrophies.innerHTML = trophyBadgesHtml();
    stageBanner.textContent = stage.name + " · " + LEAGUES[state.leagueId].flag + " " + LEAGUES[state.leagueId].name + " · Jornada " + state.seasonMatch;
  }

  function redBadgeHtml(team){
    const n = (state.redCardsThisMatch && state.redCardsThisMatch[team]) || 0;
    if(n<=0) return "";
    return `<span class="red-badge">🟥${n>1?n:""}</span>`;
  }

  function renderScoreboard(){
    teamHomeEl.innerHTML = `${state.home}${redBadgeHtml(state.home)}`;
    teamAwayEl.innerHTML = `${state.away}${redBadgeHtml(state.away)}`;
    scoreEl.textContent = `${state.homeScore} – ${state.awayScore}`;
  }

  function updateVarShopButton(){
    if(!btnBuyVar) return;
    if(state.varExtraBoughtThisMatch){
      btnBuyVar.textContent = "🎥 Revisiones VAR extra ya compradas";
      btnBuyVar.disabled = true;
    } else {
      const price = 250;
      btnBuyVar.textContent = `🎥 Comprar 2 revisiones VAR extra · ${price}€`;
      btnBuyVar.disabled = state.money < price;
    }
  }

  /* ================= PANTALLA INICIO ================= */
  let compGridBuilt = false;

  function buildCompGrid(){
    const grid = document.getElementById("comp-grid");
    grid.innerHTML = Object.keys(LEAGUES).map(id=>{
      const l = LEAGUES[id];
      return `<div class="comp-card" data-id="${id}">
        <span class="comp-crest">${l.flag}</span>
        <span class="comp-name">${l.name}</span>
        <span class="comp-region">${l.country}</span>
        <div class="comp-desc">${l.top.length + l.mid.length} equipos en clasificación</div>
      </div>`;
    }).join("");
    grid.querySelectorAll(".comp-card").forEach(card=>{
      card.addEventListener("click", ()=>{
        grid.querySelectorAll(".comp-card").forEach(c=>c.classList.remove("selected"));
        card.classList.add("selected");
        selectedLeagueId = card.dataset.id;
        btnStartCareer.disabled = false;
      });
    });
  }

  function initStartScreen(){
    if(!compGridBuilt){ buildCompGrid(); compGridBuilt = true; }
    const saved = loadCareerFromStorage();
    if(saved){
      btnContinueCareer.classList.remove("hidden");
    } else {
      btnContinueCareer.classList.add("hidden");
    }
  }

  btnStartCareer.addEventListener("click", ()=>{
    if(!selectedLeagueId) return;
    const nameInput = document.getElementById("ref-name-input");
    state = defaultState(selectedLeagueId, nameInput ? nameInput.value : "");
    saveCareer();
    goToMatch();
  });

  btnContinueCareer.addEventListener("click", ()=>{
    const saved = loadCareerFromStorage();
    if(saved){
      state = saved;
      if(state.pendingBribe){
        screenStart.classList.add("hidden");
        screenMatch.classList.remove("hidden");
        updateHud();
        renderScoreboard();
        updateVarShopButton();
        clockEl.textContent = `Min. ${state.minute}'`;
        openBribeModal();
      } else if(state.home && Array.isArray(state.incidentsThisMatch) && state.incidentIndex >= state.incidentsThisMatch.length){
        // La partida se guardó justo después del pitido final (el resumen ya se
        // calculó y el dinero/clasificación ya se aplicaron), así que no hay
        // ninguna jugada pendiente que mostrar: seguimos como si hubieras
        // pulsado "Siguiente partido" para evitar el error de jugada indefinida.
        screenStart.classList.add("hidden");
        if(state.seasonMatch >= SEASON_LENGTH){
          goToSeasonEnd();
        } else {
          state.home = "";
          goToMatch(false);
        }
      } else {
        goToMatch(true);
      }
    }
  });

  btnStandings.addEventListener("click", openStandings);
  btnStandingsSummary.addEventListener("click", openStandings);
  standingsClose.addEventListener("click", closeStandings);
  standingsOverlay.addEventListener("click", (e)=>{ if(e.target === standingsOverlay) closeStandings(); });

  /* ================= TIENDA ================= */
  let shopCat = "pro";
  function openShop(){ renderShop(); shopOverlay.classList.remove("hidden"); }
  function closeShop(){ shopOverlay.classList.add("hidden"); }

  function renderShop(){
    shopMoneyEl.textContent = state.money + "€";
    shopTabPro.classList.toggle("active", shopCat==="pro");
    shopTabPersonal.classList.toggle("active", shopCat==="personal");
    const items = SHOP_ITEMS.filter(it=> it.cat===shopCat);
    shopList.innerHTML = items.map(it=>{
      const owned = state.ownedItems.indexOf(it.id) !== -1;
      const price = priceFor(it);
      const canBuy = !( it.once && owned ) && state.money >= price;
      const btnLabel = (it.once && owned) ? "Adquirido" : `Comprar · ${price}€`;
      return `<div class="shop-item ${owned && it.once ? "owned":""}" data-id="${it.id}">
        <div class="emoji">${it.emoji}</div>
        <div class="info"><div class="name">${it.name}</div><div class="desc">${it.desc}</div></div>
        <button class="buy-btn" data-id="${it.id}" ${(!canBuy)?"disabled":""}>${btnLabel}</button>
      </div>`;
    }).join("");
    shopList.querySelectorAll(".buy-btn").forEach(btn=>{
      btn.addEventListener("click", ()=> buyItem(btn.dataset.id));
    });
  }

  function buyItem(id){
    const it = SHOP_ITEMS.find(x=>x.id===id);
    if(!it) return;
    if(it.once && state.ownedItems.indexOf(id)!==-1) return;
    const price = priceFor(it);
    if(state.money < price) return;
    state.money -= price;
    state.ownedItems.push(id);
    if(!state.itemPurchaseCounts) state.itemPurchaseCounts = {};
    state.itemPurchaseCounts[id] = (state.itemPurchaseCounts[id]||0) + 1;
    if(it.effect) it.effect();
    state.media = mediaFromAttrs(state.attrs);
    saveCareer();
    renderShop();
    updateHud();
  }

  shopTabPro.addEventListener("click", ()=>{ shopCat="pro"; renderShop(); });
  shopTabPersonal.addEventListener("click", ()=>{ shopCat="personal"; renderShop(); });
  btnShop.addEventListener("click", openShop);
  btnShopSummary.addEventListener("click", openShop);
  shopClose.addEventListener("click", closeShop);
  shopOverlay.addEventListener("click", (e)=>{ if(e.target === shopOverlay) closeShop(); });

  /* ================= COMPRA DE REVISIONES VAR EXTRA (por partido) ================= */
  function buyVarExtra(){
    const price = 250;
    if(state.varExtraBoughtThisMatch || state.money < price) return;
    state.money -= price;
    state.varMaxThisMatch += 2;
    state.varExtraBoughtThisMatch = true;
    updateHud();
    updateVarShopButton();
    // Si hay una jugada activa esperando decisión, refresca el botón de VAR con el nuevo cupo.
    if(currentIncident && !decisionMade && !varInProgress) renderOptions();
    saveCareer();
  }
  if(btnBuyVar) btnBuyVar.addEventListener("click", buyVarExtra);

  /* ================= SOBORNOS ================= */
  function maybeTriggerBribe(){
    state.matchBribeTeam = null;
    state.pendingBribe = null;
    if(state.bribesThisSeason >= BRIBE_LIMIT) return;
    const candidates = [state.home, state.away].filter(t=> state.bribeableTeams.indexOf(t) !== -1);
    if(candidates.length===0) return;
    if(Math.random() < 0.35){
      const team = pickRandom(candidates);
      const amount = Math.round((300 + Math.random()*600)/10)*10;
      state.pendingBribe = { team, amount };
    }
  }

  function openBribeModal(){
    const b = state.pendingBribe;
    if(!b) return;
    bribeText.textContent = `${b.team} se pone en contacto contigo antes del partido. Te ofrecen dinero para que les favorezcas hoy. ¿Qué haces?`;
    bribeAmountEl.textContent = b.amount + "€";
    bribeOverlay.classList.remove("hidden");
  }
  function closeBribeModal(){ bribeOverlay.classList.add("hidden"); }

  function resolveBribe(accepted){
    const b = state.pendingBribe;
    if(!b) return;
    if(accepted){
      state.money += b.amount;
      state.bribesThisSeason++;
      state.matchBribeTeam = b.team;
    } else {
      state.matchBribeTeam = null;
    }
    state.pendingBribe = null;
    updateHud();
    bribeFlagEl.textContent = state.matchBribeTeam ? `🤝 Has cobrado de ${state.matchBribeTeam} en este partido.` : "";
    saveCareer();
    closeBribeModal();
    startMatchOrShowIntro();
  }
  bribeAccept.addEventListener("click", ()=> resolveBribe(true));
  bribeDecline.addEventListener("click", ()=> resolveBribe(false));

  /* ================= FLUJO DE PARTIDO ================= */
  function goToMatch(resuming){
    screenStart.classList.add("hidden");
    screenSummary.classList.add("hidden");
    screenSeason.classList.add("hidden");
    screenMatch.classList.remove("hidden");

    if(!resuming || !state.home){
      const stage = stageFor(state.media);
      const [h,a] = pickTeamsForStage(stage.pool);
      state.home = h; state.away = a;
      state.lastHome = h; state.lastAway = a;
      state.homeScore = 0;
      state.awayScore = 0;
      state.minute = 0;
      state.incidentsThisMatch = pickIncidentsForMatch(stage.pool==="final" ? 6 : 5);
      state.incidentIndex = 0;
      state.correctCount = 0;
      state.wrongCount = 0;
      state.mediaChangeThisMatch = 0;
      state.moneyThisMatch = 0;
      state.attrsAtMatchStart = Object.assign({}, state.attrs);
      if(stage.pool==="final") state.finalsDirected++;
      state.redCardsThisMatch = {};
      state.varMaxThisMatch = 1;
      state.varUsesThisMatch = 0;
      state.varExtraBoughtThisMatch = false;
      maybeTriggerBribe();
    }

    updateHud();
    renderScoreboard();
    updateVarShopButton();
    clockEl.textContent = `Min. ${state.minute}'`;
    bribeFlagEl.textContent = state.matchBribeTeam ? `🤝 Has cobrado de ${state.matchBribeTeam} en este partido.` : "";

    saveCareer();

    if(state.pendingBribe){
      openBribeModal();
    } else {
      startMatchOrShowIntro();
    }
  }

  // Antes de la primera jugada de cada partido, se muestra un aviso con un
  // botón explícito para "salir al campo" y arrancar el encuentro. Si se
  // retoma una carrera guardada a mitad de partido, se salta directamente
  // a la jugada en curso.
  function startMatchOrShowIntro(){
    if(state.incidentIndex === 0){
      showPreMatchPanel();
    } else {
      renderIncident();
    }
  }

  function showPreMatchPanel(){
    stopVarAutoplay();
    clearInterval(timerInterval);
    varReviewPanel.classList.add("hidden");
    optionsGrid.classList.add("hidden");
    timerTrack.classList.add("hidden");
    incidentExtra.classList.remove("show");
    incidentExtra.textContent = "";
    feedbackBanner.className = "feedback-banner";
    feedbackBanner.innerHTML = "";
    crowdNote.textContent = "";
    btnNextIncident.classList.add("hidden");
    incidentTag.textContent = "A PUNTO DE EMPEZAR";
    incidentTeamsEl.innerHTML =
      `<span class="team-chip offender">🏟️ ${state.home}</span>` +
      `<span class="team-chip affected">🆚 ${state.away}</span>`;
    incidentText.textContent = `Te toca dirigir ${state.home} - ${state.away}. Cuando estés listo, sal al campo y arranca el partido.`;
    preMatchPanel.classList.remove("hidden");
  }

  btnBeginMatch.addEventListener("click", ()=>{
    preMatchPanel.classList.add("hidden");
    renderIncident();
  });

  let currentIncident = null;
  let decisionMade = false;
  let varUsed = false;
  let varInProgress = false;
  let varRevealedCorrect = false;
  let timerInterval = null;
  let timerDuration = 0;
  let timerStartTs = 0;
  let timerPaused = false;
  let timerRemainingMs = 0;
  let varFrames = [];
  let varFrameIndex = 0;
  let varPlaying = false;
  let varPlayInterval = null;
  let currentScenePositions = null;

  function renderIncident(){
    decisionMade = false;
    varUsed = false;
    varInProgress = false;
    varRevealedCorrect = false;
    stopVarAutoplay();
    varReviewPanel.classList.add("hidden");
    optionsGrid.classList.remove("hidden");
    preMatchPanel.classList.add("hidden");
    currentIncident = state.incidentsThisMatch[state.incidentIndex];

    incidentTag.textContent = currentIncident.tag;
    incidentText.textContent = currentIncident.text;

    if(currentIncident.singleTeam){
      incidentTeamsEl.innerHTML = `<span class="team-chip offender">🎽 Equipo implicado: ${currentIncident.teamA}</span>`;
    } else {
      incidentTeamsEl.innerHTML =
        `<span class="team-chip offender">⚠️ Posible sanción: ${currentIncident.teamA}</span>` +
        `<span class="team-chip affected">🛡️ Equipo afectado: ${currentIncident.teamB}</span>`;
    }

    incidentExtra.classList.remove("show");
    incidentExtra.textContent = "";
    feedbackBanner.className = "feedback-banner";
    feedbackBanner.innerHTML = "";
    crowdNote.textContent = "";
    btnNextIncident.classList.add("hidden");

    renderOptions();
  }

  function renderOptions(){
    optionsGrid.innerHTML = "";
    // Tras revisar el VAR solo se muestra la opción correcta.
    const visibleOptions = varRevealedCorrect ? [currentIncident.correct] : currentIncident.options;
    visibleOptions.forEach(optId=>{
      const btn = document.createElement("button");
      btn.className = "opt-btn" + (varRevealedCorrect ? " opt-correct" : "");
      btn.dataset.opt = optId;
      let swatchHtml = SWATCH[optId] ? `<span class="swatch" style="background:${SWATCH[optId]}"></span>` : "";
      btn.innerHTML = swatchHtml + INCIDENT_LABELS[optId];
      btn.addEventListener("click", ()=> decide(optId));
      optionsGrid.appendChild(btn);
    });
    if(currentIncident.varReveal && !varRevealedCorrect){
      const remaining = Math.max(0, (state.varMaxThisMatch||1) - (state.varUsesThisMatch||0));
      const varBtn = document.createElement("button");
      varBtn.className = "opt-btn var-btn";
      varBtn.id = "var-call-btn";
      if(remaining > 0){
        varBtn.textContent = `📺 Revisar la jugada en el VAR (quedan ${remaining} este partido)`;
      } else {
        varBtn.textContent = "📺 VAR agotado para este partido";
        varBtn.disabled = true;
      }
      varBtn.addEventListener("click", openVarReview);
      optionsGrid.appendChild(varBtn);
    }
  }

  /* ---- Revisión interactiva del VAR: fluida y con más jugadores en pantalla ---- */
  const VAR_MICRO_STEPS = 5; // fotogramas intermedios por frase, para que el rebobinado sea fluido, no por fases bruscas

  function buildVarFrames(){
    const frames = [{ label:"Jugada en directo", text: currentIncident.text }];
    const sentences = (currentIncident.varReveal.match(/[^.!?]+[.!?]*/g) || [currentIncident.varReveal])
      .map(s=> s.trim()).filter(Boolean);
    sentences.forEach((s,i)=>{
      for(let m=0;m<VAR_MICRO_STEPS;m++){
        frames.push({ label:`Repetición · ángulo ${i+1}`, text: s });
      }
    });
    frames.push({ label:"Vuelta al campo", text:"Ya has visto toda la repetición. Es tu turno de decidir." });
    return frames;
  }

  function openVarReview(){
    const remaining = Math.max(0, (state.varMaxThisMatch||1) - (state.varUsesThisMatch||0));
    if(remaining <= 0 || varUsed || varInProgress || decisionMade) return;
    varUsed = true;
    varInProgress = true;
    state.varUsesThisMatch = (state.varUsesThisMatch||0) + 1;
    saveCareer();
    pauseTimerForVar();

    const varBtn = document.getElementById("var-call-btn");
    if(varBtn){ varBtn.disabled = true; varBtn.textContent = "📺 Revisando..."; }

    varFrames = buildVarFrames();
    varFrameIndex = 0;

    const scene = SCENE_BY_TAG[currentIncident.tag] || "midfield";
    const goalSide = Math.random() < 0.5 ? "left" : "right";
    const flankTop = Math.random() < 0.5;
    currentScenePositions = getScenePositions(scene, goalSide, flankTop);
    varZoneLabel.textContent = ZONE_LABELS[scene] || "Zona: Medio campo";

    optionsGrid.classList.add("hidden");
    varReviewPanel.classList.remove("hidden");
    crowdNote.textContent = VAR_WATCH_NOTE;
    renderVarFrame();
    startVarAutoplay();
  }

  function renderVarFrame(){
    const frame = varFrames[varFrameIndex];
    varFrameCount.textContent = `Fotograma ${varFrameIndex+1}/${varFrames.length} · ${frame.label}`;
    varReviewText.textContent = frame.text;

    // Movimiento de los jugadores y el balón según la escena real de la
    // jugada (córner, área, fuera de juego...), no de forma genérica: el
    // balón siempre viaja hacia el punto exacto donde ocurre la acción,
    // en vez de flotar sin sentido por el campo.
    const t = varFrames.length > 1 ? varFrameIndex / (varFrames.length - 1) : 0;
    const sc = currentScenePositions;
    const jitter = (seed)=> Math.sin(t*Math.PI*3 + seed) * 2.2; // ligero balanceo, sin desplazar la escena
    const lerp = (p, seed)=>({
      x: p.x0 + (p.x1 - p.x0)*t + jitter(seed),
      y: p.y0 + (p.y1 - p.y0)*t + jitter(seed+1.4)
    });

    const pa1 = lerp(sc.a1, 0), pa2 = lerp(sc.a2, 1), pb1 = lerp(sc.b1, 2), pb2 = lerp(sc.b2, 3);
    const pball = { x: sc.ball.x0 + (sc.ball.x1 - sc.ball.x0)*t, y: sc.ball.y0 + (sc.ball.y1 - sc.ball.y0)*t };

    varMarkerA1.setAttribute("cx", pa1.x); varMarkerA1.setAttribute("cy", pa1.y);
    varMarkerA2.setAttribute("cx", pa2.x); varMarkerA2.setAttribute("cy", pa2.y);
    varMarkerB1.setAttribute("cx", pb1.x); varMarkerB1.setAttribute("cy", pb1.y);
    varMarkerB2.setAttribute("cx", pb2.x); varMarkerB2.setAttribute("cy", pb2.y);
    varMarkerBall.setAttribute("cx", pball.x); varMarkerBall.setAttribute("cy", pball.y);
    varMarkerBallGlow.setAttribute("cx", pball.x); varMarkerBallGlow.setAttribute("cy", pball.y);

    if(sc.showOffsideLine){
      varOffsideLine.setAttribute("x1", sc.offsideXEnd);
      varOffsideLine.setAttribute("x2", sc.offsideXEnd);
      varOffsideLine.setAttribute("opacity", "1");
    } else {
      varOffsideLine.setAttribute("opacity", "0");
    }
  }

  function stopVarAutoplay(){
    varPlaying = false;
    clearInterval(varPlayInterval);
  }

  // La repetición avanza sola, sin controles: el árbitro solo mira y decide.
  function startVarAutoplay(){
    stopVarAutoplay();
    varPlaying = true;
    varPlayInterval = setInterval(()=>{
      if(varFrameIndex >= varFrames.length-1){ stopVarAutoplay(); return; }
      varFrameIndex++;
      renderVarFrame();
    }, 600);
  }

  varBtnDone.addEventListener("click", ()=>{
    stopVarAutoplay();
    varInProgress = false;
    varReviewPanel.classList.add("hidden");
    varRevealedCorrect = true;
    optionsGrid.classList.remove("hidden");
    renderOptions();
    incidentExtra.innerHTML = `El VAR te da la decisión correcta: <b>${INCIDENT_LABELS[currentIncident.correct]}</b>.`;
    incidentExtra.classList.add("show");
    crowdNote.textContent = "";
    resumeTimerAfterVar();
  });

  // El árbitro ya no tiene límite de tiempo para decidir: se ha retirado el
  // reloj de decisión. Estas funciones se mantienen como no-op para no romper
  // las llamadas que aún hace la revisión del VAR.
  function startTimer(difficulty){
    clearInterval(timerInterval);
    timerTrack.classList.add("hidden");
  }

  function pauseTimerForVar(){}

  function resumeTimerAfterVar(){}

  function applyAttrDelta(attrKey, delta){
    state.attrs[attrKey] = clampAttr(state.attrs[attrKey] + delta);
  }

  function awardGoal(team){
    if(!team) return;
    if(team === state.home) state.homeScore++;
    else if(team === state.away) state.awayScore++;
    else return;
    renderScoreboard();
  }

  function addRedCard(team){
    if(!team) return;
    if(!state.redCardsThisMatch) state.redCardsThisMatch = {};
    state.redCardsThisMatch[team] = (state.redCardsThisMatch[team]||0) + 1;
    renderScoreboard();
  }

  function decide(chosenId){
    if(decisionMade) return;
    decisionMade = true;
    clearInterval(timerInterval);

    optionsGrid.querySelectorAll("button").forEach(b=> b.disabled = true);

    const correctId = currentIncident.correct;
    const isCorrect = (chosenId === correctId);
    const mainAttr = currentIncident.attr;
    let deltaText = "";

    const mediaBefore = state.media;

    if(chosenId === null){
      feedbackBanner.classList.add("wrong","show");
      feedbackBanner.innerHTML = "⏱️ Se te pasó el tiempo. Un buen árbitro nunca deja pasar el reloj sin decidir.";
      applyAttrDelta("TEM", -4);
      applyAttrDelta("FIS", -2);
      state.wrongCount++;
      deltaText = "Sangre fría -4 · Físico -2";
    } else if(isCorrect){
      feedbackBanner.classList.add("correct","show");
      feedbackBanner.innerHTML = "✅ Decisión correcta. " + (varUsed ? "El VAR confirma tu criterio final." : "Buena lectura de la jugada.");
      applyAttrDelta(mainAttr, varUsed ? 1 : 2);
      applyAttrDelta("TEM", currentIncident.difficulty===3 ? 2 : 1);
      state.correctCount++;
      deltaText = `${ATTR_LABELS[mainAttr]} +${varUsed?1:2} · Sangre fría +${currentIncident.difficulty===3?2:1}`;
    } else {
      feedbackBanner.classList.add("wrong","show");
      const shielded = state.perks && state.perks.errorShieldCharges > 0;
      if(shielded){
        state.perks.errorShieldCharges--;
        feedbackBanner.innerHTML = "❌ Decisión errónea, pero tu preparación mental amortigua el golpe.";
        applyAttrDelta(mainAttr, -1);
        state.wrongCount++;
        deltaText = `${ATTR_LABELS[mainAttr]} -1 (protegido)`;
      } else {
        feedbackBanner.innerHTML = "❌ Decisión errónea. La jugada mereció otra lectura.";
        applyAttrDelta(mainAttr, -3);
        applyAttrDelta("TEM", -1);
        state.wrongCount++;
        deltaText = `${ATTR_LABELS[mainAttr]} -3 · Sangre fría -1`;
      }
    }

    state.media = mediaFromAttrs(state.attrs);
    state.mediaChangeThisMatch += (state.media - mediaBefore);
    feedbackBanner.innerHTML += `<div class="attr-delta"><b>${deltaText}</b></div>`;

    // El gol solo sube al marcador si tu decisión es la que deja la jugada como gol válido.
    if(currentIncident.goalOption && chosenId === currentIncident.goalOption){
      const scoringTeam = currentIncident.teamA;
      awardGoal(scoringTeam);
      feedbackBanner.innerHTML += `<div class="attr-delta">⚽ <b>¡GOL para ${scoringTeam}! Marcador actualizado.</b></div>`;
    }
    // La tarjeta roja se refleja de inmediato junto al nombre del equipo en el marcador.
    if(chosenId === "roja"){
      addRedCard(currentIncident.teamA);
      feedbackBanner.innerHTML += `<div class="attr-delta">🟥 <b>Expulsión para ${currentIncident.teamA}.</b></div>`;
    }
    // Si señalas un penalti, se lanza en el momento: 70% de gol, 30% de fallo.
    if(chosenId === "penalti" && currentIncident.teamB){
      const penaltyTeam = currentIncident.teamB;
      const scored = Math.random() < 0.7;
      if(scored){
        awardGoal(penaltyTeam);
        feedbackBanner.innerHTML += `<div class="attr-delta">🥅 <b>¡Penalti transformado! Gol para ${penaltyTeam}.</b></div>`;
      } else {
        feedbackBanner.innerHTML += `<div class="attr-delta">🧤 <b>Penalti fallado por ${penaltyTeam}. El marcador no se mueve.</b></div>`;
      }
    }

    updateHud();
    crowdNote.textContent = (isCorrect && chosenId!==null) ? pickRandom(CROWD_CORRECT) : pickRandom(CROWD_WRONG);
    btnNextIncident.classList.remove("hidden");
    saveCareer();
  }

  btnNextIncident.addEventListener("click", ()=>{
    state.incidentIndex++;
    // Cada jugada avanza el reloj entre 8 y 20 minutos.
    state.minute = Math.min(90, state.minute + Math.floor(Math.random()*13)+8);
    clockEl.textContent = `Min. ${state.minute}'`;

    if(state.minute >= 90){
      // El partido termina en cuanto el reloj llega al minuto 90.
      goToSummary();
    } else {
      // Si se agotan las jugadas preparadas antes de llegar al 90',
      // se genera una jugada más para seguir arbitrando hasta el final.
      if(state.incidentIndex >= state.incidentsThisMatch.length){
        state.incidentsThisMatch = state.incidentsThisMatch.concat(pickIncidentsForMatch(1));
      }
      renderIncident();
    }
  });

  /* ================= RESUMEN ================= */
  function goToSummary(){
    screenMatch.classList.add("hidden");
    screenSummary.classList.remove("hidden");

    simulateRestOfMatchday();
    updateStandingsAfterMatch();

    const stageBefore = stageFor(mediaFromAttrs(state.attrsAtMatchStart));
    const stageAfter = stageFor(state.media);

    const earned = Math.max(20, 150 + state.correctCount*40 - state.wrongCount*20);
    state.moneyThisMatch = earned;
    state.money += earned;

    summaryTitle.textContent = "Pitido final";
    summarySub.textContent = `${state.home} ${state.homeScore} – ${state.awayScore} ${state.away}`;
    sumCorrect.textContent = state.correctCount;
    sumWrong.textContent = state.wrongCount;
    sumMediaChange.textContent = (state.mediaChangeThisMatch>=0?"+":"") + state.mediaChangeThisMatch;
    sumMoney.textContent = "+" + earned + "€";

    if(state.matchBribeTeam){
      bribeNoteEl.classList.remove("hidden");
      bribeNoteEl.textContent = `🤝 Cobraste de ${state.matchBribeTeam} en este partido. Nadie ha protestado... por ahora.`;
    } else {
      bribeNoteEl.classList.add("hidden");
    }

    if(stageAfter.pool === "final"){
      finalMsg.classList.remove("hidden");
      finalMsg.textContent = `🏆 ¡Has dirigido la gran final continental! Finales dirigidas: ${state.finalsDirected}.`;
    } else {
      finalMsg.classList.add("hidden");
    }

    if(stageAfter.name !== stageBefore.name){
      const idxNew = STAGES.findIndex(s=>s.name===stageAfter.name);
      const idxOld = STAGES.findIndex(s=>s.name===stageBefore.name);
      if(idxNew > idxOld){
        promoMsg.textContent = `🎉 ¡Ascenso! Ahora diriges en: ${stageAfter.name}.`;
      } else {
        promoMsg.textContent = `⚠️ Bajas de nivel. Ahora diriges en: ${stageAfter.name}.`;
      }
      promoMsg.style.display = "block";
    } else {
      promoMsg.style.display = "none";
    }

    state.matchNumber++;
    state.seasonMatch++;
    state.matchBribeTeam = null;
    saveCareer();

    renderRefCard(refCardContainer);
    renderPatrimonio();

    pushLeaderboard({
      name: `Árbitro #${Math.floor(Math.random()*900+100)}`,
      media: state.media,
      league: LEAGUES[state.leagueId].name,
      stage: stageAfter.name
    });
    renderLeaderboard();

    if(state.seasonMatch >= SEASON_LENGTH){
      // La pantalla de fin de temporada se muestra al pulsar "Siguiente partido".
      btnNextMatch.textContent = "Ver fin de temporada";
    } else {
      btnNextMatch.textContent = "Siguiente partido";
    }
  }

  function renderLeaderboard(){
    const list = getLeaderboard();
    leaderboardList.innerHTML = "";
    if(list.length===0){
      leaderboardList.innerHTML = "<li>Aún no hay partidos registrados.</li>";
      return;
    }
    list.forEach(entry=>{
      const li = document.createElement("li");
      li.innerHTML = `<span>${entry.name} · ${entry.stage}</span><span class="pts">${entry.media}</span>`;
      leaderboardList.appendChild(li);
    });
  }

  btnNextMatch.addEventListener("click", ()=>{
    if(state.seasonMatch >= SEASON_LENGTH){
      goToSeasonEnd();
    } else {
      state.home = "";
      goToMatch(false);
    }
  });

  btnQuitCareer.addEventListener("click", ()=>{
    screenSummary.classList.add("hidden");
    screenMatch.classList.add("hidden");
    screenSeason.classList.add("hidden");
    screenStart.classList.remove("hidden");
    selectedLeagueId = null;
    btnStartCareer.disabled = true;
    initStartScreen();
  });

  /* ================= FIN DE TEMPORADA / FICHAJES ================= */
  function buildSeasonOffers(){
    const currentId = state.leagueId;
    const otherIds = shuffleArr(Object.keys(LEAGUES).filter(id=> id!==currentId && !id.startsWith("continental_")));
    const offers = [];

    offers.push({ type:"stay", id: currentId, league: LEAGUES[currentId],
      desc: "Sigues una temporada más en la misma liga, para consolidar tu nombre." });

    otherIds.slice(0,2).forEach(id=>{
      offers.push({ type:"league", id, league: LEAGUES[id],
        desc: `Fichas por ${LEAGUES[id].name} para la próxima temporada.` });
    });

    if(state.media >= 70){
      const cont = buildContinentalLeague();
      offers.push({ type:"continental", id: cont.id, league: cont.def,
        desc: "Tu media te abre las puertas de una competición internacional con los grandes de varias ligas." });
    }

    return shuffleArr(offers);
  }

  function goToSeasonEnd(){
    screenSummary.classList.add("hidden");
    screenSeason.classList.remove("hidden");

    simulateTransferMarket();

    const trophyMsg = evaluateSeasonTrophies();
    if(trophyMsg){
      seasonTrophyMsg.innerHTML = trophyMsg;
      seasonTrophyMsg.classList.remove("hidden");
    } else {
      seasonTrophyMsg.classList.add("hidden");
    }

    saveCareer();
    renderSeasonTransfers();

    seasonRecapText.textContent = `Cierras tu temporada ${state.seasonNumber} en ${LEAGUES[state.leagueId].name} con una media de ${state.media}. Elige tu próximo destino.`;
    seasonRecap.innerHTML = `
      <div class="summary-stat"><span class="num">${state.matchNumber-1}</span><span class="lbl">PARTIDOS TOTALES</span></div>
      <div class="summary-stat"><span class="num money">${state.money}€</span><span class="lbl">DINERO ACUMULADO</span></div>
      <div class="summary-stat"><span class="num">${state.media}</span><span class="lbl">MEDIA ACTUAL</span></div>
    `;

    const offers = buildSeasonOffers();
    offerGrid.innerHTML = offers.map((o,i)=>{
      const kindLabel = o.type==="stay" ? "Te quedas" : o.type==="continental" ? "Competición internacional" : "Nueva liga";
      return `<div class="offer-card" data-idx="${i}">
        <div class="offer-kind">${kindLabel}</div>
        <div class="offer-name">${o.league.flag} ${o.league.name}</div>
        <div class="offer-desc">${o.desc}</div>
      </div>`;
    }).join("");

    offerGrid.querySelectorAll(".offer-card").forEach(card=>{
      card.addEventListener("click", ()=> chooseSeasonOffer(offers[parseInt(card.dataset.idx,10)]));
    });
  }

  function chooseSeasonOffer(offer){
    if(offer.type === "continental"){
      LEAGUES[offer.id] = offer.league;
      state.customLeagues[offer.id] = offer.league;
    }
    state.leagueId = offer.id;
    state.seasonMatch = 0;
    state.seasonNumber++;
    state.standings = initStandings(offer.id);
    state.bribeableTeams = pickBribeableTeams(offer.id);
    state.bribesThisSeason = 0;
    state.home = "";
    saveCareer();
    goToMatch(false);
  }

  /* ================= ARRANQUE ================= */
  document.getElementById("credit-year").textContent = new Date().getFullYear();
  initStartScreen();

})();
</script>
</body>
</html>
