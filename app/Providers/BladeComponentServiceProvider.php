<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class BladeComponentServiceProvider extends ServiceProvider
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
        // Dynamically register all components from the tabs configuration
        $this->registerTabComponents();
    }
    
    /**
     * Register all components referenced in tabs configuration
     */
    private function registerTabComponents(): void
    {
        // Get all tab configurations
        $roles = ['docent', 'student'];  // All available roles
        $allTabs = [];
        
        foreach ($roles as $role) {
            $tabs = Config::get("tabs.{$role}", []);
            $allTabs = array_merge($allTabs, $tabs);
        }
        
        // Extract unique component names from all tabs
        $componentNames = [];
        foreach ($allTabs as $tab) {
            // Get sidebar component
            if (isset($tab['sidebar']) && isset($tab['sidebar']['component']) && $tab['sidebar']['component']) {
                $componentNames[] = $tab['sidebar']['component'];
            }
            
            // Get content component
            if (isset($tab['content']) && isset($tab['content']['component']) && $tab['content']['component']) {
                $componentNames[] = $tab['content']['component'];
            }
        }
        
        // Remove duplicates
        $componentNames = array_unique($componentNames);
        
        // Register each component
        foreach ($componentNames as $name) {
            $viewPath = "components.{$name}";
            $fullPath = resource_path("views/components/{$name}.blade.php");
            
            // Only register if the component file exists
            if (File::exists($fullPath)) {
                Blade::component($viewPath, $name);
            }
        }
    }
}
