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

        .rk-thumb { position: relative; }

        .rk-play-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.28);
            opacity: 0;
            transition: opacity 0.2s;
            pointer-events: none;
        }

        .rk-card:hover .rk-play-overlay,
        .rk-play-overlay.is-always {
            opacity: 1;
            pointer-events: auto;
        }

        .rk-open-video {
            pointer-events: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            background: rgba(200, 70, 40, 0.92);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
            transition: transform 0.15s, background 0.15s;
        }

        .rk-open-video:hover {
            transform: scale(1.06);
            background: var(--rk-accent-hover);
        }

        .rk-open-video svg {
            width: 1.35rem;
            height: 1.35rem;
            margin-left: 2px;
        }

        .rk-card-actions {
            margin-top: 0.65rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .rk-btn-video-text {
            font: inherit;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--rk-accent);
            background: rgba(200, 70, 40, 0.15);
            color: var(--rk-accent-hover);
            cursor: pointer;
        }

        .rk-btn-video-text:hover {
            background: rgba(200, 70, 40, 0.28);
        }

        /* Modal média */
        .rk-modal {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
        }

        .rk-modal.is-open {
            opacity: 1;
            visibility: visible;
        }

        .rk-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(10, 6, 5, 0.82);
            cursor: pointer;
        }

        .rk-modal-panel {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: min(960px, 100vw - 2rem);
            max-height: min(85vh, 900px);
            background: var(--rk-bg-elevated);
            border-radius: 14px;
            border: 1px solid var(--rk-border);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .rk-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--rk-border);
        }

        .rk-modal-head h2 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            color: var(--rk-text);
            line-height: 1.3;
        }

        .rk-modal-close {
            flex-shrink: 0;
            width: 2.5rem;
            height: 2.5rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--rk-text);
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        .rk-modal-close:hover {
            background: rgba(200, 70, 40, 0.35);
        }

        .rk-modal-stage {
            position: relative;
            flex: 1;
            min-height: min(50vh, 360px);
            aspect-ratio: 16 / 10;
            max-height: 70vh;
            background: #0d0a09;
        }

        .rk-modal-stage iframe,
        .rk-modal-stage video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }

        .rk-modal-stage video {
            object-fit: contain;
        }

        @media (max-width: 768px) {
            .rk-topbar {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .rk-brand { justify-content: center; }
            .rk-nav { justify-content: center; }
        }

    </style>
    @php
        /** Base URL réelle de la requête (évite APP_URL erronée ex. :3000 alors que vous ouvrez :8000). */
        $rkRoot = rtrim(request()->root(), '/');
        $rkLogo = $rkRoot.'/assets/logo.jpg';
        /** Préfixe URL pour l’API (installations sous-dossier) : chargement menu = origine du navigateur + ce préfixe. */
        $rkApiBase = rtrim(request()->getBasePath(), '/');
    @endphp
</head>
<body data-rk-api-base="{{ $rkApiBase }}" data-logo-url="{{ $rkLogo }}">
    <header class="rk-topbar">
        <a href="{{ $rkRoot }}/" class="rk-brand">
            <span class="rk-logo-box">
                <img src="{{ $rkLogo }}" alt="" width="48" height="48" onerror="this.classList.add('is-hidden'); this.nextElementSibling.classList.add('is-visible');">
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
            <a href="{{ route('menu.livre') }}">Carte livre</a>
            @if (Route::has('login'))
                @auth
                    <a href="/admin">Admin</a>
                @else
                    <a href="{{ route('login', [], false) }}">Connexion</a>
                @endauth
            @endif
        </nav>
    </header>

    <main class="rk-main">
        <p class="rk-lead">Lounge bar, terrasse-piscine et salon privé — découvrez notre carte.</p>
        @include('partials.rk-restaurant-infos-widget', ['theme' => 'grid'])
        <div id="rk-menu-root">
            <p class="rk-empty">Chargement de la carte…</p>
        </div>
    </main>

    <div id="rk-media-modal" class="rk-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="rk-media-modal-title">
        <div class="rk-modal-backdrop" data-rk-modal-close tabindex="-1"></div>
        <div class="rk-modal-panel">
            <div class="rk-modal-head">
                <h2 id="rk-media-modal-title">Vidéo</h2>
                <button type="button" class="rk-modal-close" data-rk-modal-close aria-label="Fermer la vidéo">&times;</button>
            </div>
            <div class="rk-modal-stage" id="rk-media-modal-stage"></div>
        </div>
    </div>

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

            function youTubeEmbedFromUrl(url) {
                try {
                    var u = new URL(url);
                    var host = u.hostname.replace(/^www\./, '');
                    if (host === 'youtu.be') {
                        var id = u.pathname.replace(/^\//, '').split('/')[0];
                        if (id) return 'https://www.youtube.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
                    }
                    if (host.indexOf('youtube.com') !== -1) {
                        var vid = u.searchParams.get('v');
                        if (!vid && u.pathname.indexOf('/embed/') !== -1) {
                            vid = u.pathname.split('/embed/')[1];
                        }
                        if (vid) return 'https://www.youtube.com/embed/' + encodeURIComponent(vid.split('/')[0]) + '?autoplay=1&rel=0';
                    }
                } catch (e) {}
                return null;
            }

            function vimeoEmbedFromUrl(url) {
                try {
                    var u = new URL(url);
                    var host = u.hostname.replace(/^www\./, '');
                    if (host !== 'vimeo.com' && host !== 'player.vimeo.com') return null;
                    var parts = u.pathname.split('/').filter(Boolean);
                    var id = parts[parts.length - 1];
                    if (id && /^\d+$/.test(id)) return 'https://player.vimeo.com/video/' + id + '?autoplay=1';
                } catch (e) {}
                return null;
            }

            /** @returns {{ kind: string, src: string }|null} */
            function platVideoPresentation(plat) {
                if (!Array.isArray(plat.medias)) return null;
                var v = plat.medias.find(function (m) {
                    return m.type === 'video' && (m.url_fichier || m.url_externe);
                });
                if (!v) return null;
                if (v.url_fichier) return { kind: 'file', src: v.url_fichier };
                if (v.url_externe) {
                    var ext = String(v.url_externe).trim();
                    var yt = youTubeEmbedFromUrl(ext);
                    if (yt) return { kind: 'iframe', src: yt };
                    var vm = vimeoEmbedFromUrl(ext);
                    if (vm) return { kind: 'iframe', src: vm };
                    return { kind: 'file', src: ext };
                }
                return null;
            }

            var mediaModal = document.getElementById('rk-media-modal');
            var mediaModalStage = document.getElementById('rk-media-modal-stage');
            var mediaModalTitle = document.getElementById('rk-media-modal-title');

            function closeMediaModal() {
                if (!mediaModal || !mediaModalStage) return;
                mediaModal.classList.remove('is-open');
                mediaModal.setAttribute('aria-hidden', 'true');
                mediaModalStage.innerHTML = '';
                document.body.style.overflow = '';
            }

            function openMediaModal(title, presentation) {
                if (!mediaModal || !mediaModalStage || !presentation || !presentation.src) return;
                mediaModalStage.innerHTML = '';
                if (mediaModalTitle) mediaModalTitle.textContent = title || 'Vidéo';
                if (presentation.kind === 'iframe') {
                    var ifr = document.createElement('iframe');
                    ifr.setAttribute('src', presentation.src);
                    ifr.setAttribute('title', title || 'Vidéo');
                    ifr.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
                    ifr.setAttribute('allowfullscreen', '');
                    mediaModalStage.appendChild(ifr);
                } else {
                    var vid = document.createElement('video');
                    vid.setAttribute('controls', '');
                    vid.setAttribute('playsinline', '');
                    vid.src = presentation.src;
                    mediaModalStage.appendChild(vid);
                    vid.play().catch(function () {});
                }
                mediaModal.classList.add('is-open');
                mediaModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            document.addEventListener('click', function (e) {
                var closeEl = e.target.closest('[data-rk-modal-close]');
                if (closeEl) {
                    e.preventDefault();
                    closeMediaModal();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mediaModal && mediaModal.classList.contains('is-open')) {
                    closeMediaModal();
                }
            });

            window.rkOnImgError = function (img) {
                img.classList.add('is-hidden');
                var el = img.parentElement && img.parentElement.querySelector('.rk-initials');
                if (el) el.classList.add('is-visible');
            };

            window.rkOnPlatImgError = function (img) {
                var logo = document.body.getAttribute('data-logo-url');
                if (logo && img.getAttribute('data-rk-tried-logo') !== '1') {
                    img.setAttribute('data-rk-tried-logo', '1');
                    img.src = logo;
                    return;
                }
                rkOnImgError(img);
            };

            var logoUrl = document.body.getAttribute('data-logo-url') || '';

            function menuEndpointUrl() {
                var base = document.body.getAttribute('data-rk-api-base') || '';
                return window.location.origin + base + '/api/v1/menu';
            }

            /** Réponse Laravel Resource (data[]) ou tableau brut (premières versions). */
            function categoriesFromMenuPayload(payload) {
                if (!payload || typeof payload !== 'object') return [];
                if (Array.isArray(payload)) return payload;
                if (Array.isArray(payload.data)) return payload.data;
                return [];
            }

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
                        var imgUrl = platImageUrl(plat) || logoUrl;
                        var ini = initialsFromName(plat.nom);
                        var price = plat.prix_promo ? '<span style="text-decoration:line-through;opacity:0.6;margin-right:0.35rem">' + escapeHtml(String(plat.prix)) + '</span>' + escapeHtml(String(plat.prix_promo)) : escapeHtml(String(plat.prix));
                        var vidPres = platVideoPresentation(plat);
                        html += '<article class="rk-card" data-plat-id="' + plat.id + '">';
                        html += '<div class="rk-thumb">';
                        if (imgUrl) {
                            html += '<img src="' + escapeAttr(imgUrl) + '" alt="" loading="lazy" onerror="rkOnPlatImgError(this)">';
                            html += '<div class="rk-initials" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                        } else {
                            html += '<div class="rk-initials is-visible" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                        }
                        if (vidPres) {
                            html += '<div class="rk-play-overlay is-always">';
                            html += '<button type="button" class="rk-open-video" data-rk-open-video="1" data-rk-v-kind="' + escapeAttr(vidPres.kind) + '" data-rk-v-src="' + escapeAttr(vidPres.src) + '" data-rk-v-title="' + escapeAttr(plat.nom) + '" aria-label="Voir la vidéo : ' + escapeAttr(plat.nom) + '">';
                            html += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';
                            html += '</button></div>';
                        }
                        html += '</div><div class="rk-card-body">';
                        if (plat.mis_en_avant) html += '<span class="rk-badge">À la une</span>';
                        if (plat.nouveau) html += '<span class="rk-badge">Nouveau</span>';
                        html += '<h3>' + escapeHtml(plat.nom) + '</h3>';
                        if (plat.description) html += '<p>' + escapeHtml(plat.description) + '</p>';
                        html += '<div class="rk-price">' + price + ' ' + escapeHtml(plat.code_devise || '') + '</div>';
                        if (vidPres) {
                            html += '<div class="rk-card-actions"><button type="button" class="rk-btn-video-text rk-open-video" data-rk-open-video="1" data-rk-v-kind="' + escapeAttr(vidPres.kind) + '" data-rk-v-src="' + escapeAttr(vidPres.src) + '" data-rk-v-title="' + escapeAttr(plat.nom) + '">Voir la vidéo</button></div>';
                        }
                        html += '</div></article>';
                    });

                    html += '</div></section>';
                });

                if (!html) {
                    root.innerHTML = '<p class="rk-empty">' + (q ? 'Aucun plat ne correspond à « ' + escapeHtml(q) + ' ».' : 'Aucun plat à afficher.') + '</p>';
                    return;
                }
                root.innerHTML = html;
                root.querySelectorAll('.rk-open-video').forEach(function (btn) {
                    btn.addEventListener('click', function (ev) {
                        ev.preventDefault();
                        ev.stopPropagation();
                        var kind = btn.getAttribute('data-rk-v-kind');
                        var src = btn.getAttribute('data-rk-v-src');
                        var t = btn.getAttribute('data-rk-v-title') || 'Vidéo';
                        if (kind && src) openMediaModal(t, { kind: kind, src: src });
                    });
                });
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

            fetch(menuEndpointUrl(), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(function (r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status + ' ' + (r.statusText || ''));
                    return r.json();
                })
                .then(function (payload) {
                    allCategories = categoriesFromMenuPayload(payload);
                    if (!allCategories.length) {
                        root.innerHTML = '<p class="rk-empty">La carte est vide pour le moment.</p>';
                        return;
                    }
                    render();
                })
                .catch(function () {
                    root.innerHTML = '<p class="rk-error">Impossible de charger la carte. Vérifiez que l’API est disponible (même origine que cette page, ex. ne pas mélanger 127.0.0.1 et localhost).</p>';
                });

            if (searchInput) {
                searchInput.addEventListener('input', function () { render(); });
                searchInput.addEventListener('search', function () { render(); });
            }
        })();
    </script>
</body>
</html>
