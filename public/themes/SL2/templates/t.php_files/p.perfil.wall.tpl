1:
{if $tsPrivacidad.m.v == true}
{include "$tsModulos/m.perfil_muro.tpl"}
<script type="text/javascript">
/* {literal} */
$(function(){
    // WALL
    $('#wall').focus(function(){
        $('.btnStatus').show();
    });
});
/* {/literal} */
</script>
{/if}