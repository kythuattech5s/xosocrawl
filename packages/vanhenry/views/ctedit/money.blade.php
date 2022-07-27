<?php 
    $name = FCHelper::er($table,'name');
    $default_code = FCHelper::er($table,'default_code');
    $default_code = json_decode($default_code,true);
    $default_code = @$default_code?$default_code:array();
    $value ="";
    if($actionType=='edit'||$actionType=='copy'){
        $value = $dataItem->$name;
    }
?>
<div class="form-group">
	<p class="form-title" for="">{{FCHelper::er($table,'note')}} <span class="count"></span></p>
	<input  {{FCHelper::ep($table,'require')==1?'required':''}} type="number" name="{{$name}}" placeholder="{{FCHelper::ep($table,'note')}}" id="{{$name}}"  class="form-control" dt-type="{{FCHelper::ep($table,'type_show')}}" value="{{$value}}" />
</div>