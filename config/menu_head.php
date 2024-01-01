<?php
return [
    "Dashboard" => [
        "name" => "Tableau de Bord",
        "route" => "admin.dashboard",
        "parent" => true,
        "children" => []
    ],
    "Socials" => [
        "name" => "Socials & Blogs",
        "parent" => true,
        "route" => "admin.social",
        "children" => [
            [
                "name" => "Articles",
                "icon" => "fa-newspaper",
                "route" => "admin.social.articles",
            ],
            [
                "name" => "Pages",
                "icon" => "fa-file",
                "route" => "admin.social.pages",
            ],
            [
                "name" => "Cercles",
                "icon" => "fa-circle",
                "route" => "admin.social.cercles",
            ],
            [
                "name" => "Services",
                "icon" => "fa-server",
                "route" => "admin.social.services",
            ],
            [
                "name" => "Evènements",
                "icon" => "fa-calendar",
                "route" => "admin.social.event",
            ],
            [
                "name" => "Poste Sociales",
                "icon" => "fa-comments",
                "route" => "admin.social.feeds",
            ],
        ]
    ],
    "Wiki" => [
        "name" => "Wiki",
        "route" => "admin.wiki",
        "parent" => true,
        "children" => [
            [
                "name" => "Catégories",
                "icon" => "fa-boxes",
                "route" => "admin.wiki.categories",
            ],
            [
                "name" => "Articles",
                "icon" => "fa-page",
                "route" => "admin.wiki.articles",
            ],
        ]
    ],
    "Railway" => [
        "name" => "Railway Manager",
        "route" => "admin.railway",
        "parent" => true,
        "children" => [
            [
                "name" => "Matériels Roulants",
                "icon" => "fa-train",
                "route" => "admin.railway.engines",
            ],
            [
                "name" => "Gares & Hibes",
                "icon" => "fa-building",
                "route" => "admin.railway.gares",
            ],
            [
                "name" => "Lignes",
                "icon" => "fa-code-fork",
                "route" => "admin.railway.lignes",
            ],
            [
                "name" => "Badges & Récompenses",
                "icon" => "fa-certificate",
                "route" => "admin.railway.badges",
            ],
            [
                "name" => "Service de location",
                "icon" => "fa-certificate",
                "route" => "admin.railway.rents",
            ],
            [
                "name" => "Service Bancaire",
                "icon" => "fa-euro-sign",
                "route" => "admin.railway.finances",
            ],
            [
                "name" => "Recherches & Développements",
                "icon" => "fa-flask",
                "route" => "admin.railway.researches",
            ],
            [
                "name" => "Bonus Journalier",
                "icon" => "fa-gift",
                "route" => "admin.railway.bonuses",
            ],
            [
                "name" => "Porte Carte",
                "icon" => "fa-wallet",
                "route" => "admin.railway.cards",
            ],
            [
                "name" => "Configurations",
                "icon" => "fa-cogs",
                "route" => "admin.railway.configs",
            ],
        ]
    ],
    "Administration" => [
        "name" => "Administration",
        "route" => "admin.railway",
        "parent" => true,
        "children" => [

        ]
    ],
];
