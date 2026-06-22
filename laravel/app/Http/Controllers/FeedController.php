<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Species;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function index(): View
    {
        $feeds = Feed::query()
            ->with('species:species_id,name,class,feeding_group')
            ->orderBy('name')
            ->paginate(15);

        return view('feeds.index', compact('feeds'));
    }

    public function create(): View
    {
        return view('feeds.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFeed($request);
        $speciesIds = $this->resolveSpeciesIds($validated);

        $feedData = $this->extractFeedData($validated);

        $feed = Feed::create($feedData);
        $feed->species()->sync($speciesIds);

        return redirect()
            ->route('admin.feeds.index')
            ->with('success', 'Кормовой объект добавлен.');
    }

    public function edit(Feed $feed): View
    {
        $feed->load('species:species_id,name,class,feeding_group');

        return view('feeds.edit', [
            'feed' => $feed,
            ...$this->formData(),
        ]);
    }

    public function update(
        Request $request,
        Feed $feed
    ): RedirectResponse {
        $validated = $this->validateFeed($request);
        $speciesIds = $this->resolveSpeciesIds($validated);

        $feedData = $this->extractFeedData($validated);

        $feed->update($feedData);
        $feed->species()->sync($speciesIds);

        return redirect()
            ->route('admin.feeds.index')
            ->with('success', 'Кормовой объект обновлён.');
    }

    public function destroy(Feed $feed): RedirectResponse
    {
        if ($feed->feedingLogs()->exists()) {
            return back()->with(
                'error',
                'Нельзя удалить кормовой объект: он используется в журнале кормлений.'
            );
        }

        $feed->delete();

        return redirect()
            ->route('admin.feeds.index')
            ->with('success', 'Кормовой объект удалён.');
    }

    public function show(Feed $feed): void
    {
        abort(404);
    }

    private function formData(): array
    {
        return [
            'species' => Species::query()
                ->orderBy('class')
                ->orderBy('feeding_group')
                ->orderBy('name')
                ->get([
                    'species_id',
                    'name',
                    'class',
                    'feeding_group',
                ]),

            'animalClasses' => collect(
                config('exotic.animal_classes', [])
            ),

            'animalGroups' => collect(
                config('exotic.animal_groups', [])
            ),

            'feedUnits' => config('exotic.feed_units', [
                'шт' => 'Штуки',
                'г' => 'Граммы',
                'кг' => 'Килограммы',
                'упаковка' => 'Упаковки',
                'контейнер' => 'Контейнеры',
                'порция' => 'Порции',
            ]),

            'rodentStages' => [
                'pinkie' => 'Голыш',
                'fuzzy' => 'Опушок',
                'hopper' => 'Бегунок',
                'adult' => 'Взрослая мышь',
            ],
        ];
    }

    private function validateFeed(Request $request): array
    {
        $allowedClasses = collect(
            config('exotic.animal_classes', [])
        )->implode(',');

        $allowedGroups = collect(
            config('exotic.animal_groups', [])
        )->flatten()->implode(',');

        $allowedUnits = array_keys(
            config('exotic.feed_units', [
                'шт' => 'Штуки',
                'г' => 'Граммы',
                'кг' => 'Килограммы',
                'упаковка' => 'Упаковки',
                'контейнер' => 'Контейнеры',
                'порция' => 'Порции',
            ])
        );

        $normalizedName = mb_strtolower(
            (string) $request->input('name')
        );

        $isRodentFeed =
            str_contains($normalizedName, 'мыш') ||
            str_contains($normalizedName, 'крыс');

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'feed_type' => [
                    'required',
                    Rule::in([
                        'Живой корм',
                        'Замороженный корм',
                        'Растительный корм',
                        'Сухой корм',
                        'Минеральная добавка',
                        'Витаминная добавка',
                    ]),
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],

                'purpose' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],

                'unit' => [
                    'required',
                    Rule::in($allowedUnits),
                ],

                'quantity_in_stock' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'min_stock_level' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'animal_classes' => [
                    'nullable',
                    'array',
                ],

                'animal_classes.*' => [
                    'string',
                    'distinct',
                    'in:' . $allowedClasses,
                ],

                'animal_groups' => [
                    'nullable',
                    'array',
                ],

                'animal_groups.*' => [
                    'string',
                    'distinct',
                    'in:' . $allowedGroups,
                ],

                'species_ids' => [
                    'nullable',
                    'array',
                ],

                'species_ids.*' => [
                    'integer',
                    'distinct',
                    'exists:species,species_id',
                ],

                'rodent_stage' => [
                    Rule::requiredIf($isRodentFeed),
                    'nullable',
                    Rule::in([
                        'pinkie',
                        'fuzzy',
                        'hopper',
                        'adult',
                    ]),
                ],

                'prey_weight_min' => [
                    Rule::requiredIf($isRodentFeed),
                    'nullable',
                    'integer',
                    'min:1',
                    'max:500',
                ],

                'prey_weight_max' => [
                    Rule::requiredIf($isRodentFeed),
                    'nullable',
                    'integer',
                    'min:1',
                    'max:500',
                    'gte:prey_weight_min',
                ],
            ],
            [
                'feed_type.required' => 'Выберите тип корма.',
                'feed_type.in' => 'Выбран неизвестный тип корма.',

                'unit.required' => 'Выберите единицу учёта.',
                'unit.in' => 'Выбрана неизвестная единица учёта.',

                'quantity_in_stock.required' =>
                    'Укажите количество на складе.',
                'quantity_in_stock.integer' =>
                    'Количество должно быть целым числом.',
                'quantity_in_stock.min' =>
                    'Количество не может быть отрицательным.',

                'min_stock_level.required' =>
                    'Укажите минимальный остаток.',
                'min_stock_level.integer' =>
                    'Минимальный остаток должен быть целым числом.',
                'min_stock_level.min' =>
                    'Минимальный остаток не может быть отрицательным.',

                'animal_classes.*.in' =>
                    'Выбран неизвестный класс животных.',

                'animal_groups.*.in' =>
                    'Выбрана неизвестная группа животных.',

                'species_ids.*.exists' =>
                    'Один из выбранных видов животных не найден.',

                'rodent_stage.required' =>
                    'Для кормовых мышей и крыс укажите возрастную стадию.',

                'rodent_stage.in' =>
                    'Выбрана неизвестная стадия кормового грызуна.',

                'prey_weight_min.required' =>
                    'Укажите минимальную массу кормового грызуна.',

                'prey_weight_min.integer' =>
                    'Минимальная масса должна быть целым числом.',

                'prey_weight_min.min' =>
                    'Минимальная масса должна быть не меньше 1 г.',

                'prey_weight_max.required' =>
                    'Укажите максимальную массу кормового грызуна.',

                'prey_weight_max.integer' =>
                    'Максимальная масса должна быть целым числом.',

                'prey_weight_max.gte' =>
                    'Максимальная масса не может быть меньше минимальной.',
            ]
        );

        if (!$isRodentFeed) {
            $validated['rodent_stage'] = null;
            $validated['prey_weight_min'] = null;
            $validated['prey_weight_max'] = null;
        }

        return $validated;
    }

    private function extractFeedData(array $validated): array
    {
        unset(
            $validated['species_ids']
        );

        return $validated;
    }

    private function resolveSpeciesIds(array $validated): array
    {
        $manualSpeciesIds = collect(
            $validated['species_ids'] ?? []
        )->map(
            fn ($id) => (int) $id
        );

        $selectedClasses = collect(
            $validated['animal_classes'] ?? []
        );

        $selectedGroups = collect(
            $validated['animal_groups'] ?? []
        );

        /*
         * Если для класса выбрана хотя бы одна его группа,
         * весь класс не применяется.
         *
         * Пример:
         * animal_classes = ['рептилии']
         * animal_groups = ['змеи']
         *
         * Результат: только змеи, а не все рептилии.
         */
        $classesWithoutSelectedGroups = $selectedClasses
            ->filter(
                function (
                    string $animalClass
                ) use ($selectedGroups): bool {
                    $groupsOfClass = collect(
                        config(
                            "exotic.animal_groups.$animalClass",
                            []
                        )
                    );

                    return $groupsOfClass
                        ->intersect($selectedGroups)
                        ->isEmpty();
                }
            );

        $automaticSpeciesIds = Species::query()
            ->where(
                function ($query) use (
                    $selectedGroups,
                    $classesWithoutSelectedGroups
                ) {
                    if ($selectedGroups->isNotEmpty()) {
                        $query->whereIn(
                            'feeding_group',
                            $selectedGroups
                        );
                    }

                    if (
                        $classesWithoutSelectedGroups->isNotEmpty()
                    ) {
                        if ($selectedGroups->isNotEmpty()) {
                            $query->orWhereIn(
                                'class',
                                $classesWithoutSelectedGroups
                            );
                        } else {
                            $query->whereIn(
                                'class',
                                $classesWithoutSelectedGroups
                            );
                        }
                    }
                }
            )
            ->pluck('species_id');

        return $manualSpeciesIds
            ->merge($automaticSpeciesIds)
            ->unique()
            ->values()
            ->all();
    }
}
