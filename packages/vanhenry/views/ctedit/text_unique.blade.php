<?php
    $name = FCHelper::er($table, 'name');
    $default_code = FCHelper::er($table, 'default_code');
    $name_table = FCHelper::er($table, 'parent_name');
    $default_code = json_decode($default_code, true);
    $default_code = @$default_code ? $default_code : [];
    $value = '';
    $checkNameCoppy = false;
    if ($actionType == 'edit' || $actionType == 'copy') {
        if ($name != 'price' && $name != 'price_sale') {
            $value = FCHelper::er($dataItem, $name);
        } else {
            $value = $dataItem->$name;
        }

        if ($actionType == 'copy') {
            $checkNameCoppy = true;
        }
    }
    $id = $dataItem->id ?? null;
?>
<div class="form-group">
    <p class="form-title" for="">{{ FCHelper::er($table, 'note') }} <span class="count"></span></p>
    <input {{ FCHelper::ep($table, 'require' )==1 ? 'required' : '' }} data-old="{{ $value }}" type="text" name="{{ $name }}" placeholder="{{ FCHelper::ep($table, 'note') }}" id="{{ $name }}" class="form-control"  dt-type="{{ FCHelper::ep($table, 'type_show') }}" value="{{ $value }}" />
</div>
<script type="text/javascript">
    $(function() {
        @foreach ($default_code as $dc)
            <?php
                $source = $dc['source'];
                $source = $source == 'this' ? "input[name=$name]" : $source;
                $message = $dc['message'];
            ?>
            $(document).on('input', "{{ $source }}", function(event) {
                event.preventDefault();
                @if ($dc['function'] == 'count')
                    var input = $(this).val();
                    $(this).parent().find('span.count').text(input.length+" Chars");
                @endif
                @if ($dc['function'] == 'seo_title')
                    $('input[name={{ $name }}]').val($(this).val());
                @endif
                @if ($dc['function'] == 'seo_desc')
                    $('input[name={{ $name }}]').val($(this).val());
                @endif
                @if ($dc['function'] == 'seo_key')
                    $('input[name={{ $name }}]').val($(this).val());
                @endif
            });
            var timeOut{{$name}} = null;
            $(document).on('input', "{{ $source }}", function(event) {
                event.preventDefault();
                if (timeOut{{$name}}) {
                    clearTimeout(timeOut{{$name}});
                }
                timeOut{{$name}} = setTimeout(() => {
                    _this = $(this);
                    $.ajax({
                        url:"/esystem/checkFieldDuplicated/{{ $name_table }}",
                        method: "POST",
                        global: false,
                        data:{
                        value:_this.val(),
                        name: "{{ $name }}",
                        @if (!is_null($id))
                            id: {{ $id }}
                        @endif
                        }
                    }).done(res => {
                        if(res.code === 100){
                            $.simplyToast("{{ $message }}", 'danger');
                            _this.val(_this.attr('data-old'));
                        }
                    });
                }, 500);
            });
            function checkFirst(){
                _this = $("{{ $source }}");
                @if (isset($actionType) && $actionType == 'copy' && $checkNameCoppy)
                    _this.val('')
                @endif
            }
            checkFirst()
        @endforeach
    });
</script>