<?php
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', VRoute::get('home'));
});
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Đăng nhập', VRoute::get('login'));
});
Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push('Đăng ký', VRoute::get('register'));
});
Breadcrumbs::for('page', function ($trail,$currentItem) {
    $trail->parent('home');
    $trail->push(Support::show($currentItem,'name'), Support::show($currentItem,'slug'));
});
Breadcrumbs::for('static', function ($trail,$name,$link) {
    $trail->parent('home');
    $trail->push($name,$link);
});
Breadcrumbs::for('news_category', function ($trail, $currentItem, $level = 0) {
    if ($level == 0) {
        $trail->parent('home');
        $trail->push('Tin tức', VRoute::get('allNews'));
    }
    if ($currentItem->parent > 0) {
        $parent = App\Models\NewsCategory::where('news_categories.id', $currentItem->parent)->first();
        if ($parent != null) {
            $trail->parent('news_category', $parent, $level += 1);
        }   
    }
    $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('news', function ($trail, $currentItem, $parent) {
    if ($parent == null) {
        $trail->parent('home');
        $trail->push('Tin tức', VRoute::get('allNews'));
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
    else{
        $trail->parent('news_category', $parent);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('document_category', function ($trail, $currentItem, $level = 0) {
    if ($level == 0) {
        $trail->parent('home');
        $trail->push('Tài liệu', VRoute::get('tai-lieu'));
    }
    if ($currentItem->parent > 0) {
        $parent = \App\Models\DocumentCategory::where('document_categories.id', $currentItem->parent)->first();
        if ($parent != null) {
            $trail->parent('document_category', $parent, $level += 1);
        }   
    }
    $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('document', function ($trail, $currentItem, $parent) {
    if ($parent == null) {
        $trail->parent('home');
        $trail->push('Tài liệu', VRoute::get('tai-lieu'));
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
    else{
        $trail->parent('document_category', $parent);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('class_study', function ($trail, $currentItem) {
    $trail->parent('home');
    $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('subject', function ($trail, $currentItem,$parent) {
    if (!isset($parent)) {
        $trail->parent('home');
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }else{
        $trail->parent('class_study',$parent);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('subject_practice_exercises', function ($trail, $currentItem,$parent) {
    if (!isset($parent)) {
        $trail->parent('home');
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }else{
        $trail->parent('subject',$parent,$parent->classStudy);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('training_exercises', function ($trail, $currentItem,$parent) {
    if (!isset($parent)) {
        $trail->parent('home');
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }else{
        $trail->parent('subject_practice_exercises',$parent,$parent->subject);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});
Breadcrumbs::for('exercises', function ($trail, $currentItem,$parent) {
    if (!isset($parent)) {
        $trail->parent('home');
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }else{
        $trail->parent('training_exercises',$parent,$parent->subjectPracticeExercise);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});

Breadcrumbs::for('video_lecture_category',function($trail, $currentItem) {
    $subject = $currentItem->subject;
    if(!is_null($subject)){
        $trail->parent('subject',$subject,$subject->classStudy);
    }else{
        $trail->parent('home');
    }
    $category = $currentItem->category;
    if(!is_null($category)){
        $trail->push(Support::show($category,'name'), \Support::show($category,'slug'));
    }
    $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
});

Breadcrumbs::for('play_learning_category',function($trail, $currentItem){
    $trail->parent('home');
    $trail->push('Học mà chơi',url('hoc-ma-choi'));
    $trail->push(Support::show($currentItem,'name'), url('hoc-ma-choi/'.Support::show($currentItem,'id')));
});

Breadcrumbs::for('play_learning',function($trail, $currentItem, $parent){
    $trail->parent('play_learning_category',$parent);
    $trail->push(Support::show($currentItem,'name'),url('hoc-ma-choi/'.Support::show($parent,'id').'/'.Support::show($currentItem,'id')));
});

Breadcrumbs::for('exam_category', function ($trail, $currentItem, $subject, $level = 0) {
    if ($level == 0) {
        if (!isset($subject)) {
            $trail->parent('home');
        }else{
            $trail->parent('subject',$subject,$subject->classStudy);
        }
    }
    if ($currentItem->parent > 0) {
        $parent = \App\Models\ExamCategory::where('exam_categories.id', $currentItem->parent)->first();
        if ($parent != null) {
            $trail->parent('exam_category', $parent,$subject , $level += 1);
        }   
    }
    $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('exam', function ($trail, $currentItem, $parent) {
    if ($parent == null) {
        $trail->parent('home');
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
    else{
        $trail->parent('exam_category',$parent,$parent->subject);
        $trail->push($currentItem->name, \Support::show($currentItem, 'slug'));
    }
});