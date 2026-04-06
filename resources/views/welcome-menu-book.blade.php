<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carte livre — Resto Kwetu — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:ital,wght@0,600;0,700;1,600" rel="stylesheet">
    <style>
        :root {
            --rk-bg: #1e1410;
            --rk-bg-table: #2a1f18;
            --rk-paper: #f7f0e6;
            --rk-paper-dark: #ebe3d6;
            --rk-ink: #2c1810;
            --rk-ink-muted: #5c4338;
            --rk-accent: #a63a24;
            --rk-accent-soft: rgba(166, 58, 36, 0.15);
            --rk-gold: #8b6914;
            --rk-border: rgba(44, 24, 16, 0.12);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background:
                radial-gradient(ellipse 120% 80% at 50% 0%, #3d2e26 0%, var(--rk-bg) 55%),
                var(--rk-bg);
            color: var(--rk-ink);
            min-height: 100vh;
            line-height: 1.45;
        }

        .rk-topbar {
            display: grid;
            grid-template-columns: minmax(140px, 1fr) minmax(0, 2.5fr) minmax(160px, 1fr);
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
            background: rgba(30, 20, 16, 0.92);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(8px);
        }

        .rk-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: #f5f0eb;
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
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .rk-logo-fallback.is-visible { display: flex; }
        .rk-brand img.is-hidden { display: none; }

        .rk-brand span { font-weight: 600; font-size: 1.05rem; }

        .rk-search-wrap { display: flex; justify-content: center; width: 100%; }

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
            background: rgba(255, 255, 255, 0.1);
            color: #f5f0eb;
            font-size: 0.95rem;
            outline: none;
        }

        .rk-search input::placeholder { color: rgba(245, 240, 235, 0.55); }

        .rk-search input:focus {
            border-color: var(--rk-accent);
            background: rgba(255, 255, 255, 0.14);
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
            color: #f5f0eb;
        }

        .rk-nav {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .rk-nav a {
            color: rgba(245, 240, 235, 0.75);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        .rk-nav a:hover { color: #fff; background: rgba(166, 58, 36, 0.35); }

        .rk-stage {
            padding: 1.25rem 1rem 5.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: calc(100vh - 72px);
        }

        /* Livre posé sur une surface (esprit Flipsnack / menu physique) */
        .rk-book-outer {
            perspective: 2200px;
            width: 100%;
            max-width: 52rem;
        }

        .rk-book {
            position: relative;
            background: linear-gradient(145deg, #4a3528 0%, #2d2118 40%, #1a120e 100%);
            border-radius: 6px 10px 10px 6px;
            padding: 1.1rem 1rem 1.25rem 1.15rem;
            box-shadow:
                0 4px 6px rgba(0, 0, 0, 0.35),
                0 24px 48px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .rk-book::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 8%;
            bottom: 8%;
            width: 3px;
            border-radius: 2px;
            background: linear-gradient(180deg, #1a120e, #3d2d24, #1a120e);
            box-shadow: inset -1px 0 2px rgba(0, 0, 0, 0.5);
            z-index: 2;
            pointer-events: none;
        }

        .rk-spread {
            position: relative;
            background: var(--rk-paper);
            border-radius: 2px;
            box-shadow:
                inset 0 0 0 1px var(--rk-border),
                inset 0 0 80px rgba(139, 105, 20, 0.04);
            min-height: min(72vh, 640px);
            overflow: hidden;
            touch-action: pan-y;
        }

        .rk-page-surface {
            position: relative;
            min-height: min(72vh, 640px);
            padding: 1.75rem 1.5rem 2rem;
            transform-origin: left center;
        }

        .rk-page-surface.is-flip-out {
            animation: rkPageFlipOut 0.42s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .rk-page-surface.is-flip-in {
            animation: rkPageFlipIn 0.48s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes rkPageFlipOut {
            0% { transform: rotateY(0deg); opacity: 1; }
            100% { transform: rotateY(-18deg) translateX(-8px); opacity: 0; }
        }

        @keyframes rkPageFlipIn {
            0% { transform: rotateY(14deg) translateX(12px); opacity: 0; }
            100% { transform: rotateY(0deg) translateX(0); opacity: 1; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rk-page-surface.is-flip-out,
            .rk-page-surface.is-flip-in { animation: none; opacity: 1; transform: none; }
        }

        .rk-book-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.35rem, 3.5vw, 1.85rem);
            font-weight: 700;
            color: var(--rk-ink);
            text-align: center;
            margin-bottom: 0.35rem;
            letter-spacing: 0.02em;
        }

        .rk-book-sub {
            text-align: center;
            font-size: 0.82rem;
            color: var(--rk-ink-muted);
            margin-bottom: 1.5rem;
        }

        /* Table des matières */
        .rk-toc-list {
            list-style: none;
            max-width: 28rem;
            margin: 0 auto;
        }

        .rk-toc-list li {
            border-bottom: 1px dotted var(--rk-border);
        }

        .rk-toc-list button {
            width: 100%;
            text-align: left;
            padding: 0.85rem 0.25rem;
            background: none;
            border: none;
            font: inherit;
            color: var(--rk-ink);
            cursor: pointer;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 1rem;
            transition: background 0.15s, color 0.15s;
        }

        .rk-toc-list button:hover,
        .rk-toc-list button:focus-visible {
            background: var(--rk-accent-soft);
            color: var(--rk-accent);
            outline: none;
        }

        .rk-toc-num {
            font-variant-numeric: tabular-nums;
            color: var(--rk-gold);
            font-weight: 600;
            font-size: 0.9rem;
            min-width: 1.5rem;
        }

        .rk-toc-name { flex: 1; font-weight: 500; }

        .rk-toc-dots {
            flex: 0 0 auto;
            color: var(--rk-ink-muted);
            font-size: 0.75rem;
            opacity: 0.6;
        }

        /* Page catégorie — style carte restaurant */
        .rk-cat-head {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.2rem, 2.8vw, 1.55rem);
            font-weight: 700;
            color: var(--rk-accent);
            text-align: center;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--rk-accent);
        }

        .rk-cat-desc {
            font-size: 0.8rem;
            color: var(--rk-ink-muted);
            text-align: center;
            margin-bottom: 1.25rem;
            line-height: 1.4;
        }

        .rk-menu-lines {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rk-menu-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .rk-menu-item-top {
            display: flex;
            align-items: baseline;
            width: 100%;
            gap: 0.4rem;
        }

        .rk-menu-name {
            font-weight: 600;
            font-size: 0.92rem;
            color: var(--rk-ink);
            flex: 0 1 auto;
            max-width: 72%;
        }

        .rk-menu-leader {
            flex: 1;
            border-bottom: 1px dotted var(--rk-ink-muted);
            opacity: 0.35;
            min-width: 1rem;
            margin: 0 0.15rem;
            transform: translateY(-2px);
        }

        .rk-menu-price {
            flex-shrink: 0;
            font-weight: 700;
            color: var(--rk-accent);
            font-variant-numeric: tabular-nums;
        }

        .rk-menu-desc {
            font-size: 0.78rem;
            color: var(--rk-ink-muted);
            line-height: 1.35;
            padding-left: 0.05rem;
        }

        .rk-menu-badges { font-size: 0.65rem; margin-top: 0.15rem; }
        .rk-menu-badges span {
            display: inline-block;
            margin-right: 0.35rem;
            padding: 0.1rem 0.35rem;
            border-radius: 3px;
            background: var(--rk-accent-soft);
            color: var(--rk-accent);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .rk-menu-media-row {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .rk-menu-thumb {
            flex-shrink: 0;
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 8px;
            overflow: hidden;
            background: var(--rk-paper-dark);
            border: 1px solid var(--rk-border);
            position: relative;
        }

        .rk-menu-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .rk-menu-thumb img.is-hidden { display: none !important; }

        .rk-initials-mini {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--rk-accent);
            background: linear-gradient(145deg, var(--rk-paper-dark), #ddd5c8);
        }

        .rk-initials-mini.is-visible { display: flex; }

        .rk-menu-thumb .rk-play-mini {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(44, 24, 16, 0.35);
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .rk-menu-thumb .rk-play-mini svg {
            width: 1.5rem;
            height: 1.5rem;
            color: #fff;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.4));
        }

        .rk-menu-body-col {
            flex: 1;
            min-width: 0;
        }

        .rk-menu-video-link {
            margin-top: 0.35rem;
            font: inherit;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--rk-accent);
            background: var(--rk-accent-soft);
            color: var(--rk-accent);
            cursor: pointer;
        }

        .rk-menu-video-link:hover {
            background: rgba(166, 58, 36, 0.22);
        }

        .rk-scroll-page {
            max-height: calc(min(72vh, 640px) - 5.5rem);
            overflow-y: auto;
            padding-right: 0.25rem;
            scrollbar-width: thin;
        }

        /* Contrôles bas de page */
        .rk-book-controls {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem calc(0.75rem + env(safe-area-inset-bottom));
            background: linear-gradient(180deg, transparent, rgba(30, 20, 16, 0.95) 30%);
            z-index: 90;
        }

        .rk-book-controls button {
            font: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.55rem 1.15rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            background: var(--rk-paper);
            color: var(--rk-ink);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.12s, background 0.15s;
        }

        .rk-book-controls button:hover { background: #fff; transform: translateY(-1px); }
        .rk-book-controls button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
        }

        .rk-page-indicator {
            font-size: 0.8rem;
            color: rgba(245, 240, 235, 0.85);
            min-width: 5.5rem;
            text-align: center;
            font-variant-numeric: tabular-nums;
        }

        .rk-empty, .rk-error {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--rk-ink-muted);
        }

        .rk-error { color: #a63a24; }

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
            background: rgba(10, 6, 5, 0.85);
            cursor: pointer;
        }

        .rk-modal-panel {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: min(960px, 100vw - 2rem);
            max-height: min(85vh, 900px);
            background: #2a211c;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.55);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .rk-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .rk-modal-head h2 {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            color: #f5f0eb;
        }

        .rk-modal-close {
            flex-shrink: 0;
            width: 2.5rem;
            height: 2.5rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #f5f0eb;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        .rk-modal-close:hover {
            background: rgba(166, 58, 36, 0.45);
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
            .rk-topbar { grid-template-columns: 1fr; text-align: center; }
            .rk-brand { justify-content: center; }
            .rk-nav { justify-content: center; }
            .rk-page-surface { padding: 1.25rem 1rem 1.5rem; }
        }
    </style>
    @php
        $rkRoot = rtrim(request()->root(), '/');
        $rkLogo = $rkRoot.'/assets/logo.jpg';
        $rkApiBase = rtrim(request()->getBasePath(), '/');
    @endphp
</head>
<body data-rk-api-base="{{ $rkApiBase }}" data-logo-url="{{ $rkLogo }}">
    <header class="rk-topbar">
        <a href="{{ route('home') }}" class="rk-brand">
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
                <input type="search" id="rk-book-search" placeholder="Rechercher un plat, une catégorie…" autocomplete="off" aria-label="Rechercher dans la carte livre">
            </div>
        </div>
        <nav class="rk-nav" aria-label="Navigation">
            <a href="{{ route('home') }}">Vue grille</a>
            @if (Route::has('login'))
                @auth
                    <a href="/admin">Admin</a>
                @else
                    <a href="{{ route('login', [], false) }}">Connexion</a>
                @endauth
            @endif
        </nav>
    </header>

    @include('partials.rk-restaurant-infos-widget', ['theme' => 'livre'])

    <div class="rk-stage">
        <div class="rk-book-outer">
            <div class="rk-book">
                <div class="rk-spread" id="rk-book-swipe-zone" aria-live="polite">
                    <div class="rk-page-surface" id="rk-book-page">
                        <p class="rk-empty">Chargement de la carte…</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rk-book-controls">
        <button type="button" id="rk-book-prev" aria-label="Page précédente">← Précédent</button>
        <span class="rk-page-indicator" id="rk-book-indicator" aria-hidden="true">— / —</span>
        <button type="button" id="rk-book-next" aria-label="Page suivante">Suivant →</button>
    </div>

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
            function menuEndpointUrl() {
                var base = document.body.getAttribute('data-rk-api-base') || '';
                return window.location.origin + base + '/api/v1/menu';
            }

            function categoriesFromMenuPayload(payload) {
                if (!payload || typeof payload !== 'object') return [];
                if (Array.isArray(payload)) return payload;
                if (Array.isArray(payload.data)) return payload.data;
                return [];
            }

            var logoUrl = document.body.getAttribute('data-logo-url') || '';
            var pageEl = document.getElementById('rk-book-page');
            var swipeZone = document.getElementById('rk-book-swipe-zone');
            var searchInput = document.getElementById('rk-book-search');
            var btnPrev = document.getElementById('rk-book-prev');
            var btnNext = document.getElementById('rk-book-next');
            var indicator = document.getElementById('rk-book-indicator');

            var allCategories = [];
            var pages = [];
            var currentIndex = 0;
            var touchStartX = null;
            var touchStartY = null;

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

            function initialsFromName(name) {
                if (!name || typeof name !== 'string') return 'RK';
                var parts = name.trim().split(/\s+/).filter(Boolean);
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
                    var photo = plat.medias.find(function (m) { return m.type === 'photo' && m.url_fichier; });
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

            window.rkBookOnPlatImgError = function (img) {
                var logo = document.body.getAttribute('data-logo-url');
                if (logo && img.getAttribute('data-rk-tried-logo') !== '1') {
                    img.setAttribute('data-rk-tried-logo', '1');
                    img.src = logo;
                    return;
                }
                img.classList.add('is-hidden');
                var el = img.parentElement && img.parentElement.querySelector('.rk-initials-mini');
                if (el) el.classList.add('is-visible');
            };

            document.addEventListener('click', function (e) {
                if (e.target.closest('[data-rk-modal-close]')) {
                    e.preventDefault();
                    closeMediaModal();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mediaModal && mediaModal.classList.contains('is-open')) {
                    closeMediaModal();
                }
            });

            function bindOpenVideoButtons(container) {
                if (!container) return;
                container.querySelectorAll('.rk-open-video').forEach(function (btn) {
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

            function buildPages() {
                var q = (searchInput && searchInput.value) ? searchInput.value.trim() : '';
                pages = [];

                var filtered = [];
                allCategories.forEach(function (cat) {
                    var plats = (cat.plats || []).filter(function (p) { return matchesQuery(p, cat, q); });
                    if (plats.length) filtered.push({ cat: cat, plats: plats });
                });

                if (!filtered.length) {
                    pages = [{ type: 'empty', message: q ? 'Aucun plat ne correspond à votre recherche.' : 'Aucun plat à afficher.' }];
                    return;
                }

                pages.push({ type: 'toc', items: filtered.map(function (x, i) { return { title: x.cat.nom, index: i + 1 }; }) });

                filtered.forEach(function (entry) {
                    pages.push({ type: 'category', category: entry.cat, plats: entry.plats });
                });
            }

            function renderToc(items) {
                var html = '<h1 class="rk-book-title">Table des matières</h1>';
                html += '<p class="rk-book-sub">Touchez une rubrique pour ouvrir la page — ou utilisez Précédent / Suivant.</p>';
                html += '<ul class="rk-toc-list">';
                items.forEach(function (item, idx) {
                    var pageNum = idx + 1;
                    html += '<li><button type="button" class="rk-toc-btn" data-goto="' + item.index + '">';
                    html += '<span class="rk-toc-num">' + pageNum + '</span>';
                    html += '<span class="rk-toc-name">' + escapeHtml(item.title) + '</span>';
                    html += '<span class="rk-toc-dots" aria-hidden="true">→</span>';
                    html += '</button></li>';
                });
                html += '</ul>';
                return html;
            }

            function renderCategory(cat, plats) {
                var html = '<h2 class="rk-cat-head">' + escapeHtml(cat.nom) + '</h2>';
                if (cat.description) {
                    html += '<p class="rk-cat-desc">' + escapeHtml(cat.description) + '</p>';
                }
                html += '<div class="rk-scroll-page"><div class="rk-menu-lines">';
                plats.forEach(function (plat) {
                    var price = plat.prix_promo
                        ? '<span style="text-decoration:line-through;opacity:0.55;margin-right:0.25rem">' + escapeHtml(String(plat.prix)) + '</span>' + escapeHtml(String(plat.prix_promo))
                        : escapeHtml(String(plat.prix));
                    var dev = plat.code_devise ? ' ' + escapeHtml(plat.code_devise) : '';
                    var imgUrl = platImageUrl(plat) || logoUrl;
                    var ini = initialsFromName(plat.nom);
                    var vidPres = platVideoPresentation(plat);
                    html += '<div class="rk-menu-item">';
                    html += '<div class="rk-menu-media-row">';
                    html += '<div class="rk-menu-thumb">';
                    if (imgUrl) {
                        html += '<img src="' + escapeAttr(imgUrl) + '" alt="" loading="lazy" onerror="rkBookOnPlatImgError(this)">';
                        html += '<div class="rk-initials-mini" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                    } else {
                        html += '<div class="rk-initials-mini is-visible" aria-hidden="true">' + escapeHtml(ini) + '</div>';
                    }
                    if (vidPres) {
                        html += '<button type="button" class="rk-play-mini rk-open-video" data-rk-v-kind="' + escapeAttr(vidPres.kind) + '" data-rk-v-src="' + escapeAttr(vidPres.src) + '" data-rk-v-title="' + escapeAttr(plat.nom) + '" aria-label="Voir la vidéo : ' + escapeAttr(plat.nom) + '">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';
                        html += '</button>';
                    }
                    html += '</div>';
                    html += '<div class="rk-menu-body-col">';
                    html += '<div class="rk-menu-item-top">';
                    html += '<span class="rk-menu-name">' + escapeHtml(plat.nom) + '</span>';
                    html += '<span class="rk-menu-leader" aria-hidden="true"></span>';
                    html += '<span class="rk-menu-price">' + price + dev + '</span>';
                    html += '</div>';
                    if (plat.mis_en_avant || plat.nouveau) {
                        html += '<div class="rk-menu-badges">';
                        if (plat.mis_en_avant) html += '<span>À la une</span>';
                        if (plat.nouveau) html += '<span>Nouveau</span>';
                        html += '</div>';
                    }
                    if (plat.description) {
                        html += '<p class="rk-menu-desc">' + escapeHtml(plat.description) + '</p>';
                    }
                    if (vidPres) {
                        html += '<button type="button" class="rk-menu-video-link rk-open-video" data-rk-v-kind="' + escapeAttr(vidPres.kind) + '" data-rk-v-src="' + escapeAttr(vidPres.src) + '" data-rk-v-title="' + escapeAttr(plat.nom) + '">Voir la vidéo</button>';
                    }
                    html += '</div></div></div>';
                });
                html += '</div></div>';
                return html;
            }

            function renderPageHtml(page) {
                if (page.type === 'empty') {
                    return '<p class="rk-empty">' + escapeHtml(page.message) + '</p>';
                }
                if (page.type === 'toc') return renderToc(page.items);
                if (page.type === 'category') return renderCategory(page.category, page.plats);
                return '<p class="rk-error">Page inconnue.</p>';
            }

            function updateControls() {
                var total = pages.length;
                if (btnPrev) btnPrev.disabled = currentIndex <= 0 || total <= 1;
                if (btnNext) btnNext.disabled = currentIndex >= total - 1 || total <= 1;
                if (indicator) {
                    indicator.textContent = total ? (currentIndex + 1) + ' / ' + total : '— / —';
                }
            }

            function bindTocButtons() {
                pageEl.querySelectorAll('.rk-toc-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var target = parseInt(btn.getAttribute('data-goto'), 10);
                        if (!isNaN(target)) goToPage(target, true);
                    });
                });
                bindOpenVideoButtons(pageEl);
            }

            function goToPage(index, animate) {
                if (index < 0 || index >= pages.length) return;
                var useAnim = animate !== false && window.matchMedia('(prefers-reduced-motion: no-preference)').matches;

                function swap() {
                    currentIndex = index;
                    pageEl.innerHTML = renderPageHtml(pages[currentIndex]);
                    bindTocButtons();
                    updateControls();
                    if (useAnim) {
                        pageEl.classList.remove('is-flip-out');
                        pageEl.classList.add('is-flip-in');
                        setTimeout(function () { pageEl.classList.remove('is-flip-in'); }, 500);
                    }
                }

                if (useAnim && pageEl.innerHTML.trim() !== '') {
                    pageEl.classList.remove('is-flip-in');
                    pageEl.classList.add('is-flip-out');
                    setTimeout(swap, 380);
                } else {
                    swap();
                }
            }

            function nextPage() {
                if (currentIndex < pages.length - 1) goToPage(currentIndex + 1);
            }

            function prevPage() {
                if (currentIndex > 0) goToPage(currentIndex - 1);
            }

            function refreshFromSearch() {
                var prevCat = pages[currentIndex] && pages[currentIndex].type === 'category'
                    ? pages[currentIndex].category.id
                    : null;
                buildPages();
                var newIdx = 0;
                if (prevCat && pages.length > 1) {
                    for (var i = 1; i < pages.length; i++) {
                        if (pages[i].type === 'category' && pages[i].category.id === prevCat) {
                            newIdx = i;
                            break;
                        }
                    }
                }
                goToPage(newIdx, false);
            }

            fetch(menuEndpointUrl(), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(function (r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(function (payload) {
                    allCategories = categoriesFromMenuPayload(payload);
                    if (!allCategories.length) {
                        pageEl.innerHTML = '<p class="rk-empty">La carte est vide pour le moment.</p>';
                        pages = [{ type: 'empty', message: 'La carte est vide pour le moment.' }];
                        updateControls();
                        return;
                    }
                    buildPages();
                    goToPage(0, false);
                })
                .catch(function () {
                    pageEl.innerHTML = '<p class="rk-error">Impossible de charger la carte. Vérifiez que l’API est disponible.</p>';
                    pages = [];
                    updateControls();
                });

            if (btnPrev) btnPrev.addEventListener('click', function () { prevPage(); });
            if (btnNext) btnNext.addEventListener('click', function () { nextPage(); });

            if (searchInput) {
                var t = null;
                searchInput.addEventListener('input', function () {
                    clearTimeout(t);
                    t = setTimeout(refreshFromSearch, 200);
                });
                searchInput.addEventListener('search', refreshFromSearch);
            }

            document.addEventListener('keydown', function (e) {
                if (mediaModal && mediaModal.classList.contains('is-open')) return;
                if (e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA')) return;
                if (e.key === 'ArrowRight') nextPage();
                if (e.key === 'ArrowLeft') prevPage();
            });

            if (swipeZone) {
                swipeZone.addEventListener('touchstart', function (e) {
                    touchStartX = e.changedTouches[0].screenX;
                    touchStartY = e.changedTouches[0].screenY;
                }, { passive: true });
                swipeZone.addEventListener('touchend', function (e) {
                    if (touchStartX == null || touchStartY == null) return;
                    var x = e.changedTouches[0].screenX;
                    var y = e.changedTouches[0].screenY;
                    var dx = Math.abs(x - touchStartX);
                    var dy = Math.abs(y - touchStartY);
                    if (dy > dx && dy > 24) {
                        touchStartX = null;
                        touchStartY = null;
                        return;
                    }
                    var d = touchStartX - x;
                    if (d > 56) nextPage();
                    else if (d < -56) prevPage();
                    touchStartX = null;
                    touchStartY = null;
                }, { passive: true });
            }
        })();
    </script>
</body>
</html>
