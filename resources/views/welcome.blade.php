<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resto Kwetu — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700" rel="stylesheet">
    <style>
        :root {
            --rk-bg: #301B18;
            --rk-bg-elevated: #3d2420;
            --rk-accent: #C84628;
            --rk-accent-hover: #d95a3c;
            --rk-text: #f5f0eb;
            --rk-text-muted: rgba(245, 240, 235, 0.7);
            --rk-card: #3a2520;
            --rk-border: rgba(200, 70, 40, 0.25);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(180deg, var(--rk-bg) 0%, #251410 100%);
            color: var(--rk-text);
            min-height: 100vh;
            line-height: 1.5;
        }

        /* Barre horizontale : logo | recherche centrée | nav */
        .rk-topbar {
            display: grid;
            grid-template-columns: minmax(140px, 1fr) minmax(0, 2.5fr) minmax(140px, 1fr);
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
            background: var(--rk-bg);
            border-bottom: 1px solid var(--rk-border);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .rk-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: var(--rk-text);
        }

        .rk-brand .rk-logo-box {
            position: relative;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
        }

        .rk-brand img {
            height: 48px;
            width: 48px;
            object-fit: contain;
            border-radius: 8px;
        }

        .rk-logo-fallback {
            display: none;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--rk-accent);
            color: var(--rk-text);
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: -0.02em;
        }

        .rk-logo-fallback.is-visible { display: flex; }
        .rk-brand img.is-hidden { display: none; }

        .rk-brand span {
            font-weight: 600;
            font-size: 1.05rem;
            letter-spacing: 0.02em;
        }

        .rk-search-wrap {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .rk-search {
            width: 100%;
            max-width: 28rem;
            position: relative;
        }

        .rk-search input {
            width: 100%;
            padding: 0.65rem 1rem 0.65rem 2.75rem;
            border-radius: 9999px;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.08);
            color: var(--rk-text);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .rk-search input::placeholder {
            color: var(--rk-text-muted);
        }

        .rk-search input:focus {
            border-color: var(--rk-accent);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(200, 70, 40, 0.25);
        }

        .rk-search svg {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.1rem;
            height: 1.1rem;
            opacity: 0.55;
            pointer-events: none;
        }

        .rk-nav {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .rk-nav a {
            color: var(--rk-text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        .rk-nav a:hover {
            color: var(--rk-accent);
            background: rgba(200, 70, 40, 0.12);
        }

        .rk-main {
            max-width: 72rem;
            margin: 0 auto;
            padding: 1.5rem 1.25rem 3rem;
        }

        .rk-lead {
            text-align: center;
            color: var(--rk-text-muted);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .rk-section-title {
            font-size: 1.35rem;
            font-weight: 600;
            margin: 2rem 0 1rem;
            padding-bottom: 0.35rem;
            border-bottom: 2px solid var(--rk-accent);
            display: inline-block;
        }

        .rk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.25rem;
        }

        .rk-card {
            background: var(--rk-card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--rk-border);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .rk-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
        }

        .rk-thumb {
            position: relative;
            aspect-ratio: 4 / 3;
            background: var(--rk-bg-elevated);
        }

        .rk-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .rk-thumb img.is-hidden {
            display: none !important;
        }

        .rk-initials {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--rk-accent);
            background: linear-gradient(145deg, var(--rk-bg-elevated), #2a1814);
            letter-spacing: 0.05em;
        }

        .rk-initials.is-visible {
            display: flex;
        }

        .rk-card-body {
            padding: 1rem 1.1rem 1.15rem;
        }

        .rk-card-body h3 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        .rk-card-body p {
            font-size: 0.85rem;
            color: var(--rk-text-muted);
            margin-bottom: 0.65rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rk-price {
            font-weight: 600;
            color: var(--rk-accent);
        }

        .rk-badge {
            display: inline-block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: rgba(200, 70, 40, 0.2);
            color: var(--rk-accent-hover);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .rk-empty, .rk-error {
            text-align: center;
            padding: 2rem;
            color: var(--rk-text-muted);
        }

        .rk-error { color: #e8a598; }

        @media (max-width: 768px) {
            .rk-topbar {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .rk-brand { justify-content: center; }
            .rk-nav { justify-content: center; }
        }
    </style>
</head>
<body data-menu-url="{{ url('/api/v1/menu') }}">
    <header class="rk-topbar">
        <a href="{{ url('/') }}" class="rk-brand">
            <span class="rk-logo-box">
                <img src="{{ asset('assets/logo.jpg') }}" alt="" width="48" height="48" onerror="this.classList.add('is-hidden'); this.nextElementSibling.classList.add('is-visible');">
                <span class="rk-logo-fallback" aria-hidden="true">RK</span>
            </span>
            <span>Resto Kwetu</span>
        </a>
        <div class="rk-search-wrap">
            <div class="rk-search">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="search" id="rk-search-input" placeholder="Rechercher un plat, une catégorie…" autocomplete="off" aria-label="Rechercher dans la carte">
            </div>
        </div>
        <nav class="rk-nav">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/admin') }}">Admin</a>
                @else
                    <a href="{{ route('login') }}">Connexion</a>
                @endauth
            @endif
        </nav>
    </header>

    <main class="rk-main">
        <p class="rk-lead">Lounge bar, terrasse-piscine et salon privé — découvrez notre carte.</p>
        <div id="rk-menu-root">
            <p class="rk-empty">Chargement de la carte…</p>
        </div>
    </main>

    <script>
        (function () {
            function initialsFromName(name) {
                if (!name || typeof name !== 'string') return 'RK';
                const parts = name.trim().split(/\s+/).filter(Boolean);
                if (parts.length >= 2) {
                    return (parts[0][0] + parts[1][0]).toUpperCase();
                }
                return name.slice(0, 2).toUpperCase();
            }

            function platImageUrl(plat) {
                if (plat.image_principale && plat.image_principale.url_fichier) {
                    return plat.image_principale.url_fichier;
                }
                if (Array.isArray(plat.medias)) {
                    const photo = plat.medias.find(function (m) { return m.type === 'photo' && m.url_fichier; });
                    if (photo) return photo.url_fichier;
                }
                return '';
            }

            window.rkOnImgError = function (img) {
                img.classList.add('is-hidden');
                var el = img.parentElement && img.parentElement.querySelector('.rk-initials');
                if (el) el.classList.add('is-visible');
            };

            var menuUrl = document.body.getAttribute('data-menu-url');
            var root = document.getElementById('rk-menu-root');
            var searchInput = document.getElementById('rk-search-input');
            var allCategories = [];

            function normalize(s) {
                return (s || '').toString().toLowerCase().normalize('NFD').replace(/\p{M}/gu, '');
            }

            function matchesQuery(plat, cat, q) {
                if (!q) return true;
                var n = normalize(q);
                return normalize(plat.nom).includes(n)
                    || normalize(plat.description).includes(n)
                    || normalize(cat.nom).includes(n);
            }

            function render() {
                var q = (searchInput && searchInput.value) ? searchInput.value.trim() : '';
                var html = '';

                allCategories.forEach(function (cat) {
                    var plats = (cat.plats || []).filter(function (p) { return matchesQuery(p, cat, q); });
                    if (!plats.length) return;

                    html += '<section class="rk-cat-section" data-cat-id="' + cat.id + '">';
                    html += '<h2 class="rk-section-title">' + escapeHtml(cat.nom) + '</h2>';
                    if (cat.description) {
                        html += '<p class="rk-lead" style="margin-top:-1rem;margin-bottom:1rem;text-align:left">' + escapeHtml(cat.description) + '</p>';
                    }
                    html += '<div class="rk-grid">';

                    plats.forEach(function (plat) {
                        var imgUrl = platImageUrl(plat);
                        var ini = initialsFromName(plat.nom);
                        var price = plat.prix_promo ? '<span style="text-decoration:line-through;opacity:0.6;margin-right:0.35rem">' + escapeHtml(String(plat.prix)) + '</span>' + escapeHtml(String(plat.prix_promo)) : escapeHtml(String(plat.prix));
                        html += '<article class="rk-card" data-plat-id="' + plat.id + '">';
                        html += '<div class="rk-thumb">';
                        if (imgUrl) {
                            html += '<img src="' + escapeAttr(imgUrl) + '" alt="" loading="lazy" onerror="rkOnImgError(this)">';
                            html += '<div class="rk-initials" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                        } else {
                            html += '<div class="rk-initials is-visible" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                        }
                        html += '</div><div class="rk-card-body">';
                        if (plat.mis_en_avant) html += '<span class="rk-badge">À la une</span>';
                        if (plat.nouveau) html += '<span class="rk-badge">Nouveau</span>';
                        html += '<h3>' + escapeHtml(plat.nom) + '</h3>';
                        if (plat.description) html += '<p>' + escapeHtml(plat.description) + '</p>';
                        html += '<div class="rk-price">' + price + ' ' + escapeHtml(plat.code_devise || '') + '</div>';
                        html += '</div></article>';
                    });

                    html += '</div></section>';
                });

                if (!html) {
                    root.innerHTML = '<p class="rk-empty">' + (q ? 'Aucun plat ne correspond à « ' + escapeHtml(q) + ' ».' : 'Aucun plat à afficher.') + '</p>';
                    return;
                }
                root.innerHTML = html;
            }

            function escapeHtml(s) {
                if (s == null) return '';
                return String(s)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;');
            }

            function escapeAttr(s) {
                return String(s)
                    .replace(/&/g, '&amp;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;')
                    .replace(/</g, '&lt;');
            }

            fetch(menuUrl, { headers: { 'Accept': 'application/json' } })
                .then(function (r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(function (payload) {
                    allCategories = payload.data || [];
                    if (!allCategories.length) {
                        root.innerHTML = '<p class="rk-empty">La carte est vide pour le moment.</p>';
                        return;
                    }
                    render();
                })
                .catch(function () {
                    root.innerHTML = '<p class="rk-error">Impossible de charger la carte. Vérifiez que l’API est disponible.</p>';
                });

            if (searchInput) {
                searchInput.addEventListener('input', function () { render(); });
                searchInput.addEventListener('search', function () { render(); });
            }
        })();
    </script>
</body>
</html>
