## ⚠️ Zastrzeżenie

Projekt stworzony wyłącznie w celach edukacyjnych w ramach praktyk zawodowych. Nazwa, logo oraz wszelkie materiały związane z restauracją KresowaJeden należą do ich właścicieli. Aplikacja nie jest przeznaczona do użytku komercyjnego.

---

## 📋 Opis projektu

Webowa aplikacja restauracyji stworzona w ramach praktyk zawodowych. System obsługuje przeglądanie menu, składanie zamówień, rezerwacje stolików oraz ocenianie dań.

---

## ✨ Funkcjonalności

- 📖 **Menu** — przeglądanie dostępnych potraw
- 🛒 **Koszyk** — dodawanie i zarządzanie zamówieniami
- 🔐 **Logowanie / Rejestracja** — system profilu klienta
- ⭐ **Oceny dań** — wystawianie oceny i komentarza do wybranych potraw
- 📞 **Kontakt** — dane kontaktowe restauracji
- 📅 **Rezerwacje** — system rezerwacji stolika

---

## 🛠️ Technologie

| Warstwa | Technologie |
|---|---|
| Backend | PHP 8, MySQLi |
| Frontend | HTML5, CSS3, Bootstrap 5.3, Bootstrap Icons |
| Baza danych | MySQL |
| Konteneryzacja | Docker |

---

## 🚀 Uruchomienie lokalne

### Wymagania

- Docker i Docker Compose **lub** serwer z PHP i MySQL (np. XAMPP, Laragon)

### Z Dockerem

```bash
git clone https://github.com/igbury/kresowaJeden.git
cd kresowaJeden
cp .env.example .env
# Uzupełnij dane w pliku .env
docker compose up -d
```

### Bez Dockera (XAMPP / Laragon)

1. Sklonuj repozytorium do folderu serwera (np. `htdocs`).
2. Zaimportuj bazę danych z pliku `kresowaJeden.sql` do MySQL.
3. Skopiuj `.env.example` jako `.env` i uzupełnij dane połączenia z bazą.
4. Otwórz `http://localhost/kresowaJeden` w przeglądarce.

---

## 📁 Struktura projektu

```
kresowaJeden/
├── cart/           # Logika koszyka
├── contact/        # Strona kontaktowa
├── login/          # Logowanie i rejestracja
├── menu/           # Widok menu
├── modals/         # Komponenty modalowe (Bootstrap)
├── img/            # Zasoby graficzne
├── index.php       # Strona główna
├── db.php          # Połączenie z bazą danych
├── navbar.php      # Nawigacja
├── book.php        # Rezerwacje
├── kresowaJeden.sql# Schemat i dane bazy danych
├── Dockerfile
└── .env.example
```

---

## ⚙️ Konfiguracja środowiska

Skopiuj plik `.env.example` jako `.env` i uzupełnij zmienne:

```env
DB_HOST=localhost
DB_NAME=kresowaJeden
DB_USER=
DB_PASS=
```

---

## 👤 Autorzy

Projekt stworzony w ramach **praktyk zawodowych 2026**.

[@igbury](https://github.com/igbury)  
[@Agor233](https://github.com/Agor233)
