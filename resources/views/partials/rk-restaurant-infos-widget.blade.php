{{-- Bouton flottant + teaser coordonnées + modal fiche restaurant (API /api/v1/restaurant). --}}
@php
    $rkRestaurantTheme = $theme ?? 'grid';
@endphp
<div class="rk-restaurant-widget rk-restaurant-widget--{{ $rkRestaurantTheme }}" data-rk-restaurant-theme="{{ e($rkRestaurantTheme) }}">
    <p id="rk-restaurant-teaser" class="rk-restaurant-teaser rk-restaurant-teaser--{{ $rkRestaurantTheme }}" hidden>
        <button type="button" class="rk-restaurant-teaser-btn" id="rk-restaurant-teaser-btn" aria-haspopup="dialog" aria-controls="rk-restaurant-info-modal"></button>
    </p>

    <button type="button" class="rk-restaurant-fab" id="rk-restaurant-fab" aria-label="Informations sur le restaurant" aria-haspopup="dialog" aria-controls="rk-restaurant-info-modal" title="Infos &amp; contact">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="26" height="26">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
        </svg>
    </button>

    <div id="rk-restaurant-info-modal" class="rk-modal rk-restaurant-info-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="rk-restaurant-info-title">
        <div class="rk-modal-backdrop" data-rk-restaurant-info-close tabindex="-1"></div>
        <div class="rk-modal-panel rk-restaurant-info-panel">
            <div class="rk-modal-head">
                <h2 id="rk-restaurant-info-title">Restaurant</h2>
                <button type="button" class="rk-modal-close" data-rk-restaurant-info-close aria-label="Fermer">&times;</button>
            </div>
            <div class="rk-restaurant-info-body" id="rk-restaurant-info-body">
                <p class="rk-restaurant-info-loading">Chargement…</p>
            </div>
        </div>
    </div>
</div>

<style>
    .rk-restaurant-teaser { margin: 0 0 1.25rem; }
    .rk-restaurant-teaser--grid { text-align: center; color: var(--rk-text-muted); font-size: 0.9rem; line-height: 1.5; }
    .rk-restaurant-teaser--livre {
        text-align: center;
        color: rgba(245, 240, 235, 0.88);
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0 auto 1rem;
        max-width: 40rem;
        padding: 0 1rem;
    }
    .rk-restaurant-teaser-btn {
        font: inherit;
        color: inherit;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 3px;
        padding: 0.15rem 0.25rem;
        border-radius: 6px;
    }
    .rk-restaurant-teaser-btn:hover { color: var(--rk-accent); }
    .rk-restaurant-widget--livre .rk-restaurant-teaser-btn:hover { color: #ffb59a; }

    .rk-restaurant-fab {
        position: fixed;
        bottom: 1.35rem;
        right: 1.35rem;
        z-index: 240;
        width: 3.35rem;
        height: 3.35rem;
        border-radius: 50%;
        border: none;
        background: var(--rk-accent, #C84628);
        color: #fff;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.4);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .rk-restaurant-fab:hover {
        background: var(--rk-accent-hover, #d95a3c);
        transform: scale(1.06);
        box-shadow: 0 10px 32px rgba(0, 0, 0, 0.45);
    }
    .rk-restaurant-fab:focus-visible {
        outline: 2px solid var(--rk-accent-hover, #fff);
        outline-offset: 3px;
    }
    .rk-restaurant-widget--livre .rk-restaurant-fab {
        bottom: 5.35rem;
        background: var(--rk-accent);
    }
    .rk-restaurant-widget--livre .rk-restaurant-fab:hover {
        filter: brightness(1.08);
    }

    .rk-restaurant-info-modal {
        z-index: 260;
    }
    .rk-restaurant-info-panel {
        max-width: min(960px, calc(100vw - 1.5rem));
        width: 100%;
        max-height: min(90vh, 800px);
    }
    .rk-restaurant-info-body {
        overflow-y: auto;
        padding: 1.15rem 1.35rem 1.35rem;
        max-height: min(78vh, 700px);
        font-size: 0.92rem;
        line-height: 1.55;
        color: var(--rk-text, #f5f0eb);
    }
    .rk-restaurant-info-layout {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.1rem 1.35rem;
        align-items: start;
    }
    @media (max-width: 720px) {
        .rk-restaurant-info-layout {
            grid-template-columns: 1fr;
        }
        .rk-restaurant-info-col--hours,
        .rk-restaurant-info-col--social,
        .rk-restaurant-info-col--hours.rk-restaurant-info-col--full {
            grid-column: 1 / -1 !important;
        }
    }
    .rk-restaurant-info-col {
        min-width: 0;
        padding: 0.65rem 0.85rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--rk-border, rgba(200, 70, 40, 0.18));
    }
    .rk-restaurant-widget--livre .rk-restaurant-info-col {
        background: rgba(44, 24, 16, 0.04);
        border-color: var(--rk-border, rgba(44, 24, 16, 0.12));
    }
    .rk-restaurant-info-col--hours {
        grid-column: 1 / span 2;
    }
    .rk-restaurant-info-col--social {
        grid-column: 3;
    }
    .rk-restaurant-info-col--hours.rk-restaurant-info-col--full {
        grid-column: 1 / -1;
    }
    .rk-restaurant-intro-slogan {
        margin: 0 0 0.5rem;
        font-style: italic;
        opacity: 0.92;
        color: var(--rk-text-muted, rgba(245,240,235,0.8));
    }
    .rk-restaurant-widget--livre .rk-restaurant-intro-slogan {
        color: var(--rk-ink-muted, #5c4338);
    }
    .rk-restaurant-widget--livre .rk-restaurant-info-panel {
        background: var(--rk-paper, #f7f0e6);
        border-color: var(--rk-border, rgba(44, 24, 16, 0.12));
    }
    .rk-restaurant-widget--livre .rk-modal-head h2 { color: var(--rk-ink, #2c1810); }
    .rk-restaurant-widget--livre .rk-modal-close {
        background: rgba(44, 24, 16, 0.08);
        color: var(--rk-ink, #2c1810);
    }
    .rk-restaurant-widget--livre .rk-modal-close:hover { background: var(--rk-accent-soft, rgba(166, 58, 36, 0.15)); }
    .rk-restaurant-widget--livre .rk-restaurant-info-body {
        color: var(--rk-ink, #2c1810);
    }
    .rk-restaurant-widget--livre .rk-restaurant-info-muted { color: var(--rk-ink-muted, #5c4338) !important; }

    .rk-restaurant-info-loading { color: var(--rk-text-muted, rgba(245,240,235,0.7)); margin: 0; }
    .rk-restaurant-info-desc { margin: 0.35rem 0 0; white-space: pre-wrap; }
    .rk-restaurant-info-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.06em; color: var(--rk-text-muted, rgba(245,240,235,0.55)); margin-bottom: 0.35rem; }
    .rk-restaurant-widget--livre .rk-restaurant-info-label { color: var(--rk-ink-muted, #5c4338); }
    .rk-restaurant-info-line { margin: 0.2rem 0; }
    .rk-tel-role {
        display: block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--rk-text-muted, rgba(245,240,235,0.65));
        margin-bottom: 0.15rem;
    }
    .rk-restaurant-widget--livre .rk-tel-role { color: var(--rk-ink-muted, #5c4338); }
    .rk-restaurant-info-line a { color: var(--rk-accent-hover, #d95a3c); }
    .rk-restaurant-widget--livre .rk-restaurant-info-line a { color: var(--rk-accent, #a63a24); }
    .rk-restaurant-info-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.75rem; }
    .rk-btn-maps {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font: inherit;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.55rem 1rem;
        border-radius: 10px;
        border: none;
        background: var(--rk-accent, #C84628);
        color: #fff !important;
        text-decoration: none !important;
        cursor: pointer;
    }
    .rk-btn-maps:hover { filter: brightness(1.08); }
    .rk-restaurant-info-hours dt { font-weight: 600; margin-top: 0.45rem; font-size: 0.85rem; }
    .rk-restaurant-info-hours dd { margin: 0.1rem 0 0 0; color: var(--rk-text-muted, rgba(245,240,235,0.85)); }
    .rk-restaurant-widget--livre .rk-restaurant-info-hours dd { color: var(--rk-ink-muted, #5c4338); }
</style>

<script>
    (function () {
        var fab = document.getElementById('rk-restaurant-fab');
        var modal = document.getElementById('rk-restaurant-info-modal');
        var bodyEl = document.getElementById('rk-restaurant-info-body');
        var titleEl = document.getElementById('rk-restaurant-info-title');
        var teaser = document.getElementById('rk-restaurant-teaser');
        var teaserBtn = document.getElementById('rk-restaurant-teaser-btn');
        if (!fab || !modal || !bodyEl || !titleEl) return;

        function apiBase() {
            return document.body.getAttribute('data-rk-api-base') || '';
        }
        function restaurantUrl() {
            return window.location.origin + apiBase() + '/api/v1/restaurant';
        }
        function listFromPayload(payload) {
            if (!payload || typeof payload !== 'object') return [];
            if (Array.isArray(payload)) return payload;
            if (Array.isArray(payload.data)) return payload.data;
            return [];
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
        function buildAddress(r) {
            var parts = [];
            if (r.adresse) parts.push(String(r.adresse));
            var l2 = [r.code_postal, r.ville].filter(Boolean).join(' ');
            if (l2) parts.push(l2);
            if (r.pays) parts.push(String(r.pays));
            return parts.join(', ');
        }
        function mapsUrl(r) {
            var lat = r.latitude;
            var lng = r.longitude;
            if (lat != null && lng != null && String(lat) !== '' && String(lng) !== '') {
                return 'https://www.google.com/maps?q=' + encodeURIComponent(String(lat) + ',' + String(lng));
            }
            var addr = buildAddress(r);
            if (addr) return 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(addr);
            if (r.nom) return 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(String(r.nom));
            return '';
        }
        function formatHoraires(h) {
            if (h == null || typeof h !== 'object') return '';
            var keys = Object.keys(h);
            if (!keys.length) return '';
            var html = '<dl class="rk-restaurant-info-hours">';
            keys.forEach(function (k) {
                html += '<dt>' + escapeHtml(k) + '</dt><dd>' + escapeHtml(h[k]) + '</dd>';
            });
            html += '</dl>';
            return html;
        }
        function formatReseauxColumn(s) {
            if (s == null || typeof s !== 'object') return '';
            var keys = Object.keys(s);
            if (!keys.length) return '';
            var html = '<div class="rk-restaurant-info-label">Réseaux</div>';
            keys.forEach(function (k) {
                var url = String(s[k] || '').trim();
                if (!url) return;
                html += '<p class="rk-restaurant-info-line"><a href="' + escapeAttr(url) + '" target="_blank" rel="noopener noreferrer">' + escapeHtml(k) + '</a></p>';
            });
            return html;
        }
        function renderModal(r) {
            var map = mapsUrl(r);
            var addr = buildAddress(r);
            var html = '<div class="rk-restaurant-info-layout">';

            html += '<section class="rk-restaurant-info-col">';
            html += '<div class="rk-restaurant-info-label">À propos</div>';
            if (r.slogan) html += '<p class="rk-restaurant-intro-slogan">' + escapeHtml(r.slogan) + '</p>';
            if (r.description) html += '<p class="rk-restaurant-info-desc">' + escapeHtml(r.description) + '</p>';
            if (!r.slogan && !r.description) html += '<p class="rk-restaurant-info-muted" style="margin:0">—</p>';
            html += '</section>';

            html += '<section class="rk-restaurant-info-col">';
            html += '<div class="rk-restaurant-info-label">Adresse</div>';
            if (addr) html += '<p class="rk-restaurant-info-line">' + escapeHtml(addr) + '</p>';
            else html += '<p class="rk-restaurant-info-muted" style="margin:0">—</p>';
            if (map) {
                html += '<div class="rk-restaurant-info-actions">';
                html += '<a class="rk-btn-maps" href="' + escapeAttr(map) + '" target="_blank" rel="noopener noreferrer">Ouvrir la carte</a>';
                html += '</div>';
            }
            html += '</section>';

            html += '<section class="rk-restaurant-info-col">';
            html += '<div class="rk-restaurant-info-label">Contact</div>';
            if (r.telephone) {
                html += '<p class="rk-restaurant-info-line"><span class="rk-tel-role">Téléphone principal</span><a href="tel:' + escapeAttr(String(r.telephone).replace(/\s/g, '')) + '">' + escapeHtml(r.telephone) + '</a></p>';
            }
            if (r.telephone_secondaire) {
                html += '<p class="rk-restaurant-info-line"><span class="rk-tel-role">Téléphone secondaire</span><a href="tel:' + escapeAttr(String(r.telephone_secondaire).replace(/\s/g, '')) + '">' + escapeHtml(r.telephone_secondaire) + '</a></p>';
            }
            if (r.email) html += '<p class="rk-restaurant-info-line"><a href="mailto:' + escapeAttr(r.email) + '">' + escapeHtml(r.email) + '</a></p>';
            if (r.site_web) html += '<p class="rk-restaurant-info-line"><a href="' + escapeAttr(r.site_web) + '" target="_blank" rel="noopener noreferrer">Site web</a></p>';
            if (!r.telephone && !r.telephone_secondaire && !r.email && !r.site_web) html += '<p class="rk-restaurant-info-muted" style="margin:0">—</p>';
            html += '</section>';

            var hoursHtml = r.horaires ? formatHoraires(r.horaires) : '';
            var hasHours = hoursHtml.length > 0;
            var socialHtml = formatReseauxColumn(r.reseaux_sociaux);
            var hasSocial = socialHtml.length > 0;

            if (hasHours || hasSocial) {
                var hoursClass = 'rk-restaurant-info-col rk-restaurant-info-col--hours';
                if (!hasSocial) hoursClass += ' rk-restaurant-info-col--full';
                html += '<section class="' + hoursClass + '">';
                html += '<div class="rk-restaurant-info-label">Horaires</div>';
                html += hasHours ? hoursHtml : '<p class="rk-restaurant-info-muted" style="margin:0">—</p>';
                html += '</section>';
                if (hasSocial) {
                    html += '<section class="rk-restaurant-info-col rk-restaurant-info-col--social">';
                    html += socialHtml;
                    html += '</section>';
                }
            }

            html += '</div>';

            bodyEl.innerHTML = html;
            titleEl.textContent = r.nom || 'Restaurant';
        }

        function openInfoModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function closeInfoModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            if (!document.getElementById('rk-media-modal') || !document.getElementById('rk-media-modal').classList.contains('is-open')) {
                document.body.style.overflow = '';
            }
        }

        var cached = null;
        function loadRestaurantThen(fn) {
            if (cached) { fn(cached); return; }
            bodyEl.innerHTML = '<p class="rk-restaurant-info-loading">Chargement…</p>';
            fetch(restaurantUrl(), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
                .then(function (payload) {
                    var list = listFromPayload(payload);
                    cached = list.length ? list[0] : null;
                    fn(cached);
                })
                .catch(function () {
                    bodyEl.innerHTML = '<p class="rk-restaurant-info-loading">Impossible de charger les informations du restaurant.</p>';
                    titleEl.textContent = 'Restaurant';
                });
        }

        function openAndFill() {
            openInfoModal();
            loadRestaurantThen(function (r) {
                if (r) renderModal(r);
                else bodyEl.innerHTML = '<p class="rk-restaurant-info-loading">Aucune fiche restaurant en base.</p>';
            });
        }

        fab.addEventListener('click', function (e) { e.preventDefault(); openAndFill(); });
        if (teaserBtn) teaserBtn.addEventListener('click', function (e) { e.preventDefault(); openAndFill(); });

        modal.querySelectorAll('[data-rk-restaurant-info-close]').forEach(function (el) {
            el.addEventListener('click', function (e) { e.preventDefault(); closeInfoModal(); });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeInfoModal();
        });

        fetch(restaurantUrl(), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
            .then(function (payload) {
                var list = listFromPayload(payload);
                var r = list.length ? list[0] : null;
                if (!r || !teaser || !teaserBtn) return;
                var bits = [];
                if (r.ville) bits.push('📍 ' + escapeHtml(r.ville));
                if (r.telephone) bits.push('📞 <span class="rk-restaurant-info-muted">Principal</span> ' + escapeHtml(r.telephone));
                if (r.telephone_secondaire) bits.push('📞 <span class="rk-restaurant-info-muted">Secondaire</span> ' + escapeHtml(r.telephone_secondaire));
                if (!bits.length && r.nom) bits.push(escapeHtml(r.nom));
                if (!bits.length) return;
                teaserBtn.innerHTML = bits.join(' <span aria-hidden="true">·</span> ') + ' <span class="rk-restaurant-info-muted">— Infos &amp; itinéraire</span>';
                teaser.hidden = false;
            })
            .catch(function () { /* silencieux : le FAB reste disponible */ });
    })();
</script>
