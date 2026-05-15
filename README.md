# 🧡 GAINZZZ - Ultimátní databáze cviků

**GAINZZZ** je komplexní webová aplikace pro správu fitness cviků, tvorbu tréninkových plánů a výměnu zkušeností mezi sportovci. 

Tento projekt vznikl jako semestrální práce. Je postaven na **čistém PHP** s využitím vlastnoručně navržené **MVC (Model-View-Controller)** architektury, čímž demonstruje pochopení základních principů softwarového inženýrství bez spoléhání se na hotové backendové frameworky.

---

## 🚀 Klíčové vlastnosti

Aplikace nabízí robustní sadu funkcí rozdělenou podle uživatelských rolí:

### 🔐 Bezpečnost a Autentizace
- Registrace a přihlašování s validací silných hesel (min. 8 znaků, velká/malá písmena, číslice, speciální znaky).
- Bezpečné ukládání hesel pomocí moderního hashování (`password_hash`).
- Ochrana tras (routes) před nepřihlášenými uživateli a striktní oddělení práv (Admin vs. User).

### 🏋️‍♂️ Katalog cviků a CRUD operace
- Administrátorské rozhraní pro přidávání, úpravu a mazání cviků.
- Kategorizace cviků podle svalových partií a potřebného vybavení.
- Podpora pro nahrávání ilustračních obrázků (ukládání na server).
- **Integrace YouTube:** Automatický převod vložených odkazů na vložený (embedded) videopřehrávač přímo v detailu cviku.

### 👤 Osobní uživatelský profil
- Správa osobních údajů (váha, výška, bio).
- **Automatická BMI kalkulačka:** Výpočet a zařazení do kategorie na základě aktuálních tělesných proporcí.

### 💬 Sociální a osobní funkce
- **Diskusní fórum:** Možnost přidávat komentáře pod jednotlivé cviky a sdílet tipy s ostatními.
- **Tréninkový plán:** Systém ukládání cviků do oblíbených (tzv. "Můj trénink") pro rychlý přístup na profilu.

---

## 🛠️ Použité technologie

- **Backend:** Čisté PHP 8+ (OOP, MVC architektura)
- **Databáze:** MySQL / MariaDB (komunikace přes PDO s ochranou proti SQL Injection)
- **Frontend:** HTML5, moderní responzivní design pomocí [Tailwind CSS](https://tailwindcss.com/)
- **Server:** Apache (lokální vývoj přes XAMPP)

---

## 📂 Architektura projektu (MVC)

Projekt dodržuje striktní oddělení logiky a prezentace:
- `app/models/` - Databázová logika a komunikace s tabulkami.
- `app/controllers/` - Zpracování uživatelských požadavků, validace a propojování dat.
- `app/views/` - Uživatelské rozhraní (Tailwind šablony).
- `core/` - Zabezpečuje směrování (routing) napříč aplikací.
- `public/` - Vstupní bod aplikace (`index.php`), statické soubory a nahrané obrázky.

---

## ⚙️ Lokální instalace (pro vyučující)

Pro spuštění projektu na lokálním prostředí (např. XAMPP) postupujte podle těchto kroků:

1. **Naklonování repozitáře** do složky `htdocs`:
   ```bash
   git clone [https://github.com/adamerben/Gainzz.git](https://github.com/adamerben/Gainzz.git) gainzzz