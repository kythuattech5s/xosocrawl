<?php
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', VRoute::get('home'));
});
Breadcrumbs::for('page', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push(Support::show($currentItem,'name'), Support::show($currentItem,'slug'));
});
Breadcrumbs::for('static', function ($trail,$name,$slug) {
    $trail->parent('home');
    $trail->push($name,$slug);
});
Breadcrumbs::for('dream_number_decodings', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push('Sổ mơ','so-mo-lo-de-mien-bac-so-mo-giai-mong');
    $trail->push(Support::show($currentItem,'name'), Support::show($currentItem,'slug'));
});