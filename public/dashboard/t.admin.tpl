{include file='sections/main_header.tpl'}
<div id="borradores" class="row">
   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
      <div id="admin_menu">
			{include file='m.admin_sidemenu.tpl'}
      </div><!-- boxy-content -->
   </div>
   <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
      <div class="boxy" id="admin_panel">
         {include file="m.admin_$tsAction.tpl"}
      </div>
   </div>
</div>
{include file='sections/main_footer.tpl'}