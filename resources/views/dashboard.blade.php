<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>INRA Settat — Surveillance IoT</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root {
  --bg:#f0f4f8;--surface:#ffffff;--surface2:#f8fafc;--border:#e2e8f0;
  --accent:#00d4aa;--accent2:#0090ff;--warn:#ff6b35;--danger:#ff3355;
  --brown:#8B4513;
  --text:#1a202c;--text2:#4a5568;--text3:#a0aec0;
  --mono:'Space Mono',monospace;--sans:'DM Sans',sans-serif;--radius:14px;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{background:var(--bg);color:var(--text);font-family:var(--sans);min-height:100vh;overflow-x:hidden;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,180,140,0.06) 1px,transparent 1px),linear-gradient(90deg,rgba(0,180,140,0.06) 1px,transparent 1px);background-size:48px 48px;pointer-events:none;z-index:0;}
.wrapper{position:relative;z-index:1;max-width:1500px;margin:0 auto;padding:24px 32px;}

/* HEADER */
header{
  display:flex;align-items:center;justify-content:space-between;
  padding:22px 32px;
  background:radial-gradient(circle at top right,rgba(255,122,0,0.22),transparent 26%),
    linear-gradient(135deg,rgba(8,95,43,0.98),rgba(14,125,62,0.96) 48%,rgba(250,250,250,0.96) 49%,rgba(248,250,252,0.98));
  border:1px solid rgba(10,99,46,0.18);border-radius:var(--radius);
  margin-bottom:20px;position:relative;overflow:hidden;
  box-shadow:0 18px 40px rgba(15,23,42,0.08);
}
header::before{content:'';position:absolute;inset:0;background:linear-gradient(120deg,rgba(255,255,255,0.08),transparent 30%),repeating-linear-gradient(105deg,rgba(255,255,255,0.06) 0 2px,transparent 2px 28px);pointer-events:none;}
header::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,rgba(8,95,43,0.8),rgba(255,122,0,0.8),rgba(8,95,43,0.8));}
.logo-area{display:flex;align-items:center;gap:18px;}
.logo-badge{width:78px;height:78px;background:rgba(255,255,255,0.96);border-radius:16px;display:flex;align-items:center;justify-content:center;padding:8px;box-shadow:0 12px 30px rgba(8,95,43,0.16);font-family:var(--mono);font-size:11px;font-weight:700;color:#08602b;text-align:center;line-height:1.3;}
.logo-text h1{font-size:20px;font-weight:700;color:#fff;letter-spacing:-0.3px;}
.logo-text p{font-size:11px;color:rgba(255,255,255,0.88);font-family:var(--mono);margin-top:3px;letter-spacing:0.04em;}
.header-right{display:flex;align-items:center;gap:16px;}
.status-pill{display:flex;align-items:center;gap:8px;padding:8px 18px;background:rgba(8,95,43,0.78);border:1px solid rgba(255,255,255,0.2);border-radius:100px;font-size:11px;font-family:var(--mono);color:#d8ffe9;letter-spacing:0.06em;}
.status-dot{width:7px;height:7px;border-radius:50%;background:#7df2b2;animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.4;transform:scale(0.7);}}
.time-display{font-family:var(--mono);font-size:13px;color:#fff;letter-spacing:0.05em;}

/* NAV */
.nav-bar{display:flex;gap:10px;margin-bottom:20px;}
.nav-btn{padding:10px 24px;border-radius:10px;font-family:var(--mono);font-size:11px;font-weight:700;text-decoration:none;letter-spacing:0.06em;transition:all 0.2s;border:2px solid;}
.nav-btn.wm{background:#00d4aa;color:#000;border-color:#00d4aa;}
.nav-btn.wm:hover{opacity:0.9;}
.nav-btn.el{background:transparent;color:#0090ff;border-color:#0090ff;}
.nav-btn.el:hover{background:rgba(0,144,255,0.1);}

/* STATS BAND */
.stats-band{display:grid;grid-template-columns:repeat(8,1fr);gap:12px;margin-bottom:20px;}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;position:relative;overflow:hidden;transition:border-color 0.3s,transform 0.2s;}
.stat-card:hover{border-color:rgba(0,212,170,0.4);transform:translateY(-2px);}
.stat-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--brown),transparent);opacity:0.6;}
.stat-label{font-size:9px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;}
.stat-value{font-size:22px;font-family:var(--mono);font-weight:700;color:var(--brown);line-height:1;}
.stat-unit{font-size:10px;color:var(--text2);font-family:var(--mono);margin-top:4px;}
.stat-card.special::after{background:linear-gradient(90deg,var(--accent),transparent);}
.stat-card.special .stat-value{color:var(--text);}

/* SECTION TITLE */
.section-title{font-size:10px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.12em;margin-bottom:14px;}

/* ALERTS */
.alerts-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:20px;}
.alerts-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:12px;}
.alert-item{display:flex;align-items:flex-start;gap:8px;padding:10px;border:1px solid var(--border);border-radius:8px;}
.adot{width:7px;height:7px;border-radius:50%;margin-top:4px;flex-shrink:0;}
.adot.ok{background:var(--accent);}
.adot.warn{background:var(--warn);animation:pulse 1.5s infinite;}
.adot.danger{background:var(--danger);animation:pulse 0.8s infinite;}
.alert-text{color:var(--text2);font-size:10px;line-height:1.5;}
.alert-time{font-family:var(--mono);font-size:9px;color:var(--text3);margin-top:2px;}

/* WATERMARK SECTION */
.wm-section{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px;margin-bottom:20px;}

/* 6 GAUGES */
.wm-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;}
.wm-card{background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;flex-direction:column;align-items:center;position:relative;overflow:hidden;}
.wm-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--brown),#d4a373);}
.wm-name{font-size:9px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:12px;}
.wm-gauge-wrap{position:relative;width:130px;height:130px;}
.wm-gauge-svg{width:100%;height:100%;transform:rotate(-90deg);}
.wm-num{font-size:28px;font-family:var(--mono);font-weight:700;line-height:1;transition:color 0.5s;}
.wm-unit{font-size:10px;color:var(--text2);font-family:var(--mono);margin-top:2px;}
.wm-state{font-size:9px;font-family:var(--mono);margin-top:8px;padding:3px 10px;border-radius:100px;letter-spacing:0.06em;}
.wm-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);letter-spacing:0.04em;}
.wm-badge.humide{background:rgba(0,144,255,0.1);color:#0090ff;border:1px solid rgba(0,144,255,0.2);}
.wm-badge.optimal{background:rgba(0,212,170,0.1);color:var(--accent);border:1px solid rgba(0,212,170,0.2);}
.wm-badge.sec{background:rgba(255,107,53,0.1);color:var(--warn);border:1px solid rgba(255,107,53,0.2);}
.wm-badge.critical{background:rgba(255,51,85,0.1);color:var(--danger);border:1px solid rgba(255,51,85,0.2);}

/* CHARTS */
.wm-charts-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;}
.wm-charts-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.chart-label{font-size:9px;font-family:var(--mono);color:var(--text3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.1em;}
.chip-group{display:flex;gap:6px;}
.chip{padding:5px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);border:1px solid var(--border);color:var(--text2);cursor:pointer;transition:all 0.2s;background:transparent;letter-spacing:0.04em;}
.chip.active,.chip:hover{border-color:var(--accent);color:var(--accent);background:rgba(0,212,170,0.08);}
.date-input{padding:5px 10px;border-radius:8px;border:1px solid var(--border);font-size:10px;font-family:var(--mono);color:var(--text2);background:var(--surface2);}

/* TABS */
.tabs{display:flex;gap:8px;margin-bottom:14px;}
.tab{padding:8px 20px;border-radius:8px;font-size:10px;font-family:var(--mono);border:1px solid var(--border);color:var(--text2);cursor:pointer;background:transparent;transition:all 0.2s;}
.tab.active{border-color:var(--accent);color:var(--accent);background:rgba(0,212,170,0.08);}

/* TABLE */
.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px;overflow-x:auto;}
table{width:100%;border-collapse:collapse;min-width:800px;}
th{font-family:var(--mono);font-size:9px;text-transform:uppercase;letter-spacing:0.12em;color:var(--text3);padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);}
td{padding:10px 12px;font-size:11px;border-bottom:1px solid rgba(0,0,0,0.06);font-family:var(--mono);color:var(--text2);}
tr:last-child td{border-bottom:none;}
tr:hover td{background:rgba(0,180,140,0.04);}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:100px;font-size:9px;font-family:var(--mono);letter-spacing:0.04em;}
.badge.normal{background:rgba(0,212,170,0.1);color:var(--accent);border:1px solid rgba(0,212,170,0.2);}
.badge.warning{background:rgba(255,107,53,0.1);color:var(--warn);border:1px solid rgba(255,107,53,0.2);}
.badge.critical{background:rgba(255,51,85,0.1);color:var(--danger);border:1px solid rgba(255,51,85,0.2);}

/* EXPORT */
.export-bar{display:flex;align-items:center;gap:10px;margin-bottom:16px;padding:14px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);flex-wrap:wrap;}

::-webkit-scrollbar{width:4px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px;}

@media(max-width:1200px){
  .stats-band{grid-template-columns:repeat(4,1fr);}
  .wm-grid{grid-template-columns:repeat(2,1fr);}
  .wm-charts-grid{grid-template-columns:repeat(2,1fr);}
  .alerts-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:768px){
  .stats-band{grid-template-columns:repeat(2,1fr);}
  .wm-grid{grid-template-columns:1fr;}
  .wm-charts-grid{grid-template-columns:1fr;}
  .alerts-grid{grid-template-columns:1fr;}
  .header-right{display:none;}
}
</style>
</head>
<body>
<div class="wrapper">

<!-- HEADER -->
<header>
  <div class="logo-area">
    <div class="logo-badge">INRA<br/>SETTAT</div>
    <div class="logo-text">
      <h1>Système de Surveillance — Humidité du Sol</h1>
      <p>INRA Settat · Centre Régional de la Recherche Agronomique · ESP32 + LoRa · 6× WATERMARK 200SS</p>
    </div>
  </div>
  <div class="header-right">
    <div class="status-pill"><div class="status-dot"></div>SYSTÈME ACTIF</div>
    <div class="time-display" id="clock">--:--:--</div>
  </div>
</header>

<!-- NAV -->
<div class="nav-bar">
  <a href="/dashboard" class="nav-btn wm">🌱 WATERMARK</a>
  <a href="/electrique" class="nav-btn el">⚡ ÉLECTRIQUE</a>
</div>

<!-- STATS BAND -->
<div class="stats-band">
  <div class="stat-card">
    <div class="stat-label">Watermark 1</div>
    <div class="stat-value" id="kpi-w1">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Watermark 2</div>
    <div class="stat-value" id="kpi-w2">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Watermark 3</div>
    <div class="stat-value" id="kpi-w3">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Watermark 4</div>
    <div class="stat-value" id="kpi-w4">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Watermark 5</div>
    <div class="stat-value" id="kpi-w5">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Watermark 6</div>
    <div class="stat-value" id="kpi-w6">-.-</div>
    <div class="stat-unit">cb</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">État sol</div>
    <div class="stat-value" id="kpi-wm-state" style="font-size:13px;margin-top:4px">—</div>
    <div class="stat-unit">moyenne WM</div>
  </div>
  <div class="stat-card special">
    <div class="stat-label">Total mesures</div>
    <div class="stat-value" id="kpi-count">0</div>
    <div class="stat-unit">enregistrements</div>
  </div>
</div>

<!-- ALERTS -->
<div class="alerts-card">
  <div class="section-title">// alertes système</div>
  <div class="alerts-grid">
    <div class="alert-item" id="a-conn">
      <div class="adot warn"></div>
      <div><div class="alert-text">En attente ESP32...</div><div class="alert-time" id="a-time">—</div></div>
    </div>
    <div class="alert-item" id="a-wm-avg">
      <div class="adot ok"></div>
      <div><div class="alert-text">Moyenne WM — en attente</div><div class="alert-time">Seuil irrigation : 60 cb</div></div>
    </div>
    <div class="alert-item" id="a-wm-max">
      <div class="adot ok"></div>
      <div><div class="alert-text">WM max — en attente</div><div class="alert-time">Seuil critique : 100 cb</div></div>
    </div>
    <div class="alert-item" id="a-wm-min">
      <div class="adot ok"></div>
      <div><div class="alert-text">WM min — en attente</div><div class="alert-time">Saturation : &lt; 10 cb</div></div>
    </div>
  </div>
</div>

<!-- WATERMARK SECTION -->
<div class="wm-section">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
    <div class="section-title" style="margin:0">// humidité du sol — 6× WATERMARK 200SS</div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
      <span class="wm-badge humide">0-10 cb : Très humide</span>
      <span class="wm-badge optimal">10-30 cb : Optimal</span>
      <span class="wm-badge sec">30-60 cb : Cap. champ</span>
      <span class="wm-badge critical">60+ cb : Irrigation</span>
    </div>
  </div>

  <!-- 6 GAUGES -->
  <div class="wm-grid">
    <!-- WM1 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 1 · GPIO35</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <defs>
            <linearGradient id="wmG" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#0090ff"/>
              <stop offset="30%" style="stop-color:#00d4aa"/>
              <stop offset="65%" style="stop-color:#ff6b35"/>
              <stop offset="100%" style="stop-color:#ff3355"/>
            </linearGradient>
          </defs>
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc1"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv1" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws1" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
    <!-- WM2 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 2 · GPIO34</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc2"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv2" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws2" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
    <!-- WM3 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 3 · GPIO39 (VN)</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc3"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv3" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws3" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
    <!-- WM4 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 4 · GPIO32</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc4"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv4" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws4" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
    <!-- WM5 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 5 · GPIO33</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc5"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv5" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws5" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
    <!-- WM6 -->
    <div class="wm-card">
      <div class="wm-name">Watermark 6 · GPIO36 (VP)</div>
      <div class="wm-gauge-wrap">
        <svg class="wm-gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#wmG)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="wc6"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,212,170,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="wm-num" id="wv6" style="color:var(--accent)">--</div>
          <div class="wm-unit">cb</div>
        </div>
      </div>
      <div class="wm-state" id="ws6" style="background:rgba(0,212,170,0.1);color:var(--accent)">EN ATTENTE</div>
    </div>
  </div>

  <!-- CHARTS -->
  <div class="wm-charts-header">
    <div class="section-title" style="margin:0">// historique watermark (cb)</div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <div class="chip-group">
        <button class="chip active" onclick="setRange(20,this)">20 pts</button>
        <button class="chip" onclick="setRange(50,this)">50 pts</button>
        <button class="chip" onclick="setRange(100,this)">100 pts</button>
      </div>
      <input type="date" id="wm-date" class="date-input"/>
    </div>
  </div>
  <div class="wm-charts-grid">
    <div><div class="chart-label">Watermark 1</div><canvas id="wChart1" height="120"></canvas></div>
    <div><div class="chart-label">Watermark 2</div><canvas id="wChart2" height="120"></canvas></div>
    <div><div class="chart-label">Watermark 3</div><canvas id="wChart3" height="120"></canvas></div>
    <div><div class="chart-label">Watermark 4</div><canvas id="wChart4" height="120"></canvas></div>
    <div><div class="chart-label">Watermark 5</div><canvas id="wChart5" height="120"></canvas></div>
    <div><div class="chart-label">Watermark 6</div><canvas id="wChart6" height="120"></canvas></div>
  </div>
</div>

<!-- EXPORT -->
<div class="export-bar">
  <span style="font-family:var(--mono);font-size:10px;color:var(--text3);text-transform:uppercase;">📥 Exporter :</span>
  <select id="exp-type" style="padding:6px 12px;border-radius:8px;border:1px solid var(--border);font-family:var(--mono);font-size:11px;background:var(--surface2);" onchange="syncExport()">
    <option value="day">Par jour</option>
    <option value="month">Par mois</option>
  </select>
  <input type="date" id="exp-date" style="padding:6px 12px;border-radius:8px;border:1px solid var(--border);font-family:var(--mono);font-size:11px;background:var(--surface2);"/>
  <button onclick="doExport()" style="padding:8px 20px;background:#00d4aa;color:#000;border:none;border-radius:8px;font-family:var(--mono);font-size:11px;font-weight:700;cursor:pointer;">↓ Télécharger .xlsx</button>
</div>

<!-- TABLE -->
<div class="tabs">
  <button class="tab active" onclick="showTab('w',this)">Historique Watermark</button>
</div>
<div id="tab-w" class="table-card" style="margin-bottom:20px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
    <div class="section-title" style="margin:0">// mesures watermark</div>
    <div style="display:flex;align-items:center;gap:8px;">
      <label style="font-family:var(--mono);font-size:9px;color:var(--text3)">Jour:</label>
      <input type="date" id="tw-date" class="date-input">
      <span style="font-family:var(--mono);font-size:9px;color:var(--text3)" id="tw-count">0 enregistrements</span>
    </div>
  </div>
  <table>
    <thead><tr>
      <th>#</th>
      <th>WM 1 (cb)</th><th>WM 2 (cb)</th><th>WM 3 (cb)</th>
      <th>WM 4 (cb)</th><th>WM 5 (cb)</th><th>WM 6 (cb)</th>
      <th>Moy.</th><th>État</th><th>Horodatage</th>
    </tr></thead>
    <tbody id="tw-body"><tr><td colspan="10" style="text-align:center;padding:30px;color:var(--text3)">En attente...</td></tr></tbody>
  </table>
</div>

</div>

<script>
setInterval(()=>document.getElementById('clock').textContent=new Date().toLocaleTimeString('fr-FR'),1000);
document.getElementById('clock').textContent=new Date().toLocaleTimeString('fr-FR');

const today=new Date().toISOString().slice(0,10);
['wm-date','tw-date','exp-date'].forEach(id=>{const el=document.getElementById(id);if(el)el.value=today;});
document.getElementById('wm-date').addEventListener('change',fetchWatermark);
document.getElementById('tw-date').addEventListener('change',fetchWatermark);

function showTab(name,el){document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));el.classList.add('active');}

let maxRange=20;
function setRange(n,el){
  maxRange=n;
  document.querySelectorAll('.chip').forEach(c=>c.classList.remove('active'));
  el.classList.add('active');
  fetchWatermark();
}

function wmInterp(cb){
  if(cb<=10)  return{text:'TRÈS HUMIDE',color:'#0090ff',bg:'rgba(0,144,255,0.1)'};
  if(cb<=30)  return{text:'OPTIMAL ✓',color:'#00d4aa',bg:'rgba(0,212,170,0.1)'};
  if(cb<=60)  return{text:'CAP. CHAMP',color:'#ff6b35',bg:'rgba(255,107,53,0.1)'};
  if(cb<=100) return{text:'IRRIGUER 🚨',color:'#ff6b35',bg:'rgba(255,107,53,0.1)'};
  return{text:'TRÈS SEC ❌',color:'#ff3355',bg:'rgba(255,51,85,0.1)'};
}
function wmBadge(cb){const i=wmInterp(cb);return`<span style="color:${i.color};font-family:var(--mono)">${cb.toFixed(1)} cb</span>`;}

function setGaugeWM(idx,cb){
  const pct=Math.min(cb/199,1);
  const circ=2*Math.PI*55;
  document.getElementById(`wc${idx}`).style.strokeDashoffset=circ*(1-pct);
  const i=wmInterp(cb);
  const vEl=document.getElementById(`wv${idx}`);
  const sEl=document.getElementById(`ws${idx}`);
  vEl.textContent=cb.toFixed(1);vEl.style.color=i.color;
  sEl.textContent=i.text;sEl.style.color=i.color;sEl.style.background=i.bg;
}

const chartColors=['#8B4513','#d4a373','#ff8c42','#00d4aa','#0090ff','#a855f7'];
const mkChart=(id,color)=>new Chart(document.getElementById(id).getContext('2d'),{
  type:'line',
  data:{labels:[],datasets:[{data:[],borderColor:color,backgroundColor:color+'18',borderWidth:1.8,pointRadius:2.5,pointBackgroundColor:color,pointBorderColor:'#fff',pointBorderWidth:1.5,fill:true,tension:0.4}]},
  options:{responsive:true,animation:{duration:350},plugins:{legend:{display:false},tooltip:{backgroundColor:'#1a202c',borderColor:color,borderWidth:1,titleColor:'#7a8fa6',bodyColor:color,titleFont:{family:'Space Mono',size:9},bodyFont:{family:'Space Mono',size:11},callbacks:{label:c=>`${c.parsed.y.toFixed(1)} cb`}}},scales:{x:{grid:{color:'rgba(0,0,0,0.06)'},ticks:{color:'#3d5068',font:{family:'Space Mono',size:8},maxTicksLimit:8}},y:{grid:{color:'rgba(0,0,0,0.06)'},ticks:{color:'#3d5068',font:{family:'Space Mono',size:8}},min:0,max:199}}}
});

const wCharts=[mkChart('wChart1',chartColors[0]),mkChart('wChart2',chartColors[1]),mkChart('wChart3',chartColors[2]),mkChart('wChart4',chartColors[3]),mkChart('wChart5',chartColors[4]),mkChart('wChart6',chartColors[5])];

async function fetchWatermark(){
  const date=document.getElementById('wm-date').value;
  const tdDate=document.getElementById('tw-date').value;
  try{
    const res=await fetch(`/api/watermark?limit=5000&date=${date}`);
    const json=await res.json();
    const data=json.data??[];
    document.getElementById('kpi-count').textContent=json.total_records??data.length;
    if(!data.length)return;
    const last=data[0];
    const vals=[parseFloat(last.watermark1),parseFloat(last.watermark2),parseFloat(last.watermark3),parseFloat(last.watermark4??0),parseFloat(last.watermark5??0),parseFloat(last.watermark6??0)];
    const avg=vals.reduce((a,b)=>a+b,0)/6;
    const maxW=Math.max(...vals);
    const minW=Math.min(...vals);
    const t=new Date(last.recorded_at).toLocaleTimeString('fr-FR');
    vals.forEach((v,i)=>{document.getElementById(`kpi-w${i+1}`).textContent=v.toFixed(1);document.getElementById(`kpi-w${i+1}`).style.color=wmInterp(v).color;});
    const avgI=wmInterp(avg);
    document.getElementById('kpi-wm-state').textContent=avgI.text;
    document.getElementById('kpi-wm-state').style.color=avgI.color;
    vals.forEach((v,i)=>setGaugeWM(i+1,v));
    const ac=document.getElementById('a-conn');
    ac.querySelector('.adot').className='adot ok';
    ac.querySelector('.alert-text').textContent='ESP32 connecté — données reçues';
    document.getElementById('a-time').textContent='Dernière réception : '+t;
    const awAvg=document.getElementById('a-wm-avg');
    if(avg>100){awAvg.querySelector('.adot').className='adot danger';awAvg.querySelector('.alert-text').textContent='🚨 MOY. TRÈS SEC ('+avg.toFixed(1)+' cb)';}
    else if(avg>60){awAvg.querySelector('.adot').className='adot warn';awAvg.querySelector('.alert-text').textContent='Irrigation recommandée — moy. '+avg.toFixed(1)+' cb';}
    else{awAvg.querySelector('.adot').className='adot ok';awAvg.querySelector('.alert-text').textContent='Moyenne WM correcte ('+avg.toFixed(1)+' cb)';}
    const awMax=document.getElementById('a-wm-max');
    if(maxW>100){awMax.querySelector('.adot').className='adot danger';awMax.querySelector('.alert-text').textContent='⚠ WM max critique : '+maxW.toFixed(1)+' cb';}
    else if(maxW>60){awMax.querySelector('.adot').className='adot warn';awMax.querySelector('.alert-text').textContent='WM max élevé : '+maxW.toFixed(1)+' cb';}
    else{awMax.querySelector('.adot').className='adot ok';awMax.querySelector('.alert-text').textContent='WM max normal : '+maxW.toFixed(1)+' cb';}
    const awMin=document.getElementById('a-wm-min');
    if(minW<=10){awMin.querySelector('.adot').className='adot warn';awMin.querySelector('.alert-text').textContent='Sol saturé détecté ('+minW.toFixed(1)+' cb)';}
    else{awMin.querySelector('.adot').className='adot ok';awMin.querySelector('.alert-text').textContent='WM min : '+minW.toFixed(1)+' cb';}
    const pts=data.slice(0,maxRange).reverse();
    const labels=pts.map(d=>new Date(d.recorded_at).toLocaleTimeString('fr-FR'));
    const keys=['watermark1','watermark2','watermark3','watermark4','watermark5','watermark6'];
    keys.forEach((k,i)=>{wCharts[i].data.labels=labels;wCharts[i].data.datasets[0].data=pts.map(d=>parseFloat(d[k]??0));wCharts[i].update();});
    const tdata=(await(await fetch(`/api/watermark?limit=5000&date=${tdDate}`)).json()).data??[];
    document.getElementById('tw-count').textContent=tdata.length+' enregistrements';
    document.getElementById('tw-body').innerHTML=tdata.slice(0,20).map(d=>{
      const dv=[parseFloat(d.watermark1),parseFloat(d.watermark2),parseFloat(d.watermark3),parseFloat(d.watermark4??0),parseFloat(d.watermark5??0),parseFloat(d.watermark6??0)];
      const davg=dv.reduce((a,b)=>a+b,0)/6;
      const di=wmInterp(davg);
      return`<tr><td style="color:var(--text3)">${d.id}</td>${dv.map(v=>wmBadge(v)).map(b=>`<td>${b}</td>`).join('')}<td style="color:${di.color};font-weight:700">${davg.toFixed(1)}</td><td><span class="badge ${davg>100?'critical':davg>60?'warning':'normal'}">${di.text}</span></td><td style="color:var(--text3)">${new Date(d.recorded_at).toLocaleString('fr-FR')}</td></tr>`;
    }).join('');
  }catch(e){
    document.getElementById('a-conn').querySelector('.adot').className='adot danger';
    document.getElementById('a-conn').querySelector('.alert-text').textContent='Erreur API Watermark';
    console.error('WM error',e);
  }
}

fetchWatermark();
setInterval(fetchWatermark,3000);

function syncExport(){const t=document.getElementById('exp-type').value;const i=document.getElementById('exp-date');i.type=t==='month'?'month':'date';i.value=t==='month'?new Date().toISOString().slice(0,7):new Date().toISOString().slice(0,10);}
function doExport(){const t=document.getElementById('exp-type').value;const d=document.getElementById('exp-date').value;if(!d){alert('Choisissez une date!');return;}window.open(`/api/export?type=${encodeURIComponent(t)}&date=${encodeURIComponent(d)}`,'_blank');}
</script>
</body>
</html>
