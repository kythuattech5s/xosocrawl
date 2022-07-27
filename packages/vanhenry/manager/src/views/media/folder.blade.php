<div id="folder{{$file->id}}" class="col-xxl-sp-12 col-md-sp-8 col-sm-2 col-xs-3 media-it fold fileitem" data-file='{{$file->extra}}'>
	<div class="media-item">
		<div class="dp-table">
			@if($trash==0)
			<a class="mdi-img" title="" href="{{\vanhenry\manager\helpers\MediaHelper::getLinkForDir($file->id)}}">
				<span class="folder"><span></span></span>
			</a>
			@else
			<a class="mdi-img" href="javascript:void(0)">
			<span class="folder"><span></span></span>
			</a>
			@endif
		</div>
		<div class="mdi-btn clearfix">
			<a class="name-edit" href="#" data-toggle="tooltip" title="Đổi tên"><i class="fa fa-pencil"></i></a>
			@if($trash==1)
			<a onclick="MediaManager.restore({{$file->id}});return false;" dt-id="{{$file->id}}" href="#" data-toggle="tooltip" title="Restore"><i class="fa fa-arrow-up"></i></a>
			@endif
			<a href="#" dt-id="{{$file->id}}" onclick="{{$trash==1?'MediaManager.deleteFolderFull(this)':'MediaManager.deleteFolder(this)'}};return false;" data-toggle="tooltip" title="Xóa"><i class="fa fa-trash-o"></i></a>
		</div>
		<div class="mdi-title">{{$file->name}}</div>
		<span class="mdi-date">{{$file->created_at}}</span>
		<span class="mdi-size"></span>
	</div>
</div>