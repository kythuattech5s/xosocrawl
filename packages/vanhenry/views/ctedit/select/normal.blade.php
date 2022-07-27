<?php $data = $arrData;

    
    $tableMap = $data['table'];
    $dataMapDefault = $data['default'];
    $isAjax = (isset($default_data['config']['ajax']) ? $default_data['config']['ajax'] : '') == 1;
    $intersectData1 = [];
    $intersectData2 = [];
    $currentTable = false;
    if(isset($data['current_table'])){
        $currentTable = true;
    }
    $disabled = $default_code['disabled'] ?? false;
    $value = '';
    $currentId = '';

    if ($actionType == 'edit' || $actionType == 'copy') {
        $value = FCHelper::er($dataItem, $name);
        $dataMap = vanhenry\manager\helpers\DetailTableHelper::getAllDataOfTable($tableMap);
        $arrValue = explode(',', $value);
        $intersectData1 = array_intersect($arrValue, array_keys($dataMapDefault));
        $intersectData2 = array_intersect($arrValue, array_keys($dataMap));
        $currentId = $dataItem->id;
    }

    $dataSelect = explode(',', $default_data['data']['select']);
    $mainSelect = $dataSelect[1];
    $field_main = $dataSelect[0];
    $arrData = vanhenry\manager\helpers\DetailTableHelper::recursiveDataTable($default_data['data'], $currentTable, $currentId);
?>
<div class="form-group ">
    <p class="form-title" for="">{{ FCHelper::ep($table, 'note') }}
        <p />
    <div class="form-control form-reset flex">
        <select {{ FCHelper::ep($table, 'require') == 1 ? 'required' : '' }} @if($disabled) disabled @endif style="width:100%"
            placeholder="{{ FCHelper::ep($table, 'note') }}" class=" {{ $isAjax ? 'ajx_search_single_' . $name : 'select2' }}"
            name="{{ $name }}">
            @if ($isAjax)
                @if ($actionType == 'edit')
                    @foreach ($intersectData1 as $id1 => $vid1)
                        <option selected value="{{ $vid1 }}">{{ FCHelper::ep($dataMapDefault[$vid1], 'value') }}
                        </option>
                    @endforeach
                    @foreach ($intersectData2 as $id2 => $vid2)
                        <option selected value="{{ $vid2 }}">{{ $dataMap[$vid2]->$mainSelect }}</option>
                    @endforeach
                @endif
            @else
                @if (is_array($dataMapDefault) && count($dataMapDefault) > 0)
                    @php
                        $keyValueDefault = array_key_first($dataMapDefault);
                    @endphp
                    <option value="{{$keyValueDefault}}" {{$keyValueDefault == $value ? 'selected' : ''}}>{{FCHelper::ep($dataMapDefault[$keyValueDefault], 'value')}}</option>
                @endif
                @foreach($arrData as $key => $item)
                    <option value="{{$item->id}}" {{$item->$field_main == $value ? 'selected' : ''}}>{{$item->$mainSelect}}</option>
                @endforeach
            @endif
        </select>
    </div>

</div>
@if ($isAjax)
    <script type="text/javascript">
        $(function() {
            var timeout;
            $('.ajx_search_single_{{ $name }}').select2({
                ajax: {
                    transport: function(params, success, failure) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            var request = $.ajax({
                                url: "{{ $admincp }}/getData/{{ $tableMap }}",
                                data: "POST",
                                data: {
                                    q: params.data.term,
                                    target: '{{implode($dataSelect,',')}}',
                                    page: params.data.page
                                }
                            });
                            request.then(res => {
                                try{
                                    success(JSON.parse(res));
                                }catch(err){}
                            });
                        }, 350);
                    },
                    processResults: function(data, page) {
                        return data;
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: "{{ App::getLocale() }}",
            });
        });
    </script>
@endif