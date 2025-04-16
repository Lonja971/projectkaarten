<?php

return [
    'docent' => [
        [
            'id' => 'overzicht',
            'title' => 'Eerstvolgend',
            'icon' => 'fa-solid fa-calendar',
            'default' => true,
            'content' => [
                'component' => 'overzicht',
                'props' => []
            ]
        ],
        [
            'id' => 'projects',
            'title' => 'Alle Projectkaarten',
            'icon' => 'fa-solid fa-file',
            'default' => false,
            'sidebar' => [
                'component' => 'filter-section',
                'props' => [
                    'statuses' => '$statuses ?? []',
                    'schoolyears' => '$schoolyears ?? []',
                    'projectFilters' => '$projectFilters ?? ["sort" => "creation-date-asc", "name" => ""]'
                ]
            ],
            'content' => [
                'component' => 'project-cards',
                'props' => [
                    'projects' => '$projects ?? []',
                    'user' => '$user'
                ]
            ]
        ],
        [
            'id' => 'sprints',
            'title' => 'Alle Sprints',
            'icon' => 'fa-solid fa-clock',
            'default' => false,
            'sidebar' => [
                'component' => 'sprint-filter-section',
                'props' => [
                    'statuses' => '$statuses ?? []',
                    'schoolyears' => '$schoolyears ?? []',
                    'sprintFilters' => '$sprintFilters ?? ["sort" => "creation-date-asc", "name" => ""]'
                ]
            ],
            'content' => [
                'component' => 'sprint-cards',
                'props' => [
                    'sprints' => '$sprints ?? []',
                    'user' => '$user'
                ]
            ]
        ],
        [
            'id' => 'students',
            'title' => 'Studenten',
            'icon' => 'fa-solid fa-graduation-cap',
            'default' => false,
            'sidebar' => [
                'component' => 'student-filter-section',
                'props' => [
                    'roles' => '$roles ?? []',
                    'studentFilters' => '$studentFilters ?? ["sort" => "name-asc", "name" => "", "identifier" => ""]'
                ]
            ],
            'content' => [
                'component' => 'student-list',
                'props' => [
                    'users' => '$students ?? []',
                    'user' => '$user'
                ]
            ]
        ],
    ],
    'student' => [
        [
            'id' => 'my-projects',
            'title' => 'Mijn Projectkaarten',
            'icon' => 'fa-solid fa-file',
            'default' => true,
            'sidebar' => [
                'component' => 'filter-section',
                'props' => [
                    'statuses' => '$statuses ?? []',
                    'schoolyears' => '$schoolyears ?? []',
                    'projectFilters' => '$projectFilters ?? ["sort" => "creation-date-asc", "name" => ""]'
                ]
            ],
            'content' => [
                'component' => 'project-cards',
                'props' => [
                    'projects' => '$projects ?? []',
                    'user' => '$user'
                ]
            ]
        ],
    ],
];
