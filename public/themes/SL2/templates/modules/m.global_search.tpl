<form action="{$tsConfig.url}/buscador/" class="buscador-h position-relative d-flex justify-content-end align-items-center" name="top_search_box" gid="{$tsConfig.ads_search}">
   <input type="text" id="ibuscadorq" name="q" onkeypress="ibuscador_intro(event)" onfocus="onfocus_input(this)" onblur="onblur_input(this)" placeholder="¿Que quiere buscar...?" class="form-input">
   <button type="submit" class="mini_bbuscador btn btn-info"><i data-feather="search"></i></button>
   <input type="hidden" name="e" value="web" />
</form>