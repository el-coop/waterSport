<?php
$navbarItems =  ElCoop\Navbar\Services\NavbarService::getItems(Request::user()->user_type ?? '')
?>
<drawer>
    <div class="menu">
        @foreach($navbarItems as $label => $items)
            @component('elcoop:navbar::item', [
                'label' => $label,
                'items' => collect($items),
                'indexLink' => $indexLink ?? false
            ])
            @endcomponent
        @endforeach
    </div>
</drawer>

