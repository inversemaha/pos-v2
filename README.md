# Local Installation

- run `` git clone https://github.com/FahimAnzamDip/triangle-pos.git ``
- run ``composer update ``
- copy .env.example to .env
- run `` php artisan key:generate ``
- set up your database in the .env
- run `` php artisan migrate --seed ``
- run `` php artisan serve ``
- then visit `` http://localhost:8000 or http://127.0.0.1:8000 ``.
