@props(['user' => null])

<section class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex gap-[20px] justify-between" id="navigation-buttons">
   @if ($user && $user->role)
   <div class="flex gap-[20px]">
      @php
         $userRole = strtolower($user->role->name);
         $tabs = config('tabs.' . $userRole, []);
      @endphp
      
      @foreach($tabs as $tab)
         <button 
            id="{{ $tab['id'] }}-button"
            class="nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px] {{ $tab['default'] ? 'active-nav-button' : '' }}"
            data-tab-id="{{ $tab['id'] }}"
            data-default="{{ $tab['default'] ? 'true' : 'false' }}"
         >
            <i class="{{ $tab['icon'] }} pr-[6px]"></i> {{ $tab['title'] }}
         </button>
      @endforeach
   </div>
   @endif
</section>
