<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "title" => __('uncategorized'),
                "slug"  => "uncategorized",
            ],
            [
                "title"      => __("programming"),
                "slug"       => "programming",
                "categories" => [
                    [
                        "title"      => __("web"),
                        "slug"       => "web-programming",
                        "categories" => [
                            [
                                "title" => __("laravel"),
                                "slug"  => "laravel",
                            ],
                            [
                                "title" => __("react"),
                                "slug"  => "react-js",
                            ]
                        ]
                    ],
                    [
                        "title" => __("mobile"),
                        "slug"  => "mobile-programming",
                    ]
                ]
            ],
            [
                "title"      => __("graphic"),
                "slug"       => "graphic",
                "categories" => [
                    [
                        "title" => __("user-interface"),
                        "slug"  => "desgin-user-interface",
                    ]
                ]
            ],
            [
                "title" => __("language"),
                "slug"  => "language",
            ],
            [
                "title"      => __("business-management"),
                "slug"       => "business-management",
                "categories" => [
                    [
                        "title" => __("product-management"),
                        "slug"  => "product-management",
                    ],
                    [
                        "title" => __("project-management"),
                        "slug"  => "project-management",
                    ]
                ]
            ]
        ];
        foreach ($categories as $category) {
            $this->create($category);
        }
    }

    /**
     * @param $category
     * @param $parentId
     *
     * @return void
     */
    public function create($category, $parentId = null): void
    {
        $parent = Category::query()->firstOrCreate(
            [
                'parent_id' => $parentId,
                'title'     => $category['title'],
                'slug'      => $category['slug'],
            ],
            []
        );
        if (array_key_exists('categories', $category)) {
            foreach ($category['categories'] as $subCategory) {
                $this->create($subCategory, $parent->id);
            }
        }
    }
}
