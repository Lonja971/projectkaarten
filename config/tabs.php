<?php

return [
    'docent' => [
        [
            'id' => 'projects',
            'title' => 'Alle Projectkaarten',
            'icon' => 'fa-regular fa-file',
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
        [
            'id' => 'students',
            'title' => 'Studenten',
            'icon' => 'fa-regular fa-user',
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
            'icon' => 'fa-regular fa-file',
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
        [
            'id' => 'my-attendance',
            'title' => 'Mijn Aanwezigheid',
            'icon' => 'fa-regular fa-id-badge',
            'default' => false,
            'content' => [
                'component' => 'attendance',
                'props' => [],
                'fallback' => [
                    'title' => 'Aanwezigheid',
                    'message' => 'Aanwezigheid informatie komt hier'
                ]
            ]
        ],
    ],
];
