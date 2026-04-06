<x-filament::section
    heading="Détail par section de carte"
    description="Répartition des plats par catégorie (tous états confondus pour le total). L’API menu ne renvoie que les catégories actives et les plats disponibles."
>
    <div class="space-y-4 text-sm">
        <p class="text-gray-600 dark:text-gray-400">
            Points d’accès lecture seule (JSON)&nbsp;:
            <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/10">{{ $endpointMenu }}</code>
            (carte complète),
            <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/10">{{ $endpointCategories }}</code>,
            <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/10">{{ $endpointPlats }}</code>.
        </p>

        @if ($sansCategorie > 0)
            <p class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-amber-900 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-100">
                <strong>{{ $sansCategorie }}</strong> plat(s) sans catégorie assignée — ils n’apparaissent pas dans le menu groupé par section.
            </p>
        @endif

        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10">
            <table class="w-full min-w-[28rem] text-start">
                <thead class="border-b border-gray-200 bg-gray-50 dark:border-white/10 dark:bg-white/5">
                    <tr>
                        <th class="px-3 py-2 font-semibold">Catégorie</th>
                        <th class="px-3 py-2 font-semibold">Slug</th>
                        <th class="px-3 py-2 font-semibold">Active</th>
                        <th class="px-3 py-2 font-semibold text-end">Plats (total)</th>
                        <th class="px-3 py-2 font-semibold text-end">Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($parCategorie as $ligne)
                        <tr class="border-b border-gray-100 dark:border-white/5">
                            <td class="px-3 py-2">{{ $ligne['nom'] }}</td>
                            <td class="px-3 py-2 font-mono text-xs text-gray-600 dark:text-gray-400">{{ $ligne['slug'] }}</td>
                            <td class="px-3 py-2">
                                @if ($ligne['active'])
                                    <span class="text-success-600 dark:text-success-400">Oui</span>
                                @else
                                    <span class="text-gray-500">Non</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-end tabular-nums">{{ $ligne['plats_total'] }}</td>
                            <td class="px-3 py-2 text-end tabular-nums">{{ $ligne['plats_disponibles'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-gray-500">Aucune catégorie en base.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament::section>
