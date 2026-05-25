<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>INRA Settat — Surveillance Électrique</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root {
  --bg:#f0f4f8;--surface:#ffffff;--surface2:#f8fafc;--border:#e2e8f0;
  --accent:#0090ff;--accent2:#00d4aa;--warn:#ff6b35;--danger:#ff3355;
  --elec:#f59e0b;
  --text:#1a202c;--text2:#4a5568;--text3:#a0aec0;
  --mono:'Space Mono',monospace;--sans:'DM Sans',sans-serif;--radius:14px;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{background:var(--bg);color:var(--text);font-family:var(--sans);min-height:100vh;overflow-x:hidden;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,144,255,0.05) 1px,transparent 1px),linear-gradient(90deg,rgba(0,144,255,0.05) 1px,transparent 1px);background-size:48px 48px;pointer-events:none;z-index:0;}
.wrapper{position:relative;z-index:1;max-width:1500px;margin:0 auto;padding:24px 32px;}

/* HEADER */
header{
  display:flex;align-items:center;justify-content:space-between;
  padding:22px 32px;
  background:radial-gradient(circle at top right,rgba(245,158,11,0.22),transparent 26%),
    linear-gradient(135deg,rgba(8,50,95,0.98),rgba(14,80,145,0.96) 48%,rgba(250,250,250,0.96) 49%,rgba(248,250,252,0.98));
  border:1px solid rgba(10,60,120,0.18);border-radius:var(--radius);
  margin-bottom:20px;position:relative;overflow:hidden;
  box-shadow:0 18px 40px rgba(15,23,42,0.08);
}
header::before{content:'';position:absolute;inset:0;background:linear-gradient(120deg,rgba(255,255,255,0.08),transparent 30%),repeating-linear-gradient(105deg,rgba(255,255,255,0.06) 0 2px,transparent 2px 28px);pointer-events:none;}
header::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,rgba(8,50,95,0.8),rgba(245,158,11,0.8),rgba(8,50,95,0.8));}
.logo-area{display:flex;align-items:center;gap:18px;}
.logo-badge{width:78px;height:78px;background:rgba(255,255,255,0.96);border-radius:16px;display:flex;align-items:center;justify-content:center;padding:8px;box-shadow:0 12px 30px rgba(8,50,95,0.16);font-family:var(--mono);font-size:11px;font-weight:700;color:#08325f;text-align:center;line-height:1.3;}
.logo-text h1{font-size:20px;font-weight:700;color:#fff;letter-spacing:-0.3px;}
.logo-text p{font-size:11px;color:rgba(255,255,255,0.88);font-family:var(--mono);margin-top:3px;letter-spacing:0.04em;}
.header-right{display:flex;align-items:center;gap:16px;}
.status-pill{display:flex;align-items:center;gap:8px;padding:8px 18px;background:rgba(8,50,95,0.78);border:1px solid rgba(255,255,255,0.2);border-radius:100px;font-size:11px;font-family:var(--mono);color:#d0e8ff;letter-spacing:0.06em;}
.status-dot{width:7px;height:7px;border-radius:50%;background:#7bc8ff;animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.4;transform:scale(0.7);}}
.time-display{font-family:var(--mono);font-size:13px;color:#fff;letter-spacing:0.05em;}

/* NAV */
.nav-bar{display:flex;gap:10px;margin-bottom:20px;}
.nav-btn{padding:10px 24px;border-radius:10px;font-family:var(--mono);font-size:11px;font-weight:700;text-decoration:none;letter-spacing:0.06em;transition:all 0.2s;border:2px solid;}
.nav-btn.wm{background:transparent;color:#00d4aa;border-color:#00d4aa;}
.nav-btn.wm:hover{background:rgba(0,212,170,0.1);}
.nav-btn.el{background:#0090ff;color:#fff;border-color:#0090ff;}
.nav-btn.el:hover{opacity:0.9;}

/* STATS BAND */
.stats-band{display:grid;grid-template-columns:repeat(7,1fr);gap:12px;margin-bottom:20px;}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;position:relative;overflow:hidden;transition:border-color 0.3s,transform 0.2s;}
.stat-card:hover{border-color:rgba(0,144,255,0.4);transform:translateY(-2px);}
.stat-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--accent),transparent);opacity:0.6;}
.stat-card.warn-card::after{background:linear-gradient(90deg,var(--warn),transparent);}
.stat-card.special::after{background:linear-gradient(90deg,var(--accent2),transparent);}
.stat-label{font-size:9px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;}
.stat-value{font-size:22px;font-family:var(--mono);font-weight:700;color:var(--accent);line-height:1;}
.stat-unit{font-size:10px;color:var(--text2);font-family:var(--mono);margin-top:4px;}

/* SECTION TITLE */
.section-title{font-size:10px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.12em;margin-bottom:14px;}

/* ALERTS */
.alerts-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:20px;}
.alerts-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:12px;}
.alert-item{display:flex;align-items:flex-start;gap:8px;padding:10px;border:1px solid var(--border);border-radius:8px;}
.adot{width:7px;height:7px;border-radius:50%;margin-top:4px;flex-shrink:0;}
.adot.ok{background:var(--accent2);}
.adot.warn{background:var(--warn);animation:pulse 1.5s infinite;}
.adot.danger{background:var(--danger);animation:pulse 0.8s infinite;}
.alert-text{color:var(--text2);font-size:10px;line-height:1.5;}
.alert-time{font-family:var(--mono);font-size:9px;color:var(--text3);margin-top:2px;}

/* GAUGES SECTION */
.gauges-section{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px;margin-bottom:20px;}
.gauges-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;}
.gauge-card{background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;flex-direction:column;align-items:center;position:relative;overflow:hidden;}
.gauge-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;}
.gauge-card.courant::before{background:linear-gradient(90deg,#0090ff,#00d4aa);}
.gauge-card.tension::before{background:linear-gradient(90deg,#f59e0b,#ff6b35);}
.gauge-card.pression::before{background:linear-gradient(90deg,#a855f7,#ff3355);}
.gauge-name{font-size:9px;font-family:var(--mono);color:var(--text3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:12px;}
.gauge-wrap{position:relative;width:130px;height:130px;}
.gauge-svg{width:100%;height:100%;transform:rotate(-90deg);}
.gauge-num{font-size:26px;font-family:var(--mono);font-weight:700;line-height:1;transition:color 0.5s;}
.gauge-unit{font-size:10px;color:var(--text2);font-family:var(--mono);margin-top:2px;}
.gauge-state{font-size:9px;font-family:var(--mono);margin-top:8px;padding:3px 10px;border-radius:100px;letter-spacing:0.06em;}

/* CHARTS */
.charts-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.chart-label{font-size:9px;font-family:var(--mono);color:var(--text3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.1em;}
.chip-group{display:flex;gap:6px;}
.chip{padding:5px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);border:1px solid var(--border);color:var(--text2);cursor:pointer;transition:all 0.2s;background:transparent;letter-spacing:0.04em;}
.chip.active,.chip:hover{border-color:var(--accent);color:var(--accent);background:rgba(0,144,255,0.08);}
.date-input{padding:5px 10px;border-radius:8px;border:1px solid var(--border);font-size:10px;font-family:var(--mono);color:var(--text2);background:var(--surface2);}

/* TABLE */
.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px;overflow-x:auto;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;min-width:900px;}
th{font-family:var(--mono);font-size:9px;text-transform:uppercase;letter-spacing:0.12em;color:var(--text3);padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);}
td{padding:10px 12px;font-size:11px;border-bottom:1px solid rgba(0,0,0,0.06);font-family:var(--mono);color:var(--text2);}
tr:last-child td{border-bottom:none;}
tr:hover td{background:rgba(0,144,255,0.04);}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:100px;font-size:9px;font-family:var(--mono);letter-spacing:0.04em;}
.badge.normal{background:rgba(0,212,170,0.1);color:var(--accent2);border:1px solid rgba(0,212,170,0.2);}
.badge.warning{background:rgba(255,107,53,0.1);color:var(--warn);border:1px solid rgba(255,107,53,0.2);}
.badge.critical{background:rgba(255,51,85,0.1);color:var(--danger);border:1px solid rgba(255,51,85,0.2);}

/* EXPORT */
.export-bar{display:flex;align-items:center;gap:10px;margin-bottom:16px;padding:14px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);flex-wrap:wrap;}

::-webkit-scrollbar{width:4px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px;}

@media(max-width:1200px){
  .stats-band{grid-template-columns:repeat(4,1fr);}
  .gauges-grid{grid-template-columns:repeat(2,1fr);}
  .charts-grid{grid-template-columns:repeat(2,1fr);}
  .alerts-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:768px){
  .stats-band{grid-template-columns:repeat(2,1fr);}
  .gauges-grid{grid-template-columns:1fr;}
  .charts-grid{grid-template-columns:1fr;}
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
      <h1>Système de Surveillance — Électrique</h1>
      <p>INRA Settat · Centre Régional · ESP32 + LoRa · 3× ACS712 · 2× Tension · 1× Pression</p>
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
    <div class="stat-label">Courant 1</div>
    <div class="stat-value" id="kpi-i1">-.--</div>
    <div class="stat-unit">Ampères</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Courant 2</div>
    <div class="stat-value" id="kpi-i2">-.--</div>
    <div class="stat-unit">Ampères</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Courant 3</div>
    <div class="stat-value" id="kpi-i3">-.--</div>
    <div class="stat-unit">Ampères</div>
  </div>
  <div class="stat-card warn-card">
    <div class="stat-label">Tension 1</div>
    <div class="stat-value" id="kpi-v1" style="color:var(--elec)">-.--</div>
    <div class="stat-unit">Volts</div>
  </div>
  <div class="stat-card warn-card">
    <div class="stat-label">Tension 2</div>
    <div class="stat-value" id="kpi-v2" style="color:var(--elec)">-.--</div>
    <div class="stat-unit">Volts</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Pression</div>
    <div class="stat-value" id="kpi-p" style="color:#a855f7">-.--</div>
    <div class="stat-unit">Bar</div>
  </div>
  <div class="stat-card special">
    <div class="stat-label">Total mesures</div>
    <div class="stat-value" id="kpi-count" style="color:var(--text)">0</div>
    <div class="stat-unit">enregistrements</div>
  </div>
</div>

<!-- ALERTS -->
<div class="alerts-card">
  <div class="section-title">// alertes système électrique</div>
  <div class="alerts-grid">
    <div class="alert-item" id="a-conn">
      <div class="adot warn"></div>
      <div><div class="alert-text">En attente ESP32...</div><div class="alert-time" id="a-time">—</div></div>
    </div>
    <div class="alert-item" id="a-courant">
      <div class="adot ok"></div>
      <div><div class="alert-text">Courant — en attente</div><div class="alert-time">Seuil max : 25A</div></div>
    </div>
    <div class="alert-item" id="a-tension">
      <div class="adot ok"></div>
      <div><div class="alert-text">Tension — en attente</div><div class="alert-time">Nominal : 36-72V</div></div>
    </div>
    <div class="alert-item" id="a-pression">
      <div class="adot ok"></div>
      <div><div class="alert-text">Pression — en attente</div><div class="alert-time">Seuil max : 8 bar</div></div>
    </div>
  </div>
</div>

<!-- GAUGES SECTION -->
<div class="gauges-section">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
    <div class="section-title" style="margin:0">// mesures en temps réel</div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
      <span style="background:rgba(0,144,255,0.1);color:#0090ff;border:1px solid rgba(0,144,255,0.2);padding:4px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);">● Courant (A)</span>
      <span style="background:rgba(245,158,11,0.1);color:#f59e0b;border:1px solid rgba(245,158,11,0.2);padding:4px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);">● Tension (V)</span>
      <span style="background:rgba(168,85,247,0.1);color:#a855f7;border:1px solid rgba(168,85,247,0.2);padding:4px 12px;border-radius:100px;font-size:10px;font-family:var(--mono);">● Pression (bar)</span>
    </div>
  </div>

  <div class="gauges-grid">
    <!-- Courant 1 -->
    <div class="gauge-card courant">
      <div class="gauge-name">Courant 1 · GPIO33 · ACS712</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <defs>
            <linearGradient id="gC" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#0090ff"/>
              <stop offset="100%" style="stop-color:#00d4aa"/>
            </linearGradient>
          </defs>
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gC)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc1"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,144,255,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-i1" style="color:#0090ff">--</div>
          <div class="gauge-unit">A</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-i1" style="background:rgba(0,144,255,0.1);color:#0090ff">EN ATTENTE</div>
    </div>
    <!-- Courant 2 -->
    <div class="gauge-card courant">
      <div class="gauge-name">Courant 2 · GPIO35 · ACS712</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gC)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc2"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,144,255,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-i2" style="color:#0090ff">--</div>
          <div class="gauge-unit">A</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-i2" style="background:rgba(0,144,255,0.1);color:#0090ff">EN ATTENTE</div>
    </div>
    <!-- Courant 3 -->
    <div class="gauge-card courant">
      <div class="gauge-name">Courant 3 · GPIO32 · ACS712</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gC)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc3"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(0,144,255,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-i3" style="color:#0090ff">--</div>
          <div class="gauge-unit">A</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-i3" style="background:rgba(0,144,255,0.1);color:#0090ff">EN ATTENTE</div>
    </div>
    <!-- Tension 1 -->
    <div class="gauge-card tension">
      <div class="gauge-name">Tension 1 · GPIO36 (VP) · Panneau</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <defs>
            <linearGradient id="gV" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#f59e0b"/>
              <stop offset="100%" style="stop-color:#ff6b35"/>
            </linearGradient>
          </defs>
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gV)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc4"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(245,158,11,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-v1" style="color:#f59e0b">--</div>
          <div class="gauge-unit">V</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-v1" style="background:rgba(245,158,11,0.1);color:#f59e0b">EN ATTENTE</div>
    </div>
    <!-- Tension 2 -->
    <div class="gauge-card tension">
      <div class="gauge-name">Tension 2 · GPIO39 (VN) · Panneau</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gV)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc5"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(245,158,11,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-v2" style="color:#f59e0b">--</div>
          <div class="gauge-unit">V</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-v2" style="background:rgba(245,158,11,0.1);color:#f59e0b">EN ATTENTE</div>
    </div>
    <!-- Pression -->
    <div class="gauge-card pression">
      <div class="gauge-name">Pression · GPIO34 · Circuit irrigation</div>
      <div class="gauge-wrap">
        <svg class="gauge-svg" viewBox="0 0 130 130">
          <defs>
            <linearGradient id="gP" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#a855f7"/>
              <stop offset="100%" style="stop-color:#ff3355"/>
            </linearGradient>
          </defs>
          <circle fill="none" stroke="#e2e8f0" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"/>
          <circle fill="none" stroke="url(#gP)" stroke-width="10" stroke-linecap="round" cx="65" cy="65" r="55"
            stroke-dasharray="346" stroke-dashoffset="346" id="gc6"
            style="transition:stroke-dashoffset 1.4s cubic-bezier(0.4,0,0.2,1);filter:drop-shadow(0 0 4px rgba(168,85,247,0.4))"/>
        </svg>
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
          <div class="gauge-num" id="gv-p" style="color:#a855f7">--</div>
          <div class="gauge-unit">bar</div>
        </div>
      </div>
      <div class="gauge-state" id="gs-p" style="background:rgba(168,85,247,0.1);color:#a855f7">EN ATTENTE</div>
    </div>
  </div>

  <!-- CHARTS -->
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
    <div class="section-title" style="margin:0">// historique (6 dernières mesures)</div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <div class="chip-group">
        <button class="chip active" onclick="setRange(20,this)">20 pts</button>
        <button class="chip" onclick="setRange(50,this)">50 pts</button>
        <button class="chip" onclick="setRange(100,this)">100 pts</button>
      </div>
      <input type="date" id="el-date" class="date-input"/>
    </div>
  </div>
  <div class="charts-grid">
    <div><div class="chart-label">Courant 1 (A)</div><canvas id="chart-i1" height="120"></canvas></div>
    <div><div class="chart-label">Courant 2 (A)</div><canvas id="chart-i2" height="120"></canvas></div>
    <div><div class="chart-label">Courant 3 (A)</div><canvas id="chart-i3" height="120"></canvas></div>
    <div><div class="chart-label">Tension 1 (V)</div><canvas id="chart-v1" height="120"></canvas></div>
    <div><div class="chart-label">Tension 2 (V)</div><canvas id="chart-v2" height="120"></canvas></div>
    <div><div class="chart-label">Pression (bar)</div><canvas id="chart-p" height="120"></canvas></div>
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
  <button onclick="doExport()" style="padding:8px 20px;background:#0090ff;color:#fff;border:none;border-radius:8px;font-family:var(--mono);font-size:11px;font-weight:700;cursor:pointer;">↓ Télécharger .xlsx</button>
</div>

<!-- TABLE -->
<div class="table-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
    <div class="section-title" style="margin:0">// historique mesures électriques</div>
    <div style="display:flex;align-items:center;gap:8px;">
      <label style="font-family:var(--mono);font-size:9px;color:var(--text3)">Jour:</label>
      <input type="date" id="t-date" class="date-input">
      <span style="font-family:var(--mono);font-size:9px;color:var(--text3)" id="t-count">0 enregistrements</span>
    </div>
  </div>
  <table>
    <thead><tr>
      <th>#</th>
      <th>I1 (A)</th><th>I2 (A)</th><th>I3 (A)</th>
      <th>V1 (V)</th><th>V2 (V)</th>
      <th>P (bar)</th>
      <th>État</th><th>RSSI</th><th>Horodatage</th>
    </tr></thead>
    <tbody id="t-body">
      <tr><td colspan="10" style="text-align:center;padding:30px;color:var(--text3)">En attente...</td></tr>
    </tbody>
  </table>
</div>

</div>

<script>
setInterval(()=>document.getElementById('clock').textContent=new Date().toLocaleTimeString('fr-FR'),1000);

const today=new Date().toISOString().slice(0,10);
['el-date','t-date','exp-date'].forEach(id=>{const el=document.getElementById(id);if(el)el.value=today;});
document.getElementById('el-date').addEventListener('change',fetchElectrique);
document.getElementById('t-date').addEventListener('change',fetchElectrique);

let maxRange=20;
function setRange(n,el){
  maxRange=n;
  document.querySelectorAll('.chip').forEach(c=>c.classList.remove('active'));
  el.classList.add('active');
  fetchElectrique();
}

function setGauge(circleId,numId,stateId,val,max,color,unit,interpFn){
  const pct=Math.min(Math.abs(val)/max,1);
  const circ=2*Math.PI*55;
  document.getElementById(circleId).style.strokeDashoffset=circ*(1-pct);
  const num=document.getElementById(numId);
  const state=document.getElementById(stateId);
  num.textContent=val.toFixed(2);num.style.color=color;
  const interp=interpFn(val);
  state.textContent=interp.text;state.style.color=interp.color;state.style.background=interp.bg;
}

function interpCourant(v){
  const a=Math.abs(v);
  if(a<0.1)return{text:'INACTIF',color:'#a0aec0',bg:'rgba(160,174,192,0.1)'};
  if(a<10) return{text:'NORMAL ✓',color:'#00d4aa',bg:'rgba(0,212,170,0.1)'};
  if(a<20) return{text:'CHARGE ÉLEVÉE',color:'#ff6b35',bg:'rgba(255,107,53,0.1)'};
  return{text:'SURCHARGE ⚠',color:'#ff3355',bg:'rgba(255,51,85,0.1)'};
}
function interpTension(v){
  if(v<5)  return{text:'HORS TENSION',color:'#a0aec0',bg:'rgba(160,174,192,0.1)'};
  if(v<30) return{text:'TENSION FAIBLE',color:'#ff6b35',bg:'rgba(255,107,53,0.1)'};
  if(v<=72)return{text:'NORMAL ✓',color:'#f59e0b',bg:'rgba(245,158,11,0.1)'};
  return{text:'SURTENSION ⚠',color:'#ff3355',bg:'rgba(255,51,85,0.1)'};
}
function interpPression(v){
  if(v<0.1)return{text:'INACTIF',color:'#a0aec0',bg:'rgba(160,174,192,0.1)'};
  if(v<3)  return{text:'PRESSION FAIBLE',color:'#0090ff',bg:'rgba(0,144,255,0.1)'};
  if(v<=7) return{text:'NORMAL ✓',color:'#a855f7',bg:'rgba(168,85,247,0.1)'};
  return{text:'PRESSION ÉLEVÉE ⚠',color:'#ff3355',bg:'rgba(255,51,85,0.1)'};
}

const mkChart=(id,color,yMax)=>new Chart(document.getElementById(id).getContext('2d'),{
  type:'line',
  data:{labels:[],datasets:[{data:[],borderColor:color,backgroundColor:color+'18',borderWidth:1.8,pointRadius:2.5,pointBackgroundColor:color,pointBorderColor:'#fff',pointBorderWidth:1.5,fill:true,tension:0.4}]},
  options:{responsive:true,animation:{duration:350},plugins:{legend:{display:false},tooltip:{backgroundColor:'#1a202c',borderColor:color,borderWidth:1,titleColor:'#7a8fa6',bodyColor:color,titleFont:{family:'Space Mono',size:9},bodyFont:{family:'Space Mono',size:11}}},scales:{x:{grid:{color:'rgba(0,0,0,0.06)'},ticks:{color:'#3d5068',font:{family:'Space Mono',size:8},maxTicksLimit:8}},y:{grid:{color:'rgba(0,0,0,0.06)'},ticks:{color:'#3d5068',font:{family:'Space Mono',size:8}},min:0,max:yMax}}}
});

const charts={
  i1:mkChart('chart-i1','#0090ff',30),i2:mkChart('chart-i2','#0090ff',30),i3:mkChart('chart-i3','#0090ff',30),
  v1:mkChart('chart-v1','#f59e0b',100),v2:mkChart('chart-v2','#f59e0b',100),p:mkChart('chart-p','#a855f7',10),
};

async function fetchElectrique(){
  const date=document.getElementById('el-date').value;
  const tDate=document.getElementById('t-date').value;
  try{
    const res=await fetch(`/api/electrique?limit=5000&date=${date}`);
    const json=await res.json();
    const data=json.data??[];
    document.getElementById('kpi-count').textContent=json.total_records??data.length;
    if(!data.length)return;
    const last=data[0];
    const i1=parseFloat(last.courant1),i2=parseFloat(last.courant2),i3=parseFloat(last.courant3);
    const v1=parseFloat(last.tension1),v2=parseFloat(last.tension2),p=parseFloat(last.pression);
    const t=new Date(last.recorded_at).toLocaleTimeString('fr-FR');
    document.getElementById('kpi-i1').textContent=i1.toFixed(2);
    document.getElementById('kpi-i2').textContent=i2.toFixed(2);
    document.getElementById('kpi-i3').textContent=i3.toFixed(2);
    document.getElementById('kpi-v1').textContent=v1.toFixed(1);
    document.getElementById('kpi-v2').textContent=v2.toFixed(1);
    document.getElementById('kpi-p').textContent=p.toFixed(2);
    setGauge('gc1','gv-i1','gs-i1',i1,30,'#0090ff','A',interpCourant);
    setGauge('gc2','gv-i2','gs-i2',i2,30,'#0090ff','A',interpCourant);
    setGauge('gc3','gv-i3','gs-i3',i3,30,'#0090ff','A',interpCourant);
    setGauge('gc4','gv-v1','gs-v1',v1,100,'#f59e0b','V',interpTension);
    setGauge('gc5','gv-v2','gs-v2',v2,100,'#f59e0b','V',interpTension);
    setGauge('gc6','gv-p','gs-p',p,10,'#a855f7','bar',interpPression);
    const ac=document.getElementById('a-conn');
    ac.querySelector('.adot').className='adot ok';
    ac.querySelector('.alert-text').textContent='ESP32 connecté — données reçues';
    document.getElementById('a-time').textContent='Dernière réception : '+t;
    const maxI=Math.max(Math.abs(i1),Math.abs(i2),Math.abs(i3));
    const aC=document.getElementById('a-courant');
    if(maxI>25){aC.querySelector('.adot').className='adot danger';aC.querySelector('.alert-text').textContent='🚨 Surcharge courant : '+maxI.toFixed(1)+'A';}
    else if(maxI>15){aC.querySelector('.adot').className='adot warn';aC.querySelector('.alert-text').textContent='Courant élevé : '+maxI.toFixed(1)+'A';}
    else{aC.querySelector('.adot').className='adot ok';aC.querySelector('.alert-text').textContent='Courant normal — max '+maxI.toFixed(1)+'A';}
    const maxV=Math.max(v1,v2);
    const aV=document.getElementById('a-tension');
    if(maxV>72){aV.querySelector('.adot').className='adot danger';aV.querySelector('.alert-text').textContent='⚠ Surtension : '+maxV.toFixed(1)+'V';}
    else if(maxV<20&&maxV>1){aV.querySelector('.adot').className='adot warn';aV.querySelector('.alert-text').textContent='Tension faible : '+maxV.toFixed(1)+'V';}
    else{aV.querySelector('.adot').className='adot ok';aV.querySelector('.alert-text').textContent='Tension normale : '+maxV.toFixed(1)+'V';}
    const aP=document.getElementById('a-pression');
    if(p>8){aP.querySelector('.adot').className='adot danger';aP.querySelector('.alert-text').textContent='🚨 Pression critique : '+p.toFixed(1)+' bar';}
    else if(p>6){aP.querySelector('.adot').className='adot warn';aP.querySelector('.alert-text').textContent='Pression élevée : '+p.toFixed(1)+' bar';}
    else{aP.querySelector('.adot').className='adot ok';aP.querySelector('.alert-text').textContent='Pression normale : '+p.toFixed(1)+' bar';}
    const pts=data.slice(0,maxRange).reverse();
    const labels=pts.map(d=>new Date(d.recorded_at).toLocaleTimeString('fr-FR'));
    const keys={i1:'courant1',i2:'courant2',i3:'courant3',v1:'tension1',v2:'tension2',p:'pression'};
    Object.entries(keys).forEach(([k,col])=>{charts[k].data.labels=labels;charts[k].data.datasets[0].data=pts.map(d=>parseFloat(d[col]??0));charts[k].update();});
    const tRes=await fetch(`/api/electrique?limit=5000&date=${tDate}`);
    const tJson=await tRes.json();
    const tData=tJson.data??[];
    document.getElementById('t-count').textContent=tData.length+' enregistrements';
    document.getElementById('t-body').innerHTML=tData.slice(0,20).map(d=>{
      const di1=parseFloat(d.courant1),di2=parseFloat(d.courant2),di3=parseFloat(d.courant3);
      const dv1=parseFloat(d.tension1),dv2=parseFloat(d.tension2),dp=parseFloat(d.pression);
      const maxI2=Math.max(Math.abs(di1),Math.abs(di2),Math.abs(di3));
      const cls=maxI2>25?'critical':maxI2>15?'warning':'normal';
      const txt=maxI2>25?'SURCHARGE':maxI2>15?'CHARGE ÉLEVÉE':'NORMAL';
      return`<tr><td style="color:var(--text3)">${d.id}</td><td style="color:#0090ff">${di1.toFixed(2)}</td><td style="color:#0090ff">${di2.toFixed(2)}</td><td style="color:#0090ff">${di3.toFixed(2)}</td><td style="color:#f59e0b">${dv1.toFixed(1)}</td><td style="color:#f59e0b">${dv2.toFixed(1)}</td><td style="color:#a855f7">${dp.toFixed(2)}</td><td><span class="badge ${cls}">${txt}</span></td><td style="color:var(--text3)">${d.rssi??'—'}</td><td style="color:var(--text3)">${new Date(d.recorded_at).toLocaleString('fr-FR')}</td></tr>`;
    }).join('');
  }catch(e){
    document.getElementById('a-conn').querySelector('.adot').className='adot danger';
    document.getElementById('a-conn').querySelector('.alert-text').textContent='Erreur API Électrique';
    console.error('Elec error',e);
  }
}

fetchElectrique();
setInterval(fetchElectrique,3000);

function syncExport(){const t=document.getElementById('exp-type').value;const i=document.getElementById('exp-date');i.type=t==='month'?'month':'date';i.value=t==='month'?new Date().toISOString().slice(0,7):new Date().toISOString().slice(0,10);}
function doExport(){const t=document.getElementById('exp-type').value;const d=document.getElementById('exp-date').value;if(!d){alert('Choisissez une date!');return;}window.open(`/api/export-electrique?type=${encodeURIComponent(t)}&date=${encodeURIComponent(d)}`,'_blank');}
</script>
</body>
</html>
