<?php 
	$name = FCHelper::er($table,'name');
	$value ="";
	if($actionType=='edit'||$actionType=='copy'){
	  	$value = FCHelper::ep($dataItem,$name);
	}
?>
<div class="row margin0">
	<div class="col-xs-12">
		<p class="form-title">{{FCHelper::er($table,'note')}}</p>
	</div>
	<div class="col-xs-12 box-gallery" data-variable ='gallery_control_admin_{{$name}}'>
		<?php 
			$galleriesJson = $value;
           	$galleries = json_decode($galleriesJson,true);
           	$galleries = is_array($galleries)?$galleries:[];
        ?>
		<textarea class="hidden" name="{{$name}}" id="{{$name}}" data-type="GALLERY_CONTROL_ADMIN.VIEW"><?php echo $galleriesJson ?></textarea>
		<div class="gallery_control_admin_list" >
           <ul class="gallery_ul gallery_ul_{{$name}}">
           	
            <?php foreach($galleries as $gallery): ?>

            	<?php 
            		$path = $gallery["path"] ?? '';
            		$fileName = $gallery["file_name"] ?? '';
            		$file =$path.$fileName; 
            		$file= file_exists($file)?$file:'public/admin/images/noimage.png'; 
            	?>
            	<?php 
            		$idfile = \Str::random(10);
            	?>
	            <li class="col-sm-2 col-xs-12 gallery-item">
	                 <div>
	                    <span tagname="gallery"></span> <img class="img-responsive " name="gallery_control_admin_list_<?php echo $idfile ?>" id="gallery_control_admin_list_<?php echo $idfile ?>" rel="lib_img" dt-file='<?php echo json_encode($gallery) ?>' src="<?php echo $file ?>" alt="<?php echo $gallery['file_name'] ?? '' ?>"> 
	                    <p><?php echo $gallery['file_name'] ?? '' ?></p>
	                    <i class="fa fa-times icon-remove gallery-close" aria-hidden="true"></i> <a href="Techsystem/Media/media?istiny=gallery_control_admin_list_<?php echo $idfile ?>&callback=GALLERY_CONTROL_ADMIN_PROVIDER.callback" class="iframe-btn button" type="button">Chọn hình</a> 
	                 </div>
	            </li>
            <?php endforeach ?>
           </ul>
      </div>
    <div class="btnadmin">
    	<a href="javascript:void(0);" class="btn gallery_ul_{{$name}}_add " type="button">Add 1 Image</a>
    </div>
    <div class="btnadmin">
    	<a href="esystem/media/view?istiny=gallery_control_admin_{{$name}}&callback=GALLERY_CONTROL_ADMIN_PROVIDER.callback_multi" class="btn gallery_ul_{{$name}}_add_multi iframe-btn" type="button">Add Images</a>
    </div>
	</div>
</div>
<style type="text/css">
	.box-gallery{
		margin-bottom: 15px;
	}
	.gallery_control_admin_list{
	    width: 100%;
		max-height: 250px;
		border: 1px solid #E0E0E0;
		overflow-y: scroll;
	}
	.gallery_control_admin_list .gallery_ul{
		padding: 0;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item >div{
		position: relative;
		background: #ececec;
		height: 102px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item img{
		margin:0 auto;
		max-height: 102px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item{
		position: relative;
		    padding-top: 15px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item p {
	    position: absolute;
	    bottom: 0;
	    left: 0;
	    width: 100%;
	    background: rgba(0, 0, 0, 0.55);
	    color: #fff;
	    padding: 3px;
	    text-align: center;
	    margin: 0;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item .gallery-close {
position: absolute;
    top: -13px;
    right: -13px;
    font-size: 20px;
    z-index: 1;
    border-radius: 50%;
    width: 27px;
    height: 27px;
    text-align: center;
    cursor: pointer;
    color: #fff;
    background: #ff1515!important;
    line-height: 27px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item .button {
    	position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    margin: auto;
	    width: 100px;
	    height: 30px;
	    background: #00923f;
	    color: #fff;
	    border: none;
	    text-transform: uppercase;
	    visibility: hidden;
	    display: block;
	    text-align: center;
	    padding-top: 7px;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item:hover .button {
	    visibility: visible;
	}
	.gallery_control_admin_list .gallery_ul .gallery-item.selected {
	    opacity: 0.4;
	}
</style>
<script type="text/javascript">
	$(function() {
		window['gallery_control_admin_{{$name}}'] = new GALLERY_CONTROL('{{$name}}');
		window['gallery_control_admin_{{$name}}'].init();
	});
</script>