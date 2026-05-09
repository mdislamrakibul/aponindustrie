<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // This attaches data to 'layouts.header' (or your header path)
        View::composer('layout.header', function ($view) {


            $menuItems = Category::where('parent_id', 0) // Get Top-level parents
                ->select('id', 'name', 'slug', 'parent_id') // Select for parents
                ->with(['childrenRecursive' => function ($query) {
                    $query->select('id', 'name', 'slug', 'parent_id'); // Select for children
                }])         // Layer in all children & sub-children
                ->get();

            $view->with('menuItems', $menuItems);
        });

        // This attaches data to 'layouts.header' (or your header path)
        View::composer('layout.mobile_header', function ($view) {


            $menuItems = Category::where('parent_id', 0) // Get Top-level parents
                ->select('id', 'name', 'slug', 'parent_id') // Select for parents
                ->with(['childrenRecursive' => function ($query) {
                    $query->select('id', 'name', 'slug', 'parent_id'); // Select for children
                }])         // Layer in all children & sub-children
                ->get();

            $view->with('menuItems', $menuItems);
        });
    }
}
