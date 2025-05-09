@props(['user' => Auth::user()])

<!DOCTYPE html>
<html lang="nl" class="h-full">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Homepage</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
      <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
      <!-- Custom CSS -->
      <link href="{{ asset('css/home.css') }}" rel="stylesheet">
   </head>
   <body class="h-full flex flex-col min-h-screen">
      <x-header title="Overzicht" />
      @if ($user)
         <x-navigation-buttons :user="$user" />
         
         <!-- Main content area with sidebar-content layout -->
         <div class="flex flex-row flex-grow">
            @php
               $userRole = strtolower($user->role->name);
               $tabs = config('tabs.' . $userRole, []);
               $currentTab = collect($tabs)->firstWhere('default', true) ?? collect($tabs)->first();
            @endphp

            <!-- Sidebar for filters - Only shown if any tab has a sidebar defined -->
            @php
                $anySidebarExists = collect($tabs)->contains(function ($tab) {
                    return isset($tab['sidebar']);
                });
            @endphp
            @if($anySidebarExists)
            <div id="sidebar" class="min-w-[330px] max-w-[330px] border-r border-[#ddd]">
               @foreach($tabs as $tab)
                  <div id="{{ $tab['id'] }}-filters" class="{{ !$tab['default'] ? 'hidden' : '' }}">
                     @if(isset($tab['sidebar']) && $tab['sidebar']['component'])
                        @php
                           // Extract variables from configuration
                           extract([
                              'statuses' => $statuses ?? [],
                              'schoolyears' => $schoolyears ?? [],
                              'projectFilters' => $projectFilters ?? ['sort' => 'creation-date-asc', 'name' => ''],
                              'roles' => $roles ?? [],
                              'studentFilters' => $studentFilters ?? ['sort' => 'name-asc', 'name' => '', 'identifier' => '']
                           ]);
                           
                           // Determine the component name
                           $component = $tab['sidebar']['component'];
                        @endphp
                        
                        @if(in_array($tab['id'], ['projects', 'my-projects']))
                           <x-filter-section :statuses="$statuses" :schoolyears="$schoolyears" :projectFilters="$projectFilters" />
                        @elseif($tab['id'] === 'students')
                           <x-student-filter-section :roles="$roles" :studentFilters="$studentFilters" />
                        @else
                           <!-- Use include for all other components with standard layout -->
                           <x-tab-filter-layout>
                              @include('components.' . (string)$tab['sidebar']['component'])
                           </x-tab-filter-layout>
                        @endif
                     @elseif(isset($tab['sidebar']) && isset($tab['sidebar']['fallback']))
                        <!-- Fallback for tabs without a specific sidebar component -->
                        <x-tab-filter-layout>
                           <h3 class="font-[Inter] text-[18px] font-bold mb-4">{{ $tab['sidebar']['fallback']['title'] }}</h3>
                           <p class="text-gray-500">{{ $tab['sidebar']['fallback']['message'] }}</p>
                        </x-tab-filter-layout>
                     @elseif(isset($tab['sidebar']))
                        <!-- Default fallback only if sidebar is specified but incomplete -->
                        <x-tab-filter-layout>
                           <h3 class="font-[Inter] text-[18px] font-bold mb-4">{{ $tab['title'] }} filters</h3>
                           <p class="text-gray-500">Maak een filter component voor deze tab</p>
                        </x-tab-filter-layout>
                     @endif
                  </div>
               @endforeach
            </div>
            @endif
            
            <!-- Main content area - Adjusts width based on sidebar presence -->
            <div class="w-full" id="content-container">
               @php
                  $userRole = strtolower($user->role->name);
                  $tabs = config('tabs.' . $userRole, []);
               @endphp

               @foreach($tabs as $tab)
                  <div id="{{ $tab['id'] }}-content" class="{{ !$tab['default'] ? 'hidden' : '' }}">
                     @if(isset($tab['content']) && $tab['content']['component'])
                        @php
                           // Extract variables from configuration
                           extract([
                              'statuses' => $statuses ?? [],
                              'schoolyears' => $schoolyears ?? [],
                              'projectFilters' => $projectFilters ?? ['sort' => 'creation-date-asc', 'name' => ''],
                              'roles' => $roles ?? [],
                              'studentFilters' => $studentFilters ?? ['sort' => 'name-asc', 'name' => '', 'identifier' => ''],
                              'students' => $students ?? [],
                              'projects' => $projects ?? [],
                           ]);
                        @endphp
                        
                        @if(in_array($tab['id'], ['projects', 'my-projects']))
                           <x-project-cards :projects="$projects" :user="$user" />
                        @elseif($tab['id'] === 'students')
                           <x-student-list :users="$students" :user="$user" />
                        @else
                           <!-- Use include for all other components with standard layout -->
                           <x-tab-content-layout>
                              @include('components.' . (string)$tab['content']['component'])
                           </x-tab-content-layout>
                        @endif
                     @elseif(isset($tab['content']) && isset($tab['content']['fallback']))
                        <!-- Fallback for tabs without a specific content component -->
                        <x-tab-content-layout>
                           <div class="flex justify-center items-center min-h-[60vh] flex-col">
                              <p class="font-[Inter] text-[20px] text-[#000]">{{ $tab['content']['fallback']['message'] }}</p>
                           </div>
                        </x-tab-content-layout>
                     @else
                        <!-- Default fallback -->
                        <x-tab-content-layout>
                           <div class="flex justify-center items-center min-h-[60vh] flex-col">
                              <p class="font-[Inter] text-[20px] text-[#000]">Content voor "{{ $tab['title'] }}" tab</p>
                              <p class="text-gray-500">Maak een component of view voor deze tab</p>
                           </div>
                        </x-tab-content-layout>
                     @endif
                  </div>
               @endforeach
            </div>
         </div>
      @else
         <x-login-required />
      @endif

      <x-footer />
      
      <!-- Custom JavaScript -->
      <script src="{{ asset('js/reset-form.js') }}"></script>
      <script src="{{ asset('js/form-elements.js') }}"></script>
      <script src="{{ asset('js/filter.js') }}"></script>
      <script src="{{ asset('js/navigation.js') }}"></script>
      <script src="{{ asset('js/student-filter.js') }}"></script>
      <script src="{{ asset('js/auto-switch-tab.js') }}"></script>
      @if ($user && $user->identifier)
         <script>
            let userIdentifier = @json($user->identifier);
         </script>
      @endif
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      @if ($user)
      <script>
         // Simple script to handle tab switching and sidebar visibility
         document.addEventListener('DOMContentLoaded', function() {
            // Get all navigation buttons
            var buttons = document.querySelectorAll('.nav-toggle-button');
            var sidebar = document.getElementById('sidebar');
            
            // Create a map of tab IDs to sidebar status
            var hasSidebar = {
            @foreach($tabs as $tab)
               '{{ $tab['id'] }}': {{ isset($tab['sidebar']) ? 'true' : 'false' }},
            @endforeach
            };
            
            // Function to update sidebar visibility
            function updateSidebar(tabId) {
               if (!sidebar) return;
               
               // Show sidebar if current tab has a sidebar configuration
               if (hasSidebar[tabId]) {
                  sidebar.style.display = '';
                  
                  // Hide all filter sections first
                  document.querySelectorAll('[id$="-filters"]').forEach(function(filterSection) {
                     filterSection.classList.add('hidden');
                  });
                  
                  // Show only the filter section for current tab
                  var currentFilterSection = document.getElementById(tabId + '-filters');
                  if (currentFilterSection) {
                     currentFilterSection.classList.remove('hidden');
                  }
               } else {
                  // Hide sidebar if current tab has no sidebar
                  sidebar.style.display = 'none';
               }
            }
            
            // Set up click handlers for navigation buttons
            buttons.forEach(function(button) {
               button.addEventListener('click', function() {
                  var tabId = this.getAttribute('data-tab-id');
                  updateSidebar(tabId);
               });
            });
         });
      </script>
      @endif
   </body>
</html>
