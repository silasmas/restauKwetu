# Documentation API — RestauKwetu

**Base** : `{APP_URL}/api`  
**Réponses** : JSON (`data` pour les collections Laravel).

Les **chemins**, **paramètres de requête** et **clés JSON** des plats / catégories sont en **français**.  
Types de médias : `photo` et `video` (plus `image` côté historique interne migré vers `photo` en base).

---

## Authentification

| Route | Rôle |
|-------|------|
| `GET /api/utilisateur` | Utilisateur Sanctum (recommandé) |
| `GET /api/user` | Alias pour compatibilité |

En-tête : `Authorization: Bearer {token}`

---

## Routes v1

| Méthode | Route | Description |
|---------|--------|-------------|
| GET | `/api/v1/menu` | Carte : catégories **actives** + plats **disponibles** + médias |
| GET | `/api/v1/categories` | Liste des catégories |
| GET | `/api/v1/categories/{categorie}` | Détail (slug ou id) + **plats** |
| GET | `/api/v1/plats` | Liste / **recherche** de plats |
| GET | `/api/v1/plats/{plat}` | Détail (slug ou id) |

---

## `GET /api/v1/categories`

| Paramètre | Défaut | Description |
|-----------|--------|-------------|
| `actives` | `true` | Seulement catégories actives |
| `avec_plats` | `false` | Inclut le tableau `plats` |
| `disponibles_uniquement` | `true` | Avec `avec_plats`, filtre les plats disponibles |

---

## `GET /api/v1/categories/{categorie}`

| Paramètre | Défaut | Description |
|-----------|--------|-------------|
| `disponibles_uniquement` | `true` | Filtre les plats |

---

## `GET /api/v1/plats` (recherche / filtres)

Tous les critères se **combinent** (ET).

| Paramètre | Description |
|-----------|-------------|
| `disponibles_uniquement` | `true` par défaut |
| `id_categorie` | Id de la catégorie |
| `slug_categorie` | Slug exact de la catégorie |
| `nom_categorie` | Portion du **nom** de la catégorie |
| `nom` | Portion du **nom** du plat |
| `description` | Mot dans la **description** |
| `prix` | Prix exact |
| `prix_min` / `prix_max` | Fourchette de prix |
| `a_la_une` | Plats mis en avant |
| `nouveau` ou `nouveautes` | Plats marqués nouveauté |

---

## Objets JSON (aperçu)

### Catégorie

`id`, `nom`, `slug`, `ordre`, `actif`, `plats` (si chargé)

### Plat

`id`, `id_categorie`, `categorie`, `nom`, `slug`, `description`, `prix`, `code_devise`, `prix_promo`, `disponible`, `mis_en_avant`, `nouveau`, `minutes_preparation`, `reference_interne`, `allergenes`, `labels_alimentaires`, `taux_tva`, `ordre`, `medias`, `image_principale`

### Média

`id`, `type` (`photo` \| `video`), `url_fichier` (fichier hébergé), `url_externe` (lien vidéo, souvent pour `video`), `est_principale`, `ordre`, `legende`

Pour une **vidéo**, vous pouvez avoir **uniquement** `url_externe`, **uniquement** `url_fichier`, ou **les deux**.

---

## OpenAPI

Fichier : `docs/openapi.yaml` (à jour avec `/plats`, paramètres français).
