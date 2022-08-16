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
Breadcrumbs::for('predict_lottery_result_categories', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push('Dự đoán KQXS','du-doan-ket-qua-xo-so-kqxs-c229');
    $trail->push(Support::show($currentItem,'short_name'), Support::show($currentItem,'slug'));
});
Breadcrumbs::for('predict_lottery_results', function ($trail,$currentItem,$parent) {
    if ($parent == null) {
        $trail->parent('home');
        $trail->push('Dự đoán KQXS','du-doan-ket-qua-xo-so-kqxs-c229');
    }else{
        $trail->parent('predict_lottery_result_categories',$parent);
    }
    $itemNameInfo = explode('-',$currentItem->name);
    if (is_array($itemNameInfo) && count($itemNameInfo) > 0) {
        $trail->push(trim($itemNameInfo[0]), Support::show($currentItem, 'slug'));
    }else{
        $trail->push($currentItem->name, Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('predict_lottery_province_results', function ($trail,$currentItem,$parent) {
    if ($parent == null) {
        $trail->parent('home');
        $trail->push('Dự đoán KQXS','du-doan-ket-qua-xo-so-kqxs-c229');
    }else{
        $trail->parent('predict_lottery_result_categories',$parent);
    }
    $trail->push('Dự đoán xổ số '.$currentItem->province_name, Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('test_spin_categories', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push('Quay thử KQXS','quay-thu-kqxs-quay-thu-ket-qua-xo-so');
    $itemNameInfo = explode('-',$currentItem->name);
    if (is_array($itemNameInfo) && count($itemNameInfo) > 0) {
        $trail->push(trim($itemNameInfo[0]), Support::show($currentItem, 'slug'));
    }else{
        $trail->push($currentItem->name, Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('user', function ($trail,$user) {
    $trail->parent('home');
    $trail->push('Diễn đàn sổ xố','dien-dan-xo-so');
    $trail->push($user->fullname,'thong-tin-thanh-vien-c'.$user->id);
});
Breadcrumbs::for('user_sub', function ($trail,$user,$name,$slug) {
    $trail->parent('user',$user);
    $trail->push($name,$slug);
});
Breadcrumbs::for('forum', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push($currentItem->name, Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('staticals', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push($currentItem->breadcrum_name, Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('vietlott_child', function ($trail,$name,$slug) {
    $trail->parent('home');
    $trail->push('XS Vietlott','kq-xs-vietlott-truc-tiep-ket-qua-xo-so-vietlott-hom-nay');
    $trail->push($name,$slug);
});
Breadcrumbs::for('so_dau_duoi', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push($currentItem->short_name, Support::show($currentItem, 'slug'));
});