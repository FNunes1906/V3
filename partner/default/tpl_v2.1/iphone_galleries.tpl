<style>
	.buttonbar{display:block;margin: 5px 0;clear: both;width: 100%;border-bottom:1px solid #d6d6d6;height: auto;min-height: 42px;}
	.btn{text-align: center;padding: 10px 10px; background: #d1d1d1;font-weight: 700;text-decoration: none;width: auto;margin: 0 5px;}
	.btn-success{background: lightgreen; color::green}
	.right{float: right}
	.clearfix{clear: both}
	a.listingTitle{color:#000000;margin: 6px;display:block; }
	a:visited{color:#000000}
</style>
<div id="main" role="main"> 
	<div id="zigzag" style="vertical-align:bottom;"> </div>
	<div class="clearfix"></div>
	<div class="buttonbar">
		<a href="upload_photo.php" class="btn btn-btn-success right">+ UPLOAD YOUR PHOTO</a>
	</div>
	<div class="clearfix"></div>
	<div id="content">
		<ul class="mainList" id="placesList">
			<?php 
				foreach($galleries as $v){
					if(isset($v['avatar']) && trim($v['avatar']) != '') {?>
					<li class="textbox"  style="padding-bottom:0px;">
						<table><tr>
							<td>
								<a href="photos.php?id=<?php echo $v['id']?>"><img class="photo_container" src="<?php echo $v['avatar']; ?>" alt="<?php echo $v['title']; ?>" title="<?php echo $v['title']; ?>" /></a>
							</td>
							<td>
								<strong><a href="photos.php?id=<?php echo $v['id']?>" class="listingTitle"><?php echo $v['title']?></a></strong>
							</td>
						</tr></table>
					</li>
					<?php 
					} 
		  		}  
			?>
		</ul>
	</div>
</div>
<div id="footer"></div>
<div style='display:none;'><?php echo $pageglobal['googgle_map_api_keys']; ?></div>

